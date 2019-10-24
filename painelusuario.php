<?php
    //Iniciando a sessão
    session_start();
    ob_start();


    //include de arquivos 
    require_once 'header.html';
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

    //Verificação de segurança
    if(!isset($_SESSION['tipo']) && !isset($_SESSION['idUsuario']) && $_SESSION['tipo'] != 'participante'){
        session_destroy();
        header('Location: index.php');
    }
    
    
    //Instanciação de classes
    $evento = new Classes\evento();
    $eventopai = new Classes\eventopai();
    $usuario = new Classes\usuario();
    $participante = new Classes\participante();
    $autor = new Classes\autor();

    //Iniciação das variáveis de controle
    $id = '';
    $acao = '';
    $idEvento = '';
    $idAutor = '';
    $idUsuario = $_SESSION['idUsuario'];
    $nomeUsuario = $_SESSION['nomeUsuario'];
    $tela = '';
    $idUsuarioPlanilha = '';

    //Verifica se as variáveis de controle foram passadas na URL
    if(array_key_exists('id', $_GET)){
        $id = $_GET['id'];
    }
    if(array_key_exists('acao', $_GET)){
        $acao = $_GET['acao'];
    }
    if(array_key_exists('idEvento', $_GET)){
        $idEvento = $_GET['idEvento'];
    }
    if(array_key_exists('tela', $_GET)){
        $tela = $_GET['tela'];
    }
    if(array_key_exists('idUsuarioPlanilha', $_GET)){
        $idUsuarioPlanilha = $_GET['idUsuarioPlanilha'];
    }
    if(array_key_exists('idAutor', $_GET)){
        $idAutor = $_GET['idAutor'];
    }

    //Conteudo do painel de controle do administrador
    echo "
        <div class='row'>
            <div class='col-1' id='painel_controle_menu_esquerda'>
                <div id='menu'>
                    <ul>
                        <li><a href='painelcontrole.php?acao=exibirEventosValidados'>Eventos</a></li>
                        <li><a href='painelcontrole.php?id=3'>Sair</a></li>
                    </ul>
                </div>
            </div>
            <div class='col-11'>";

            /*==========================================================================================
            A PARTIR DAQUI É DECIDIDO O QUE SERÁ MOSTRADO NA TELA DEPENDENDO DA AÇÃO QUE O USUÁRIO FIZER
            ==========================================================================================*/

            //A estutura a baixo tem a finalidade de mostrar o contúdo inicial assim que o usuário logar.
            //Aqui as variáveis de controle $id e $acao ainda está vazias.

            if($id == '' && $acao == ''){
                echo "<div class='inicioDiv' style='margin-top: 7%;text-align: center; font-size: 25px;'>
                        Bem vindo <strong>".$nomeUsuario."</strong> este é seu painel de controle!<br><br>
                        Use o menu a sua esquerda para fazer sua inscrição nos eventos cadastrados nesta plataforma!<br>
                        <img src='img/seta.png' style='width: 200px; heigth: 200px;'>
                    </div>";
            }

            /*=======================================================================================================
            AS ESTRUTURAS ABAIXO DEFINEM O MENU LATERAL ESQUERDO DO SISTEMA. ONDE O RANGE DA VARIÁVEL $id 
            VAI DE 1 ATÉ 3. ONDE:
            $id = 1: RENDERIZA A TELA DE EVENTOS E TODAS AS FUNÇÕES RELACIONADAS A EVENTOS;
            $id = 2: RENDERIZA A TELA DE CADASTRO DE USUARIOS E TODAS AS FUNÇÕES RELACIONADAS A CADASTRO DE USUÁRIOS;
            $id = 3: RESPONSÁVEL PELO logoff DO USUARIO NO SISTEMA
            =======================================================================================================*/

            //Logout do usuario

            if($id == 3){
                $usuario->UsuarioLogOut();
            }

            /*============================================================
            ABAIXO ESTÃO TODAS AS AÇÕES QUE PODEM SER FEITAS COM EVENTOS
            ============================================================*/

            if($acao == 'inscrito'){
                $dataEvento = '';
                $dataEventoPai = '';
                $dataUsarioEvento = $participante->BuscaEventosDoUsuarioEspecifico($idUsuario);

                echo "<div class='divBtnCadastrarEvento'>
                            <a href='painelcontrole.php?id=1' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Pendências</a>
                            <a href='painelcontrole.php?acao=eventoprincipal' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Evento principal</a>
                            <a href='painelcontrole.php?acao=cadastrarEvento' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Cadastrar novo evento</a>
                            <a href='painelcontrole.php?acao=exibirEventosValidados' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Listar eventos validados</a>
                            <a href='painelcontrole.php?acao=eventosDoUsuario' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Meus eventos</a>
                            <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Minhas inscrições</a>
                    </div>";

                echo "<table class='table'>
                    <tr>
                        <th></th>
                        <th scope='col'>Evento principal</th>
                        <th scope='col'>Curso</th>
                        <th scope='col'>Descrição</th>
                        <th scope='col'>Carga horária</th>
                        <th scope='col'>Data inicio</th>
                        <th scope='col'>Data fim</th>
                        <th scope='col'>Tipo</th>
                        <th></th>
                    </tr>            
                ";
                foreach($dataUsarioEvento as $rowUsuarioEvento){
                    $dataEvento = $evento->ExibeEventoExpecifico($rowUsuarioEvento['id_evento']);
                    foreach($dataEvento as $rowEvento){
                        echo "<tr>";
                        echo "<td><a target='_blank' href="."'"."emitircertificado.php?idEvento=".$rowEvento['idEvento']."&oficinaMinicurso=".$rowEvento['oficina_minicurso']."&apresentacao=".$rowEvento['extencao_ou_ic']."'"." style='color:red;'><i class='fas fa-print' title='Emitir Certificado'></i></a></td>";
                        if($rowEvento['codigo_evento_pai'] == '' || $rowEvento['codigo_evento_pai'] == null){
                            echo "<td>-</td>";
                        }else{
                            $dataEventoPai = $eventopai->BuscaEventoPaiPorCodigo($rowEvento['codigo_evento_pai']);
                            foreach($dataEventoPai as $rowEventoPai){
                                echo "<td>".$rowEventoPai['descricao']."</td>";
                            }
                        }
                        echo "<td>".$rowEvento['curso']."</td>";
                        echo "<td>".$rowEvento['descricao']."</td>
                        <td>".$rowEvento['carga_horaria']."</td>
                        <td>".date("d/m/Y",strtotime($rowEvento['data_inicio']))."</td>
                        <td>".date("d/m/Y",strtotime($rowEvento['data_fim']))."</td>";
                        echo "<td>".$rowUsuarioEvento['tipo']."</td>";
                        echo "<td><a href="."painelcontrole.php?acao=cancelarinscricao&idEvento=".$rowEvento['idEvento']." title='Cancelar inscrição'><i class='far fa-times-circle'></i></a></td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";
            }
            
            if($acao == 'cancelarinscricao'){
                $participante->CancelarInscricao($idEvento,$idUsuario);
                header('Location: painelcontrole.php?acao=inscrito');
            }


            //Estrutura para exibir apenas os eventos que foram validados.

            if($acao == 'exibirEventosValidados'){
                $descricaoEventoPai = '';
                echo "<div class='divBtnCadastrarEvento'>
                            <a href='painelcontrole.php?id=1' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Pendências</a>
                            <a href='painelcontrole.php?acao=eventoprincipal' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Evento principal</a>
                            <a href='painelcontrole.php?acao=cadastrarEvento' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Cadastrar novo evento</a>
                            <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Listar eventos validados</a>
                            <a href='painelcontrole.php?acao=eventosDoUsuario' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Meus eventos</a>
                            <a href='painelcontrole.php?acao=inscrito' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Minhas inscrições</a>
                    </div>";

                $dataEvento = $evento->ListarEventosValidados();
                $dataUsuario = '';
                $dataEventoPai = '';

                echo "<table class='table'>
                    <tr>
                        <th></th>
                        <th></th>
                        <th scope='col'>Evento principal</th>
                        <th scope='col'>Descrição</th>
                        <th scope='col'>Carga horária</th>
                        <th scope='col'>Data inicio</th>
                        <th scope='col'>Data fim</th>
                        <th scope='col'>Responsável</th>
                        <th scope='col'>Validado</th>
                        <th scope='col'>Permite emissão de certificado</th>";
                        foreach($dataEvento as $rowEvento){
                            if($rowEvento['tipo'] == 'extensao'){
                                if($rowEvento['extensao'] == 'evento' || $rowEvento['extensao'] == 'curso'){
                                    if($rowEvento['evento_participante'] == 1 || $rowEvento['curso_participante'] == 1){
                                        echo "<th></th>";
                                    }
                                }
                            }
                        }
                        echo "<th></th>
                    </tr>            
                ";
                foreach($dataEvento as $rowEvento){                    
                    if($rowEvento['data_fim'] >= date("Y-m-d")){
                        echo "
                            <tr>";
                            echo "<td><a target='_blank' href="."'"."emitircertificado.php?idEvento=".$rowEvento['idEvento']."&oficinaMinicurso=".$rowEvento['oficina_minicurso']."&apresentacao=".$rowEvento['extencao_ou_ic']."'"." style='color:red;'><i class='fas fa-print' title='Emitir Certificado'></i></a></td>";
                            echo "<td><a target='_blank' href="."gerarqrcode.php?idEvento=".$rowEvento['idEvento']."&evento=".$rowEvento['descricao']." title='Emitir QRcode'><i class='fas fa-qrcode'></i></a></td>";
                                $dataEventoPai = $eventopai->BuscaEventoPaiPorCodigo($rowEvento['codigo_evento_pai']);
                                if($rowEvento['codigo_evento_pai'] != '' || $rowEvento['codigo_evento_pai'] != null){
                                    foreach($dataEventoPai as $rowEventoPai){
                                        echo "<td>".$rowEventoPai['descricao']."</td>";
                                    }
                                } else{
                                    echo "<td>-</td>";
                                }
                            
                                echo "<td>".$rowEvento['descricao']."</td>
                                <td>".$rowEvento['carga_horaria']."</td>
                                <td>".date("d/m/Y",strtotime($rowEvento['data_inicio']))."</td>
                                <td>".date("d/m/Y",strtotime($rowEvento['data_fim']))."</td>";
                                $dataUsuario = $usuario->ListaUsuarioExpecifico($rowEvento['id_usuario_responsavel']);
                                foreach($dataUsuario as $rowUsuario){
                                    echo "<td>".$rowUsuario['nome']."</td>";
                                }
                                if($rowEvento['validado'] == 0){
                                    echo "<td>Não</td>";
                                }else{
                                    echo "<td>Sim</td>";
                                } 
                                if($rowEvento['permiteemimssaocertificado'] == 0){
                                    echo "<td>Não</td>";
                                }else{
                                    echo "<td>Sim</td>";
                                }
                            if($rowEvento['tipo'] == 'extensao'){
                                if($rowEvento['extensao'] == 'evento' || $rowEvento['extensao'] == 'curso'){
                                    if($rowEvento['evento_participante'] == 1 || $rowEvento['curso_participante'] == 1){
                                        echo "<td><a href="."painelcontrole.php?acao=realizarInscricao&idEvento=".$rowEvento['idEvento']." title='Inscrever-se'><i class='fas fa-user-check'></i></a></td>";
                                    }
                                }
                            }
                            echo "<td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=excluirEvento&tela=validado><i class='far fa-trash-alt' title='Excluir evento'></i></a></td>";   
                            echo "</tr>";
                    }
                }
                echo "</table>";
            }

            if($acao == 'realizarInscricao'){
                $verificaParticipante = $participante->VerificaSeUsuarioJaInscrito($idEvento,$idUsuario);
                if($verificaParticipante){
                    $dataParticipante = $participante->BuscaEventosDoUsuarioEspecifico($idUsuario);
                    $tipo = '';
                    foreach($dataParticipante as $rowParticipante){
                        $tipo = $rowParticipante['tipo'];
                    }
                    echo "<script>
                            alert('Você já está inscrito neste evento como ".$tipo."');
                            window.location.href='painelcontrole.php?acao=exibirEventosValidados';
                        </script>";
                }else{
                    $participante->InscreverParticipante($idEvento, $idUsuario);
                    header('Location: painelcontrole.php?acao=inscrito');
                }
            }


    echo    "</div>
        </div>
    ";

    require_once 'footer.html';
?>