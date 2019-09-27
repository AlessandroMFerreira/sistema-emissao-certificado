<?php
    session_start();
    require_once __DIR__."/vendor/autoload.php";
    
    $evento = new Classes\evento();
    $certificado = new Classes\certificado();

    $idEvento = $_GET['idEvento'];
    $nomeEvento = '';
    $dataInicio  = '';
    $dataFim = '';
    $cargaHoraria = '';

    $data = $evento->ExibeEventoExpecifico($idEvento);
    foreach($data as $row){
        $nomeEvento = $row['descricao'];
        $dataInicio  = $row['data_inicio'];
        $dataFim = $row['data_fim'];
        $cargaHoraria = $row['carga_horaria'];
    }
    $certificado->CertificadoCursoOuvinte($idEvento, $nomeEvento, $dataInicio, $dataFim, $cargaHoraria);

?>