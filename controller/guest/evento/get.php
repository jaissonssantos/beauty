<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {

    if (!isset(
        $params->slug
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $stmt = $oConexao->prepare(
        'SELECT
            e.hash,e.id,UPPER(e.nome) nome,UPPER(c.nome) categoria, e.faixa,e.local,e.descricao,e.pais,
            DATE_FORMAT(e.data, "%d/%m/%Y") data,
            DATE_FORMAT(e.data, "%d") dia,
            DATE_FORMAT(e.data, "%M") mes,
            DATE_FORMAT(e.termino, "%d/%m/%Y") termino,
            (SELECT i.imagem 
                FROM evento_imagem i
                WHERE e.id = i.idevento LIMIT 1) imagem
        FROM evento e
        INNER JOIN categoria c ON e.idcategoria = c.id
        WHERE e.hash = :slug
		ORDER BY nome ASC, id DESC'
    );

    $stmt->execute(
        array(
            'slug' => $params->slug
        )
    );
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$results) {
        throw new Exception('Não encontrado', 404);
    }

    http_response_code(200);
    $response = $results;

} catch (PDOException $e) {
    //echo $e->getMessage();
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde: ' . $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
