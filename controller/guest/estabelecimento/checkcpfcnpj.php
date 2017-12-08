<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {
    if (!isset($params->cpfcnpj)) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $stmt = $oConexao->prepare('SELECT id, cpfcnpj FROM estabelecimento WHERE upper(cpfcnpj) = upper(?) LIMIT 1');
    $stmt->execute(array($params->cpfcnpj));
    $results = $stmt->fetchObject();

    http_response_code(200);
    if (!$results) {
       $response->error =  'CNPJ/CPF não cadastrados';
    }else{
        $response->success = 'CNPJ/CPF encontrado';
    }
    
} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
