<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {

    if (!isset(
        $params->email,
        $params->senha
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $stmt = $oConexao->prepare(
        'SELECT id,nome,sobrenome,email,cpf,gestor
		FROM usuario
		WHERE email=upper(?) 
		AND 
			senha=?
		AND
			status=1'
    );
    $stmt->execute(array(
        $params->email,
        sha1(SALT.$params->senha)
    ));
    $results = $stmt->fetchObject();

    if($results){
        $_SESSION['congresso_uid'] = $results->id;
        $_SESSION['congresso_nome'] = $results->nome;
        $_SESSION['congresso_sobrenome'] = $results->sobrenome;
        $_SESSION['congresso_cpf'] = $results->cpf;
        $_SESSION['congresso_email'] = $results->email;
        $_SESSION['congresso_gestor'] = $results->gestor;
        $stmt = $oConexao->prepare(
            'UPDATE usuario 
				SET login_at=now()
			WHERE id=?'
        );
        $stmt->execute(array(
            $results->id
        ));
    } 
    http_response_code(200);
    if (!$results) {
        throw new Exception('Favor verifique os dados, credenciais informada está incorreta', 404);
    }
    $response = array(
        'results' => $results
    );

} catch (PDOException $e) {
    echo $e->getMessage();
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
