<?php
    require_once __DIR__."\../vendor\autoload.php";
    $usuario = new Classes\usuario();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../fontAwesome/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../resources/style.css">
    <title>Gerenciador de Eventos</title>
</head>
<body>
        <div class="container-fluid">
            <div class="row" id="cabecalho" style="height: 25px;">
            </div>
            <div class="row" id="row_cabecalho_2">
                <div id="cabecalho2">
                    <a href="//www.uemg.br"><img src="../img/logo30site.png" alt="logo_30_anos"></a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="#" method="post" id="formCadastroUsuario" onsubmit="return ValidarFormCadastroUsuario(this)">
                        <div class="form-inline itensCadastro">
                            <label for="nome"><strong>Nome</strong></label>
                            <input type="text" name="nome" class="form-control" placeholder="Insira seu nome completo" >
                            <label for="usuario" style="margin-left: 5%;"><strong>Usuario</strong></label>
                            <input type="text" name="usuario" class="form-control" placeholder="Insira um nome de usuario">
                            <label for="sexo" style="margin-left: 3%;" id="labelSexo"><strong>Sexo</strong></label>
                            <input type="radio" name="sexo" value="m" class="form-control">Masculino
                            <input type="radio" name="sexo" value="f" class="form-control" style="margin-left: 1%;">Feminino
                        </div>
                        <div class="form-inline itensCadastro">
                            <label for="senha"><strong>Senha</strong></label>
                            <input type="password" name="senha" placeholder="Insira uma senha" class="form-control">
                            <label for="senha2" style="margin-left: 5%;"><strong>Redigite a senha</strong></label>
                            <input type="password" name="senha2" placeholder="Redigite a senha" class="form-control">
                        </div>
                        <div class="form-inline itensCadastro">
                            <label for="cpf"><strong>CPF</strong></label>
                            <input type="text" name="cpf" placeholder="Informe seu CPF" class="form-control">
                            <label for="emil" style="margin-left: 5%;"><strong>E-mail</strong></label>
                            <input type="email" name="email" placeholder="Informe um endereço de email" class="form-control">
                        </div>
                        <div class="form-inline itensCadastro">
                            <label for="endereco"><strong>Endereço</strong></label>
                            <input type="text" name="endereco" class="form-control" placeholder="Informe seu endereço">
                            <label for="numero" style="margin-left: 5%;"><strong>Número</strong></label>
                            <input type="text" name="numero" class="form-control" placeholder="Informe o numero do seu endereço">
                            <label for="bairro" style="margin-left: 3%;"><strong>Bairro</strong></label>
                            <input type="text" name="bairro" class="form-control" placeholder="Informe o nome do seu bairro">
                        </div>
                        <div class="form-inline itensCadastro">
                            <label for="cidade"><strong>Cidade</strong></label>
                            <input type="text" name="cidade" class="form-control" placeholder="Informe sua cidade">
                            <label for="estado" style="margin-left: 5%;"><strong>UF</strong></label>
                            <select name="uf" class="form-control">
                                <option value="ac">Acre (AC)</option>
                                <option value="al">Alagoas (AL)</option>
                                <option value="ap">Amapá (AP)</option>
                                <option value="am">Amazonas (AM)</option>
                                <option value="ba">Bahia (BA)</option>
                                <option value="ce">Ceará (CE)</option>
                                <option value="df">Distrito Federal (DF)</option>
                                <option value="es">Espírito Santo (ES)</option>
                                <option value="go">Goiás (GO)</option>
                                <option value="ma">Maranhão (MA)</option>
                                <option value="mt">Mato Grosso (MT)</option>
                                <option value="ms">Mato Grosso do Sul (MS)</option>
                                <option value="mg">Minas Gerais (MG)</option>
                                <option value="pa">Pará (PA)</option>
                                <option value="pb">Paraíba (PB)</option>
                                <option value="pr">Paraná (PR)</option>
                                <option value="pe">Pernambuco (PE)</option>
                                <option value="pi">Piauí (PI)</option>
                                <option value="rj">Rio de Janeiro (RJ)</option>
                                <option value="rn">Rio Grande do Norte (RN)</option>
                                <option value="rs">Rio Grande do Sul (RS)</option>
                                <option value="ro">Rondônia (RO)</option>
                                <option value="rr">Roraima (RR)</option>
                                <option value="sc">Santa Catarina (SC)</option>
                                <option value="sp">São Paulo (SP)</option>
                                <option value="se">Sergipe (SE)</option>
                                <option value="to">Tocantins (TO)</option>
                            </select>
                            <label for="cep" style="margin-left: 3%;"><strong>Cep</strong></label>
                            <input type="text" name="cep" class="form-control" placeholder="Informe seu cep">                                                      
                        </div>
                        <div class="form-inline itensCadastro">
                            <label for="telefone"><strong>Telefone</strong></label>  
                            <input type="text" name="telefone" class="form-control" placeholder="Informe um telefone">
                            <input type="submit" name="cadastrar" class="btn btn-primary" id="btnCadastrarUsuario" style="margin-left: 5%;background-color: #3c6178 !important; border-color: #3c6178 !important; position: relative; display: flex; justify-content: center;" value="Cadastrar">
                            <a href="../index.php" style="text-decoration:none; color: black; margin-left: 5%;">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
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
</body>
<script src="../resources/script.js"></script>
</html>