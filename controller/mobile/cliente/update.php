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
        $params->name,
        $params->phone,
        $params->date
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $oConexao->beginTransaction();

    $stmt = $oConexao->prepare(
        'SELECT id FROM cliente WHERE telefone = ? LIMIT 1'
    );
    $stmt->execute(array(
        $params->phone
    ));
    $results = $stmt->fetchObject();
    if ($results->id != $params->id)
        throw new Exception('Opa! Telefone já cadastrado', 404);

    //data de nascimento
    if(!isset($params->date))
        $params->date = null;


    $stmt = $oConexao->prepare('UPDATE cliente SET 
        nome=?,telefone=?,datanascimento=?,updated_at=now()
        WHERE id=?');
    $stmt->execute(array(
        $params->name,
        $params->phone,
        $params->date,
        $params->id
    ));

    http_response_code(200);
    $response->success = 'Atualizado com successo';

    $oConexao->commit();

} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa, Tivemos um problema. Erro fatal: '. $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
