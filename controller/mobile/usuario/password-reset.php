<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

//phpmailer
require_once '../vendor/phpmailer/class.phpmailer.php';
require_once '../vendor/phpmailer/class.smtp.php';

try {

    if (!isset(
        $params->email
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $stmt = $oConexao->prepare('
        SELECT id,nome,sobrenome,cpf,email
            FROM usuario
            WHERE email=upper(?)
    ');
    $stmt->execute(array(
        $params->email
    ));
    $results = $stmt->fetchObject();

    if (!$results) {
        throw new Exception('E-mail não encontrado', 404);
    }
        
    $send_email = 0;
    $code = microtime();
    $token = base64_encode($params->email.'@@@'.$code);
    $ip_host = $_SERVER['REMOTE_ADDR'];
    $url = URL_APP.'/password-change/'.$token;

    /**
     * layout send e-mail cliente.
     *
     * @login      login ou nome do cliente
     * @email      e-mail do cliente(solicitante)
     * @url        url para o cliente mudar a senha
     */
    $layout = sendPasswordReset(
        $results->nome, 
        $results->email, 
        $url
    );

    if (envia_email(
        $results->nome,
        $results->email,
        'Redefina sua senha',
        $layout,
        EMAIL_NOREPLAY
    )) {
        $send_email++;
    }

    if ($send_email >= 1) {

        //token
        $stmt = $oConexao->prepare('INSERT INTO usuario_token(token,idusuario,ip,created_at,active_at
            ) VALUES(?,?,?,NOW(),DATE_ADD(NOW(), INTERVAL 3 DAY))');
        $stmt->execute(array(
            $token,
            $results->id,
            $ip_host
        ));

        http_response_code(200);
        $response->success = 'Foi enviado um e-mail para você com instruções de como redefinir sua senha, por favor verifique sua caixa de entrada';

    } else {
        throw new Exception('E-mail de recuperação não enviado até o momento, aguarde instantes ou solicite novamente', 404);
    }

    
} catch (PDOException $e) {
    http_response_code(500);
    // $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
    $response->error = $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);