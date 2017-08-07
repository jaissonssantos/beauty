<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {

    $stmt = $oConexao->prepare(
        'SELECT
            UPPER(CONCAT(c.nome,\' \', c.sobrenome)) cliente,c.cpf,i.nome ingresso,p.valor,p.codigo,p.status
        FROM pagamento p
        INNER JOIN usuario c ON c.id = p.idusuario
        INNER JOIN ingresso i ON i.id = p.idingresso
        WHERE p.status<>99
        ORDER BY p.id DESC LIMIT 0,20'
    );
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $oConexao->prepare(
        'SELECT
            COUNT(*)
        FROM pagamento
        WHERE status<>99'
    );
    $stmt->execute();
    $count_results_pagamento = $stmt->fetchColumn();

    $stmt = $oConexao->prepare(
        'SELECT
            COUNT(*)
        FROM usuario
        WHERE status=1
        AND gestor=0'
    );
    $stmt->execute();
    $count_results_cliente = $stmt->fetchColumn();

    $stmt = $oConexao->prepare(
        'SELECT
            COUNT(*)
        FROM lote
        WHERE status=1'
    );
    $stmt->execute();
    $count_results_lote = $stmt->fetchColumn();

    $stmt = $oConexao->prepare(
        'SELECT
            COUNT(*)
        FROM ingresso
        WHERE status=1'
    );
    $stmt->execute();
    $count_results_ingresso = $stmt->fetchColumn();

    http_response_code(200);
    $response = array(
        'results' => $results,
        'count' => array(
            'pagamentos' => $count_results_pagamento,
            'clientes' => $count_results_cliente,
            'lotes' => $count_results_lote,
            'ingressos' => $count_results_ingresso
        ),
    );
} catch (PDOException $e) {
    //echo $e->getMessage();
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
