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

    $stmt = $oConexao->prepare(
        'SELECT 
                ag.id,ag.inicio start,ag.fim end,serv.nome title,art.id resourceId
            FROM agenda ag 
            LEFT JOIN servico serv ON(ag.idservico = serv.id)
            LEFT JOIN artista art ON(ag.idartista = art.id)
        WHERE art.idempresa=:idempresa
        LIMIT :offset,:limit'
    );
    $stmt->bindParam('idempresa', $idempresa);
    $stmt->bindParam('offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam('limit', $limit, PDO::PARAM_INT);

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $oConexao->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);

    http_response_code(200);
    $response = array(
        'results' => $results,
        'count' => $count,
    );

} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
    echo $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
