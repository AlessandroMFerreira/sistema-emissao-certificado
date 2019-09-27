<?php
    //Iniciando a sessão
    session_start();


    //include de arquivos 
    require_once 'header.html';
    require __DIR__."/vendor/autoload.php";

    //Verificação de segurança
    if(!isset($_SESSION['tipo']) && !isset($_SESSION['idUsuario']) || $_SESSION['tipo'] != 'administrador'){
        session_destroy();
        header('Location: index.php');
    }
    
    
    //Instanciação de classes
    $evento = new evento();
     $usuario = new usuario();

    //Iniciação das variáveis de controle
    $id = '';
    $acao = '';
    $idEvento = '';
    $idUsuario = $_SESSION['idUsuario'];
    $nomeUsuario = $_SESSION['nomeUsuario'];
    $tela = '';

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
                echo "<div id='divBtnCadastrarEvento'>
                            <button type='button' class='btn btn-primary' style='background-color: grey !important;width: 250px;'><a href='#' style='text-decoration: none; color:white;'>Eventos</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?acao=cadastrarEvento' style='text-decoration: none; color:white;'>Cadastrar novo evento</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?acao=exibirEventosValidados' style='text-decoration: none; color:white;'>Listar eventos validados</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?acao=exibirEventosNaoValidados' style='text-decoration: none; color:white;'>Listar eventos não validados</a></button>
                    </div>";
                
                $dataEvento = $evento->ExibeTodosEventos();
                $dataUsuario = $usuario->ListaTodosOsUsuarios();

                echo "<table class='table'>
                    <tr>
                        <th></th>
                        <th></th>
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
                            echo "<td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=emitirCertificado><i class='fas fa-print' title='Emitir Certificado'></i></a></td>";
                            echo "<td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=cadastrarPlanilha><i class='fas fa-table' title='Cadastrar planilha de participantes'></i></a></td>";
                            echo "<td>".$rowEvento['curso']."</td>";
                            echo "<td><a href='#' title='Clique para ver a planilha de participantes associados ao evento'>".$rowEvento['descricao']."</a></td>
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
                        echo "<td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=excluirEvento><i class='far fa-trash-alt' title='Excluir evento'></i></a></td>";   
                        echo "</tr>";
                }
                echo "</table>";
            }

            /*Exisbe todos os usuários cadastrados no sistema, assim como permite fazer a adição de um usuário do tipo professor,
            adicção de um usuário do tipo aluno/usuário comum (que são a mesma coisa), a edição dos cadastros e exclusão.
            Cuidado com as exclusões pois se algum usuario cadastrado, seja ele de qualquer tipo for excluido e possuir vinculo com a tabela
            participanteevento, automaticamente esta tabela irá corromper-se.*/

            if($id == 2){
                echo "<div id='divBtnCadastrarUsuario'>
                            <button type='button' class='btn btn-primary' style='background-color: grey !important;width: 250px;'><a href='#' style='text-decoration: none; color:white;'>Usuarios</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?acao=cadastrarProfessor' style='text-decoration: none; color:white;'>Cadastrar Professor</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?acao=cadastrarUsuario' style='text-decoration: none; color:white;'>Cadastrar Usuario</a></button>
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

            if($acao == 'cadastrarEvento'){
                echo "<div id='divBtnCadastrarEvento'>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?id=1' style='text-decoration: none; color:white;'>Eventos</a></button>
                            <button type='button' class='btn btn-primary' style='background-color: grey !important;width: 250px;'><a href='#' style='text-decoration: none; color:white;'>Cadastrar novo evento</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?acao=exibirEventosValidados' style='text-decoration: none; color:white;'>Listar eventos validados</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?acao=exibirEventosNaoValidados' style='text-decoration: none; color:white;'>Listar eventos não validados</a></button>
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
                    $evento->NovoEvento($descricao,$cargahoraria,$datainicio,$datafim,$datacriacao,$tipo,$extensao,$pesquisa,$bolsista_projeto,$orientador_projeto,$voluntario_projeto,$colaborador_projeto,$organizador_evento,$palestrante_evento,$ministrante_evento,$apresentador_evento,$monitor_evento,$mediador_evento,$participante_evento,$avaliador_evento,$organizador_curso,$ministrante_curso,$participante_curso,$orientador_iniciacao_cientifica,$bolsista_iniciacao_cientifica,$voluntario_iniciacao_cientifica,$orientador_iniciacao_cientifica_jr,$bolsista_iniciacao_cientifica_jr,$voluntario_iniciacao_cientifica_jr,$sigaextensao,$idsiga,$map,$idmap,$colegiado,$numeroata,$dataata,$outrasocorrencias,$curso,$iduser);

                }
                
            }

            /*Esta estrutura exclui um evento em especícifo e retorna o usuário para a tela que
            lista todos os eventos*/

            if($acao == 'excluirEvento'){
                $evento->ExcluirEvento($idEvento);
                if($tela == 'validado'){
                    header('Location: painelcontrole.php?acao=exibirEventosValidados');
                }
                else if($tela == 'naovalidados'){
                    header('Location: painelcontrole.php?acao=exibirEventosNaoValidados');
                }else{
                    header('Location: painelcontrole.php?id=1');
                }
            }

            if($acao == 'cadastrarPlanilha'){
                $dataEvento = $evento->ExibeEventoExpecifico($idEvento);
                $dataUusario = $usuario->ListaTodosOsUsuarios();

                foreach($dataEvento as $rowEvento){

                    //verificando para Evento-Projeto
                    if($rowEvento['tipo'] == 'extensao' && $rowEvento['extensao'] == 'projeto'){
                        require_once "formularios/planilhaextensaoprojeto.html";
                    }
                }
            }


            /*Esta estrutura valida (seta o campo "validado" na tabela "evento" como "1") 
            um evento em especícifo e retorna o usuário para a tela que
            lista todos os eventos*/

            if($acao == 'validarEvento'){
                $evento->ValidarEvento($idEvento);
                if($tela == 'naovalidados'){
                    header('Location: painelcontrole.php?acao=exibirEventosNaoValidados');
                }else{
                    header('Location: painelcontrole.php?id=1');
                }
            }
            if($acao == 'emitirCertificado'){
                header('Location: emitircertificado.php?idEvento='.$idEvento);
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
                echo "<div id='divBtnCadastrarEvento'>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?id=1' style='text-decoration: none; color:white;'>Eventos</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?acao=cadastrarEvento' style='text-decoration: none; color:white;'>Cadastrar novo evento</a></button>
                            <button type='button' class='btn btn-primary' style='background-color: grey !important; width: 250px;'><a href='#' style='text-decoration: none; color:white;'>Listar eventos validados</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?acao=exibirEventosNaoValidados' style='text-decoration: none; color:white;'>Listar eventos não validados</a></button>
                    </div>";

                $dataEvento = $evento->ListarEventosValidados();
                $dataUsuario = $usuario->ListaTodosOsUsuarios();

                echo "<table class='table'>
                    <tr>
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
                        <tr>
                            <td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=permitirCertificado&tela=validado style='color:red;'><i class='far fa-file-alt' title='Permitir emissão de certificado'></i><a></td>";
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
                        echo "<td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=excluirEvento&tela=validado><i class='far fa-trash-alt' title='Excluir evento'></i></a></td>";   
                        echo "</tr>";
                }
                echo "</table>";
            }

            //Estrutura para exibir somente os eventos que ainda não foram validados.

            if($acao == 'exibirEventosNaoValidados'){
                echo "<div id='divBtnCadastrarEvento'>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?id=1' style='text-decoration: none; color:white;'>Eventos</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?acao=cadastrarEvento' style='text-decoration: none; color:white;'>Cadastrar novo evento</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?acao=exibirEventosValidados' style='text-decoration: none; color:white;'>Listar eventos validados</a></button>
                            <button type='button' class='btn btn-primary' style='background-color: grey !important;width: 250px;'><a href='#' style='text-decoration: none; color:white;'>Listar eventos não validados</a></button>
                    </div>";

                $dataEvento = $evento->ListaEventosNaoValidados();
                $dataUsuario = $usuario->ListaTodosOsUsuarios();

                echo "<table class='table'>
                    <tr>
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
                        <tr>
                            <td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=validarEvento&tela=naovalidados><i class='far fa-check-square' title='Validar evento'></i><a></td>";
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
                        echo "<td><a href="."painelcontrole.php?idEvento=".$rowEvento['idEvento']."&acao=excluirEvento&tela=naovalidados><i class='far fa-trash-alt' title='Excluir evento'></i></a></td>";   
                        echo "</tr>";
                }
                echo "</table>";
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
                echo "<div id='divBtnCadastrarUsuario'>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?id=2' style='text-decoration: none; color:white;'>Usuarios</a></button>
                            <button type='button' class='btn btn-primary' style='background-color: grey !important;width: 250px;'><a href='#' style='text-decoration: none; color:white;'>Cadastrar Professor</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?acao=cadastrarUsuario' style='text-decoration: none; color:white;'>Cadastrar Usuario</a></button>
                    </div>";
                
                require_once 'formularios/cadastrousuario.html';

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
                echo "<div id='divBtnCadastrarUsuario'>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?id=2' style='text-decoration: none; color:white;'>Usuarios</a></button>
                            <button type='button' class='btn btn-primary' style='width: 250px;'><a href='painelcontrole.php?acao=cadastrarProfessor' style='text-decoration: none; color:white;'>Cadastrar Professor</a></button>
                            <button type='button' class='btn btn-primary' style='background-color: grey !important;width: 250px;'><a href='#' style='text-decoration: none; color:white;'>Cadastrar Usuario</a></button>
                    </div>";

                    require_once 'formularios/cadastrousuario.html';

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