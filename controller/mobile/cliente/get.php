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
        $params->id
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $stmt = $oConexao->prepare(
        'SELECT id,nome,sexo,email,telefone,datanascimento
        FROM cliente
        WHERE id=?
        LIMIT 1'
    );

    $stmt->execute(array(
        $params->id
    ));
    $results = $stmt->fetchObject();

    if (!$results) {
        throw new Exception('Cliente não encontrado', 404);
    }

    http_response_code(200);
    $response = $results;
} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa, Tivemos um problema. Erro fatal: '. $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
