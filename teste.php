<?php


    include_once 'classes/usuario.class.php';
    $cpf = $_GET['cpf'];
    $usuario  = new usuario();

    $data = $usuario->BuscaUsuarioPorCpf($cpf);
    echo json_encode($data);
?>