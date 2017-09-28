<?php

use Utils\Conexao;

sleep(1);

header("access-control-allow-origin: *");
header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {

    $id = isset($params->id) && $params->id > 0 ? $params->id : 0;
    $idcliente = isset($params->idcliente) && $params->idcliente > 0 ? $params->idcliente : 0;

    $offset = isset($params->offset) && $params->offset > 0 ? $params->offset : 0;
    $limit = isset($params->limit) && $params->limit < 200 ? $params->limit : 200;

    $stmt = $oConexao->prepare(
        "SELECT att.id,att.nome,att.local,att.cep,att.endereco,att.numero,att.imagem,
            cd.nome cidade,et.sigla estado,
            (select AVG(nota) from artista_avaliacao aa where aa.idartista = att.id) nota,
            (select COUNT(*) from artista_avaliacao aa where aa.idartista = att.id) avaliacao,
            (select COUNT(*) from artista_favorito af where af.idartista = att.id and idcliente = :idcliente) favorito
        FROM artista_servico ats 
        INNER JOIN artista att ON(ats.idartista = att.id)
        LEFT JOIN cidade cd ON(att.idcidade = cd.id)
        LEFT JOIN estado et ON(cd.idestado = et.id)
        WHERE ats.idservico=:id
		LIMIT :offset,:limit"
    );
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->bindParam('idcliente', $idcliente, PDO::PARAM_INT);
    $stmt->bindParam('offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam('limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach($results as &$row) {
        if($row->favorito >= 1){
            $row->favorito = true;    
        }else{
            $row->favorito = false;
        }
        if($row->imagem != null){
            $row->imagem = STORAGE_URL . '/artiste/' . $row->imagem;
        }else{
            $row->imagem = STORAGE_URL . '/artiste/default.jpg';
        }
    }

    http_response_code(200);
    if (!$results) {
        throw new Exception('Nenhum resultado encontrado', 404);
    }
    $response = array(
        'results' => $results
    );
} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa, Tivemos um problema. Erro fatal: '. $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);