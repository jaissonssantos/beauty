<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();
$response->count = array('ativos' => 0, 'inativos' => 0, 'arquivados' => 0);

try {
    $offset = isset($params->offset) && $params->offset > 0
                        ? $params->offset
                        : 0;
    $limit = isset($params->limit) && $params->limit < 200
                        ? $params->limit
                        : 200;

    $status = isset($params->status)
                        ? $params->status
                        : 1;

    $search = isset($params->search[0])
                        ? ' AND
								(
									id LIKE :query OR
									nome LIKE :query OR
									email LIKE :query
								)
							'
                        : null;

    $idempresa = $_SESSION['labella_empresa'];

    $stmt = $oConexao->prepare(
        'SELECT
			id,nome title
		FROM artista
		WHERE 
            idempresa = :idempresa 
        AND 
            status = :status '.$search.'
		LIMIT :offset,:limit'
    );
    $stmt->bindParam('idempresa', $idempresa);
    $stmt->bindParam('offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam('limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam('status', $status, PDO::PARAM_INT);

    if (isset($params->search[0])) {
        $query = '%'.$params->search.'%';
        $stmt->bindParam('query', $query);
    }

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $count = $oConexao->prepare(
        'SELECT
			COUNT(*)
		FROM artista
		WHERE 
            idempresa = :idempresa 
        AND 
            status = :status' .' '.$search
    );

    if (isset($params->search[0])) {
        $query = '%'.$params->search.'%';
        $count->bindParam('query', $query);
    }

    $count->bindParam('idempresa', $idempresa);
    $count->bindParam('status', $status);
    $count->execute();
    $count_results = $count->fetchColumn();

    $status = 1;
    $count->bindParam('idempresa', $idempresa);
    $count->bindParam('status', $status);
    $count->execute();
    $count_ativos = $count->fetchColumn();

    $status = 2;
    $count->bindParam('idempresa', $idempresa);
    $count->bindParam('status', $status);
    $count->execute();
    $count_inativos = $count->fetchColumn();

    $status = 3;
    $count->bindParam('idempresa', $idempresa);
    $count->bindParam('status', $status);
    $count->execute();
    $count_arquivados = $count->fetchColumn();

    http_response_code(200);
    $response = array(
        'results' => $results,
        'count' => array(
            'results' => $count_results,
            'ativos' => $count_ativos,
            'inativos' => $count_inativos,
            'arquivados' => $count_arquivados,
        ),
    );
} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
