<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {

    $stmt = $oConexao->prepare(
        'SELECT
            *
        FROM categoria'
    );
    
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $oConexao->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);

    http_response_code(200);
    $response = array(
        'results' => $results,
        'count' => $count
    );
} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde: '. $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
