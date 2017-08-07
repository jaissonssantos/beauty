<?php
	
use Utils\Conexao;

header('Content-type: application/json; charset=ISO-8859-1');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

//ingresso
$stmt = $oConexao->prepare(
    'SELECT ig.id,lt.nome as lote,ig.nome as ingresso,ig.valor 
    FROM ingresso ig
    INNER JOIN lote lt ON(ig.idlote = lt.id) 
    WHERE ig.id=?
    AND lt.status=1'
);
$stmt->execute(array(
    $params->usuario->ingresso
));
$ingresso = $stmt->fetchObject();

//configurações
$url = transactionsURL;
$credentials['email'] = PAGSEGURO_EMAIL;
$credentials['token'] = PAGSEGURO_TOKEN;
$credentials['paymentMode'] = 'default';
$credentials['currency'] = 'BRL';
$credentials['notificationURL'] = URL_APP.'/controller/guest/checkout/callback';
$credentials['paymentMethod'] = 'eft';
$credentials['bankName'] = $params->bank;
$credentials['receiverEmail'] = PAGSEGURO_EMAIL;

//itens
$credentials['itemId1'] = $ingresso->id;
$credentials['itemDescription1'] = utf8_decode($ingresso->lote.' - '.$ingresso->ingresso);
$credentials['itemAmount1'] = $ingresso->valor;
$credentials['itemQuantity1'] = 1;

//dados do comprador
$credentials['senderName'] = utf8_decode($params->usuario->nome.' '.$params->usuario->sobrenome);
$credentials['senderCPF'] = $params->usuario->cpf;
$credentials['senderAreaCode'] = '68';
$credentials['senderPhone'] = '21025035';
$credentials['senderEmail'] = $params->usuario->email;
$credentials['senderHash'] = $params->senderhash;

//endereço do cliente
$credentials['shippingAddressStreet'] = 'R Bartolomeu Bueno';
$credentials['shippingAddressNumber'] = 33;
$credentials['shippingAddressComplement'] = 'Sala A';
$credentials['shippingAddressDistrict'] = 'Bosque';
$credentials['shippingAddressPostalCode'] = '69900541';
$credentials['shippingAddressCity'] = 'Rio branco';
$credentials['shippingAddressState'] = 'AC';
$credentials['shippingAddressCountry'] = 'BRA';

//endereço de pagamento
$credentials['billingAddressStreet'] = 'R Bartolomeu Bueno';
$credentials['billingAddressNumber'] = 33;
$credentials['billingAddressDistrict'] = 'Bosque';
$credentials['billingAddressPostalCode'] = '69900541';
$credentials['billingAddressCity'] = 'Rio branco';
$credentials['billingAddressState'] = 'AC';
$credentials['billingAddressCountry'] = 'BRA';

$credentials = http_build_query($credentials);

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, 
	Array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1')
);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $credentials);
$xml = curl_exec($curl);

$results = simplexml_load_string($xml);
$results = json_decode(json_encode($results));

if(isset($results->code)){
	http_response_code(200);
	$response = array(
	    'results' => array(
	    	'codigo' => $results->code,
	    	'status' => $results->status,
	    	'descricao' => getStatusPagSeguro($results->status),
	    	'metodo' => 3,
	    	'valor' => $ingresso->valor,
	    	'link' => $results->paymentLink
	    )
	);
}else{
	http_response_code(500);
	$response->error = 'Ocorreu um erro na sua transação de pagamento';
	$response->results = $results;
}

echo json_encode($response);