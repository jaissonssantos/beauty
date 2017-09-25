<?php

use Utils\Conexao;

header("access-control-allow-origin: *");
header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {
    if (!isset(
        $params->id,
        $params->idcliente
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $oConexao->beginTransaction();

    $stmt = $oConexao->prepare('INSERT INTO
                 artista_favorito(idartista,idcliente
                ) VALUES (?,?)');
    $stmt->execute(array(
        $params->id,
        $params->idcliente
    ));

    $oConexao->commit();

    http_response_code(200);
    $response->success = 'Favoritado com sucesso';
} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde. '. $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
