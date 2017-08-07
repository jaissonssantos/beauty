<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {
    if (!isset(
        $_POST['nome']
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $oConexao->beginTransaction();

    $stmt = $oConexao->prepare(
        'UPDATE lote
			SET nome=?,updated_at=now()
			WHERE id=?'
        );
    $stmt->execute(array(
        $_POST['nome'],
        $_POST['id']
    )); 

    //adicionar ou atualizar ingressos
    $count_ingresso = sizeof($_POST['ingressoId']);
    for($i=0; $i<$count_ingresso; $i++){
        
        //params
        $ingressoId = $_POST['ingressoId'][$i];
        $ingressoNome = $_POST['ingressoNome'][$i];
        $ingressoQtd = $_POST['ingressoQtd'][$i];
        $ingressoValor = $_POST['ingressoValor'][$i];

        $stmt = $oConexao->prepare(
            'SELECT 
                COUNT(*)
            FROM ingresso 
            WHERE id = ?'
        );
        $stmt->execute(array(
            $ingressoId
        ));
        $count = $stmt->fetchColumn();

        if($count){
            //update
            $stmt = $oConexao->prepare(
                'UPDATE ingresso
                    SET nome=?,qtd=?,valor=?,updated_at=now()
                    WHERE id=?'
                );
            $stmt->execute(array(
                $ingressoNome,
                $ingressoQtd,
                converteValorMonetario($ingressoValor),
                $ingressoId
            )); 
        }else{
            //insert
            $stmt = $oConexao->prepare(
            'INSERT INTO
                ingresso(
                    idlote,nome,qtd,valor,status,created_at,updated_at
                ) VALUES (
                    ?,?,?,?,1,now(),now()
                )');

            $stmt->execute(array(
                $_POST['id'],
                $ingressoNome,
                $ingressoQtd,
                converteValorMonetario($ingressoValor)
            ));
        }

    }

    //atualizar ingressos
    $count_ingresso = isset($_POST['removeId']) 
                            ? sizeof($_POST['removeId']) 
                            : 0;
    for($i=0; $i<$count_ingresso; $i++){

        //params
        $ingressoId = $_POST['removeId'][$i];

        //update status
        $stmt = $oConexao->prepare(
            'UPDATE ingresso
                SET status=2
                WHERE id=?'
            );
        $stmt->execute(array(
            $ingressoId
        )); 
    }

    $oConexao->commit();

    http_response_code(200);
    $response->success = 'Atualizado com sucesso';
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
