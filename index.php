<?php
    session_start();
    require_once 'header.html';
    require_once 'classes/usuario.class.php';

    $usuario = new usuario();
?>
        <div class="row" id="content">
            <div class="col-2" id="div_esquerda">

            </div>
            <div class="col-8" id="div_centro">
            <form id="formLogin" method="POST" action="#">
                <div class="form-group">
                    <label for="usuario"><strong>Usuario</strong></label>
                    <input name="login" type="text" class="form-control" placeholder="Usuario">
                </div>
                <div class="form-group">
                    <label for="senha"><strong>Senha</strong></label>
                    <input name="senha" type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha">
                </div>
                <div class="btnEntrar">
                    <button name="entrar" type="submit" class="btn btn-primary">Entrar</button>
                </div>
                <p><strong>ou</strong></p>
                <div class="btnEntrar">
                    <a href="Formularios/cadastrousuario.php" id="linkCadastre">Cadastre-se</a>
                </div>
            </form>
            </div>
            <div class="col-2" id="div_direita">

            </div>
        </div>
<?php
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
    include_once 'footer.html';
?>