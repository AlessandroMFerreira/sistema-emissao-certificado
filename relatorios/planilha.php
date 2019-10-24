<?php

    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

    include_once "header.html";

    $evento = new Classes\evento();
    $eventopai = new Classes\eventopai();
    $autor = new Classes\autor();
    $participante = new Classes\participante();
    $usuario = new Classes\usuario();
    $certificados = array();

    $idEvento = '';

    if(array_key_exists('idEvento', $_GET)){
        $idEvento = $_GET['idEvento'];
    }

    $dataEvento = $evento->ExibeEventoExpecifico($idEvento);
    $dataEventoPai = '';
    $dataUsuario = '';
    $dataAutor = $autor->ExibeAutorEventoEspecifico($idEvento);
    $dataParticipante = $participante->ExibeParticipanteEventoEspecifico($idEvento);

    foreach($dataEvento as $rowEvento){
        $dataEventoPai = $eventopai->BuscaEventoPaiPorCodigo($rowEvento['codigo_evento_pai']);
        $dataUsuario = $usuario->ListaUsuarioExpecifico($rowEvento['id_usuario_responsavel']);
        echo    "<div>
                    <div style='display:flex;position:relative;justify-content:center;font-weight: bolder;font-size: 20px;margin-top: 10px;'>".$rowEvento['descricao']."</div>";
                    echo "<table id='tabelaPlanilha'>
                            <tr><td><b style='color: red;'>DADOS DO EVENTO</b></td></tr>
                            <tr>";
                        foreach($dataUsuario as $rowUsuario){
                            echo "<td><b>Responsável: </b>".$rowUsuario['nome']."</td>";
                        }
                        echo "<td><b>Carga horária: </b>".$rowEvento['carga_horaria']."</td></tr>";
                        echo "<tr>
                                <td><b>Data inicio: </b>".date("d/m/Y",strtotime($rowEvento['data_inicio']))."</td>".
                                "<td><b>Data fim: </b>".date("d/m/Y",strtotime($rowEvento['data_fim']))."</td>".
                            "</tr>
                            <tr>
                                <td><b>Tipo: </b>".$rowEvento['tipo']."</td>";
                                if($rowEvento['extensao'] != '' || $rowEvento['extensao'] != null){
                                    echo "<td><b>Enquadramento: </b>".$rowEvento['extensao']."</td>";
                                }else{
                                    echo "<td><b>Enquadramento: </b>".$rowEvento['pesquisa']."</td>";
                                }
                        echo   "</tr>
                                <tr>
                                    <td><b>Certificados: </b>";
                                if($rowEvento['projeto_bolsista'] == 1 || $rowEvento['pesquisa_projeto_ic_bolsista'] == 1 || $rowEvento['pesquisa_projeto_icj_bolsista'] == 1){
                                    array_push($certificados, "bolsista");
                                }
                                if($rowEvento['projeto_orientador'] == 1 || $rowEvento['pesquisa_projeto_ic_orientador'] == 1 || $rowEvento['pesquisa_projeto_icj_orientador'] == 1){
                                    array_push($certificados, "orientador");
                                }
                                if($rowEvento['projeto_voluntario'] == 1 || $rowEvento['pesquisa_projeto_ic_voluntario'] == 1 || $rowEvento['pesquisa_projeto_icj_voluntario'] == 1){
                                    array_push($certificados, "voluntario");
                                }
                                if($rowEvento['projeto_colaborador'] == 1){
                                    array_push($certificados, "colaborador");
                                }
                                if($rowEvento['evento_organizador'] == 1 || $rowEvento['curso_organizador'] == 1){
                                    array_push($certificados, "organizador");
                                }
                                if($rowEvento['evento_palestrante'] == 1){
                                    array_push($certificados,"palestrante");
                                }
                                if($rowEvento['evento_ministrante'] == 1 || $rowEvento['curso_ministrante'] == 1){
                                    array_push($certificados, "ministrante");
                                }
                                if($rowEvento['evento_apresentador'] == 1){
                                    array_push($certificados,"apresentador");
                                }
                                if($rowEvento['evento_monitor'] == 1){
                                    array_push($certificados,"monitor");
                                }
                                if($rowEvento['evento_mediador'] == 1){
                                    array_push($certificados,"mediador");
                                }
                                if($rowEvento['evento_participante'] == 1 || $rowEvento['curso_participante'] == 1){
                                    array_push($certificados,"participante");
                                }
                                if($rowEvento['evento_avaliador'] == 1){
                                    array_push($certificados,"avaliador");
                                }
                                for($i=0; $i < sizeof($certificados); $i++){
                                    if(sizeof($certificados) <= 1){
                                        echo $certificados[$i];
                                    }else{
                                        echo " ".$certificados[$i];
                                    }
                                }

                            echo "</td>
                            </tr>
                            <tr>
                                <td><b>ID SIGA EXTENSÃO: </b>".$rowEvento['id_siga_extensao']."</td>
                                <td><b>ID MAP: </b>".$rowEvento['idmap']."</td>
                            </tr>
                            <tr>";
                                if($rowEvento['informado_ao_colegiado_do_curso'] == 1){
                                    echo "<td><b>Informado ao colegiado do curso: </b>SIM</td></tr>";
                                }else{
                                    echo "<td><b>Informado ao colegiado do curso: </b>NÃO</td></tr>";
                                }
                            echo "<tr>
                                        <td><b>Numero da ata: </b>".$rowEvento['numero_ata']."</td>";
                                        if($rowEvento['data_ata'] == '' || $rowEvento['data_ata'] == null || $rowEvento['data_ata'] == '0000-00-00'){
                                            echo "<td><b>Data da ata:</b></td></tr>";
                                        }else{
                                            echo "<td><b>Data da ata: </b>".date('d/m/Y',strtotime($rowEvento['data_ata']))."</td></tr>";
                                        }
                            echo "<tr>
                                    <td><b>Outras ocorrências: </b>".$rowEvento['outras_ocorrencias']."</td>
                                </tr>
                                <tr><td><b style='color: red;'>PARTICIPANTES DO EVENTO</b></td></tr>
                                <tr>
                                    <td><b>Nome</b></td>
                                    <td><b>CPF</b></td>
                                    <td><b>Tipo</b></td>
                                    <td><b>Quantidade pôsteres</b></td>
                                    <td><b>Natreza dos pôsteres</b></td>
                                </tr>";

                            foreach($dataParticipante as $rowParticipante){
                                    if($rowParticipante['tipo'] != 'ouvinte'){
                                    $dataUsuario = $usuario->ListaUsuarioExpecifico($rowParticipante['id_usuario']);
                                    foreach($dataUsuario as $rowUsuario){
                                        echo "<tr><td>".$rowUsuario['nome']."</td>";
                                        echo "<td>".$rowUsuario['cpf']."</td>";
                                    }
                                    echo "<td>".$rowParticipante['tipo']."</td>";
                                    if($rowParticipante['numero_posteres'] == '' || $rowParticipante['numero_posteres'] == null || $rowParticipante['numero_posteres'] == 0){
                                        echo "<td>Não se aplica</td>";
                                    }else{
                                        echo "<td>".$rowParticipante['numero_posteres']."</td>";
                                    }
                                    if($rowParticipante['tipoPoster'] == 'extensao'){
                                        echo "<td>Extensão</td></tr>";
                                    }else if($rowParticipante['tipoPoster'] == 'iniciacaoCientifica'){
                                        echo "<td>Iniciação Científica</td></tr>";
                                    }else{
                                        echo "<td>Não se aplica</td></tr>";
                                    }
                                }
                            }
                            echo  "<tr><td><b style='color: red;'>AUTORES</b></td></tr>";
                            foreach($dataAutor as $rowAutor){
                                echo "<tr><td>".$rowAutor['nome']."</td></tr>";
                            }
        echo    "</table>
                </div>
                <div style='display:flex;position:relative;justify-content:center;margin-top: 10px;'><a href="."painelcontrole.php?idEvento=".$idEvento."&acao=validarEvento>Validar evento</a></div>;
                <div style='display:flex;position:relative;justify-content:center;margin-top: 10px;'><a href='#' onclick='imprimirTela()' id='btnImprimir'>Imprmir</a></div>";

    }

    require_once "footer.html";
?>