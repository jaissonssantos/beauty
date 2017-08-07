<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {
    if (!isset(
        $params->usuario->nome,
        $params->usuario->sobrenome,
        $params->usuario->cpf,
        $params->usuario->email, 
        $params->usuario->senha,
        $params->usuario->ingresso,
        $params->usuario->sexo,
        $params->usuario->cracha,
        $params->usuario->deficiencia,
        $params->usuario->pais,
        $params->usuario->cidade,
        $params->pagamento->codigo,
        $params->pagamento->metodo,
        $params->pagamento->status,
        $params->pagamento->valor
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $oConexao->beginTransaction();

    //criptografia da senha com SALT
    $params->usuario->senha = sha1(SALT.$params->usuario->senha);

    //verifica se tem link
    if(!isset($params->pagamento->link))
        $params->pagamento->link = null;


    $stmt = $oConexao->prepare('INSERT INTO
                 usuario(idingresso,nome,sobrenome,cracha,sexo,email,telefone,
                 cpf,senha,idpais,idcidade,iddeficiencia,created_at,updated_at
                ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,now(),now())');
    $stmt->execute(array(
        $params->usuario->ingresso,
        $params->usuario->nome,
        $params->usuario->sobrenome, 
        $params->usuario->cracha,
        $params->usuario->sexo,
        $params->usuario->email,
        $params->usuario->telefone,
        $params->usuario->cpf,
        $params->usuario->senha,
        $params->usuario->pais,
        $params->usuario->cidade,
        $params->usuario->deficiencia
    ));    

    $usuario_id = $oConexao->lastInsertId();

    //pagamento do usuário
    $stmt = $oConexao->prepare('INSERT INTO
                 pagamento(idingresso,idusuario,codigo,metodo,valor,status,link,created_at,updated_at
                ) VALUES (?,?,?,?,?,?,?,now(),now())');
    $stmt->execute(array(
        $params->usuario->ingresso,
        $usuario_id,
        $params->pagamento->codigo, 
        $params->pagamento->metodo,
        $params->pagamento->valor,
        $params->pagamento->status,
        $params->pagamento->link
    ));

    //permissões do usuário
    $stmt = $oConexao->prepare(
    'INSERT INTO usuario_permissao(
            idusuario,regra
        ) VALUES (
            :idusuario,:regra
        )');
    $usuario_permissao = array('idusuario' => $usuario_id);
    $regras = array(
        '/dashboard', '/certificado', '/conta'
    );
    foreach ($regras as $regra) {
        $usuario_permissao['regra'] = $regra;
        $stmt->execute($usuario_permissao);
    }

    $_SESSION['congresso_uid'] = $usuario_id;
    $_SESSION['congresso_nome'] = $params->usuario->nome;
    $_SESSION['congresso_sobrenome'] = $params->usuario->sobrenome;
    $_SESSION['congresso_email'] = $params->usuario->email;
    $_SESSION['congresso_cpf'] = $params->usuario->cpf;
    $_SESSION['congresso_gestor'] = false;

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
