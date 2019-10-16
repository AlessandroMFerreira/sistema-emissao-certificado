<?php
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
    $usuario = new Classes\usuario();

    if(isset($_POST['cadastrar'])){
        $nome = $_POST['nome'];
        $usuarioNome = $_POST['usuario'];
        $sexo = $_POST['sexo'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
        $endereco = $_POST['endereco'];
        $numero = $_POST['numero'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];
        $cep = $_POST['cep'];
        $telefone = $_POST['telefone'];

        $usuario->CriaNovoUsuario($nome, $usuarioNome, $sexo, $senha, $cpf, $email, $endereco, $numero, $bairro, $cidade, $uf, $cep, $telefone);
    }

?>