<?php

use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {

    if (!isset(
        $_SESSION['congresso_uid']
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    //params
    $cliente_id = $_SESSION['congresso_uid'];

    $stmt = $oConexao->prepare(
        'SELECT
            c.id,UPPER(CONCAT(c.nome,\' \', c.sobrenome)) cliente,c.nome,c.sobrenome,
            c.cpf,c.cracha,c.email,c.telefone,c.sexo,i.id idingresso,i.nome ingresso,l.nome lote,p.valor,
            p.codigo,p.metodo,p.status,
            cid.nome cidade,cid.id idcidade,cid.idestado,ps.nome pais,ps.id idpais,
            DATE_FORMAT(c.created_at, "%d/%m/%Y %h\h%i") created_at,
            DATE_FORMAT(c.updated_at, "%d/%m/%Y %h\h%i") updated_at,
            DATE_FORMAT(c.login_at, "%d/%m/%Y %h\h%i") login_at,
            DATE_FORMAT(p.created_at, "%d/%m/%Y %h\h%i") created_pay_at,
            DATE_FORMAT(p.updated_at, "%d/%m/%Y %h\h%i") updated_pay_at
        FROM pagamento p
        INNER JOIN usuario c ON c.id = p.idusuario
        INNER JOIN ingresso i ON i.id = p.idingresso
        LEFT JOIN lote l ON i.idlote = l.id
        LEFT JOIN cidade cid ON c.idcidade = cid.id
        RIGHT JOIN pais ps ON c.idpais = ps.id
        WHERE c.id=?'
    );
    $stmt->execute(array(
        $cliente_id
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
