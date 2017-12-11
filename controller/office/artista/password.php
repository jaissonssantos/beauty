<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {
    if (!isset(
        $_SESSION['labella_uid'],
        $params->senha,
        $params->atual
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $oConexao->beginTransaction();

    $params->senha = sha1(SALT.$params->senha);
    $id = $_SESSION['labella_uid'];

     $stmt = $oConexao->prepare(
        'SELECT count(id) total
        FROM artista
        WHERE 
            id=?
        AND
            senha=?
        AND
            status=1'
    );
    $stmt->execute(array(
        $id,
        sha1(SALT.$params->atual)
    ));
    $results = $stmt->fetchObject();

    if($results->total < 1){
        throw new Exception('Sua senha não foi atualizada', 400);
    }

    $stmt = $oConexao->prepare(
        'UPDATE artista 
            SET senha=? 
            WHERE id=?'
    );
    $stmt->execute(array(
        $params->senha,
        $id
    ));

    $oConexao->commit();

    http_response_code(200);
    $response->success = 'Senha redefinida com sucesso';
} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
