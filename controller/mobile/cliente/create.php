<?php

use Utils\Conexao;

header("access-control-allow-origin: *");
header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {
    if (!isset(
        $params->name,
        $params->gender,
        $params->email, 
        $params->password,
        $params->phone
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $oConexao->beginTransaction();

    $stmt = $oConexao->prepare(
        'SELECT id FROM cliente WHERE upper(email) = upper(?) LIMIT 1'
    );
    $stmt->execute(array(
        $params->email
    ));
    $results = $stmt->fetchObject();
    if ($results)
        throw new Exception('Opa! Email já cadastrado', 404);

    $stmt = $oConexao->prepare(
        'SELECT id FROM cliente WHERE telefone = ? LIMIT 1'
    );
    $stmt->execute(array(
        $params->phone
    ));
    $results = $stmt->fetchObject();
    if ($results)
        throw new Exception('Opa! Telefone já cadastrado', 404);

    //criptografia da senha com SALT
    $params->password = sha1(SALT.$params->password);

    //data de nascimento
    if(!isset($params->date))
        $params->date = null;


    $stmt = $oConexao->prepare('INSERT INTO
                 cliente(nome,sexo,email,senha,telefone,datanascimento,created_at,updated_at,login_at
                ) VALUES (?,?,?,?,?,?,now(),now(),now())');
    $stmt->execute(array(
        $params->name,
        $params->gender,
        $params->email,
        $params->password,
        $params->phone,
        $params->date
    ));

    //set id
    $params->id = $oConexao->lastInsertId('id');

    http_response_code(200);
    $response = array(
        'success' => 'Bem vindo(a) seu cadastrado foi efetuado com successo',
        'results' => array(
            'id' => $params->id,
            'nome' => $params->name,
            'sexo' => $params->gender,
            'email' => $params->email,
            'phone' => $params->phone,
            'datanascimento' => $params->date
        )
    );

    $oConexao->commit();

} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa, Tivemos um problema. Erro fatal: '. $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
