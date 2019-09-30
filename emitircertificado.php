<?php
    session_start();
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
    
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