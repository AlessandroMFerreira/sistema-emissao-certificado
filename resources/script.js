     function CriaElementoTipoEvento(){
        var tipo = document.getElementsByName('tipo');
        var tipoEventoEnquadramento = document.getElementById('tipoEventoEnquadramento');


        for(var i = 0; i< tipo.length; i++){

            if(tipo[i]['checked'] == true && tipo[i]['value'] == "extensao"){

                var solicitacaoDiv = document.getElementById('solicitacaoDiv');
                var divSIGAMAP = document.getElementById("divSIGAMAP");

                divSIGAMAP.innerHTML = "";
                solicitacaoDiv.innerHTML = "";
                tipoEventoEnquadramento.innerHTML = "";

                CriaSigaExtensao();

                var elementoLabel = document.createElement("label");
                elementoLabel.id = "labelEnquadramento";
                elementoLabel.for = 'enquadramento';   
                elementoLabel.style ='padding-left: 50px;';
                elementoLabel.innerHTML = "<strong>Enquadramento:</strong>";

                var elementoRadioEntensaoProjeto = document.createElement("input");
                elementoRadioEntensaoProjeto.id = "idExtensaoProjeto";
                elementoRadioEntensaoProjeto.name = "enquadramento";
                elementoRadioEntensaoProjeto.className = "form-control";
                elementoRadioEntensaoProjeto.type = "radio";
                elementoRadioEntensaoProjeto.value = "projeto";
                var textoExtensaoProjeto = document.createTextNode("Projeto"); 

                var elementoRadioExtensaoEvento = document.createElement("input");
                elementoRadioExtensaoEvento.id = "idExtensaoEvento";
                elementoRadioExtensaoEvento.name = "enquadramento";
                elementoRadioExtensaoEvento.className = "form-control";
                elementoRadioExtensaoEvento.type = "radio";
                elementoRadioExtensaoEvento.value = "evento"; 
                elementoRadioExtensaoEvento.style = "margin-left: 10px";
                var textoExtensaoEvento = document.createTextNode("Evento");

                var elementoRadioExtensaoCurso = document.createElement("input");
                elementoRadioExtensaoCurso.id = "idExtensaoCurso";
                elementoRadioExtensaoCurso.name = "enquadramento";
                elementoRadioExtensaoCurso.className = "form-control";
                elementoRadioExtensaoCurso.type = "radio";
                elementoRadioExtensaoCurso.value = "curso"; 
                elementoRadioExtensaoCurso.style = "margin-left: 10px";
                var textoExtensaoCurso = document.createTextNode("Curso");

                tipoEventoEnquadramento.appendChild(elementoLabel);                    
                tipoEventoEnquadramento.appendChild(elementoRadioEntensaoProjeto);
                tipoEventoEnquadramento.appendChild(textoExtensaoProjeto);
                tipoEventoEnquadramento.appendChild(elementoRadioExtensaoEvento);
                tipoEventoEnquadramento.appendChild(textoExtensaoEvento);
                tipoEventoEnquadramento.appendChild(elementoRadioExtensaoCurso);
                tipoEventoEnquadramento.appendChild(textoExtensaoCurso);

                tipoEventoEnquadramento.addEventListener('click', function(e){
                    if(e.target.id == "idExtensaoProjeto"){
                        CriaSolicitacaoExtensaoProjeto();
                    }
                    if(e.target.id == "idExtensaoEvento"){
                        CriaSolicitacaoExtensaoEvento();
                    }
                    if(e.target.id == "idExtensaoCurso"){
                        CriaSolicitacaoExtensaoCurso();
                    }


                })


            }
            if(tipo[i]['checked'] == true && tipo[i]['value'] == "pesquisa"){

                var solicitacaoDiv = document.getElementById('solicitacaoDiv');
                var divSIGAMAP = document.getElementById("divSIGAMAP");

                divSIGAMAP.innerHTML = "";

                tipoEventoEnquadramento.innerHTML = "";
                solicitacaoDiv.innerHTML = "";

                CriaMap();

                var elementoLabel = document.createElement("label");
                elementoLabel.id = "labelEnquadramento";
                elementoLabel.for = 'enquadramento';   
                elementoLabel.style ='padding-left: 50px;';
                elementoLabel.innerHTML = "<strong>Enquadramento</strong>";

                var elementoRadioPesquisaIniciacaoCientifica = document.createElement("input");
                elementoRadioPesquisaIniciacaoCientifica.id = "idPesquisaIniciacaoCientifica";
                elementoRadioPesquisaIniciacaoCientifica.name = "enquadramento";
                elementoRadioPesquisaIniciacaoCientifica.className = "form-control";
                elementoRadioPesquisaIniciacaoCientifica.type = "radio";
                elementoRadioPesquisaIniciacaoCientifica.value = "iniciacao_cientifica";
                var textoPesquisaIniciacaoCientifica = document.createTextNode("Iniciação científica");

                var elementoRadioPesquisaIniciacaoCientificaJr = document.createElement("input");
                elementoRadioPesquisaIniciacaoCientificaJr.id = "idPesquisaIniciacaoCientificaJr";
                elementoRadioPesquisaIniciacaoCientificaJr.name = "enquadramento";
                elementoRadioPesquisaIniciacaoCientificaJr.className = "form-control";
                elementoRadioPesquisaIniciacaoCientificaJr.type = "radio";
                elementoRadioPesquisaIniciacaoCientificaJr.value = "iniciacao_cientifica_jr";
                elementoRadioPesquisaIniciacaoCientificaJr.style  = "margin-left: 10px";
                var textoPesquisaIniciacaoCientificaJr = document.createTextNode("Iniciação científica júnior");

                tipoEventoEnquadramento.appendChild(elementoLabel);
                tipoEventoEnquadramento.appendChild(elementoRadioPesquisaIniciacaoCientifica);
                tipoEventoEnquadramento.appendChild(textoPesquisaIniciacaoCientifica);
                tipoEventoEnquadramento.appendChild(elementoRadioPesquisaIniciacaoCientificaJr);
                tipoEventoEnquadramento.appendChild(textoPesquisaIniciacaoCientificaJr);

                tipoEventoEnquadramento.addEventListener('click', function(e){

                    if(e.target.id == "idPesquisaIniciacaoCientifica"){
                        CriaSolicitacaoPesquisaIniciacaoCientifica();
                    }
                    if(e.target.id == "idPesquisaIniciacaoCientificaJr"){
                        CriaSolicitacaoPesquisaIniciacaoCientificaJunior();
                    }
                });
            }
        }
    }

    function CriaSolicitacaoExtensaoProjeto(){

        var solicitacaoDiv = document.getElementById('solicitacaoDiv');

        solicitacaoDiv.innerHTML = "";
                
        var solicitacaoLabel = document.createElement("label");
        solicitacaoLabel.id = "solicitacaoLabel";
        solicitacaoLabel.for = "solicitacao_projeto";
        solicitacaoLabel.innerHTML = "<strong>Projeto:</strong>";

        var checkboxProjetoBolsista = document.createElement("input");
        checkboxProjetoBolsista.name = "bolsista_projeto";
        checkboxProjetoBolsista.type = "checkbox";
        checkboxProjetoBolsista.value = "bolsista_projeto";
        checkboxProjetoBolsista.className = "form-contol";
        var textoCheckboxProjetoBolsista = document.createTextNode("Bolsista");

        var checkboxProjetoOrientador = document.createElement("input");
        checkboxProjetoOrientador.name = "orientador_projeto";
        checkboxProjetoOrientador.type = "checkbox";
        checkboxProjetoOrientador.value = "orientador_projeto";
        checkboxProjetoOrientador.className = "form-contol";
        checkboxProjetoOrientador.style = "margin-left: 10px;";
        var textoCheckboxProjetoOrientador = document.createTextNode("Orientador");

        var checkboxProjetoVoluntario = document.createElement("input");
        checkboxProjetoVoluntario.name = "voluntario_projeto";
        checkboxProjetoVoluntario.type = "checkbox";
        checkboxProjetoVoluntario.value = "voluntario_projeto";
        checkboxProjetoVoluntario.className = "form-contol";
        checkboxProjetoVoluntario.style = "margin-left: 10px;";
        var textoCheckboxProjetoVoluntario = document.createTextNode("Voluntário");

        var checkboxProjetoColaborador = document.createElement("input");
        checkboxProjetoColaborador.name = "colaborador_projeto";
        checkboxProjetoColaborador.type = "checkbox";
        checkboxProjetoColaborador.value = "colaborador_projeto";
        checkboxProjetoColaborador.className = "form-contol";
        checkboxProjetoColaborador.style = "margin-left: 10px;";
        var textoCheckboxProjetoColaborador = document.createTextNode("Colaborador");

        solicitacaoDiv.appendChild(solicitacaoLabel);
        solicitacaoDiv.appendChild(checkboxProjetoBolsista);
        solicitacaoDiv.appendChild(textoCheckboxProjetoBolsista);
        solicitacaoDiv.appendChild(checkboxProjetoOrientador);
        solicitacaoDiv.appendChild(textoCheckboxProjetoOrientador);
        solicitacaoDiv.appendChild(checkboxProjetoVoluntario);
        solicitacaoDiv.appendChild(textoCheckboxProjetoVoluntario);
        solicitacaoDiv.appendChild(checkboxProjetoColaborador);
        solicitacaoDiv.appendChild(textoCheckboxProjetoColaborador);       

    }


    function CriaSolicitacaoExtensaoEvento(){

        var solicitacaoDiv = document.getElementById('solicitacaoDiv');

        solicitacaoDiv.innerHTML = "";
                
        var solicitacaoLabel = document.createElement("label");
        solicitacaoLabel.id = "solicitacaoLabel";
        solicitacaoLabel.for = "solicitacao_evento";
        solicitacaoLabel.innerHTML = "<strong>Evento:</strong>";

        var checkboxEventoOrganizador = document.createElement("input");
        checkboxEventoOrganizador.name = "organizador_evento";
        checkboxEventoOrganizador.type = "checkbox";
        checkboxEventoOrganizador.value = "organizador_evento";
        checkboxEventoOrganizador.className = "form-contol";
        var textoCheckboxEventoOrganizador = document.createTextNode("Organizador");

        var checkboxEventoPalestrante = document.createElement("input");
        checkboxEventoPalestrante.name = "palestrante_evento";
        checkboxEventoPalestrante.type = "checkbox";
        checkboxEventoPalestrante.value = "palestrante_evento";
        checkboxEventoPalestrante.className = "form-contol";
        checkboxEventoPalestrante.style = "margin-left: 10px;";
        var textoCheckboxEventoPalestrante = document.createTextNode("Palestrante");

        var checkboxEventoMinistrante = document.createElement("input");
        checkboxEventoMinistrante.name = "ministrante_evento";
        checkboxEventoMinistrante.type = "checkbox";
        checkboxEventoMinistrante.value = "ministrante_evento";
        checkboxEventoMinistrante.className = "form-contol";
        checkboxEventoMinistrante.style = "margin-left: 10px;";
        var textoCheckboxEventoMinistrante = document.createTextNode("Ministrante");


        var checkboxEventoApresentador = document.createElement("input");
        checkboxEventoApresentador.name = "apresentador_evento";
        checkboxEventoApresentador.type = "checkbox";
        checkboxEventoApresentador.value = "apresentador_evento";
        checkboxEventoApresentador.className = "form-contol";
        checkboxEventoApresentador.style = "margin-left: 10px;";
        var textoCheckboxEventoApresentador = document.createTextNode("Apresentador");


        var checkboxEventoMonitor = document.createElement("input");
        checkboxEventoMonitor.name = "monitor_evento";
        checkboxEventoMonitor.type = "checkbox";
        checkboxEventoMonitor.value = "monitor_evento";
        checkboxEventoMonitor.className = "form-contol";
        checkboxEventoMonitor.style = "margin-left: 10px;";
        var textoCheckboxEventoMonitor = document.createTextNode("Monitor");


        var checkboxEventoMediador = document.createElement("input");
        checkboxEventoMediador.name = "mediador_evento";
        checkboxEventoMediador.type = "checkbox";
        checkboxEventoMediador.value = "mediador_evento";
        checkboxEventoMediador.className = "form-contol";
        checkboxEventoMediador.style = "margin-left: 10px;";
        var textoCheckboxEventoMediador = document.createTextNode("Debatedor/Mediador");


        var checkboxEventoParticipante = document.createElement("input");
        checkboxEventoParticipante.name = "participante_evento";
        checkboxEventoParticipante.type = "checkbox";
        checkboxEventoParticipante.value = "participante_evento";
        checkboxEventoParticipante.className = "form-contol";
        checkboxEventoParticipante.style = "margin-left: 10px;";
        var textoCheckboxEventoParticipante = document.createTextNode("Ouvinte");


        var checkboxEventoAvaliador = document.createElement("input");
        checkboxEventoAvaliador.name = "avaliador_evento";
        checkboxEventoAvaliador.type = "checkbox";
        checkboxEventoAvaliador.value = "avaliador_evento";
        checkboxEventoAvaliador.className = "form-contol";
        checkboxEventoAvaliador.style = "margin-left: 10px;";
        var textoCheckboxEventoAvaliador = document.createTextNode("Avaliador");

        solicitacaoDiv.appendChild(solicitacaoLabel);
        solicitacaoDiv.appendChild(checkboxEventoOrganizador);
        solicitacaoDiv.appendChild(textoCheckboxEventoOrganizador);
        solicitacaoDiv.appendChild(checkboxEventoPalestrante);
        solicitacaoDiv.appendChild(textoCheckboxEventoPalestrante);
        solicitacaoDiv.appendChild(checkboxEventoMinistrante);
        solicitacaoDiv.appendChild(textoCheckboxEventoMinistrante);
        solicitacaoDiv.appendChild(checkboxEventoApresentador);
        solicitacaoDiv.appendChild(textoCheckboxEventoApresentador);
        solicitacaoDiv.appendChild(checkboxEventoMonitor);
        solicitacaoDiv.appendChild(textoCheckboxEventoMonitor);
        solicitacaoDiv.appendChild(checkboxEventoMediador);
        solicitacaoDiv.appendChild(textoCheckboxEventoMediador);
        solicitacaoDiv.appendChild(checkboxEventoParticipante);
        solicitacaoDiv.appendChild(textoCheckboxEventoParticipante);
        solicitacaoDiv.appendChild(checkboxEventoAvaliador);
        solicitacaoDiv.appendChild(textoCheckboxEventoAvaliador);

    }


    function CriaSolicitacaoExtensaoCurso(){

        var solicitacaoDiv = document.getElementById('solicitacaoDiv');

        solicitacaoDiv.innerHTML = "";

        var solicitacaoLabel = document.createElement("label");
        solicitacaoLabel.id = "solicitacaoLabel";
        solicitacaoLabel.for = "solicitacao_curso";
        solicitacaoLabel.innerHTML = "<strong>Curso:</strong>";

        var checkboxCursoOrganizador = document.createElement("input");
        checkboxCursoOrganizador.name = "organizador_curso";
        checkboxCursoOrganizador.type = "checkbox";
        checkboxCursoOrganizador.value = "organizador_curso";
        checkboxCursoOrganizador.className = "form-contol";
        var textoCheckboxCursoOrganizador = document.createTextNode("Organizador");

        var checkboxCursoMinistrante = document.createElement("input");
        checkboxCursoMinistrante.name = "ministrante_curso";
        checkboxCursoMinistrante.type = "checkbox";
        checkboxCursoMinistrante.value = "ministrante_curso";
        checkboxCursoMinistrante.className = "form-contol";
        checkboxCursoMinistrante.style = "margin-left: 10px;";
        var textoCheckboxCursoMinistrante = document.createTextNode("Ministrante");

        var checkboxCursoParticipante = document.createElement("input");
        checkboxCursoParticipante.name = "participante_curso";
        checkboxCursoParticipante.type = "checkbox";
        checkboxCursoParticipante.value = "participante_curso";
        checkboxCursoParticipante.className = "form-contol";
        checkboxCursoParticipante.style = "margin-left: 10px;";
        var textoCheckboxCursoParticipante = document.createTextNode("Participante");

        solicitacaoDiv.appendChild(solicitacaoLabel);
        solicitacaoDiv.appendChild(checkboxCursoOrganizador);
        solicitacaoDiv.appendChild(textoCheckboxCursoOrganizador);
        solicitacaoDiv.appendChild(checkboxCursoMinistrante);
        solicitacaoDiv.appendChild(textoCheckboxCursoMinistrante);
        solicitacaoDiv.appendChild(checkboxCursoParticipante);
        solicitacaoDiv.appendChild(textoCheckboxCursoParticipante);
    }


    function CriaSolicitacaoPesquisaIniciacaoCientifica(){

        var solicitacaoDiv = document.getElementById('solicitacaoDiv');

        solicitacaoDiv.innerHTML = "";

        var solicitacaoLabel = document.createElement("label");
        solicitacaoLabel.id = "solicitacaoLabel";
        solicitacaoLabel.for = "solicitacao_pesquisa_iniciacao_cientifica";
        solicitacaoLabel.innerHTML = "<strong>Iniciação científica:</strong>";

        var checkboxIniciacaoCientificaOrientador = document.createElement("input");
        checkboxIniciacaoCientificaOrientador.name = "orientador_iniciacao_cientifica";
        checkboxIniciacaoCientificaOrientador.type = "checkbox";
        checkboxIniciacaoCientificaOrientador.value = "orientador_iniciacao_cientifica";
        checkboxIniciacaoCientificaOrientador.className = "form-contol";
        var textoCheckboxIniciacaoCientificaOrientador = document.createTextNode("Orientador");

        var checkboxIniciacaoCientificaBolsista = document.createElement("input");
        checkboxIniciacaoCientificaBolsista.name = "bolsista_iniciacao_cientifica";
        checkboxIniciacaoCientificaBolsista.type = "checkbox";
        checkboxIniciacaoCientificaBolsista.value = "bolsista_iniciacao_cientifica";
        checkboxIniciacaoCientificaBolsista.className = "form-contol";
        checkboxIniciacaoCientificaBolsista.style = "margin-left: 10px;";
        var textoCheckboxIniciacaoCientificaBolsista = document.createTextNode("Bolsista");

        var checkboxIniciacaoCientificaVoluntario = document.createElement("input");
        checkboxIniciacaoCientificaVoluntario.name = "voluntario_iniciacao_cientifica";
        checkboxIniciacaoCientificaVoluntario.type = "checkbox";
        checkboxIniciacaoCientificaVoluntario.value = "voluntario_iniciacao_cientifica";
        checkboxIniciacaoCientificaVoluntario.className = "form-contol";
        checkboxIniciacaoCientificaVoluntario.style = "margin-left: 10px;";
        var textoCheckboxIniciacaoCientificaVoluntario = document.createTextNode("Voluntario");

        solicitacaoDiv.appendChild(solicitacaoLabel);
        solicitacaoDiv.appendChild(checkboxIniciacaoCientificaOrientador);
        solicitacaoDiv.appendChild(textoCheckboxIniciacaoCientificaOrientador);
        solicitacaoDiv.appendChild(checkboxIniciacaoCientificaBolsista);
        solicitacaoDiv.appendChild(textoCheckboxIniciacaoCientificaBolsista);
        solicitacaoDiv.appendChild(checkboxIniciacaoCientificaVoluntario);
        solicitacaoDiv.appendChild(textoCheckboxIniciacaoCientificaVoluntario);
    }


    function CriaSolicitacaoPesquisaIniciacaoCientificaJunior(){

        var solicitacaoDiv = document.getElementById('solicitacaoDiv');

        solicitacaoDiv.innerHTML = "";

        var solicitacaoLabel = document.createElement("label");
        solicitacaoLabel.id = "solicitacaoLabel";
        solicitacaoLabel.for = "solicitacao_pesquisa_iniciacao_cientifica_jr";
        solicitacaoLabel.innerHTML = "<strong>Iniciação científica júnior:</strong>";

        var checkboxIniciacaoCientificaJrOrientador = document.createElement("input");
        checkboxIniciacaoCientificaJrOrientador.name = "orientador_iniciacao_cientifica_jr";
        checkboxIniciacaoCientificaJrOrientador.type = "checkbox";
        checkboxIniciacaoCientificaJrOrientador.value = "orientador_iniciacao_cientifica_jr";
        checkboxIniciacaoCientificaJrOrientador.className = "form-contol";
        var textoCheckboxIniciacaoCientificaJrOrientador = document.createTextNode("Orientador");

        var checkboxIniciacaoCientificaJrBolsista = document.createElement("input");
        checkboxIniciacaoCientificaJrBolsista.name = "bolsista_iniciacao_cientifica_jr";
        checkboxIniciacaoCientificaJrBolsista.type = "checkbox";
        checkboxIniciacaoCientificaJrBolsista.value = "bolsista_iniciacao_cientifica_jr";
        checkboxIniciacaoCientificaJrBolsista.className = "form-contol";
        checkboxIniciacaoCientificaJrBolsista.style = "margin-left: 10px;";
        var textoCheckboxIniciacaoCientificaJrBolsista = document.createTextNode("Bolsista");

        var checkboxIniciacaoCientificaJrVoluntario = document.createElement("input");
        checkboxIniciacaoCientificaJrVoluntario.name = "voluntario_iniciacao_cientifica_jr";
        checkboxIniciacaoCientificaJrVoluntario.type = "checkbox";
        checkboxIniciacaoCientificaJrVoluntario.value = "voluntario_iniciacao_cientifica_jr";
        checkboxIniciacaoCientificaJrVoluntario.className = "form-contol";
        checkboxIniciacaoCientificaJrVoluntario.style = "margin-left: 10px;";
        var textoCheckboxIniciacaoCientificaJrVoluntario = document.createTextNode("Voluntario");

        solicitacaoDiv.appendChild(solicitacaoLabel);
        solicitacaoDiv.appendChild(checkboxIniciacaoCientificaJrOrientador);
        solicitacaoDiv.appendChild(textoCheckboxIniciacaoCientificaJrOrientador);
        solicitacaoDiv.appendChild(checkboxIniciacaoCientificaJrBolsista);
        solicitacaoDiv.appendChild(textoCheckboxIniciacaoCientificaJrBolsista);
        solicitacaoDiv.appendChild(checkboxIniciacaoCientificaJrVoluntario);
        solicitacaoDiv.appendChild(textoCheckboxIniciacaoCientificaJrVoluntario);

    }

    function CriaSigaExtensao(){

        var divSIGAMAP = document.getElementById("divSIGAMAP");
        divSIGAMAP.innerHTML = "";

        var labelSiga = document.createElement("label");
        labelSiga.for = "labelSiga";
        labelSiga.id = "idLabelSiga";
        labelSiga.innerHTML = "<strong>Cadastro no SIGA EXTENSÃO?</strong>";

        var elementoRadioSigaExtensaoSim = document.createElement("input");
        elementoRadioSigaExtensaoSim.type = "radio";
        elementoRadioSigaExtensaoSim.id = "simSiga"
        elementoRadioSigaExtensaoSim.name = "siga";
        elementoRadioSigaExtensaoSim.value = "sim";
        elementoRadioSigaExtensaoSim.className = "form-control";
        var textoSimSigaExtensao = document.createTextNode("Sim");


        var elementoRadioSigaExtensaoNao = document.createElement("input");
        elementoRadioSigaExtensaoNao.type = "radio";
        elementoRadioSigaExtensaoNao.id = "naoSiga"
        elementoRadioSigaExtensaoNao.name = "siga";
        elementoRadioSigaExtensaoNao.value = "nao";
        elementoRadioSigaExtensaoNao.style = "margin-left: 10px;";
        elementoRadioSigaExtensaoNao.className = "form-control";
        var textoNaoSigaExtensao = document.createTextNode("Não");        

        divSIGAMAP.appendChild(labelSiga);
        divSIGAMAP.appendChild(elementoRadioSigaExtensaoSim);
        divSIGAMAP.appendChild(textoSimSigaExtensao);
        divSIGAMAP.appendChild(elementoRadioSigaExtensaoNao);
        divSIGAMAP.appendChild(textoNaoSigaExtensao);

        divSIGAMAP.addEventListener('click', function(e){
            if(e.target.id == "simSiga"){

                var divSIGAMAP = document.getElementById("divSIGAMAP");

                var divIdSigaExtensao = document.createElement("div");
                divIdSigaExtensao.id = "idSigaExtensao";
                divIdSigaExtensao.className = "form-inline";
                divIdSigaExtensao.style = "margin-left: 10%;";

                divSIGAMAP.appendChild(divIdSigaExtensao);

                var idSigaExtensao = document.getElementById("idSigaExtensao");
                idSigaExtensao.innerHTML = "";


                var labelIdSiga = document.createElement("label");
                labelIdSiga.id = "labelIdSiga";
                labelIdSiga.for = "labelIdSigaExtensao";
                labelIdSiga.innerHTML = "<strong>Id SIGA EXTENSÃO</strong>";

                var elementoInputSigaExtensao = document.createElement("input");
                elementoInputSigaExtensao.id = "inputSigaExtensao";
                elementoInputSigaExtensao.type = "text";
                elementoInputSigaExtensao.name = "idSigaInput";
                elementoInputSigaExtensao.className = "form-control";

                idSigaExtensao.appendChild(labelIdSiga);
                idSigaExtensao.appendChild(elementoInputSigaExtensao);

            }if(e.target.id == "naoSiga") {
                var idSigaExtensao = document.getElementById("idSigaExtensao");
                idSigaExtensao.innerHTML = "";
            }
        });
    }

    function CriaMap(){

        var divSIGAMAP = document.getElementById("divSIGAMAP");
        divSIGAMAP.innerHTML = "";

        var labelMap = document.createElement("label");
        labelMap.for = "labelMap";
        labelMap.id = "idLbaelMap";
        labelMap.innerHTML = "<strong>Cadastrado no MAP?</strong>";

        var elementoRadioMapSim = document.createElement("input");
        elementoRadioMapSim.type = "radio";
        elementoRadioMapSim.id = "simMap"
        elementoRadioMapSim.name = "map";
        elementoRadioMapSim.value = "sim";
        elementoRadioMapSim.className = "form-control";
        var textoSimMap = document.createTextNode("Sim");


        var elementoRadioMapNao = document.createElement("input");
        elementoRadioMapNao.type = "radio";
        elementoRadioMapNao.id = "naoMap"
        elementoRadioMapNao.name = "map";
        elementoRadioMapNao.value = "nao";
        elementoRadioMapNao.style = "margin-left: 10px;";
        elementoRadioMapNao.className = "form-control";
        var textoNaoMap = document.createTextNode("Não");

        divSIGAMAP.appendChild(labelMap);
        divSIGAMAP.appendChild(elementoRadioMapSim);
        divSIGAMAP.appendChild(textoSimMap);
        divSIGAMAP.appendChild(elementoRadioMapNao);
        divSIGAMAP.appendChild(textoNaoMap);

        divSIGAMAP.addEventListener('click', function(e){
            if(e.target.id == "simMap"){

                var divSIGAMAP = document.getElementById("divSIGAMAP");

                var divMap = document.createElement("div");
                divMap.id = "idMap";
                divMap.className = "form-inline";
                divMap.style = "margin-left: 10%;";

                divSIGAMAP.appendChild(divMap);

                var divIdMap = document.getElementById("idMap");
                divIdMap.innerHTML = "";


                var labelIdMap = document.createElement("label");
                labelIdMap.id = "labelIMap";
                labelIdMap.for = "labelIMap";
                labelIdMap.innerHTML = "<strong>Id MAP - projetos científicos</strong>";

                var elementoInputMap = document.createElement("input");
                elementoInputMap.id = "inputMap";
                elementoInputMap.type = "text";
                elementoInputMap.name = "idMapInput";
                elementoInputMap.className = "form-control";

                divIdMap.appendChild(labelIdMap);
                divIdMap.appendChild(elementoInputMap);

            }if(e.target.id == "naoMap") {
                var divMap = document.getElementById("idMap");
                divMap.innerHTML = "";
            }
        });


    }

    function CriaColegiadoCurso(){

        var colegiado  = document.getElementsByName('colegiado');
        var divColegiadoCurso = document.getElementById('divColegiadoCurso');
        console.log(colegiado);

        for(var i = 0; i < colegiado.length; i ++){
            console.log(colegiado[i]['value']);
            if(colegiado[i]['checked'] == true && colegiado[i]['value'] == 'sim'){

                divColegiadoCurso.innerHTML = "";

                var labelAta = document.createElement("label");
                labelAta.for = "labelAta";
                labelAta.id = "idlabelAta";
                labelAta.innerHTML = "<strong>Número da ata:</strong>";

                var inputNumeroAta = document.createElement("input");
                inputNumeroAta.type = "text";
                inputNumeroAta.id = "numeroAta";
                inputNumeroAta.name = "numeroAta";
                inputNumeroAta.className = "form-control";

                var labelDataAta = document.createElement("label");
                labelDataAta.for = "labelAta";
                labelDataAta.id = "idlabelAta";
                labelDataAta.innerHTML = "<strong>Data da ata:</strong>";

                var inputDataAta = document.createElement("input");
                inputDataAta.type = "date";
                inputDataAta.id = "dataAta";
                inputDataAta.name = "dataAta";
                inputDataAta.className = "form-control";

                divColegiadoCurso.appendChild(labelAta);
                divColegiadoCurso.appendChild(inputNumeroAta);
                divColegiadoCurso.appendChild(labelDataAta);
                divColegiadoCurso.appendChild(inputDataAta);
            }
            if(colegiado[i]['checked'] == true && colegiado[i]['value'] == 'naoColegiado'){
                divColegiadoCurso.innerHTML = "";
            }

        }

    }

    function ValidarFormCadastroUsuario(frm){

        if(frm.nome.value == "" || frm.nome.value ==  null || frm.nome.value.length < 3){
            alert('Preencha o campo nome');
            frm.nome.focus();
            return false;
        }
        if(frm.usuario.value == "" || frm.usuario.value == null || frm.usuario.value.length < 3){
            alert('Preencha corretamente o campo usuario');
            frm.usuario.focus();
            return false;
        }

        var sexo = document.getElementsByName('sexo');

        if(sexo[0]['checked'] == false && sexo[1]['checked'] == false){
            alert('Preencha o campo sexo');
            sexo[0]['checked'] = true;
            return false;
        }

        if(frm.senha.value == "" || frm.senha.value == null || frm.senha.value.length < 8){
            if(frm.senha.value.length < 8){
                alert("A senha deve conter no mínimo 8 caracteres");
                frm.senha.focus();
                return false;
            }else{
                alert("Preencha o campo senha");
                frm.senha.focus();
                return false;
            }
        }
        if(frm.senha2.value == "" || frm.senha2.value == null || frm.senha2.value != frm.senha.value){
            if(frm.senha2.value != frm.senha.value && frm.senha2.value.length > 0){
                alert("As senhas não coincidem");
                frm.senha2.focus();
                return false;
            }else{
                alert("Redigite sua senha");
                frm.senha2.focus();
                return false;
            }
        }
        if(frm.cpf.value == "" || frm.cpf.value == null || frm.cpf.value.length < 11 || frm.cpf.value.indexOf(".") != -1 || frm.cpf.value.indexOf("-") != -1){

            if(frm.cpf.value.indexOf(".") != -1 || frm.cpf.value.indexOf("-") != -1){
                alert("O CFP não deve conter pontos (.) ou traços (-)");
                frm.cpf.focus();
                return false;
            }else{
                alert("Preencha o campo CPF corretamente");
                frm.cpf.focus();
                return false;
            }
        }
        if(frm.email.value == "" || frm.email.value == null){
            alert("Preencha o campo email");
            frm.email.focus();
            return false;
        }
        if(frm.endereco.value == "" || frm.endereco.value == null){
            alert("Preencha o campo endereço");
            frm.endereco.focus();
            return false;
        }
        if(frm.numero.value == "" || frm.numero.value == null){
            alert("Preencha o campo numero");
            frm.numero.focus();
            return false;
        }
        if(frm.bairro.value == "" || frm.bairro.value == null){
            alert("Preencha o campo bairro");
            frm.bairro.focus();
            return false;
        }
        if(frm.cidade.value == "" || frm.cidade.value == null){
            alert("Preencha o campo cidade");
            frm.cidade.focus();
            return false;
        }
        if(frm.cep.value == "" || frm.cep.value == null || frm.cep.value.indexOf("-") != -1 || frm.cep.value.indexOf(".") != -1 || frm.cep.value.length < 7){
            if(frm.cep.value.indexOf("-") != -1 || frm.cep.value.indexOf(".") != -1){
                alert("O campo cep não pode conter pontos (.) ou traços (-)");
                frm.cep.focus();
                return false;
            }else{
                alert("Preencha corretamento o campo cep");
                frm.cep.focus();
                return false;
            }
        }
        if(frm.telefone.value == "" || frm.telefone.value == null || frm.telefone.value.length < 8 || frm.telefone.value.indexOf("(") != -1 || frm.telefone.value.indexOf(")") != -1 || frm.telefone.value.length > 11){
            if(frm.telefone.value.indexOf(")") != -1 || frm.telefone.value.indexOf("(") != -1){
                alert("O campo telefone não pode conter ( ou )");
                frm.telefone.focus();
                return false;
            }
            else if(frm.telefone.value.length > 11){
                alert("O campo telefone pode conter apenas 11 digitos. Verifique se o DDD possui zeros e os retire");
                frm.telefone.focus();
                return false;
            }else{
                alert("Preencha o campo telefone");
                frm.telefone.focus();
                return false;
            }
        }

    }
    
    function imprimirTela(){
        var btnImprimir = document.getElementById('btnImprimir');
        window.print();

    }
    