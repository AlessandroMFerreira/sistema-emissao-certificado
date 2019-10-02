<?php


    $acao = '';
    $idEvento = '';

    if(array_key_exists('acao',$_GET)){
        $acao = $_GET['acao'];
    }
    if(array_key_exists('idEvento',$_GET)){
        $idEvento = $_GET['idEvento'];
    }
    if($acao == 'cadastrarPlanilha'){
        header("Location: painelcontrole.php?acao=cadastrarPlanilha&idEvento=".$idEvento);
    }
?>