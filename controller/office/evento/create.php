<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {
    
    $oConexao->beginTransaction();

    // Gerar url (hash) do questionário
    $hash = friendlyURL($_POST['nome']);
    
    $stmt = $oConexao->prepare(
    'INSERT INTO
		evento(
			hash,idcategoria,idempresa,nome,local,descricao,faixa,pais,data,termino,status
		) VALUES (
			?,?,?,?,?,?,?,?,?,?,1
		)');

    $stmt->execute(array(
        $hash,
        $_POST['categoria'],
        $_SESSION['eventos_empresa'],
        $_POST['nome'],
        $_POST['local'],
        $_POST['descricao'],
        $_POST['faixa'],
        $_POST['pais'],
        formata_data($_POST['data']),
        formata_data($_POST['termino'])
    ));
    $idevento = $oConexao->lastInsertId();

    if(!empty($_POST['foto1'])){
        $stmt = $oConexao->prepare(
        'INSERT INTO
            evento_imagem(
                idevento, imagem
            ) VALUES (
                ?,?
            )');

        $stmt->execute(array(
            $idevento,
            $_POST['foto1']
        ));
    }

    if(!empty($_POST['foto2'])){
        $stmt = $oConexao->prepare(
        'INSERT INTO
            evento_imagem(
                idevento, imagem
            ) VALUES (
                ?,?
            )');

        $stmt->execute(array(
            $idevento,
            $_POST['foto2']
        ));
    }

    if(!empty($_POST['foto3'])){
        $stmt = $oConexao->prepare(
        'INSERT INTO
            evento_imagem(
                idevento, imagem
            ) VALUES (
                ?,?
            )');

        $stmt->execute(array(
            $idevento,
            $_POST['foto3']
        ));
    }

    if(!empty($_POST['foto4'])){
        $stmt = $oConexao->prepare(
        'INSERT INTO
            evento_imagem(
                idevento, imagem
            ) VALUES (
                ?,?
            )');

        $stmt->execute(array(
            $idevento,
            $_POST['foto4']
        ));
    }

    if(!empty($_POST['foto5'])){
        $stmt = $oConexao->prepare(
        'INSERT INTO
            evento_imagem(
                idevento, imagem
            ) VALUES (
                ?,?
            )');

        $stmt->execute(array(
            $idevento,
            $_POST['foto5']
        ));
    }


    $oConexao->commit();

    http_response_code(200);
    $response->success = 'Cadastrado com sucesso';

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
