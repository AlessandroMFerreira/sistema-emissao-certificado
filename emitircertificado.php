<?php
    session_start();
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
    
    $evento = new Classes\evento();
    $certificado = new Classes\certificado();
    $autor = new Classes\autor();
    $participante = new Classes\participante();
    $usuario = new Classes\usuario();
    $eventopai = new Classes\eventopai();

    $apresentacao = $_GET['apresentacao'];
    $oficina_minicurso = $_GET['oficinaMinicurso'];
    $idEvento = intval($_GET['idEvento']);
    $idUsuario = intval($_SESSION['idUsuario']);
    $nomeUsuario = $_SESSION['nomeUsuario'];
    $descricaoEventoPai = '';
    $nomeEvento = '';
    $dataInicio  = '';
    $dataFim = '';
    $cargaHoraria = '';
    $tipoEvento = '';
    $extensao = '';
    $pesquisa = '';
    $validado = '';
    $tipoParticipante = '';
    $orientador = '';
    $projeto_bolsista = '';
    $projeto_orientador = '';
    $projeto_voluntario = '';
    $projeto_colaborador = '';
    $evento_organizador = '';
    $evento_palestrante = '';
    $evento_ministrante = '';
    $evento_apresentador = '';
    $evento_monitor = '';
    $evento_mediador = '';
    $evento_participante = '';
    $evento_avaliador = '';
    $curso_organizador = '';
    $curso_ministrante = '';
    $curso_participante = '';
    $pesquisa_projeto_ic_orientador = '';
    $pesquisa_projeto_ic_bolsista = '';
    $pesquisa_projeto_ic_voluntario = '';
    $pesquisa_projeto_icj_orientador = '';
    $pesquisa_projeto_icj_bolsista = '';
    $pesquisa_projeto_icj_voluntario = '';
    $bolsista = '';

    //foreach para preencher os autores
    $dataAutor = $autor->ExibeAutorEventoEspecifico($idEvento);
    $nomeAutores = '';
    $contador = 0; //contar a quantidade de autores
    foreach($dataAutor as $rowAutor){
        $contador ++;
        if($contador <= 1){
            $nomeAutores = $rowAutor['nome'];
        }else{
            $nomeAutores .= ", ".$rowAutor['nome'];
        }
    }

    $dataEvento = $evento->ExibeEventoExpecifico($idEvento);
    $dataParticipante = $participante->BuscaParticipanteExpecificoEventoExpecifico($idUsuario,$idEvento);
    $dataParticipanteAll = $participante->ExibeTodosParticipantes();
    $dataUsuario = $usuario->ListaTodosOsUsuarios();

    //foreach para buscar o tipo de participante

    foreach($dataParticipante as $rowParticipante){
        $tipoParticipante = $rowParticipante['tipo'];
        $entrada = $rowParticipante['entrada'];
        $saida = $rowParticipante['saida'];
        $tipoPoster = $rowParticipante['tipoPoster'];
        $numeroPosteres = $rowParticipante['numero_posteres'];
    }
    //calcula a quantidade de horas que o usuario obteve no evento
    $d1 = new DateTime($entrada);
    $d2 = new DateTime($saida);
    $diferenca = $d1->diff($d2, true);
    $cargaRealizada = $diferenca->format('%H:%i:%s');
    

    //foreach para buscar o orientador

    foreach($dataParticipanteAll as $rowParticipanteAll){
        if($rowParticipanteAll['id_evento'] == $idEvento && $rowParticipanteAll['tipo'] == 'orientador'){
            foreach($dataUsuario as $rowUsuario){
                if($rowParticipanteAll['id_usuario'] == $rowUsuario['idUsuario']){
                    $orientador = $rowUsuario['nome'];
                }
            }
        }
        //bolsista
        if($rowParticipanteAll['id_evento'] == $idEvento && $rowParticipanteAll['tipo'] == 'bolsista'){
            foreach($dataUsuario as $rowUsuario){
                if($rowParticipanteAll['id_usuario'] == $rowUsuario['idUsuario']){
                    $bolsista = $rowUsuario['nome'];
                }
            }
        }
    }

    //foreach para preencher as variaveis da tabela evento
    foreach($dataEvento as $rowEvento){
        $dataInicio = $rowEvento['data_inicio'];
        $dataFim = $rowEvento['data_fim'];
        $cargaHoraria = $rowEvento['carga_horaria'];
        $nomeEvento = $rowEvento['descricao'];
        $validado = $rowEvento['validado'];
        $permiteCertificado = $rowEvento['permiteemimssaocertificado'];
        $tipoEvento = $rowEvento['tipo'];
        $extensao = $rowEvento['extensao'];
        $pesquisa = $rowEvento['pesquisa'];
        $projeto_bolsista = $rowEvento['projeto_bolsista'];
        $projeto_orientador = $rowEvento['projeto_orientador'];
        $projeto_voluntario = $rowEvento['projeto_voluntario'];
        $projeto_colaborador = $rowEvento['projeto_colaborador'];
        $evento_organizador = $rowEvento['evento_organizador'];
        $evento_palestrante = $rowEvento['evento_palestrante'];
        $evento_ministrante = $rowEvento['evento_ministrante'];
        $evento_apresentador = $rowEvento['evento_apresentador'];
        $evento_monitor = $rowEvento['evento_monitor'];
        $evento_mediador = $rowEvento['evento_mediador'];
        $evento_participante = $rowEvento['evento_participante'];
        $evento_avaliador = $rowEvento['evento_avaliador'];
        $curso_organizador = $rowEvento['curso_organizador'];
        $curso_ministrante = $rowEvento['curso_ministrante'];
        $curso_participante = $rowEvento['curso_participante'];
        $pesquisa_projeto_ic_orientador = $rowEvento['pesquisa_projeto_ic_orientador'];
        $pesquisa_projeto_ic_bolsista = $rowEvento['pesquisa_projeto_ic_bolsista'];
        $pesquisa_projeto_ic_voluntario = $rowEvento['pesquisa_projeto_ic_voluntario'];
        $pesquisa_projeto_icj_orientador = $rowEvento['pesquisa_projeto_icj_orientador'];
        $pesquisa_projeto_icj_bolsista = $rowEvento['pesquisa_projeto_icj_bolsista'];
        $pesquisa_projeto_icj_voluntario = $rowEvento['pesquisa_projeto_icj_voluntario'];
        $colaboracao = $rowEvento['colaboracao'];
        $cursoGraduacao = $rowEvento['curso'];
        $codigo = $rowEvento['codigo_evento_pai'];
        $fomento = $rowEvento['fomento'];
    }

    //estrutura para pegar a descrição do evento pai
    $dataEventoPai = $eventopai->BuscaEventoPaiPorCodigo($codigo);
    foreach($dataEventoPai as $rowEventoPai){
        $descricaoEventoPai = $rowEventoPai['descricao'];
    }
    /*================================================================================
    ABAIXO ESTÃO AS VALIDAÇÕES PARA O TIPO DE EVENTO "EXTENSÃO" ENQUADRAMENTO "PROJETO"
    ================================================================================*/
    
    //BOLSISTA

    if($tipoEvento == 'extensao' && $extensao == 'projeto' && $projeto_bolsista == 1 && $tipoParticipante == 'bolsista' && $validado == 1 && $permiteCertificado == 1){
        $certificado->CertificadoProjetoBolsista($nomeEvento,$orientador,$dataInicio,$dataFim);
    }

    //ORIENTADOR

    else if($tipoEvento == 'extensao' && $extensao == 'projeto' && $projeto_orientador == 1 && $tipoParticipante == 'orientador' && $validado == 1 && $permiteCertificado == 1){
        $certificado->CertificadoProjetoOrientador($nomeEvento, $bolsista, $dataInicio, $dataFim);
    }

    //VOLUNTÁRIO

    else if($tipoEvento == 'extensao' && $extensao == 'projeto' && $projeto_voluntario == 1 && $tipoParticipante == 'voluntario' && $validado == 1 && $permiteCertificado == 1){
        $certificado->CertificadoProjetoVoluntario($orientador,$nomeEvento,$dataInicio,$dataFim);
    }
    
    //COLABORADOR

    else if($tipoEvento == 'extensao' && $extensao == 'projeto' && $projeto_colaborador == 1 && $tipoParticipante == 'colaborador' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoProjetoColaborador($orientador,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria);
    }

    /*================================================================================
    ABAIXO ESTÃO AS VALIDAÇÕES PARA O TIPO DE EVENTO "EXTENSÃO" ENQUADRAMENTO "EVENTO"
    ================================================================================*/

    //ORGANIZADOR

    else if($tipoEvento == 'extensao' && $extensao == 'evento' && $evento_organizador == 1 && $tipoParticipante == 'organizador' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoEventoOrganizador($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$cargaHoraria);
    }

    //PALESTRANTE
    else if($tipoEvento == 'extensao' && $extensao == 'evento' && $evento_palestrante == 1 && $tipoParticipante == 'palestrante' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoEventoPalestrante($cursoGraduacao,$nomeEvento,$descricaoEventoPai,$colaboracao,$dataInicio,$dataFim,$cargaHoraria);
    }

    //MINISTRANTE

    else if($tipoEvento == 'extensao' && $extensao == 'evento' && $evento_ministrante == 1 && $tipoParticipante == 'ministrante' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoEventoMinistrante($cursoGraduacao,$nomeEvento,$descricaoEventoPai,$oficina_minicurso,$colaboracao,$dataInicio,$dataFim,$cargaHoraria);
    }

    //APRESENTADOR

    else if($tipoEvento == 'extensao' && $extensao == 'evento' && $evento_apresentador == 1 && $tipoParticipante == 'apresentador' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoEventoApresentador($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$cargaHoraria,$apresentacao,$nomeAutores,$descricaoEventoPai);
    }

    //MONITOR

    else if($tipoEvento == 'extensao' && $extensao == 'evento' && $evento_monitor == 1 && $tipoParticipante == 'monitor' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoEventoMonitor($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$cargaHoraria,$cargaRealizada);
    }

    //DEBATEDOR - MEDIADOR
    
    else if($tipoEvento == 'extensao' && $extensao == 'evento' && $evento_mediador == 1 && $tipoParticipante == 'mediador' || $tipoParticipante == 'debatedor' && $validado == 1 && $permiteCertificado == 1){
        $certificado->CertificadoEventoDebatedorMediador($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$cargaHoraria,$tipoParticipante,$descricaoEventoPai);
    }

    //OUVINTE

    else if($tipoEvento == 'extensao' && $extensao == 'evento' && $evento_participante == 1 && $tipoParticipante == 'ouvinte' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoEventoParticipante($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$cargaHoraria);
    }

    //AVALIADOR

    else if($tipoEvento == 'extensao' && $extensao == 'evento' && $evento_avaliador == 1 && $tipoParticipante == 'avaliador' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoEventoAvaliador($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$numeroPosteres,$tipoPoster);
    }

    /*================================================================================
    ABAIXO ESTÃO AS VALIDAÇÕES PARA O TIPO DE EVENTO "EXTENSÃO" ENQUADRAMENTO "CURSO"
    ================================================================================*/

    //ORGANIZADOR

    else if($tipoEvento == 'extensao' && $extensao == 'curso' && $curso_organizador == 1 && $tipoParticipante == 'organizador' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoCursoOrganizador($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$cargaHoraria);
    }

    //MINISTRANTE

    else if($tipoEvento == 'extensao' && $extensao == 'curso' && $curso_ministrante == 1 && $tipoParticipante == 'ministrante' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoCursoMinistrante($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$cargaHoraria);
    }
    
    //OUVINTE

    else if($tipoEvento == 'extensao' && $extensao == 'curso' && $curso_participante == 1 && $tipoParticipante == 'ouvinte' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoCursoOuvinte($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$cargaHoraria);
    }

    /*============================================================================================
    ABAIXO ESTÃO AS VALIDAÇÕES PARA O TIPO DE EVENTO "PESQUISA" ENQUADRAMENTO "INICIAÇÃO CINTÍFICA"
    ============================================================================================*/

    //ORIENTADOR

    else if($tipoEvento == 'pesquisa' && $pesquisa == 'iniciacao cientifica' && $pesquisa_projeto_ic_orientador == 1 && $tipoParticipante == 'orientador' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoIcOrientador($bolsista,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria,$fomento);
    }

    //BOLSISTA

    else if($tipoEvento == 'pesquisa' && $pesquisa == 'iniciacao cientifica' && $pesquisa_projeto_ic_bolsista == 1 && $tipoParticipante == 'bolsista' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoIcBolsista($orientador,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria,$fomento);
    }

    //VOLUNTARIO

    else if($tipoEvento == 'pesquisa' && $pesquisa == 'iniciacao cientifica' && $pesquisa_projeto_ic_voluntario == 1 && $tipoParticipante == 'voluntario' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoIcVoluntario($orientador,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria,$fomento);
    }

    /*====================================================================================================
    ABAIXO ESTÃO AS VALIDAÇÕES PARA O TIPO DE EVENTO "PESQUISA" ENQUADRAMENTO "INICIAÇÃO CINTÍFICA JÚNIOR"
    ====================================================================================================*/

    //ORIENTADOR

    else if($tipoEvento == 'pesquisa' && $pesquisa == 'iniciacao cientifica junior' && $pesquisa_projeto_icj_orientador == 1 && $tipoParticipante == 'orientador' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoIcjOrientador($bolsista,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria,$fomento);
    }

    //BOLSISTA

    else if($tipoEvento == 'pesquisa' && $pesquisa == 'iniciacao cientifica junior' && $pesquisa_projeto_icj_bolsista == 1 && $tipoParticipante == 'bolsista' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoIcjBolsista($orientador,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria,$fomento);
    }

    //VOLUNTARIO

    else if($tipoEvento == 'pesquisa' && $pesquisa == 'iniciacao cientifica junior' && $pesquisa_projeto_icj_voluntario == 1 && $tipoParticipante == 'voluntario' && $validado == 1 && $permiteCertificado == 1){

        $certificado->CertificadoIcjVoluntario($orientador,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria,$fomento);
    }

    else if($validado == 0){
        echo "<script>
                    alert('Evento ainda não validado!');
                    window.close();
                </script>";
    }
    else if($permiteCertificado == 0){
        echo "<script>
                    alert('A emissão de certificados para este evento ainda não foi liberada. Entre em contato com a secretaria da Universidade!');
                    window.close();
                </script>";
    }
    else{
        echo "<script>
                    alert('Certificado não permitido para este tipo de usuario!');
                    window.close();
                </script>";
    }
?>