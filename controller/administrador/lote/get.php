<?php

use Utils\Conexao;

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
        'SELECT id,nome,status
        FROM lote
        WHERE id=?
        LIMIT 1'
    );

    $stmt->execute(array(
        $params->id
    ));
    $results = $stmt->fetchObject();

    $stmt = $oConexao->prepare(
        'SELECT id,nome,qtd,valor,status
        FROM ingresso
        WHERE idlote=?
        AND status=1'
    );
    $stmt->execute(array(
        $params->id
    ));
    $results->ingresso = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$results) {
        throw new Exception('Não encontrado', 404);
    }

    http_response_code(200);
    $response = $results;
} catch (PDOException $e) {
    //echo $e->getMessage();
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
