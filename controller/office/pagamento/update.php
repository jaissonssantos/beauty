<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {
    if (!isset(
        $params->codigo,
        $params->valor,
        $params->status,
        $params->link,
        $params->metodo,
        $params->codigoupdate
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $oConexao->beginTransaction();

    $stmt = $oConexao->prepare(
        'UPDATE pagamento
			SET codigo=?,metodo=?,valor=?,link=?,status=?,created_at=now(),updated_at=now()
            WHERE codigo=?'
        );
    $stmt->execute(array(
        $params->codigo,
        $params->metodo,
        $params->valor,
        $params->link,
        $params->status, 
        $params->codigoupdate
    )); 

    $oConexao->commit();

    http_response_code(200);
    $response->success = 'Boleto gerado com sucesso';
} catch (PDOException $e) {
    //echo $e->getMessage();
    http_response_code(500);
    $oConexao->rollBack();
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde: '. $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
