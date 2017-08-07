<?php
use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$response = new stdClass();

try {
    $stmt = $oConexao->prepare('SELECT * FROM lote WHERE status=1');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $count = 0;
    foreach ($results as $row) {
        //ingresso
        $stmt = $oConexao->prepare(
            'SELECT ig.id,ig.idlote,ig.nome,ig.valor,
            (ig.qtd - (SELECT count(pg.id) FROM pagamento pg
                        WHERE pg.idingresso=ig.id)) as qtd 
            FROM ingresso ig
            WHERE
                ig.idlote=?
            AND
                ig.status=1'
        );
        $stmt->execute(array($row['id']));
        $ingresso = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //associar ingresso ao lote
        $results[$count]['ingresso'] = $ingresso; 
        $count++;
    }

    if(!$results){
        throw new Exception('Nenhum resultado encontrado', 404);
    }
    
    http_response_code(200);
    $response = array(
        'results' => $results
    );

} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde';
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);

