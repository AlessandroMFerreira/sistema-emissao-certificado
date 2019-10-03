<?php
    session_start();
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
    
    $evento = new Classes\evento();
    $certificado = new Classes\certificado();
    $autor = new Classes\autor();
    $participante = new Classes\participante();
    $usuario = new Classes\usuario();

    $idEvento = $_GET['idEvento'];
    $idUsuario = $_SESSION['idUsuario'];
    $nomeUsuario = $_SESSION['nomeUsuario'];
    $nomeEvento = '';
    $dataInicio  = '';
    $dataFim = '';
    $cargaHoraria = '';
    $autor = '';
    $tipoEvento = '';
    $extensao = '';
    $pesquisa = '';
    $validado = '';
    $certificado = '';
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


    $dataEvento = $evento->ExibeEventoExpecifico($idEvento);
    $dataParticipante = $participante->BuscaParticipanteExpecifico($idUsuario);
    $dataUsuario = $usuario->ListaTodosOsUsuarios();

    foreach($dataEvento as $rowEvento){
        $dataInicio = $rowEvento['data_inicio'];
        $dataFim = $rowEvento['data_fim'];
        $cargaHoraria = $rowEvento['carga_horaria'];
        $nomeEvento = $rowEvento['descricao'];
        $validado = $rowEvento['validado'];
        $certificado = $rowEvento['permiteemimssaocertificado'];
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
    }


    
    


?>