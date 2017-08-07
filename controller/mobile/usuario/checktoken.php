<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {

    if (!isset(
        $params->token
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $stmt = $oConexao->prepare('
        SELECT id
            FROM usuario_token
            WHERE token=?
            AND active_at>=NOW()
    ');
    $stmt->execute(array(
        $params->token
    ));
    $results = $stmt->fetchObject();

    if (!$results) {
        throw new Exception('Token não encontrado', 404);
    }
        
    http_response_code(200);
    $response->success = 'success';

    
} catch (PDOException $e) {
    http_response_code(500);
    // $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
    $response->error = $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);