<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();
$response->count = array('pagas' => 0, 'pendentes' => 0, 'cancelados' => 0, 'estornados' => 0);

try {
    $offset = isset($params->offset) && $params->offset > 0
                        ? $params->offset
                        : 0;
    $limit = isset($params->limit) && $params->limit < 200
                        ? $params->limit
                        : 200;

    $status = isset($params->status) && $params->status == 99
                        ? ' p.status <> :status'
                        : ' p.status = :status';

    $search = isset($params->search[0])
                        ? ' AND
								(
									p.codigo LIKE :query OR
									c.nome LIKE :query OR
                                    c.sobrenome LIKE :query OR
									c.cpf LIKE :query
								)
							'
                        : null;

    $stmt = $oConexao->prepare(
        'SELECT
            UPPER(CONCAT(c.nome,\' \', c.sobrenome)) cliente,c.nome,c.sobrenome,c.cpf,c.email,i.id idingresso,i.nome ingresso,
            p.id,p.valor,p.codigo,p.metodo,p.status,p.link,
            DATE_FORMAT(p.created_at, "%d/%m/%Y %h\h%i") created_at
        FROM pagamento p
        INNER JOIN usuario c ON c.id = p.idusuario
        INNER JOIN ingresso i ON i.id = p.idingresso
        WHERE '.$status.' '.$search.'
		ORDER BY p.id DESC, p.updated_at DESC
        LIMIT :offset,:limit'
    );
    $stmt->bindParam('offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam('limit', $limit, PDO::PARAM_INT);

    if (isset($params->search[0])) {
        $query = '%'.$params->search.'%';
        $stmt->bindParam('query', $query);
    }

    $stmt->bindParam('status', $params->status, PDO::PARAM_INT);

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $count = $oConexao->prepare(
        'SELECT
			COUNT(*)
		FROM pagamento p
        INNER JOIN usuario c ON c.id = p.idusuario
        INNER JOIN ingresso i ON i.id = p.idingresso
		WHERE '.$status.' '.$search
    );

    if (isset($params->search[0])) {
        $query = '%'.$params->search.'%';
        $count->bindParam('query', $query);
    }

    $status = $params->status;
    $count->bindParam('status', $status);
    $count->execute();
    $count_results = $count->fetchColumn();

    $status = 1;
    $count->bindParam('status', $status);
    $count->execute();
    $count_aguardando = $count->fetchColumn();

    $status = 2;
    $count->bindParam('status', $status);
    $count->execute();
    $count_analise = $count->fetchColumn();

    $status = 3;
    $count->bindParam('status', $status);
    $count->execute();
    $count_paga = $count->fetchColumn();

    $status = 7;
    $count->bindParam('status', $status);
    $count->execute();
    $count_cancelada = $count->fetchColumn();

    http_response_code(200);
    $response = array(
        'results' => $results,
        'count' => array(
            'results' => $count_results,
            'aguardando' => $count_aguardando,
            'analise' => $count_analise,
            'paga' => $count_paga,
            'cancelada' => $count_cancelada
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
