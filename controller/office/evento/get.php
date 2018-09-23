<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {
    
    if (!isset(
        $params->id
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $stmt = $oConexao->prepare(
        'SELECT
            e.hash,e.id,UPPER(e.nome) nome,UPPER(c.nome) categoria, e.faixa,e.local,e.descricao,e.pais,
            DATE_FORMAT(e.data, "%d/%m/%Y") data,
            DATE_FORMAT(e.termino, "%d/%m/%Y") termino
        FROM evento e
        INNER JOIN categoria c ON e.idcategoria = c.id
        WHERE e.id=:id'
    );

    $stmt->execute(
        array(
            'id' => $params->id
        )
    );
    $results = $stmt->fetchObject();

    $codeContents = URL_APP.'/events/'.$results->hash; 
    QRcode::png($codeContents, $results->hash.'007_1.png', QR_ECLEVEL_L, 4); 
    $results->qrcode = $results->hash.'007_1.png';

    //images
    $stmt = $oConexao->prepare(
        'SELECT i.imagem
        FROM evento_imagem i
        LEFT JOIN evento e ON(i.idevento = e.id)
        WHERE
            e.id=:id');
    $stmt->execute(
        array(
            'id' => $params->id
        )
    );

    $imagem = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $results->imagem = $imagem;

    if (!$results) {
        throw new Exception('Não encontrado', 404);
    }

    http_response_code(200);
    $response = $results;
} catch (PDOException $e) {
    //echo $e->getMessage();
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
