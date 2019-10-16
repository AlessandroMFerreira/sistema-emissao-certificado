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
                        <li><a href='painelprofessor.php?id=1'>Eventos</a></li>
                        <li><a href='painelprofessor.php?id=3'>Sair</a></li>
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
                            <a href='painelprofessor.php?acao=eventoprincipal' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Evento principal</a>
                            <a href='painelprofessor.php?acao=cadastrarEvento' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Cadastrar novo evento</a>
                            <a href='painelprofessor.php?acao=exibirEventosValidados' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Listar eventos validados</a>
                    </div>";
                
                $dataEvento = $evento->ExibeTodosEventos();
                $dataUsuario = $usuario->ListaTodosOsUsuarios();
                $dataEventoPai = $eventopai->ExibeTodosEventosPai();

                echo "<table class='table'>
                    <tr>
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
                foreach($dataEvento as $rowEvento){
                    if($rowEvento['validado'] == 0 || $rowEvento['permiteemimssaocertificado'] == 0){
                        echo "
                            <tr>";
                                foreach($dataEventoPai as $rowEventoPai){
                                    if($rowEvento['codigo_evento_pai'] == $rowEventoPai['codigo']){
                                        echo "<td>".$rowEventoPai['descricao']."</td>";
                                    }else{
                                        echo "<td>-</td>";
                                    }
                                }
                                echo "<td>".$rowEvento['curso']."</td>";
                                echo "<td><a href="."painelprofessor.php?idEvento=".$rowEvento['idEvento']."&acao=cadastrarPlanilha title='Clique para ver a planilha de participantes associados ao evento'>".$rowEvento['descricao']."</a></td>
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
                            echo "<td><a href="."painelprofessor.php?idEvento=".$rowEvento['idEvento']."&acao=excluirEvento><i class='far fa-trash-alt' title='Excluir evento'></i></a></td>";   
                            echo "</tr>";
                    }
                }
                echo "</table>";
            }

            /*Exisbe todos os usuários cadastrados no sistema, assim como permite fazer a adição de um usuário do tipo professor,
            adicção de um usuário do tipo aluno/usuário comum (que são a mesma coisa), a edição dos cadastros e exclusão.
            Cuidado com as exclusões pois se algum usuario cadastrado, seja ele de qualquer tipo for excluido e possuir vinculo com a tabela
            participanteevento, automaticamente esta tabela irá corromper-se.*/


            //Logout do usuario

            if($id == 3){
                $usuario->UsuarioLogOut();
            }

            /*============================================================
            ABAIXO ESTÃO TODAS AS AÇÕES QUE PODEM SER FEITAS COM EVENTOS
            ============================================================*/

            if($acao ==  'eventoprincipal'){
                echo "<div class='divBtnCadastrarEvento'>
                            <a href='painelprofessor.php?id=1' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Pendências</a>
                            <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Evento principal</a>
                            <a href='painelprofessor.php?acao=cadastrarEvento' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Cadastrar novo evento</a>
                            <a href='painelprofessor.php?acao=exibirEventosValidados' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Listar eventos validados</a>
                    </div>";
                    include_once "formularios/cadastroeventopai.html";
                    if(isset($_POST['cadastrar'])){
                        $descricao = $_POST['descricao'];
                        $dataInicio = $_POST['data_inicio'];
                        $dataFim = $_POST['data_fim'];
                        $curso = $_POST['curso'];
                        $eventopai->NovoEventoPai($descricao,$dataInicio,$dataFim,$curso,$idUsuario);
                        header("Location: painelprofessor.php?acao=eventoprincipal");
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
                                        echo "<td><a href="."painelprofessor.php?idEvento=".$roweventopai['idEventopai']."&acao=excluirEventoPai><i class='far fa-trash-alt' title='Excluir evento principal'></i></a></td>";
                                    echo "</tr>";
                                }
                            }
                    echo "</tbody>
                    </table>";
            }

            if($acao == 'excluirEventoPai'){
                $eventopai->ExcluiEventoPai($idEvento);
                header("Location: painelprofessor.php?acao=eventoprincipal");
            }

            if($acao == 'cadastrarEvento'){
                echo "<div class='divBtnCadastrarEvento'>
                            <a href='painelprofessor.php?id=1' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Pendências</a>
                            <a href='painelprofessor.php?acao=eventoprincipal' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Evento principal</a>
                            <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Cadastrar novo evento</a>
                            <a href='painelprofessor.php?acao=exibirEventosValidados' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Listar eventos validados</a>
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
                    header("Location: painelprofessor.php?id=1");
                }
                
            }

            /*Esta estrutura exclui um evento em especícifo e retorna o usuário para a tela que
            lista todos os eventos*/

            if($acao == 'excluirEvento'){
                $evento->ExcluirEvento($idEvento);
                if($tela == 'validado'){
                    header('Location: painelprofessor.php?acao=exibirEventosValidados');
                }else{
                    header('Location: painelprofessor.php?id=1');
                }
            }

            if($acao == 'cadastrarPlanilha'){
                $dataEvento = $evento->ExibeEventoExpecifico($idEvento);
                $dataUsario = $usuario->ListaTodosOsUsuarios();
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
                                <a href="."painelprofessor.php?acao=todosInscritosPlanilha&idEvento=".$rowEvento['idEvento']." style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Todos os Inscritos</a>";
                                if($rowEvento['extensao'] == 'evento' || $rowEvento['extensao'] == 'curso'){
                                   echo "<a href="."painelprofessor.php?acao=colab&idEvento=".$rowEvento['idEvento']." style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Colaboração</a>";
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
                        foreach($dataUsario as $rowUsuario){
                            if($rowParticipante['tipo'] == 'orientador' || $rowParticipante['tipo'] == 'bolsista' || $rowParticipante['tipo'] == 'voluntario' || $rowParticipante['tipo'] == 'colaborador' || $rowParticipante['tipo'] == 'organizador' || $rowParticipante['tipo'] == 'monitor' || $rowParticipante['tipo'] == 'palestrante' || $rowParticipante['tipo'] == 'mediador' || $rowParticipante['tipo'] == 'debatedor' || $rowParticipante['tipo'] == 'ministrante' || $rowParticipante['tipo'] == 'ouvinte' || $rowParticipante['tipo'] == 'apresentador' || $rowParticipante['tipo'] == 'avaliador'){
                                if($rowParticipante['id_usuario'] == $rowUsuario['idUsuario']){
                                    echo "<tr>";
                                                echo "<td>".$rowUsuario['nome']."</td>";
                                                echo "<td>".$rowUsuario['cpf']."</td>";
                                                echo "<td>".$rowParticipante['tipo']."</td>";
                                                echo "<td><a href="."painelprofessor.php?acao=excluirUsuarioPlanilha&idUsuarioPlanilha=".$rowParticipante['idParticipanteEvento']."&idEvento=".$rowEvento['idEvento']."><i class='far fa-trash-alt' title='Excluir usuario'></i></a></td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    }
                
                        echo "</tbody>
                            </table>";
                        require_once "formularios/planilha.html";
                                    
                        echo "<div class='form-inline' style='margin-top: 20px; position: relative; display: flex; justify-content: center;'>
                                <a href="."painelprofessor.php?acao=cadastrarAutor&idEvento=".$rowEvento['idEvento'].">Vincular Autores do evento</a>
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
                                windows.location.href="."painelprofessor.php?acao=cadastrarPlanilha&idEvento=".$eventoID.";
                            </script>";
                        }else{
                            $participante->NovoParticipanteEvento($tipo,$posteres,$tipoPoster,$idUsuarioEvento,$eventoID);
                            header("Location: painelprofessor.php?acao=cadastrarPlanilha&idEvento=".$eventoID);
                        }
                    }
                }
                               
            }
            if($acao == 'colab'){

                $dataEvento = $evento->ExibeEventoExpecifico($idEvento);
                $dataUsario = $usuario->ListaTodosOsUsuarios();
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
                                        <a href="."painelprofessor.php?acao=cadastrarPlanilha&idEvento=".$rowEvento['idEvento']." style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Participantes Organização</a>
                                        <a href="."painelprofessor.php?acao=todosInscritosPlanilha&idEvento=".$rowEvento['idEvento']." style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Todos os Inscritos</a>
                                        <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Colaboração</a>           
                                </div>";   
                            require_once "formularios/colaboracao.html";
                            if(isset($_POST['bntColab'])){
                                $colaboracao = $_POST['colab'];
                                $evento->alterarColaboracao($idEvento,$colaboracao);
                                header("Location:"."painelprofessor.php?acao=colab&idEvento=".$idEvento);
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
                header("Location: painelprofessor.php?acao=cadastrarPlanilha&idEvento=".$evento);
            }
            if($acao == 'todosInscritosPlanilha'){
                $eventoID = intval($idEvento);
                $dataEvento = $evento->ExibeEventoExpecifico($eventoID);
                $dataUsario = $usuario->ListaTodosOsUsuarios();
                $dataParticipante = $participante->ExibeParticipanteEventoEspecifico($idEvento);

                foreach($dataEvento as $rowEvento){
                    echo "<div class='form-inline' style='display: felx; position: relative; justify-content: center;'>";
                        echo "<h1>".$rowEvento['descricao']."</h1>";                    
                    echo "</div>";

                    echo "<div class='divBtnCadastrarEvento'>
                                <a href="."painelprofessor.php?acao=cadastrarPlanilha&idEvento=".$rowEvento['idEvento']." style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Participantes Organização</a>
                                <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Todos os Inscritos</a>";
                                if($rowEvento['extensao'] == 'evento' || $rowEvento['extensao'] == 'curso'){
                                    echo "<a href="."painelprofessor.php?acao=colab&idEvento=".$rowEvento['idEvento']." style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Colaboração</a>";
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
                        foreach($dataUsario as $rowUsuario){
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
                        echo "<td><a href="."painelprofessor.php?acao=excluirAutor&idAutor=".$rowAutor['idAutor']."&idEvento=".$idEvento."><i class='far fa-trash-alt' title='Excluir autor'></i></a></td>";
                        echo "</tr>";
                    }
                    echo "</tbody>
                    </table>";
                    include_once 'formularios/autor.html';
                    if(isset($_POST['vincularAutor'])){
                        $nome = $_POST['nomeAutor'];
                        $eventoID = $idEvento;

                        $autor->NovoAutor($nome,$eventoID);
                        header("Location:"."painelprofessor.php?acao=cadastrarAutor&idEvento=".$eventoID);
                    }
                    echo "<div class='form-inline' style='margin-top: 20px; position: relative; display: flex; justify-content: center;'>
                            <a href='#' onclick='imprimirTela()' id='btnImprimir'>Imprmir</a>
                        </div>";                              
            }
            if($acao == 'excluirAutor'){
                $autor->ExcluirAutor($idAutor);
                header("Location:"."painelprofessor.php?acao=cadastrarAutor&idEvento=".$idEvento);
            }

            //Estrutura para exibir apenas os eventos que foram validados.

            if($acao == 'exibirEventosValidados'){
                $descricaoEventoPai = '';
                echo "<div class='divBtnCadastrarEvento'>
                            <a href='painelprofessor.php?id=1' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Pendências</a>
                            <a href='painelprofessor.php?acao=eventoprincipal' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Evento principal</a>
                            <a href='painelprofessor.php?acao=cadastrarEvento' style='text-decoration: none; color:blue;' class='linksMenuPrincipal'>Cadastrar novo evento</a>
                            <a href='#' style='text-decoration: none; color:blue;' class='linksMenuPrincipalSelecionado'>Listar eventos validados</a>
                    </div>";

                $dataEvento = $evento->ListarEventosValidados();
                $dataUsuario = $usuario->ListaTodosOsUsuarios();
                $dataEventoPai = $eventopai->ExibeTodosEventosPai();

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
                        <th scope='col'>Permite emissão de certificado</th>
                        <th></th>
                    </tr>            
                ";
                foreach($dataEvento as $rowEvento){                    
                    if($rowEvento['data_fim'] >= date("Y-m-d")){
                        echo "
                            <tr>";
                            echo "<td><a target='_blank' href="."'"."emitircertificado.php?idEvento=".$rowEvento['idEvento']."&oficinaMinicurso=".$rowEvento['oficina_minicurso']."&apresentacao=".$rowEvento['extencao_ou_ic']."'"." style='color:red;'><i class='fas fa-print' title='Emitir Certificado'></i></a></td>";
                            echo "<td><a target='_blank' href="."gerarqrcode.php?idEvento=".$rowEvento['idEvento']."&evento=".$rowEvento['descricao']." title='Emitir QRcode'><i class='fas fa-qrcode'></i></a></td>";
                                foreach($dataEventoPai as $rowEventoPai){
                                    if($rowEvento['codigo_evento_pai'] == $rowEventoPai['codigo']){
                                        echo "<td>".$rowEventoPai['descricao']."</td>";
                                    }else if($rowEvento['codigo_evento_pai'] == '' || $rowEvento['codigo_evento_pai'] == null){
                                        echo "<td>-</td>";
                                    }
                                }
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
                            echo "<td><a href="."painelprofessor.php?idEvento=".$rowEvento['idEvento']."&acao=excluirEvento&tela=validado><i class='far fa-trash-alt' title='Excluir evento'></i></a></td>";   
                            echo "</tr>";
                    }
                }
                echo "</table>";
            }

    echo    "</div>
        </div>
    ";

    require_once 'footer.html';
?>