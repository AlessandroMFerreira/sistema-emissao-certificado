<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fontAwesome/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/style.css">
    <title>Gerenciador de Eventos</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row" id="cabecalho" style="height: 25px;">
        </div>
        <div class="row" id="row_cabecalho_2">
            <div id="cabecalho2">
                <a href="//www.uemg.br"><img src="img/logo30site.png" alt="logo_30_anos"></a>
            </div>
        </div>
        <div class="row" id="content">
            <div class="col-2" id="div_esquerda">

            </div>
            <div class="col-8" id="div_centro">
            <form id="formLogin" method="POST" action="login.php">
                <div class="form-group">
                    <label for="usuario"><strong>Usuario</strong></label>
                    <input name="login" type="text" class="form-control" placeholder="Usuario">
                </div>
                <div class="form-group">
                    <label for="senha"><strong>Senha</strong></label>
                    <input name="senha" type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha">
                </div>
                <div class="btnEntrar">
                    <button name="entrar" type="submit" class="btn btn-primary" style="background-color: #3c6178 !important; border-color: #3c6178 !important;">Entrar</button>
                </div>
                <p><strong>ou</strong></p>
                <div class="btnEntrar">
                    <a href="formularios/cadastronovousuario.html" id="linkCadastre">Cadastre-se</a>
                </div>
            </form>
            </div>
            <div class="col-2" id="div_direita">

            </div>
        </div>
    </div>
</body>
<script src="resources/script.js"></script>
</html>
    