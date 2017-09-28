<?php

use Utils\Conexao;

sleep(1);
header("access-control-allow-origin: *");
header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {

    if (!isset(
        $params->email,
        $params->password
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $stmt = $oConexao->prepare(
        'SELECT id,nome,sexo,email,telefone,datanascimento
		FROM cliente
		WHERE email=upper(?) 
		AND 
			senha=?'
    );
    $stmt->execute(array(
        $params->email,
        sha1(SALT.$params->password)
    ));
    $results = $stmt->fetchObject();

    if($results){
        $stmt = $oConexao->prepare(
            'UPDATE cliente 
				SET login_at=now()
			WHERE id=?'
        );
        $stmt->execute(array(
            $results->id
        ));
    } 
    http_response_code(200);
    if (!$results) {
        throw new Exception('Opa! credencial informada está incorreta', 404);
    }
    $response = array(
        'results' => $results
    );

} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa, Tivemos um problema. Erro fatal: '. $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
