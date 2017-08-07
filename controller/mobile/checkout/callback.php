<?php
	
use Utils\Conexao;

header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
header("access-control-allow-origin: https://pagseguro.uol.com.br");
header("access-control-allow-origin: http://pagseguro.uol.com.br");
header("access-control-allow-origin: *");
header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$response = new stdClass();

//phpmailer
include_once BASE_DIR.'/vendor/phpmailer/class.phpmailer.php';
include_once BASE_DIR.'/vendor/phpmailer/class.smtp.php';

if(isset(
	$_POST['notificationCode'],
	$_POST['notificationType']
)) 	{

	//configurações
	$codigo = $_POST['notificationCode'];
	$url = notificationsURL.'/'.$codigo.'?email='.PAGSEGURO_EMAIL.'&token='.PAGSEGURO_TOKEN;
	
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	
	$xml = curl_exec($curl);
	$http = curl_getinfo($curl); //info http

	if($xml == 'Unauthorized'){
		//objeto
		$results = simplexml_load_string($xml);
		$results = json_decode(json_encode($results));

		http_response_code(500);
		$response->error = 'Foi enviado um e-mail para o suporte de notificação da transação';
		$response->results = $results;

		/*enviar e-mail para o suporte*/
		$html = '<p>'. $results .'</p>';
		envia_email(
			'jaissonssantos@gmail.com', 
			'Erro de notificação PagSeguro',
			$html,
			'kambo.tecnologia@gmail.com',
			'Suporte' 
		);

	}else{
		//objeto
		$results = simplexml_load_string($xml);
		$results = json_decode(json_encode($results));

		//get
		$stmt = $oConexao->prepare(
	        'SELECT
				id,codigo,status
			FROM pagamento
			WHERE codigo=?
			LIMIT 1'
	    );

	    $stmt->execute(array($results->code));
	    $pagamento = $stmt->fetchObject();

	    if($pagamento->status != 3){
			//pagamento
			$stmt = $oConexao->prepare(
			    'UPDATE pagamento SET status=?,updated_at=now() WHERE codigo=?'
			);
			$stmt->execute(array(
			    $results->status,
			    $results->code
			));

			http_response_code(200);
			$response->success = 'Transação atualizada com sucesso';
		}
	}
 
   	$today = date("Y_m_d");
   	$file = fopen("LogPagSeguro.$today.txt", "ab");
   	$hour = date("H:i:s T");
   	fwrite($file,"Log de Notificações e consulta\\\\r\\\\n");
   	fwrite($file,"Hora da consulta: $hour \\\\r\\\\n");
   	fwrite($file,"HTTP: ".$http['http_code']." \\\\r\\\\n");
   	fwrite($file,"Código de Notificação:".$codigo." \\\\r\\\\n");
   	fwrite($file, "Código da transação:".$results->code."\\\\r\\\\n");
   	fwrite($file, "Status da transação:".$results->status."\\\\r\\\\n");
  	fwrite($file,"____________________________________ \\\\r\\\\n");
   	fclose($file);

}else{
	http_response_code(500);
	$response->error = 'Ocorreu um erro na notificação da transação';
}

echo json_encode($response);