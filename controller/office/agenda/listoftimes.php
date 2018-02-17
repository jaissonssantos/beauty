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
        'SELECT a.id,at.inicio,at.fim FROM artista a, 
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

    //converte a hora para minutos e somar a duração do serviço e realizar a montagem dos horarios
    $begin_time = h2m($results_artiste[0]->inicio);
    $end_time = h2m($results_artiste[0]->fim);
    $time = $results_service[0]->duracao;
    
    //lista os horarios do profissional baseado na duração do serviço
    $i = 0;
    $times = array();
    $count_time = $begin_time;
    while($count_time <= $end_time){
        $times[$i] = $current_date.' '.m2h($count_time);
        $i++;
        $count_time += $time;
    }

    //seta novos valores ao horário inicial e final
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

    //montagem da lista com os horarios livres
    $time_free = array();

    for($i=0;$i<count($times);$i++){
        $exists = true;
        for($j=0;$j<count($results);$j++){
            $t = explode(' ',$times[$i]);
            $date_tmp = $t[0];
            $time_tmp = $t[1];
            $time_tmp = h2m($time_tmp)+1;
            $time_tmp = m2h($time_tmp);
            $current_time_tmp = new DateTime($date_tmp.' '.$time_tmp);
            
            $begin_time_tmp = new DateTime($results[0]->inicio);
            $end_time_tmp = new DateTime($results[0]->fim);
            if ($current_time_tmp >= $begin_time_tmp && $current_time_tmp <= $end_time_tmp) {
                $exists = false;
                break;
            }
        }
        if($exists){
            $time_free[$i] = $times[$i];
        }
    }

    //retira a data completa e deixa no padrão de horário hh:mm
    $time_results = array();
    $count = 0;

    for($i=0;$i<count($time_free);$i++){

        if($time_free[$i] != null){
            $date_tmp = explode(' ',$time_free[$i]);
            $time_results['results'][$count] = $date_tmp[1];
            $count++;
        }
    }
    $response = array_filter($time_results);

} catch (PDOException $e) {
    http_response_code(500);
    $response->error = 'Desculpa. Tivemos um problema, tente novamente mais tarde: '. $e->getMessage();
} catch (Exception $e) {
    http_response_code($e->getCode());
    $response->error = $e->getMessage();
}

echo json_encode($response);
