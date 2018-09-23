<?php

// use Utils\Conexao;

// header('Content-type: application/json');
// $oConexao = Conexao::getInstance();
// $response = new stdClass();

// try {
    
echo $url_path.'<br/>';
echo $url_subpath.'<br/>';
echo $url_file.'<br/>';
echo $url_params.'<br/>';

    // if (!isset(
    //     $_GET['id']
    // )) {
    //     throw new Exception('Verifique os dados preenchidos', 400);
    // }

    // $stmt = $oConexao->prepare(
    //     'SELECT
    //         hash
    //     FROM evento
    //     WHERE id=:id'
    // );

    // $stmt->execute(
    //     array(
    //         'id' => $_GET['id']
    //     )
    // );
    // $results = $stmt->fetchObject();

    // if (!$results) {
    //     throw new Exception('Não encontrado', 404);
    // }
    
    // http_response_code(200);
    // QRcode::png($results['hash']);

    // echo $_GET['id'];

    
// } catch (PDOException $e) {
//     //echo $e->getMessage();
//     http_response_code(500);
//     $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
// } catch (Exception $e) {
//     http_response_code($e->getCode());
//     $response->error = $e->getMessage();
// }

// echo json_encode($response);
