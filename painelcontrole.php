<?php
    //Iniciando a sessão
    session_start();
    ob_start();


    //include de arquivos 
    require_once 'header.html';
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

    //Verificação de segurança
    if(!isset($_SESSION['tipo']) && !isset($_SESSION['idUsuario']) && $_SESSION['tipo'] != 'administrador'){
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
                        <li><a href='painelcontrole.php?id=1'>Eventos</a></li>
                        <li><a href='painelcontrole.php?id=2'>Cadastros</a></li>
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
                        Use o menu a sua esquerda para fazer a administração dos eventos cadastrados nesta plataforma!<br>
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

            //Exibe os eventos cadastrados, assim como permite fazer a adição de novos eventos, exclusão e validação

            if($id == 1){
                echo "<div class='divBtnCadastrarEvento'>
                            <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Pendências</a>
                            <a href='painelcontrole.php?acao=eventoprincipal' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Evento principal</a>
                            <a href='painelcontrole.php?acao=cadastrarEvento' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Cadastrar novo evento</a>
                            <a href='painelcontrole.php?acao=exibirEventosValidados' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Listar eventos validados</a>
                            <a href='painelcontrole.php?acao=eventosDoUsuario' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Meus eventos</a>
                            <a href='painelcontrole.php?acao=inscrito' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Minhas inscrições</a>
                    </div>";
                
                $dataEvento = $evento->ExibeTodosEventos();
                $dataUsuario = '';
                $dataEventoPai = '';

                echo "<table class='table'>
                    <tr>
                        <th></th>
                        <th></th>
                        <th scope='col'>Evento principal</th>
                        <th scope='col'>Curso</th>
                        <th scope='col'>Descrição</th>
                        <th scope='col'>Carga horária</th>
                        <th scope='col'>Data inicio</th>
                        <th scope='col'>Data fim</th>
                        <th scope='col'>Responsável</th>
                        <th scope='col'>Validado</th>
                        <th scope='col'>Permite emissão de certificado</th>
                        <th></th>
                        <th></th>
                    </tr>            
                ";
                foreach($dataEvento as $rowEvento){
                    if($rowEvento['validado'] == 0 || $rowEvento['permiteemimssaocertificado'] == 0){
                        echo "
                            <tr>";
                                if($rowEvento['validado'] == 1){
                                    echo "<td><a href='#' style='color: grey;'><i class='far fa-check-square' title='Validar evento'></i><a></td>";
                                }else{
                                    echo "<td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=validarEvento><i class='far fa-check-square' title='Validar evento'></i><a></td>";
                                }
                                if($rowEvento['permiteemimssaocertificado'] == 1){
                                    echo "<td><a href='#' style='color: grey;'><i class='far fa-file-alt' title='Permitir emissão de certificado'></i></a></td>";
                                }else{
                                    echo "<td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=permitirCertificado><i class='far fa-file-alt' title='Permitir emissão de certificado'></i></a></td>";
                                }
                                if($rowEvento['codigo_evento_pai'] == '' || $rowEvento['codigo_evento_pai'] == null){
                                    echo "<td>-</td>";
                                }else{
                                    $dataEventoPai = $eventopai->BuscaEventoPaiPorCodigo($rowEvento['codigo_evento_pai']);
                                    foreach($dataEventoPai as $rowEventoPai){
                                        echo "<td>".$rowEventoPai['descricao']."</td>";
                                    }
                                }
                                echo "<td>".$rowEvento['curso']."</td>";
                                echo "<td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=cadastrarPlanilha title='Clique para ver a planilha de participantes associados ao evento'>".$rowEvento['descricao']."</a></td>
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
                            echo "<td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=excluirEvento><i class='far fa-trash-alt' title='Excluir evento'></i></a></td>";   
                            echo "<td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=visualizardocumentos title='Visualizar documentos preenchidos'><i class='fas fa-list'></i></a></td>";
                            echo "</tr>";
                    }
                }
                echo "</table>";
            }

            /*Exisbe todos os usuários cadastrados no sistema, assim como permite fazer a adição de um usuário do tipo professor,
            adicção de um usuário do tipo aluno/usuário comum (que são a mesma coisa), a edição dos cadastros e exclusão.
            Cuidado com as exclusões pois se algum usuario cadastrado, seja ele de qualquer tipo for excluido e possuir vinculo com a tabela
            participanteevento, automaticamente esta tabela irá corromper-se.*/

            if($id == 2){
                echo "<div class='divBtnCadastrarEvento'>
                            <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Usuarios</a>
                            <a href='painelcontrole.php?acao=cadastrarProfessor' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Cadastrar Professor</a>
                            <a href='painelcontrole.php?acao=cadastrarUsuario' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Cadastrar Usuario</a>
                    </div>";
                $data = $usuario->ListaTodosOsUsuarios();

                echo "
                    <table class='table'>
                        <tr>
                            <th></th>
                            <th scope='col'>Nome</th>
                            <th scope='col'>E-mail</th>
                            <th scope='col'>Endereço</th>
                            <th scope='col'>Número</th>
                            <th scope='col'>Cidade</th>
                            <th scope='col'>Telefone</th>
                        </tr>
                ";
                foreach($data as $row){
                    echo "
                            <tr>
                                <td><a href='painelcontrole.php?idUsuario=".$row['idUsuario']."&acao=editarUsuario'><i class='far fa-edit'></i></a></td>
                                <td>".$row['nome']."</td>
                                <td>".$row['email']."</td>
                                <td>".$row['endereco']."</td>
                                <td>".$row['numero']."</td>
                                <td>".$row['cidade']."</td>
                                <td>".$row['telefone']."</td>
                            </tr>
                    ";
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

            if($acao ==  'visualizardocumentos'){
                require_once "relatorios/planilha.php";
            }

            if($acao ==  'eventoprincipal'){
                echo "<div class='divBtnCadastrarEvento'>
                            <a href='painelcontrole.php?id=1' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Pendências</a>
                            <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Evento principal</a>
                            <a href='painelcontrole.php?acao=cadastrarEvento' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Cadastrar novo evento</a>
                            <a href='painelcontrole.php?acao=exibirEventosValidados' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Listar eventos validados</a>
                            <a href='painelcontrole.php?acao=eventosDoUsuario' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Meus eventos</a>
                            <a href='painelcontrole.php?acao=inscrito' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Minhas inscrições</a>
                    </div>";
                    include_once "formularios/cadastroeventopai.html";
                    if(isset($_POST['cadastrar'])){
                        $descricao = $_POST['descricao'];
                        $dataInicio = $_POST['data_inicio'];
                        $dataFim = $_POST['data_fim'];
                        $curso = $_POST['curso'];
                        $eventopai->NovoEventoPai($descricao,$dataInicio,$dataFim,$curso,$idUsuario);
                        header("Location: painelcontrole.php?acao=eventoprincipal");
                    }
                    $exibeeventopai = $eventopai->ExibeTodosEventosPai();
                    echo "<table class='table' style='margin-top: 10px;'>
                            <thead>
                                <tr>
                                    <th scope='col'>Descrição</th>
                                    <th scope='col'>Data Inicio</th>
                                    <th scope='col'>Data Fim</th>
                                    <th scope='col'>Codigo</th>
                                    <th scope='col'>Responsável</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>";
                            foreach($exibeeventopai as $roweventopai){
                                $idusuarioresponsavel = $roweventopai['id_usuario_responsavel'];
                                $usuarioResponsavel = $usuario->ListaUsuarioExpecifico($idusuarioresponsavel);
                                foreach($usuarioResponsavel as $rowUsuario){
                                    $nomeUsuario = $rowUsuario['nome'];
                                }
                                if($roweventopai['data_fim'] >= date("Y-m-d")){
                                    echo "<tr>";
                                        echo "<td>".$roweventopai['descricao']."</td>";
                                        echo "<td>".date("d/m/Y", strtotime($roweventopai['data_inicio']))."</td>";
                                        echo "<td>".date("d/m/Y", strtotime($roweventopai['data_fim']))."</td>";
                                        echo "<td>".$roweventopai['codigo']."</td>";
                                        echo "<td>".$nomeUsuario."</td>";
                                        echo "<td><a href="."painelcontrole.php?idEvento=".$roweventopai['idEventopai']."&acao=excluirEventoPai><i class='far fa-trash-alt' title='Excluir evento principal'></i></a></td>";
                                    echo "</tr>";
                                }
                            }
                    echo "</tbody>
                    </table>";
            }

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
                        echo "<td><a href='#divModal' rel='modal:open' title='Cancelar inscrição' id=\"cancelarInscricaoADM\" name=\"".$rowEvento['idEvento']."\"><i class='far fa-times-circle'></i></a></td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";
            }
            
            if($acao == 'cancelarinscricao'){
                $participante->CancelarInscricao($idEvento,$idUsuario);
                header('Location: painelcontrole.php?acao=inscrito');
            }

            if($acao == 'eventosDoUsuario'){
                echo "<div class='divBtnCadastrarEvento'>
                            <a href='painelcontrole.php?id=1' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Pendências</a>
                            <a href='painelcontrole.php?acao=eventoprincipal' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Evento principal</a>
                            <a href='painelcontrole.php?acao=cadastrarEvento' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Cadastrar novo evento</a>
                            <a href='painelcontrole.php?acao=exibirEventosValidados' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Listar eventos validados</a>
                            <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Meus eventos</a>
                            <a href='painelcontrole.php?acao=inscrito' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Minhas inscrições</a>
                    </div>";
                
                    $dataEventoUsuario = $evento->ListaEventosPorUsuarioResponsavel($idUsuario);
                    $dataUsuario = '';
                    $dataEventoPai = '';

                echo "<table class='table'>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th scope='col'>Evento principal</th>
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
                foreach($dataEventoUsuario as $rowEventoUsuario){
                    echo "
                            <tr>";
                                if($rowEventoUsuario['validado'] == 1){
                                    echo "<td><a href='#' style='color: grey;'><i class='far fa-check-square' title='Validar evento'></i><a></td>";
                                }else{
                                    echo "<td><a href="."painelcontrole.php?idEvento=".$rowEventoUsuario['idEvento']."&acao=validarEvento><i class='far fa-check-square' title='Validar evento'></i><a></td>";
                                }
                                if($rowEventoUsuario['permiteemimssaocertificado'] == 1){
                                    echo "<td><a href='#' style='color: grey;'><i class='far fa-file-alt' title='Permitir emissão de certificado'></i></a></td>";
                                }else{
                                    echo "<td><a href="."painelcontrole.php?idEvento=".$rowEventoUsuario['idEvento']."&acao=permitirCertificado><i class='far fa-file-alt' title='Permitir emissão de certificado'></i></a></td>";
                                }
                                echo "<td><a target='_blank' href="."'"."emitircertificado.php?idEvento=".$rowEventoUsuario['idEvento']."&oficinaMinicurso=".$rowEventoUsuario['oficina_minicurso']."&apresentacao=".$rowEventoUsuario['extencao_ou_ic']."'"." style='color:red;'><i class='fas fa-print' title='Emitir Certificado'></i></a></td>";
                                if($rowEventoUsuario['codigo_evento_pai'] == '' || $rowEventoUsuario['codigo_evento_pai'] == null){
                                    echo "<td>-</td>";
                                }else{
                                    $dataEventoPai = $eventopai->BuscaEventoPaiPorCodigo($rowEventoUsuario['codigo_evento_pai']);
                                    foreach($dataEventoPai as $rowEventoPai){
                                        echo "<td>".$rowEventoPai['descricao']."</td>";
                                    }
                                }
                                echo "<td>".$rowEventoUsuario['curso']."</td>";
                                echo "<td><a href="."painelcontrole.php?idEvento=".$rowEventoUsuario['idEvento']."&acao=cadastrarPlanilha title='Clique para ver a planilha de participantes associados ao evento'>".$rowEventoUsuario['descricao']."</a></td>
                                <td>".$rowEventoUsuario['carga_horaria']."</td>
                                <td>".date("d/m/Y",strtotime($rowEventoUsuario['data_inicio']))."</td>
                                <td>".date("d/m/Y",strtotime($rowEventoUsuario['data_fim']))."</td>";
                                
                                $dataUsuario = $usuario->ListaUsuarioExpecifico($rowEventoUsuario['id_usuario_responsavel']);
                                foreach($dataUsuario as $rowUsuario){
                                    echo "<td>".$rowUsuario['nome']."</td>";
                                }
                                if($rowEventoUsuario['validado'] == 0){
                                    echo "<td>Não</td>";
                                }else{
                                    echo "<td>Sim</td>";
                                }
                                if($rowEventoUsuario['permiteemimssaocertificado'] == 0){
                                    echo "<td>Não</td>";
                                }else{
                                    echo "<td>Sim</td>";
                                }
                            echo "<td><a href="."painelcontrole.php?idEvento=".$rowEventoUsuario['idEvento']."&acao=excluirEvento&tela=eventosDoUsuario><i class='far fa-trash-alt' title='Excluir evento'></i></a></td>";   
                            echo "<td><a href="."painelcontrole.php?idEvento=".$rowEventoUsuario['idEvento']."&acao=visualizardocumentos title='Visualizar documentos preenchidos'><i class='fas fa-list'></i></a></td>";
                            echo "</tr>";
                }
                echo "</table>";
            }

            if($acao == 'excluirEventoPai'){
                $eventopai->ExcluiEventoPai($idEvento);
                header("Location: painelcontrole.php?acao=eventoprincipal");
            }

            if($acao == 'cadastrarEvento'){
                echo "<div class='divBtnCadastrarEvento'>
                            <a href='painelcontrole.php?id=1' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Pendências</a>
                            <a href='painelcontrole.php?acao=eventoprincipal' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Evento principal</a>
                            <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Cadastrar novo evento</a>
                            <a href='painelcontrole.php?acao=exibirEventosValidados' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Listar eventos validados</a>
                            <a href='painelcontrole.php?acao=eventosDoUsuario' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Meus eventos</a>
                            <a href='painelcontrole.php?acao=inscrito' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Minhas inscrições</a>
                    </div>";
                require_once "formularios/cadastroevento.html";
                
                if(isset($_POST['cadastrarEvento'])){

                    $campos = $_POST; // esta variável armazena todos os campos que foram preenchidos no momento que o usuario clica no botão subtmit. Não estou usando $_POST['nome_do_campo'] pois vários campos deste formulário são gerados com JavaScript de acordo com o que o usuário vai escolhendo. A forma utilizada transforma a variável $campos em um vetor com todas as informações vindas do formulario no seu estado final.
                    $descricao = $campos['descricao'];
                    $cargahoraria = $campos['cargahoraria'];
                    $datainicio = $campos['data_inicio'];
                    $datafim = $campos['data_fim'];
                    $datacriacao = date('Y-m-d');
                    $tipo = $campos['tipo'];
                    $eventopaicodigo = strtoupper($_POST['ideventopai']);
                    $oficina_minicurso = $_POST['oficina_minicurso'];
                    $tipoApresentacao = $_POST['extensaoIC'];
                    $fomento = $_POST['fomento'];

                    $verificaSeCodigoExiste = $eventopai->VerificaSeCodigoExiste($eventopaicodigo);
                    
                    //Iniciando todas as variáveis que são geradas dinamicamente no formulario
                    $extensao = '';
                    $pesquisa = '';
                    $sigaextensao = '';
                    $sigaextensao = '';
                    $map = '';
                    $idmap = '';
                    $idsiga = '';
                    $organizador_evento = '';
                    $palestrante_evento = '';
                    $ministrante_evento = '';
                    $apresentador_evento = '';
                    $monitor_evento = '';
                    $mediador_evento = '';
                    $participante_evento = '';
                    $avaliador_evento = '';
                    $organizador_curso = '';
                    $ministrante_curso = '';
                    $participante_curso = '';
                    $orientador_iniciacao_cientifica = '';
                    $bolsista_iniciacao_cientifica = '';
                    $voluntario_iniciacao_cientifica = '';
                    $orientador_iniciacao_cientifica_jr = '';
                    $bolsista_iniciacao_cientifica_jr = '';
                    $voluntario_iniciacao_cientifica_jr = '';
                    $bolsista_projeto = '';
                    $orientador_projeto = '';
                    $voluntario_projeto = '';
                    $colaborador_projeto = '';
                    $colegiado = '';
                    $curso = '';
                    $iduser = '';

                    //Atribuindo valores às variáveis geradas dinamicamente
                    if($tipo == 'extensao'){
                        $extensao = $campos['enquadramento'];
                        $pesquisa = '';
                        $sigaextensao = $campos['siga'];
                        if($sigaextensao == 'sim'){
                            $sigaextensao = 1;
                        }else{
                            $sigaextensao = 0;
                        }
                        $sigaextensao == 1 ? $idsiga = $campos['idSigaInput'] : $idsiga = '';
                        $map = 0;
                        $idmap = '';
                    }
                    else{
                        $pesquisa = $campos['enquadramento'];
                        $extensao = '';
                        $map = $campos['map'];
                        if($map == 'sim'){
                            $map = 1;
                        }else{
                            $map = 0;
                        }
                        $map == 1 ? $idmap = $campos['idMapInput'] : $idmap = '';
                        $sigaextensao = 0;
                        $idsiga = '';
                    }

                    /*Esta estruturas validam os campos de checkbox. Estes campos são os resposáveis por decidir que tipo de participante
                    poderá obter certificado no evento. Por exemplo: Você pode ter um evento do tipo EXTENSÃO do genero CURSO e emitir certificado apenas para participantes
                    ou pode ter o mesmo evento do mesmo tipo e genero porém permitindo emissão de certificado para o Organizador para o Ministrante e Para o partidipante.
                    Como os campos aqui são todos gerados dinamicamente por meio de JavaScript, primeiro valido se foram "setados", ou seja, se existem,
                    e também se o valor deles corresponde ao atributo "value" que cada checkbox possui. Caso verdadeiro quer dizer que o certificado para esse tipo de participante 
                    foi permitido e a variável correspondente recebe o valor 1 (true) caso contrário quer dizer que para este tipo de usuario não será permitido
                    a emissão do certifico então a variável correspondente recebe o valor 0 (false)*/

                    if($extensao == 'projeto'){

                        if(isset($campos['bolsista_projeto']) && $campos['bolsista_projeto'] == 'bolsista_projeto'){
                            $bolsista_projeto = 1;
                        }else{
                            $bolsista_projeto = 0;
                        }
                        if(isset($campos['orientador_projeto']) && $campos['orientador_projeto'] == 'orientador_projeto'){
                            $orientador_projeto = 1;
                        }else{
                            $orientador_projeto = 0;
                        }
                        if(isset($campos['voluntario_projeto']) && $campos['voluntario_projeto'] == 'voluntario_projeto'){
                            $voluntario_projeto = 1;
                        }else{
                            $voluntario_projeto = 0;
                        }
                        if(isset($campos['colaborador_projeto']) && $campos['colaborador_projeto'] == 'colaborador_projeto'){
                            $colaborador_projeto = 1;
                        }else{
                            $colaborador_projeto = 0;
                        }

                        $organizador_evento = 0;
                        $palestrante_evento = 0;
                        $ministrante_evento = 0;
                        $apresentador_evento = 0;
                        $monitor_evento = 0;
                        $mediador_evento = 0;
                        $participante_evento = 0;
                        $avaliador_evento = 0;
                        $organizador_curso = 0;
                        $ministrante_curso = 0;
                        $participante_curso = 0;
                        $orientador_iniciacao_cientifica = 0;
                        $bolsista_iniciacao_cientifica = 0;
                        $voluntario_iniciacao_cientifica = 0;
                        $orientador_iniciacao_cientifica_jr = 0;
                        $bolsista_iniciacao_cientifica_jr = 0;
                        $voluntario_iniciacao_cientifica_jr = 0;

                    }
                    if($extensao == 'evento'){
                        $bolsista_projeto = 0;
                        $orientador_projeto = 0;
                        $voluntario_projeto = 0;
                        $colaborador_projeto = 0;

                        if(isset($campos['organizador_evento']) && $campos['organizador_evento'] == 'organizador_evento'){
                            $organizador_evento = 1;
                        }else{
                            $organizador_evento = 0;
                        }
                        if(isset($campos['palestrante_evento']) && $campos['palestrante_evento'] == 'palestrante_evento'){
                            $palestrante_evento = 1;
                        }else{
                            $palestrante_evento = 0;
                        }
                        if(isset($campos['ministrante_evento']) && $campos['ministrante_evento'] == 'ministrante_evento'){
                            $ministrante_evento = 1;
                        }else{
                            $ministrante_evento = 0;
                        }
                        if(isset($campos['apresentador_evento']) && $campos['apresentador_evento'] == 'apresentador_evento'){
                            $apresentador_evento = 1;
                        }else{
                            $apresentador_evento = 0;
                        }
                        if(isset($campos['monitor_evento']) && $campos['monitor_evento'] == 'monitor_evento'){
                            $monitor_evento = 1;
                        }else{
                            $monitor_evento = 0;
                        }
                        if(isset($campos['mediador_evento']) && $campos['mediador_evento'] == 'mediador_evento'){
                            $mediador_evento = 1;
                        }else{
                            $mediador_evento = 0;
                        }
                        if(isset($campos['participante_evento']) && $campos['participante_evento'] == 'participante_evento'){
                            $participante_evento = 1;
                        }else{
                            $participante_evento = 0;
                        }   
                        if(isset($campos['avaliador_evento']) && $campos['avaliador_evento'] == 'avaliador_evento'){
                            $avaliador_evento = 1;
                        }else{
                            $avaliador_evento = 0;
                        }

                        $organizador_curso = 0;
                        $ministrante_curso = 0;
                        $participante_curso = 0;
                        $orientador_iniciacao_cientifica = 0;
                        $bolsista_iniciacao_cientifica = 0;
                        $voluntario_iniciacao_cientifica = 0;
                        $orientador_iniciacao_cientifica_jr = 0;
                        $bolsista_iniciacao_cientifica_jr = 0;
                        $voluntario_iniciacao_cientifica_jr = 0;
                    }
                    if($extensao == 'curso'){
                        $bolsista_projeto = 0;
                        $orientador_projeto = 0;
                        $voluntario_projeto = 0;
                        $colaborador_projeto = 0;
                        $organizador_evento = 0;
                        $palestrante_evento = 0;
                        $ministrante_evento = 0;
                        $apresentador_evento = 0;
                        $monitor_evento = 0;
                        $mediador_evento = 0;
                        $participante_evento = 0;
                        $avaliador_evento = 0;

                        if(isset($campos['organizador_curso']) && $campos['organizador_curso'] == 'organizador_curso'){
                            $organizador_curso = 1;
                        }else{
                            $organizador_curso = 0;
                        }
                        if(isset($campos['ministrante_curso']) && $campos['ministrante_curso'] == 'ministrante_curso'){
                            $ministrante_curso = 1;
                        }else{
                            $ministrante_curso = 0;
                        }
                        if(isset($campos['participante_curso']) && $campos['participante_curso'] == 'participante_curso'){
                            $participante_curso = 1;
                        }else{
                            $participante_curso = 0;
                        }

                        $orientador_iniciacao_cientifica = 0;
                        $bolsista_iniciacao_cientifica = 0;
                        $voluntario_iniciacao_cientifica = 0;
                        $orientador_iniciacao_cientifica_jr = 0;
                        $bolsista_iniciacao_cientifica_jr = 0;
                        $voluntario_iniciacao_cientifica_jr = 0;
                    }
                    if($pesquisa == 'iniciacao_cientifica'){
                        $pesquisa = 'iniciacao cientifica';
                        $bolsista_projeto = 0;
                        $orientador_projeto = 0;
                        $voluntario_projeto = 0;
                        $colaborador_projeto = 0;
                        $organizador_evento = 0;
                        $palestrante_evento = 0;
                        $ministrante_evento = 0;
                        $apresentador_evento = 0;
                        $monitor_evento = 0;
                        $mediador_evento = 0;
                        $participante_evento = 0;
                        $avaliador_evento = 0;
                        $organizador_curso = 0;
                        $ministrante_curso = 0;
                        $participante_curso = 0;

                        if(isset($campos['orientador_iniciacao_cientifica']) && $campos['orientador_iniciacao_cientifica'] == 'orientador_iniciacao_cientifica'){
                            $orientador_iniciacao_cientifica = 1;
                        }else{
                            $orientador_iniciacao_cientifica = 0;
                        }
                        if(isset($campos['bolsista_iniciacao_cientifica']) && $campos['bolsista_iniciacao_cientifica'] == 'bolsista_iniciacao_cientifica'){
                            $bolsista_iniciacao_cientifica = 1;
                        }else{
                            $bolsista_iniciacao_cientifica = 0;
                        }
                        if(isset($campos['voluntario_iniciacao_cientifica']) && $campos['voluntario_iniciacao_cientifica'] == 'voluntario_iniciacao_cientifica'){
                            $voluntario_iniciacao_cientifica = 1;
                        }else{
                            $voluntario_iniciacao_cientifica = 0;
                        }

                        $orientador_iniciacao_cientifica_jr = 0;
                        $bolsista_iniciacao_cientifica_jr = 0;
                        $voluntario_iniciacao_cientifica_jr = 0;
                    }
                    if($pesquisa == 'iniciacao_cientifica_jr'){
                        $pesquisa = 'iniciacao cientifica junior';
                        $bolsista_projeto = 0;
                        $orientador_projeto = 0;
                        $voluntario_projeto = 0;
                        $colaborador_projeto = 0;
                        $organizador_evento = 0;
                        $palestrante_evento = 0;
                        $ministrante_evento = 0;
                        $apresentador_evento = 0;
                        $monitor_evento = 0;
                        $mediador_evento = 0;
                        $participante_evento = 0;
                        $avaliador_evento = 0;
                        $organizador_curso = 0;
                        $ministrante_curso = 0;
                        $participante_curso = 0;
                        $orientador_iniciacao_cientifica = 0;
                        $bolsista_iniciacao_cientifica = 0;
                        $voluntario_iniciacao_cientifica = 0;

                        if(isset($campos['orientador_iniciacao_cientifica_jr']) && $campos['orientador_iniciacao_cientifica_jr'] == 'orientador_iniciacao_cientifica_jr'){
                            $orientador_iniciacao_cientifica_jr = 1;
                        }else{
                            $orientador_iniciacao_cientifica_jr = 0;
                        }
                        if(isset($campos['bolsista_iniciacao_cientifica_jr']) && $campos['bolsista_iniciacao_cientifica_jr'] == 'bolsista_iniciacao_cientifica_jr'){
                            $bolsista_iniciacao_cientifica_jr = 1;
                        }else{
                            $bolsista_iniciacao_cientifica_jr = 0;
                        }
                        if(isset($campos['voluntario_iniciacao_cientifica_jr']) && $campos['voluntario_iniciacao_cientifica_jr'] == 'voluntario_iniciacao_cientifica_jr'){
                            $voluntario_iniciacao_cientifica_jr = 1;
                        }else{
                            $voluntario_iniciacao_cientifica_jr = 0;
                        }

                    }
                    $colegiado = $campos['colegiado'];
                    if($colegiado == 'sim'){
                        $colegiado = 1;
                        $numeroata = $campos['numeroAta'];
                        $dataata = $campos['dataAta'];

                    }else{
                        $colegiado = 0;
                        $numeroata = null;
                        $dataata = '0000-00-00';
                    }
                    $outrasocorrencias = $campos['ocorrencias'];
                    $curso = $campos['cursos'];
                    $iduser = $_SESSION['idUsuario'];
                    $evento->NovoEvento($descricao,$oficina_minicurso,$tipoApresentacao,$cargahoraria,$datainicio,$datafim,$datacriacao,$tipo,$extensao,$pesquisa,$bolsista_projeto,$orientador_projeto,$voluntario_projeto,$colaborador_projeto,$organizador_evento,$palestrante_evento,$ministrante_evento,$apresentador_evento,$monitor_evento,$mediador_evento,$participante_evento,$avaliador_evento,$organizador_curso,$ministrante_curso,$participante_curso,$orientador_iniciacao_cientifica,$bolsista_iniciacao_cientifica,$voluntario_iniciacao_cientifica,$orientador_iniciacao_cientifica_jr,$bolsista_iniciacao_cientifica_jr,$voluntario_iniciacao_cientifica_jr,$sigaextensao,$idsiga,$map,$idmap,$colegiado,$numeroata,$dataata,$outrasocorrencias,$curso,$iduser,$eventopaicodigo,$fomento);
                    if($eventopaicodigo != '' || $eventopaicodigo != null){
                        if(!$verificaSeCodigoExiste){
                            echo "<script>
                                    alert('Não existe correspondência para o Código informado no campo CÓDIGO EVENTO favor verificar o código informado. Entre em contato com o suporte.');
                                <script>";
                        }
                    }
                    header("Location: painelcontrole.php?id=1");
                }
                
            }

            /*Esta estrutura exclui um evento em especícifo e retorna o usuário para a tela que
            lista todos os eventos*/

            if($acao == 'excluirEvento'){
                $evento->ExcluirEvento($idEvento);
                if($tela == 'validado'){
                    header('Location: painelcontrole.php?acao=exibirEventosValidados');
                }
                else if($tela == 'eventosDoUsuario'){
                    header('Location: painelcontrole.php?acao=eventosDoUsuario');
                }
                else{
                    header('Location: painelcontrole.php?id=1');
                }
            }

            if($acao == 'cadastrarPlanilha'){
                $dataEvento = $evento->ExibeEventoExpecifico($idEvento);
                $dataUsuario = $usuario->ListaTodosOsUsuarios();
                $dataParticipante = $participante->ExibeParticipanteEventoEspecifico($idEvento);
                $posteres = '';
                $dataInscricao = '';
                $idUsuarioEvento = '';
                foreach($dataEvento as $rowEvento){
                    echo "<div class='form-inline' style='display: felx; position: relative; justify-content: center;'>";
                        echo "<h1>".$rowEvento['descricao']."</h1>";                    
                    echo "</div>";

                    echo "<div class='divBtnCadastrarEvento'>
                                <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Participantes Organização</a>
                                <a href="."painelcontrole.php?acao=todosInscritosPlanilha&idEvento=".$rowEvento['idEvento']." style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Todos os Inscritos</a>";
                                if($rowEvento['extensao'] == 'evento' || $rowEvento['extensao'] == 'curso'){
                                   echo "<a href="."painelcontrole.php?acao=colab&idEvento=".$rowEvento['idEvento']." style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Colaboração</a>";
                                }                                
                    echo  "</div>";
                    echo   "<table class='table'>
                                <thead>
                                    <tr>
                                        <th scope='col'>Nome</th>
                                        <th scope='col'>CPF</th>
                                        <th scope='col'>Tipo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>";
                    foreach($dataParticipante as $rowParticipante){
                        foreach($dataUsuario as $rowUsuario){
                            if($rowParticipante['tipo'] == 'orientador' || $rowParticipante['tipo'] == 'bolsista' || $rowParticipante['tipo'] == 'voluntario' || $rowParticipante['tipo'] == 'colaborador' || $rowParticipante['tipo'] == 'organizador' || $rowParticipante['tipo'] == 'monitor' || $rowParticipante['tipo'] == 'palestrante' || $rowParticipante['tipo'] == 'mediador' || $rowParticipante['tipo'] == 'debatedor' || $rowParticipante['tipo'] == 'ministrante' || $rowParticipante['tipo'] == 'ouvinte' || $rowParticipante['tipo'] == 'apresentador' || $rowParticipante['tipo'] == 'avaliador'){
                                if($rowParticipante['id_usuario'] == $rowUsuario['idUsuario']){
                                    echo "<tr>";
                                                echo "<td>".$rowUsuario['nome']."</td>";
                                                echo "<td>".$rowUsuario['cpf']."</td>";
                                                echo "<td>".$rowParticipante['tipo']."</td>";
                                                echo "<td><a href="."painelcontrole.php?acao=excluirUsuarioPlanilha&idUsuarioPlanilha=".$rowParticipante['idParticipanteEvento']."&idEvento=".$rowEvento['idEvento']."><i class='far fa-trash-alt' title='Excluir usuario'></i></a></td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    }
                
                        echo "</tbody>
                            </table>";
                        require_once "formularios/planilha.html";
                                    
                        echo "<div class='form-inline' style='margin-top: 20px; position: relative; display: flex; justify-content: center;'>
                                <a href="."painelcontrole.php?acao=cadastrarAutor&idEvento=".$rowEvento['idEvento'].">Vincular Autores do evento</a>
                            </div>
                            <div class='form-inline' style='margin-top: 20px; position: relative; display: flex; justify-content: center;'>
                                <a href='#' onclick='imprimirTela()' id='btnImprimir'>Imprmir</a>
                            </div>";
                
                
                    if(isset($_POST['btnVincular'])){
                        $cpf = $_POST['cpf'];
                        $tipo = $_POST['tipoUsuario'];
                        $posteres = $_POST['qntPosteres'];
                        $tipoPoster = $_POST['tipoPoster'];
                        $id = $usuario->BuscaUsuarioPorCpf($cpf);
                        $eventoID = intval($idEvento);

                        foreach($id as $row){
                            $idUsuarioEvento = intval($row['idUsuario']);
                        }
                        if($cpf == '' || $cpf == null || $tipo == '' || $tipo == null){
                            echo "<script>
                                alert('Preencha os campos CPF e Tipo CORRETAMENTE!!');
                                windows.location.href="."painelcontrole.php?acao=cadastrarPlanilha&idEvento=".$eventoID.";
                            </script>";
                        }else{
                            $participante->NovoParticipanteEvento($tipo,$posteres,$tipoPoster,$idUsuarioEvento,$eventoID);
                            header("Location: painelcontrole.php?acao=cadastrarPlanilha&idEvento=".$eventoID);
                        }
                    }
                }
                               
            }
            if($acao == 'colab'){

                $dataEvento = $evento->ExibeEventoExpecifico($idEvento);
                $dataUsuario = $usuario->ListaTodosOsUsuarios();
                $dataParticipante = $participante->ExibeParticipanteEventoEspecifico($idEvento);
                $posteres = '';
                $dataInscricao = '';
                $idUsuarioEvento = '';
                foreach($dataEvento as $rowEvento){
                    if($rowEvento['extensao'] == 'evento' || $rowEvento['extensao'] == 'curso'){
                        if($rowEvento['colaboracao'] == '' || $rowEvento['colaboracao'] == null){
                            echo "<div class='form-inline' style='display: felx; position: relative; justify-content: center;'>";
                                echo "<h1>".$rowEvento['descricao']."</h1>";                    
                            echo "</div>";

                            echo "<div class='divBtnCadastrarEvento'>
                                        <a href="."painelcontrole.php?acao=cadastrarPlanilha&idEvento=".$rowEvento['idEvento']." style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Participantes Organização</a>
                                        <a href="."painelcontrole.php?acao=todosInscritosPlanilha&idEvento=".$rowEvento['idEvento']." style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Todos os Inscritos</a>
                                        <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Colaboração</a>           
                                </div>";   
                            require_once "formularios/colaboracao.html";
                            if(isset($_POST['bntColab'])){
                                $colaboracao = $_POST['colab'];
                                $evento->alterarColaboracao($idEvento,$colaboracao);
                                header("Location:"."painelcontrole.php?acao=colab&idEvento=".$idEvento);
                            }
                        }else{
                            echo "<div style='display: flex;position: relative;justify-content: center;margin-top:10px;'>
                                <h4><strong>EVENTO JÁ VINCULADO AO SETOR</strong></h4>
                            </div>";
                        }
                    }else{
                        echo "<div style='display: flex;position: relative;justify-content: center;margin-top:10px;'>
                                <h3><strong>OPÇÃO VÁLIDA SOMENTE PARA EVENTOS DO TIPO 'EVENTO'!!</strong></h3>
                            </div>";
                    }
                }

            }
            if($acao == 'excluirUsuarioPlanilha'){
                $evento = intval($idEvento);
                $participante->ExcluirParticipante($evento, $idUsuarioPlanilha);
                header("Location: painelcontrole.php?acao=cadastrarPlanilha&idEvento=".$evento);
            }
            if($acao == 'todosInscritosPlanilha'){
                $eventoID = intval($idEvento);
                $dataEvento = $evento->ExibeEventoExpecifico($eventoID);
                $dataUsuario = $usuario->ListaTodosOsUsuarios();
                $dataParticipante = $participante->ExibeParticipanteEventoEspecifico($idEvento);

                foreach($dataEvento as $rowEvento){
                    echo "<div class='form-inline' style='display: felx; position: relative; justify-content: center;'>";
                        echo "<h1>".$rowEvento['descricao']."</h1>";                    
                    echo "</div>";

                    echo "<div class='divBtnCadastrarEvento'>
                                <a href="."painelcontrole.php?acao=cadastrarPlanilha&idEvento=".$rowEvento['idEvento']." style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Participantes Organização</a>
                                <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Todos os Inscritos</a>";
                                if($rowEvento['extensao'] == 'evento' || $rowEvento['extensao'] == 'curso'){
                                    echo "<a href="."painelcontrole.php?acao=colab&idEvento=".$rowEvento['idEvento']." style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Colaboração</a>";
                                 }        
                    echo  "</div>";
                    echo   "<table class='table'>
                                <thead>
                                    <tr>
                                        <th scope='col'>Nome</th>
                                        <th scope='col'>CPF</th>
                                        <th scope='col'>Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>";
                    foreach($dataParticipante as $rowParticipante){
                        foreach($dataUsuario as $rowUsuario){
                            if($rowParticipante['id_usuario'] == $rowUsuario['idUsuario']){
                                echo "<tr>";
                                            echo "<td>".$rowUsuario['nome']."</td>";
                                            echo "<td>".$rowUsuario['cpf']."</td>";
                                            echo "<td>".$rowParticipante['tipo']."</td>";
                                echo "</tr>";
                            }
                        }
                    }
                
                        echo "</tbody>
                            </table>
                            <div class='form-inline' style='margin-top: 20px; position: relative; display: flex; justify-content: center;'>
                                <a href='#' onclick='imprimirTela()' id='btnImprimir'>Imprmir</a>
                            </div>";
                }              
            }
            if($acao == 'cadastrarAutor'){
                $dataEvento = $evento->ExibeEventoExpecifico($idEvento);
                $dataAutor = $autor->ExibeAutorEventoEspecifico($idEvento);

                echo "<div id='nomeCurso'>";
                    foreach($dataEvento as $rowEvento){
                        echo "<h2>".$rowEvento['descricao']."</h2>";
                    
                        echo "</div>";
                        echo "<div class='form-inline' style='margin-top: 20px; position: relative; display: flex; justify-content: center;'>
                                <h4>Autores</h4>
                            </div>";
                    }
                    echo "<table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'>Nome</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";
                    foreach($dataAutor as $rowAutor){
                        echo "<tr>";
                        echo "<td>".$rowAutor['nome']."</td>";
                        echo "<td><a href="."painelcontrole.php?acao=excluirAutor&idAutor=".$rowAutor['idAutor']."&idEvento=".$idEvento."><i class='far fa-trash-alt' title='Excluir autor'></i></a></td>";
                        echo "</tr>";
                    }
                    echo "</tbody>
                    </table>";
                    include_once 'formularios/autor.html';
                    if(isset($_POST['vincularAutor'])){
                        $nome = $_POST['nomeAutor'];
                        $eventoID = $idEvento;

                        $autor->NovoAutor($nome,$eventoID);
                        header("Location:"."painelcontrole.php?acao=cadastrarAutor&idEvento=".$eventoID);
                    }
                    echo "<div class='form-inline' style='margin-top: 20px; position: relative; display: flex; justify-content: center;'>
                            <a href='#' onclick='imprimirTela()' id='btnImprimir'>Imprmir</a>
                        </div>";                              
            }
            if($acao == 'excluirAutor'){
                $autor->ExcluirAutor($idAutor);
                header("Location:"."painelcontrole.php?acao=cadastrarAutor&idEvento=".$idEvento);
            }

            /*Esta estrutura valida (seta o campo "validado" na tabela "evento" como "1") 
            um evento em especícifo e retorna o usuário para a tela que
            lista todos os eventos*/

            if($acao == 'validarEvento'){
                $evento->ValidarEvento($idEvento);
                header('Location: painelcontrole.php?id=1');
            }

            if($acao == 'permitirCertificado'){
                $data = $evento->ExibeEventoExpecifico($idEvento);
                foreach($data as $row){
                    if($row['validado'] == 1){
                        $evento->PermiteEmissaoDeCertificado($idEvento);
                        if($tela == 'validado'){
                            echo "
                                <script>
                                    alert('A emissão de certificados para o evento ".$row['descricao']." está liberada!');
                                    window.location.href='painelcontrole.php?acao=exibirEventosValidados';
                                </script>
                            ";
                        }else{
                            echo "
                                <script>
                                    alert('A emissão de certificados para o evento ".$row['descricao']." está liberada!');
                                    window.location.href='painelcontrole.php?id=1';
                                </script>
                            ";
                        }
                    }else{
                        if($tela == 'validado'){
                            echo "
                                <script>
                                    alert('Valide o evento antes de permitir a emissão de certificados');
                                    window.location.href='painelcontrole.php?acao=exibirEventosValidados';
                                </script>
                            ";
                        }
                        else{
                            echo "
                            <script>
                                alert('Valide o evento antes de permitir a emissão de certificados');
                                window.location.href='painelcontrole.php?id=1';
                            </script>
                            ";
                        }
                    }
                }
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
                            echo "<td><a target='_blank' href="."gerarqrcode.php?idEvento=".$rowEvento['idEvento']."&evento=".urlencode($rowEvento['descricao'])." title='Emitir QRcode'><i class='fas fa-qrcode'></i></a></td>";
                                $dataEventoPai = $eventopai->BuscaEventoPaiPorCodigo($rowEvento['codigo_evento_pai']);
                                if($rowEvento['codigo_evento_pai'] != '' || $rowEvento['codigo_evento_pai'] != null){
                                    foreach($dataEventoPai as $rowEventoPai){
                                        echo "<td>".$rowEventoPai['descricao']."</td>";
                                    }
                                } else{
                                    echo "<td>-</td>";
                                }
                            
                                echo "<td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=cadastrarPlanilha title='Clique para ver a planilha de participantes associados ao evento'>".$rowEvento['descricao']."</a></td>
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

            /*============================================================
            ABAIXO ESTÃO TODAS AS AÇÕES QUE PODEM SER FEITAS COM USUÁRIOS
            ============================================================*/

            /*Estrutura que permite o cadastro de um usuário do tipo Professor.
            Lembrando que apenas o ADM do sistema pode cadastrar um professor, qualquer
            cadastro feito diretamente na index do sistema cadastra-rá o usuário como um usuário comum
            AMDs também podem cadastrar usuários comuns porém somente o usuário que faz a manutenção do sistema
            poderá cadastrar um ADM.*/

            if($acao == 'cadastrarProfessor'){
                echo "<div class='divBtnCadastrarEvento'>
                            <a href='painelcontrole.php?id=2' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Usuarios</a>
                            <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Cadastrar Professor</a>
                            <a href='painelcontrole.php?acao=cadastrarUsuario' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Cadastrar Usuario</a>
                    </div>";
                
                require_once 'formularios/cadastrousuarioadm.html';

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
    
                    $usuario->CriaUsuarioProfessor($nome, $usuarioNome, $sexo, $senha, $cpf, $email, $endereco, $numero, $bairro, $cidade, $uf, $cep, $telefone);
                }
            }

            //Estrutura que permite ao ADM cadastrar um usuário comum.

            if($acao == 'cadastrarUsuario'){
                echo "<div class='divBtnCadastrarEvento'>
                            <a href='painelcontrole.php?id=2' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Usuarios</a>
                            <a href='painelcontrole.php?acao=cadastrarProfessor' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Cadastrar Professor</a>
                            <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Cadastrar Usuario</a>
                    </div>";

                    require_once 'formularios/cadastrousuarioadm.html';

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
            }

            //Estrutura que permite ao usuario ADM editar qualquer dado do cadastro dos usuários inclusivo o próprio

            if($acao == 'editarUsuario'){
                $dadosUsuario = $usuario->ListaUsuarioExpecifico($idUsuario);
                foreach($dadosUsuario as $row){
                   echo "<div class='row>
                        <div class='col-10'>
                            <form action='#' method='post' id='formCadastroUsuario'>
                                    <div class='form-inline formCadastroUsuarioProfessor'>
                                        <label for='nome'><strong>Nome</strong></label>
                                        <input type='text' name='nome' class='form-control' value=".$row['nome'].">
                                    </div>
                                    <div class='form-inline formCadastroUsuarioProfessor'>
                                        <label for='sexo' id='labelSexo'><strong>Sexo</strong></label>
                                        ";
                                            if($row['sexo'] == 'm'){
                                                echo "<input type='radio' name='sexo' value='m' class='form-control' checked>Masculino
                                                <input type='radio' name='sexo' value='f' class='form-control' style='margin-left: 1%;'>Feminino";
                                            }
                                            else{
                                                echo "<input type='radio' name='sexo' value='m' class='form-control'>Masculino
                                                <input type='radio' name='sexo' value='f' class='form-control' style='margin-left: 1%;' checked>Feminino";
                                            }
                                     echo   "
                                    </div>
                                    <div class='form-inline formCadastroUsuarioProfessor'>
                                        <label for='cpf'><strong>CPF</strong></label>
                                        <input type='text' name='cpf' class='form-control' value=".$row['cpf'].">
                                        <label for='emil'><strong>E-mail</strong></label>
                                        <input type='email' name='email' class='form-control' value=".$row['email'].">
                                    </div>
                                    <div class='form-inline formCadastroUsuarioProfessor'>
                                        <label for='endereco'><strong>Endereço</strong></label>
                                        <input type='text' name='endereco' class='form-control' value=".$row['endereco'].">
                                        <label for='numero'><strong>Número</strong></label>
                                        <input type='text' name='numero' class='form-control' value=".$row['numero'].">
                                    </div>
                                    <div class='form-inline formCadastroUsuarioProfessor'>
                                        <label for='bairro'><strong>Bairro</strong></label>
                                        <input type='text' name='bairro' class='form-control' value=".$row['bairro'].">
                                        <label for='cidade'><strong>Cidade</strong></label>
                                        <input type='text' name='cidade' class='form-control' value=".$row['cidade'].">
                                    </div>
                                    <div class='form-inline formCadastroUsuarioProfessor'>                       
                                        <label for='estado'><strong>UF</strong></label>
                                        <select name='uf' class='form-control' required>
                                            <option></option>
                                            <option value='ac'>Acre (AC)</option>
                                            <option value='al'>Alagoas (AL)</option>
                                            <option value='ap>Amapá (AP)</option>
                                            <option value='am>Amazonas (AM)</option>
                                            <option value='ba'>Bahia (BA)</option>
                                            <option value='ce'>Ceará (CE)</option>
                                            <option value='df'>Distrito Federal (DF)</option>
                                            <option value='es'>Espírito Santo (ES)</option>
                                            <option value='go'>Goiás (GO)</option>
                                            <option value='ma'>Maranhão (MA)</option>
                                            <option value='mt>Mato Grosso (MT)</option>
                                            <option value='ms'>Mato Grosso do Sul (MS)</option>
                                            <option value='mg'>Minas Gerais (MG)</option>
                                            <option value='pa'>Pará (PA)</option>
                                            <option value='pb'>Paraíba (PB)</option>
                                            <option value='pr'>Paraná (PR)</option>
                                            <option value='pe'>Pernambuco (PE)</option>
                                            <option value='pi'>Piauí (PI)</option>
                                            <option value='rj'>Rio de Janeiro (RJ)</option>
                                            <option value='rn'>Rio Grande do Norte (RN)</option>
                                            <option value='rs'>Rio Grande do Sul (RS)</option>
                                            <option value='ro'>Rondônia (RO)</option>
                                            <option value='rr'>Roraima (RR)</option>
                                            <option value='sc'>Santa Catarina (SC)</option>
                                            <option value='sp>São Paulo (SP)</option>
                                            <option value='se'>Sergipe (SE)</option>
                                            <option value='to'>Tocantins (TO)</option>
                                        </select>
                                        <label for='cep'><strong>Cep</strong></label>
                                        <input type='text' name='cep' placeholder='Informe seu cep' class='form-control' value=".$row['cep'].">                                                      
                                    </div>
                                    <div class='form-inline  formCadastroUsuarioProfessor'>
                                        <label for='telefone'><strong>Telefone</strong></label>  
                                        <input type='text' name='telefone' class='form-control' value=".$row['telefone'].">
                                        <input type='submit' name='editar' class='btn btn-primary' id='btnCadastrarUsuario' style='margin-left: 5%;background-color: #3c6178 !important; border-color: #3c6178 !important; position: relative; display: flex; justify-content: center;' value='Editar'>
                                    </div>
                                </form>
                        </div>
                    </div>";

                    if(isset($_POST['editar'])){
                        $nome = $_POST['nome'];
                        $sexo = $_POST['sexo'];
                        $cpf = $_POST['cpf'];
                        $email = $_POST['email'];
                        $endereco = $_POST['endereco'];
                        $numero = $_POST['numero'];
                        $bairro = $_POST['bairro'];
                        $cidade = $_POST['cidade'];
                        $uf = $_POST['uf'];
                        $cep = $_POST['cep'];
                        $telefone = $_POST['telefone'];
        
                        $usuario->EditarUsuario($idUsuario,$nome, $sexo, $cpf, $email, $endereco, $numero, $bairro, $cidade, $uf, $cep, $telefone);
                    }
                }
            }

    echo    "</div>
        </div>
    ";

    require_once 'footer.html';
?>