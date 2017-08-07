<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {
    $lotes = isset($params->lotes) ? $params->lotes : null;
    $status = isset($params->status) ? $params->status : 1;

    if (!is_array($lotes)) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $idsLotes = implode(',', $lotes);

    $oConexao->beginTransaction();

    $stmt = $oConexao->prepare(
        'UPDATE lote l SET status=?'.
        'WHERE FIND_IN_SET(cast(l.id AS CHAR), ?)'
    );
    $stmt->execute(array($status, $idsLotes));

    http_response_code(200);
    $response->success = 'Atualizado com sucesso';
    $oConexao->commit();
} catch (PDOException $e) {
    //echo $e->getMessage();
        $oConexao->rollBack();
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

    echo json_encode($response);
