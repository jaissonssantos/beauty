<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {

    if (!isset(
        $params->token,
        $params->senha
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $stmt = $oConexao->prepare('
        SELECT c.id,c.nome,c.sobrenome,c.cpf,c.email,c.gestor
            FROM usuario_token t
            INNER JOIN usuario c ON(c.id=t.idusuario)
            WHERE t.token=?
            AND t.active_at>=NOW()
    ');
    $stmt->execute(array(
        $params->token
    ));
    $results = $stmt->fetchObject();

    if (!$results) {
        throw new Exception('Token não encontrado', 404);
    }

    $stmt = $oConexao->prepare('
        UPDATE usuario 
            SET senha=?
        WHERE id=?
    ');
    $stmt->execute(array(
        sha1(SALT.$params->senha),
        $results->id
    ));

    //session
    $_SESSION['congresso_uid'] = $results->id;
    $_SESSION['congresso_nome'] = $results->nome;
    $_SESSION['congresso_sobrenome'] = $results->sobrenome;
    $_SESSION['congresso_cpf'] = $results->cpf;
    $_SESSION['congresso_email'] = $results->email;
    $_SESSION['congresso_gestor'] = $results->gestor;

    $stmt = $oConexao->prepare(
        'UPDATE usuario 
            SET login_at=NOW()
        WHERE id=?'
    );
    $stmt->execute(array(
        $results->id
    ));
        
    http_response_code(200);
    $response->success = 'success';
    $response->results = $results;

    
} catch (PDOException $e) {
    http_response_code(500);
    // $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
    $response->error = $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);