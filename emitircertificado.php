<?php
    session_start();
    include 'certificado.class.php';
    include 'evento.class.php';
    $evento = new evento();
    $certificado = new certificado();

    $idEvento = $_GET['idEvento'];
    $nomeEvento = '';
    $dataInicio  = '';
    $dataFim = '';
    $cargaHoraria = '';

    $data = $evento->ExibeEventoExpecifico($idEvento,);
    foreach($data as $row){
        $nomeEvento = $row['descricao'];
        $dataInicio  = $row['data_inicio'];
        $dataFim = $row['data_fim'];
        $cargaHoraria = $row['carga_horaria'];
    }
    $certificado->CertificadoCursoOuvinte($idEvento, $nomeEvento, $dataInicio, $dataFim, $cargaHoraria);

?>