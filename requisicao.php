<?php

    require_once "vendor/autoload.php";

    $cpf = '';
    $acao = '';

    if(array_key_exists('cpf', $_GET)){
        $cpf = $_GET['cpf'];
    }
    if(array_key_exists('acao', $_GET)){
        $acao = $_GET['acao'];
    }

    $usuario = new usuario();

    if($acao == 'buscaUsuario'){
        $data = $usuario->BuscaUsuarioPorCpf($cpf);
        echo json_encode($data);
    }

?>