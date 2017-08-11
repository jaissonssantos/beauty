<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {
    if (!isset($params->cpf)) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $stmt = $oConexao->prepare('SELECT id,cpf FROM usuario WHERE upper(cpf) = upper(?) LIMIT 1');
    $stmt->execute(array($params->cpf));
    $results = $stmt->fetchObject();

    http_response_code(200);
    if (!$results) {
        $response->error = 'CPF não cadastrado';
    }else{
        $response->success = 'CPF encontrado';
    }

} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
