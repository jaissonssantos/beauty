<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {
    if (!isset(
        $params->nome,
        $params->sexo,
        $params->email, 
        $params->senha,
        $params->telefone,
        $params->datanascimento
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $oConexao->beginTransaction();

    //criptografia da senha com SALT
    $params->senha = sha1(SALT.$params->senha);

    //data de nascimento
    if(!isset($params->datanascimento))
        $params->datanascimento = null;


    $stmt = $oConexao->prepare('INSERT INTO
                 cliente(nome,sexo,email,senha,telefone,datanascimento,created_at,updated_at
                ) VALUES (?,?,?,?,?,?,now(),now())');
    $stmt->execute(array(
        $params->nome,
        $params->sexo,
        $params->email,
        $params->senha,
        $params->telefone,
        $params->datanascimento
    ));

    $oConexao->commit();

    http_response_code(200);
    $response->success = 'Cadastrado sucesso';
} catch (PDOException $e) {
    http_response_code(500);
    // $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
    $response->error = $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
