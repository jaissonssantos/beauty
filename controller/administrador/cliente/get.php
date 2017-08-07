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
            c.id,UPPER(CONCAT(c.nome,\' \', c.sobrenome)) cliente,c.nome,c.sobrenome,c.cpf,c.cracha,c.email,c.telefone,c.sexo,
            cid.nome cidade,cid.id idcidade,cid.idestado,ps.nome pais,ps.id idpais,
            DATE_FORMAT(c.created_at, "%d/%m/%Y %h\h%i") created_at,
            DATE_FORMAT(c.updated_at, "%d/%m/%Y %h\h%i") updated_at
        FROM usuario c
        LEFT JOIN cidade cid ON c.idcidade = cid.id
        RIGHT JOIN pais ps ON c.idpais = ps.id
        WHERE c.id=?
        LIMIT 1'
    );

    $stmt->execute(array(
        $params->id
    ));
    $results = $stmt->fetchObject();

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
