<?php


use Utils\Conexao;

header('Content-type: application/json');
$oConexao = Conexao::getInstance();
$params = json_decode(file_get_contents('php://input'));
$response = new stdClass();

try {
    if (!isset(
        $params->data,
        $params->artista,
        $params->servico
    )) {
        throw new Exception('Verifique os dados preenchidos', 400);
    }

    $date = date_create(formata_data($params->data));
    $current_date = date_format($date, 'Y-m-d');
    $current_day = diasemana($current_date);
    
    $stmt = $oConexao->prepare(
        'SELECT * FROM artista a, 
            artista_atendimento at 
		WHERE a.id = at.idartista
        AND at.dia=? 
        AND a.id=?');
    $stmt->execute(array(
        $current_day,
        $params->artista
    ));
    $results_artiste = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $oConexao->prepare(
        'SELECT id,duracao
        FROM servico
        WHERE id=?
        LIMIT 1');
    $stmt->execute(array(
        $params->servico
    ));
    $results_service = $stmt->fetchAll(PDO::FETCH_OBJ);

    //converte a hora para minutos para poder somar o tempo de atendimento e realizar a montagem dos horarios baseado no tempo de atendimento
    $begin_time = h2m($results_artiste[0]->inicio);
    $end_time = h2m($results_artiste[0]->fim);

    $time = $results_service[0]->duracao;
    $count_time = $begin_time;
    
    $times = array();
    $time_free = array();
    $i = 0;
    //lista os horarios do profissional baseados no cadastro dele
    while($count_time <= $end_time){
        $times[$i] = $current_date.' '.m2h($count_time);
        ++$i;
        $count_time += $time;
    }

    //pega os horarios ocupados
    $current_date = date_format($date, 'Y-m-d');
    $current_dateinit = $current_date.' 00:00:00';
    $current_datefinal = $current_date.' 23:59:59';
    $begin_time = $current_date.' '.$results_artiste[0]->inicio;
    $end_time = $current_date.' '.$results_artiste[0]->fim;

    $stmt = $oConexao->prepare(
        "SELECT id, 
        DATE_FORMAT(inicio,'%Y-%m-%d %h:%i:%s') inicio,
        DATE_FORMAT(fim,'%Y-%m-%d %h:%i:%s') fim
		FROM agenda
	    WHERE status <= 7 
        AND idartista=?
        AND inicio>=?
        AND fim<=?"
    );
    $stmt->execute(array(
        $params->artista,
        $begin_time,
        $end_time
    ));
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    //faz a comparacao dos horarios com os horarios ocupados e monta a lista somente com os horarios livres, foi adicionado 1 minuto ao horario,
    //para liberar a hora final no horario, pois estava entrando como horario ocupado, mas na realidade é um horario disponivel
    for ($i = 0; $i < count($times); ++$i) {
        $teste = true;
        for ($j = 0; $j < count($results); ++$j) {
            $tmp = explode(' ', $times[$i]);
            $datatmp = $tmp[0];
            $horatmp = $tmp[1];
            $horatmp = h2m($horatmp) + 1;
            $horatmp = m2h($horatmp);
            $tmphorario = date_create($datatmp.' '.$horatmp);
            $tmpinicio = date_create($results_artiste[$j]->inicio);
            $tmpfinal = date_create($results_artiste[$j]->fim);
            if ($tmphorario >= $tmpinicio && $tmphorario <= $tmpfinal) {
                $teste = false;
                break;
            }
        }
        if ($teste) {
            $time_free[$i] = $times[$i];
        }
    }
    $hLivres = array();
    //retira a data e deixa somente o horario
    for ($i = 0; $i < count($time_free); ++$i) {
        $tmp = explode(' ', $time_free[$i]);
        $hLivres[$i] = $tmp[1];
    }

    $response = array_filter($hLivres);
} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde: '. $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
