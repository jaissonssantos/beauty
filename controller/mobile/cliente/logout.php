<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {

	if(session_id()){
		unset($_SESSION['congresso_uid']);
		unset($_SESSION['congresso_nome']);
		unset($_SESSION['congresso_sobrenome']);
		unset($_SESSION['congresso_email']);
		unset($_SESSION['congresso_perfil']);
		unset($_SESSION['congresso_gestor']);
		unset($_SESSION['congresso_estabelecimento']);
		$response->success = 'Usuário saiu da plataforma';
		http_response_code(200);
	}

} catch (PDOException $e) {
    echo $e->getMessage();
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);