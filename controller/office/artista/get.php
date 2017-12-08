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
        'SELECT id,idempresa,nome,email,idprofissao,status,
            DATE_FORMAT(created_at, "%d/%m/%Y %h\h%i") created_at,
            DATE_FORMAT(updated_at, "%d/%m/%Y %h\h%i") updated_at
        FROM artista 
        WHERE id=?
        LIMIT 1'
    );

    $stmt->execute(array(
        $params->id
    ));
    $results = $stmt->fetchObject();

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
