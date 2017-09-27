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

    $stmt = $oConexao->prepare(
        'SELECT count(id) as qtd
        FROM artista_favorito
        WHERE
            idartista=?
        AND
            idcliente=?'
    );

    $stmt->execute(array(
        $params->id,
        $params->idcliente
    ));
    $results = $stmt->fetchObject();

    if($results->qtd < 1){
        $stmt = $oConexao->prepare('INSERT INTO
                     artista_favorito(idartista,idcliente
                    ) VALUES (?,?)');
        $stmt->execute(array(
            $params->id,
            $params->idcliente
        ));
        $response->success = 'Favoritado com sucesso';
        $response->favorite = true;
    }else{
        $stmt = $oConexao->prepare(
            'DELETE FROM artista_favorito WHERE idartista=? AND idcliente=?'
        );
        $stmt->execute(array(
            $params->id,
            $params->idcliente
        ));
        $response->success = 'Artista desfavoritado';
        $response->favorite = false;
    }

    $oConexao->commit();

    http_response_code(200);
    
} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde. '. $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
