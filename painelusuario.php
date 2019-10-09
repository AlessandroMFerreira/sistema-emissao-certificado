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
                        <li><a href='painelusuario.php?id=1'>Eventos</a></li>
                        <li><a href='painelusuario.php?id=3'>Sair</a></li>
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
                        Use o menu a sua esquerda para fazer a inscrição nos eventos cadastrados nesta plataforma!<br>
                        <img src='img/seta.png' style='width: 200px; heigth: 200px;'>
                    </div>";
            }

            /*=======================================================================================================
            AS ESTRUTURAS ABAIXO DEFINEM O MENU LATERAL ESQUERDO DO SISTEMA. ONDE O RANGE DA VARIÁVEL $id 
            VAI DE 1 ATÉ 3. ONDE:
            $id = 1: RENDERIZA A TELA DE EVENTOS E TODAS AS FUNÇÕES RELACIONADAS A EVENTOS;
            $id = 3: RESPONSÁVEL PELO logoff DO USUARIO NO SISTEMA
            =======================================================================================================*/

            //Exibe os eventos cadastrados, assim como permite fazer a adição de novos eventos, exclusão e validação

            if($id == 1){
                echo "<div id='divBtnCadastrarEvento'>
                            <button type='button' class='btn btn-primary' style='background-color: grey !important;width: 250px;'><a href='#' style='text-decoration: none; color:white;'>Eventos</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelusuario.php?acao=exibirEventosValidados' style='text-decoration: none; color:white;'>Listar eventos validados</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelusuario.php?acao=exibirEventosNaoValidados' style='text-decoration: none; color:white;'>Listar eventos não validados</a></button>
                    </div>";
                
                $dataEvento = $evento->ExibeTodosEventos();
                $dataUsuario = $usuario->ListaTodosOsUsuarios();

                echo "<table class='table'>
                    <tr>
                        <th></th>
                        <th></th>
                        <th scope='col'>Curso</th>
                        <th scope='col'>Descrição</th>
                        <th scope='col'>Carga horária</th>
                        <th scope='col'>Data inicio</th>
                        <th scope='col'>Data fim</th>
                        <th scope='col'>Responsável</th>
                        <th scope='col'>Validado</th>
                        <th scope='col'>Permite emissão de certificado</th>
                        <th></th>
                    </tr>            
                ";
                foreach($dataEvento as $rowEvento){
                    echo "
                        <tr>";
                            echo "<td><a target='_blank' href="."emitircertificado.php?idEvento=".$rowEvento['idEvento']." style='color:red;'><i class='fas fa-print' title='Emitir Certificado'></i></a></td>";
                            echo "<td><a target='_blank' href="."gerarqrcode.php?idEvento=".$rowEvento['idEvento']."&evento=".$rowEvento['descricao']." title='Emitir QRcode'><i class='fas fa-qrcode'></i></a></td>";
                            echo "<td>".$rowEvento['curso']."</td>";
                            echo "<td><a href="."painelusuario.php?idEvento=".$rowEvento['idEvento']."&acao=cadastrarPlanilha title='Clique para ver a planilha de participantes associados ao evento'>".$rowEvento['descricao']."</a></td>
                            <td>".$rowEvento['carga_horaria']."</td>
                            <td>".date("d/m/Y",strtotime($rowEvento['data_inicio']))."</td>
                            <td>".date("d/m/Y",strtotime($rowEvento['data_fim']))."</td>";
                            foreach($dataUsuario as $rowUsuario){
                                if($rowEvento['id_usuario_responsavel'] == $rowUsuario['idUsuario']){
                                    echo "<td>".$rowUsuario['nome']."</td>";
                                }
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
                        echo "<td><a href="."painelusuario.php?idEvento=".$rowEvento['idEvento']."&acao=excluirEvento><i class='far fa-trash-alt' title='Excluir evento'></i></a></td>";   
                        echo "</tr>";
                }
                echo "</table>";
            }            

            //Logout do usuario

            if($id == 3){
                $usuario->UsuarioLogOut();
            }

            /*============================================================
            ABAIXO ESTÃO TODAS AS AÇÕES QUE PODEM SER FEITAS COM EVENTOS
            ============================================================*/

            //Estrutura para exibir apenas os eventos que foram validados.

            if($acao == 'exibirEventosValidados'){
                echo "<div id='divBtnCadastrarEvento'>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelusuario.php?id=1' style='text-decoration: none; color:white;'>Eventos</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelusuario.php?acao=cadastrarEvento' style='text-decoration: none; color:white;'>Cadastrar novo evento</a></button>
                            <button type='button' class='btn btn-primary' style='background-color: grey !important; width: 250px;'><a href='#' style='text-decoration: none; color:white;'>Listar eventos validados</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelusuario.php?acao=exibirEventosNaoValidados' style='text-decoration: none; color:white;'>Listar eventos não validados</a></button>
                    </div>";

                $dataEvento = $evento->ListarEventosValidados();
                $dataUsuario = $usuario->ListaTodosOsUsuarios();

                echo "<table class='table'>
                    <tr>
                        <th scope='col'>Curso</th>
                        <th scope='col'>Descrição</th>
                        <th scope='col'>Carga horária</th>
                        <th scope='col'>Data inicio</th>
                        <th scope='col'>Data fim</th>
                        <th scope='col'>Responsável</th>
                        <th scope='col'>Validado</th>
                        <th scope='col'>Permite emissão de certificado</th>
                        <th></th>
                    </tr>            
                ";
                foreach($dataEvento as $rowEvento){
                    echo "
                        <tr>";
                            echo "<td>".$rowEvento['curso']."</td>";
                            echo "<td>".$rowEvento['descricao']."</td>
                            <td>".$rowEvento['carga_horaria']."</td>
                            <td>".date("d/m/Y",strtotime($rowEvento['data_inicio']))."</td>
                            <td>".date("d/m/Y",strtotime($rowEvento['data_fim']))."</td>";
                            foreach($dataUsuario as $rowUsuario){
                                if($rowEvento['id_usuario_responsavel'] == $rowUsuario['idUsuario']){
                                    echo "<td>".$rowUsuario['nome']."</td>";
                                }
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
                        echo "<td><a href="."painelusuario.php?idEvento=".$rowEvento['idEvento']."&acao=excluirEvento&tela=validado><i class='far fa-trash-alt' title='Excluir evento'></i></a></td>";   
                        echo "</tr>";
                }
                echo "</table>";
            }

            //Estrutura para exibir somente os eventos que ainda não foram validados.

    echo    "</div>
        </div>
    ";

    require_once 'footer.html';
?>