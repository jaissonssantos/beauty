<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {

    $idempresa = $_SESSION['labella_empresa'];

    if (!isset($idempresa)) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $offset = isset($params->offset) && $params->offset > 0
                        ? $params->offset
                        : 0;
    $limit = isset($params->limit) && $params->limit < 200
                        ? $params->limit
                        : 200;
    $field = isset($params->id[0]) 
                        ? ' AND
                                art.idartista=:idartista
                            '
                        : null;

    $stmt = $oConexao->prepare(
        'SELECT
            sev.id,sev.nome,sev.duracao,art.valor
        FROM servico sev
        INNER JOIN artista_servico art ON(sev.id = art.idservico)
        WHERE art.idempresa=:idempresa '.$field.'
        GROUP BY sev.id
        LIMIT :offset,:limit'
    );
    $stmt->bindParam('idempresa', $idempresa);
    $stmt->bindParam('offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam('limit', $limit, PDO::PARAM_INT);

    if (isset($params->id[0])) {
        $stmt->bindParam('idartista', $params->id);
    }

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $oConexao->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);

    http_response_code(200);
    $response = array(
        'results' => $results,
        'count' => $count
    );
} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde: '. $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
