<?php
    session_start();
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
    require "header.html";

    $usuario = new Classes\usuario();
    if(isset($_POST['entrar'])){
        $login = $_POST['login'];
        $senha = $_POST['senha'];
        $_SESSION['tipo'] = '';

        $usuarioId = $usuario->UsuarioLogin($login, $senha);
        $_SESSION['idUsuario'] = $usuarioId['idUsuario'];
        $_SESSION['nomeUsuario'] = $usuarioId['nomeUsuario'];
        if($usuarioId['adm'] == 1){
            $_SESSION['tipo'] = "administrador";
        }
        if($usuarioId['professor'] == 1){
            $_SESSION['tipo'] = "professor";
        }
        if($usuarioId['participante'] == 1){
            $_SESSION['tipo'] = "participante";
        }
    }
    require 'footer.html';
?>