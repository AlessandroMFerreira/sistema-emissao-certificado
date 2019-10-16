<?php
    namespace Classes;
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
    use Fpdf\Fpdf;
    class certificado extends Fpdf{

        private function mes($mes){

            if($mes == '1' || $mes == 1){
                $mes = "Janeiro";
                return $mes;
            }
            else if($mes == '2' || $mes == 2){
                $mes = "Fevereiro";
                return $mes;
            }
            else if($mes == '3' || $mes == 3){
                $mes = "Março";
                return $mes;
            }
            else if($mes == '4' || $mes == 4){
                $mes = "Abril";
                return $mes;
            }
            else if($mes == '5' || $mes == 5){
                $mes = "Maio"; 
                return $mes; 
            }
            else if($mes == '6' || $mes == 6){
                $mes = "Junho";
                return $mes;
            }
            else if($mes == '7' || $mes == 7){
                $mes = "Julho";
                return $mes;
            }
            else if($mes == '8' || $mes == 8){
                $mes = "Agosto";
                return $mes;
            }
            else if($mes == '9' || $mes == 9){
                $mes = "Setembro";
                return $mes;
            }
            else if($mes == '10' || $mes == 10){
                $mes = "Outubro";
                return $mes;
            }
            else if($mes == '11' || $mes == 11){
                $mes = "Novembro";
                return $mes;
            }
            else if($mes == '12' || $mes == 12){
                $mes = "Dezembro";
                return $mes;
            }

        }
        public function CertificadoCursoMinistrante($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$cargaHoraria){
            
            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $textoExtra1 = "em parceria pela Coordenação de Extensão e Coordenação de Pesquisa";
            $textoExtra2 = "pela Coordenação do Curso de Graduação em ".$cursoGraduacao;
            if($colaboracao == "coordenacao"){
                $texto = "Certificamos que ".$nomeUsuario." ministrou curso intitulado ".$nomeEvento.", promovido ".$textoExtra1." da UEMG, Unidade Ituiutaba. O curso ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". A carga horária total da atividade foi de ".substr($cargaHoraria,0,5)." horas.";
            }else{
                $texto = "Certificamos que ".$nomeUsuario." ministrou curso intitulado ".$nomeEvento.", promovido ".$textoExtra2." da UEMG, Unidade Ituiutaba. O curso ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". A carga horária total da atividade foi de ".substr($cargaHoraria,0,5)." horas.";
            }
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);

        }
        public function CertificadoCursoOrganizador($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$cargaHoraria){
            
            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $textoExtra1 = "em parceria pela Coordenação de Extensão e Coordenação de Pesquisa";
            $textoExtra2 = "pela Coordenação do Curso de Graduação em ".$cursoGraduacao;
            if($colaboracao == "coordenacao"){
                $texto = "Certificamos que ".$nomeUsuario." atuou como organizador(a) do ".$nomeEvento.", promovido ".$textoExtra1." da UEMG, Unidade Ituiutaba. O curso ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).", perfazendo carga horária total de ".substr($cargaHoraria,0,5)." horas.";
            }else{
                $texto = "Certificamos que ".$nomeUsuario." atuou como organizador(a) do ".$nomeEvento.", promovido ".$textoExtra2." da UEMG, Unidade Ituiutaba. O curso ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).", perfazendo carga horária total de ".substr($cargaHoraria,0,5)." horas.";
            }
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoCursoOuvinte($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$cargaHoraria){
           
            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $textoExtra1 = "em parceria pela Coordenação de Extensão e Coordenação de Pesquisa";
            $textoExtra2 = "pela Coordenação do Curso de Graduação em ".$cursoGraduacao;
            if($colaboracao == "coordenacao"){
                $texto = "Certificamos que ".$nomeUsuario." participou como ouvinte das atividades do curso intitulado ".$nomeEvento.", promovido ".$textoExtra1." da UEMG, Unidade Ituiutaba. O curso ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).", perfazendo carga horária total de ".substr($cargaHoraria,0,5)." horas. ";
            }else{
                $texto = "Certificamos que ".$nomeUsuario." participou como ouvinte das atividades do curso intitulado ".$nomeEvento.", promovido ".$textoExtra2." da UEMG, Unidade Ituiutaba. O curso ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).", perfazendo carga horária total de ".substr($cargaHoraria,0,5)." horas. ";
            }
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoEventoApresentador($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$cargaHoraria,$apresentacao,$nomeAutores,$descricaoEventoPai){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $textoExtra1 = "em parceria pela Coordenação de Extensão e Coordenação de Pesquisa";
            $textoExtra2 = "pela Coordenação do Curso de Graduação em ".$cursoGraduacao;
            if($apresentacao == 'extensionista'){
                $textoExtra3 = 'extensionista';
            }else{
                $textoExtra3 = 'de iniciação científica';
            }
            if($colaboracao == "coordenacao"){
                $texto = "Certificamos que ".$nomeUsuario." apresentou o trabalho ".$textoExtra3." intitulado ".$nomeEvento." durante o evento intitulado ".strtoupper($descricaoEventoPai).", promovido ".$textoExtra1." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". São autores do trabalho ".strtoupper($nomeAutores).".";
            }else{
                $texto = "Certificamos que ".$nomeUsuario." apresentou o trabalho ".$textoExtra3." intitulado ".$nomeEvento." durante o evento intitulado ".strtoupper($descricaoEventoPai).", promovido ".$textoExtra2." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". São autores do trabalho ".strtoupper($nomeAutores).".";
            }
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoEventoAvaliador($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$numeroPosteres,$tipoPoster){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $textoExtra1 = "em parceria pela Coordenação de Extensão e Coordenação de Pesquisa";
            $textoExtra2 = "pela Coordenação do Curso de Graduação em ".$cursoGraduacao;
            if($tipoPoster == 'extensao'){
                $poster = "Extensão";
                if($colaboracao == "coordenacao"){
                    $texto = "Certificamos que ".$nomeUsuario." participou da Comissão Científica de avaliação de pôsteres de ".$poster." apresentados no evento intitulado ".$nomeEvento.", promovido ".$textoExtra1." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". Na presente banca de comissão julgadora o(a) docente avaliou ".$numeroPosteres." pôster(es).";
                }else{
                    $texto = "Certificamos que ".$nomeUsuario." participou da Comissão Científica de avaliação de pôsteres de ".$poster." apresentados no evento intitulado ".$nomeEvento.", promovido ".$textoExtra2." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". Na presente banca de comissão julgadora o(a) docente avaliou ".$numeroPosteres." pôster(es).";
                }
            }else{
                 $poster = "Iniciação Científica";
                 if($colaboracao == "coordenacao"){
                    $texto = "Certificamos que ".$nomeUsuario." participou da Comissão Científica de avaliação de pôsteres de ".$poster." apresentados no evento intitulado ".$nomeEvento.", promovido ".$textoExtra1." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". Na presente banca de comissão julgadora o(a) docente avaliou ".$numeroPosteres." pôster(es).";
                }else{
                    $texto = "Certificamos que ".$nomeUsuario." participou da Comissão Científica de avaliação de pôsteres de ".$poster." apresentados no evento intitulado ".$nomeEvento.", promovido ".$textoExtra2." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". Na presente banca de comissão julgadora o(a) docente avaliou ".$numeroPosteres." pôster(es).";
                }
            }
            
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoEventoDebatedorMediador($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim, $cargaHoraria,$tipoParticipante,$descricaoEventoPai){
            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $textoExtra1 = "em parceria pela Coordenação de Extensão e Coordenação de Pesquisa";
            $textoExtra2 = "pela Coordenação do Curso de Graduação em ".$cursoGraduacao;
            if($tipoParticipante == 'debatedor'){
                $tipo = "participou como debatedor da";
                if($colaboracao == "coordenacao"){
                    $texto = "Certificamos que ".$nomeUsuario." ".$tipo." mesa redonda intitulada ".$nomeEvento." durante o evento intitulado ".$descricaoEventoPai.", promovido ".$textoExtra1." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". A carga horária total da palestra foi de ".substr($cargaHoraria,0,5)." horas.";
                }else{
                    $texto = "Certificamos que ".$nomeUsuario." ".$tipo." mesa redonda intitulada ".$nomeEvento." durante o evento intitulado ".$descricaoEventoPai.", promovido ".$textoExtra2." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". A carga horária total da palestra foi de ".substr($cargaHoraria,0,5)." horas."; 
                }
            }else{
                 $tipo = "mediou a";
                 if($colaboracao == "coordenacao"){
                    $texto = "Certificamos que ".$nomeUsuario." ".$tipo." mesa redonda intitulada ".$nomeEvento." durante o evento intitulado ".$descricaoEventoPai.", promovido ".$textoExtra1." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". A carga horária total da palestra foi de ".substr($cargaHoraria,0,5)." horas.";
                }else{
                    $texto = "Certificamos que ".$nomeUsuario." ".$tipo." mesa redonda intitulada ".$nomeEvento." durante o evento intitulado ".$descricaoEventoPai.", promovido ".$textoExtra2." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". A carga horária total da palestra foi de ".substr($cargaHoraria,0,5)." horas."; 
                }
            }
            
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);


        }
        public function CertificadoEventoMinistrante($cursoGraduacao,$nomeEvento,$descricaoEventoPai,$oficina_minicurso,$colaboracao,$dataInicio,$dataFim,$cargaHoraria){
            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $textoExtra1 = "em parceria pela Coordenação de Extensão e Coordenação de Pesquisa";
            $textoExtra2 = "pela Coordenação do Curso de Graduação em ".$cursoGraduacao;
            if($oficina_minicurso == 'oficina'){
                $textoExtra3 = "oficina intitulada";
            }else{
                $textoExtra3 = "minicurso intitulado";
            }
            if($colaboracao == "coordenacao"){
                $texto = "Certificamos que ".$nomeUsuario." ministrou ".$textoExtra3." ".$nomeEvento." durante o evento intitulado ".strtoupper($descricaoEventoPai).", promovido ".$textoExtra1." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". A carga horária total da atividade foi de ".substr($cargaHoraria,0,5)." horas.";
            }else{
                $texto = "Certificamos que ".$nomeUsuario." ministrou ".$textoExtra3." ".$nomeEvento." durante o evento intitulado ".strtoupper($descricaoEventoPai).", promovido ".$textoExtra2." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". A carga horária total da atividade foi de ".substr($cargaHoraria,0,5)." horas.";
            }
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoEventoMonitor($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim, $cargaHoraria,$cargaRealizada){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $textoExtra1 = "em parceria pela Coordenação de Extensão e Coordenação de Pesquisa";
            $textoExtra2 = "pela Coordenação do Curso de Graduação em ".$cursoGraduacao;
            if($colaboracao == "coordenacao"){
                $texto = "Certificamos que ".$nomeUsuario." atuou como monitor(a) na organização do ".$nomeEvento.", promovido ".$textoExtra1." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).", perfazendo carga horária total de ".substr($cargaHoraria,0,5)." horas. A carga horária desempenhada como monitor no evento foi da ordem de ".$cargaRealizada." horas.";
            }else{
                $texto = "Certificamos que ".$nomeUsuario." atuou como monitor(a) na organização do ".$nomeEvento.", promovido ".$textoExtra2." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).", perfazendo carga horária total de ".substr($cargaHoraria,0,5)." horas. A carga horária desempenhada como monitor no evento foi da ordem de ".$cargaRealizada." horas.";
            }
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoEventoOrganizador($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim, $cargaHoraria){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $textoExtra1 = "em parceria pela Coordenação de Extensão e Coordenação de Pesquisa";
            $textoExtra2 = "pela Coordenação do Curso de Graduação em ".$cursoGraduacao;
            if($colaboracao == "coordenacao"){
                $texto = "Certificamos que ".$nomeUsuario." atuou como organizador(a) do ".$nomeEvento.", promovido ".$textoExtra1." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).", perfazendo carga horária total de ".substr($cargaHoraria,0,5)." horas.";
            }else{
                $texto = "Certificamos que ".$nomeUsuario." atuou como organizador(a) do ".$nomeEvento.", promovido ".$textoExtra2." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).", perfazendo carga horária total de ".substr($cargaHoraria,0,5)." horas.";
            }
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);

        }

        public function CertificadoEventoParticipante($cursoGraduacao,$nomeEvento,$colaboracao,$dataInicio,$dataFim,$cargaHoraria){
            //AQUI
            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $textoExtra1 = "em parceria pela Coordenação de Extensão e Coordenação de Pesquisa";
            $textoExtra2 = "pela Coordenação do Curso de Graduação em ".$cursoGraduacao;
            if($colaboracao == "coordenacao"){
                $texto = "Certificamos que ".$nomeUsuario." participou como ouvinte das atividades do evento intitulado ".$nomeEvento.", promovido ".$textoExtra1." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).", perfazendo carga horária total de ".substr($cargaHoraria,0,5)." horas.";
            }else{
                $texto = "Certificamos que ".$nomeUsuario." participou como ouvinte das atividades do evento intitulado ".$nomeEvento.", promovido ".$textoExtra2." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).", perfazendo carga horária total de ".substr($cargaHoraria,0,5)." horas.";
            }
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);

        }
        public function CertificadoEventoPalestrante($cursoGraduacao,$nomeEvento,$descricaoEventoPai,$colaboracao,$dataInicio,$dataFim, $cargaHoraria){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $textoExtra1 = "em parceria pela Coordenação de Extensão e Coordenação de Pesquisa";
            $textoExtra2 = "pela Coordenação do Curso de Graduação em ".$cursoGraduacao;
            if($colaboracao == "coordenacao"){
                $texto = "Certificamos que ".$nomeUsuario." proferiu palestra intitulada ".$nomeEvento." durante o evento intitulado ".$descricaoEventoPai.", promovido ".$textoExtra1." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". A carga horária total da palestra foi de ".substr($cargaHoraria,0,5)." horas.";
            }else{
                $texto = "Certificamos que ".$nomeUsuario." proferiu palestra intitulada ".$nomeEvento." durante o evento intitulado ".$descricaoEventoPai.", promovido ".$textoExtra2." da UEMG, Unidade Ituiutaba. O evento ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". A carga horária total da palestra foi de ".substr($cargaHoraria,0,5)." horas.";
            }
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoProjetoBolsista($nomeEvento,$orientador,$dataInicio,$dataFim){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $texto = "Certificamos que ".$nomeUsuario." atuou como bolsista pelo Programa Institucional de Apoio à Extensão (PAEx/UEMG) para desenvolvimento do Projeto de Extensão intitulado ".$nomeEvento.", sob a orientação do(a) professor(a) ".strtoupper($orientador).", durante o(s) mês(meses) de ".$mesInicio." a ".$mesFim." de ".$anoRealizacao.", atuando 20 horas semanais para cumprimento das atividades do referido projeto.";
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,144,'PNG');
            $this->Image('img/ass_conrado.png',180,146,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoProjetoColaborador($orientador,$nomeEvento,$dataInicio,$dataFim, $cargaHoraria){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $texto = "Certificamos que ".$nomeUsuario." atuou como colaborador(a) no desenvolvimento do Projeto de Extensão intitulado ".$nomeEvento.", sob a orientação do(a) professor(a) ".strtoupper($orientador).", durante o(s) mês(meses) de ".$mesInicio." a ".$mesFim." de ".$anoRealizacao.", atuando ".substr($cargaHoraria,0,5)." horas semanais para cumprimento das atividades do referido projeto.";
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,144,'PNG');
            $this->Image('img/ass_conrado.png',180,146,'PNG');

            $this->Output('I',true);

        }
        public function CertificadoProjetoOrientador($nomeEvento, $bolsista, $dataInicio, $dataFim){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $texto = "Certificamos que ".$nomeUsuario." atuou como orientador(a) do(a) acadêmico(a) ".strtoupper($bolsista).", com bolsa aprovada e financiada pelo Programa Institucional de Apoio à Extensão (PAEx/UEMG), para desenvolvimento do Projeto de Extensão intitulado ".$nomeEvento.", durante o(s) mês(meses) de ".$mesInicio." a ".$mesFim." de ".$anoRealizacao.", atuando cerca de 20 horas semanais para cumprimento das atividades do referido projeto.";
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,144,'PNG');
            $this->Image('img/ass_conrado.png',180,146,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoProjetoVoluntario($orientador,$nomeEvento,$dataInicio,$dataFim){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $texto = "Certificamos que ".$nomeUsuario." atuou como voluntário(a) no desenvolvimento do Projeto de Extensão intitulado ".$nomeEvento.", sob a orientação do(a) professor(a) ".strtoupper($orientador).", durante o(s) mês(meses) de ".$mesInicio." a ".$mesFim." de ".$anoRealizacao.", atuando 20 horas semanais para cumprimento das atividades do referido projeto.";
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,144,'PNG');
            $this->Image('img/ass_conrado.png',180,146,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoIcBolsista($orientador,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria,$fomento){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $texto = "Certificamos que ".$nomeUsuario." atuou como bolsista pelo(a) ".strtoupper($fomento).", para desenvolvimento do Projeto de Iniciação Científica intitulado ".$nomeEvento.", sob a orientação do(a) professor(a) ".strtoupper($orientador).", durante o(s) mês(meses) de ".$mesInicio." a ".$mesFim." de ".$anoRealizacao.", atuando cerca de 20 horas semanais para cumprimento das atividades do referido projeto.";
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_amanda.png',40,149,'PNG');
            $this->Image('img/ass_conrado.png',180,151,'PNG');

            $this->Output('I',true);

        }
        public function CertificadoIcOrientador($bolsista,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria,$fomento){
            
            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $texto = "Certificamos que ".$nomeUsuario." atuou como orientador(a) do(a) acadêmico(a) ".strtoupper($bolsista).", com bolsa aprovada e financiada pelo(a) ".strtoupper($fomento).", para desenvolvimento do Projeto de Iniciação Científica intitulado ".$nomeEvento.", durante o(s) mês(meses) de ".$mesInicio." a ".$mesFim." de ".$anoRealizacao.", atuando cerca de 20 horas semanais para cumprimento das atividades do referido projeto.";
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_amanda.png',40,149,'PNG');
            $this->Image('img/ass_conrado.png',180,151,'PNG');

            $this->Output('I',true);

        }
        public function CertificadoIcVoluntario($orientador,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria,$fomento){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $texto = "Certificamos que ".$nomeUsuario." atuou como voluntário(a) no desenvolvimento do Projeto de Iniciação Científica intitulado ".$nomeEvento.", sob a orientação do(a) professor(a) ".strtoupper($orientador).", durante o(s) mês(meses) de ".$mesInicio." a ".$mesFim." de ".$anoRealizacao.", atuando cerca de 20 horas semanais para cumprimento das atividades do referido projeto.";
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_amanda.png',40,149,'PNG');
            $this->Image('img/ass_conrado.png',180,151,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoIcjBolsista($orientador,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria,$fomento){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $texto = "Certificamos que ".$nomeUsuario." atuou como bolsista pelo(a) ".strtoupper($fomento).", para desenvolvimento do Projeto de Iniciação Científica Júnior intitulado ".$nomeEvento.", sob a orientação do(a) professor(a) ".strtoupper($orientador).", durante o(s) mês(meses) de ".$mesInicio." a ".$mesFim." de ".$anoRealizacao.", atuando cerca de 20 horas semanais para cumprimento das atividades do referido projeto.";
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_amanda.png',40,149,'PNG');
            $this->Image('img/ass_conrado.png',180,151,'PNG');

            $this->Output('I',true);

        }
        public function CertificadoIcjOrientador($bolsista,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria,$fomento){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $texto = "Certificamos que ".$nomeUsuario." atuou como orientador(a) do(a) acadêmico(a) ".strtoupper($bolsista).", com bolsa aprovada e financiada pelo(a) ".strtoupper($fomento).", para desenvolvimento do Projeto de Iniciação Científica Júnior intitulado ".$nomeEvento.", durante o(s) mês(meses) de ".$mesInicio." a ".$mesFim." de ".$anoRealizacao.", atuando cerca de 20 horas semanais para cumprimento das atividades do referido projeto.";
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_amanda.png',40,149,'PNG');
            $this->Image('img/ass_conrado.png',180,151,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoIcjVoluntario($orientador,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria,$fomento){

            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $inicio = explode("-",$dataInicio);
            $fim = explode("-",$dataFim);
            $mesInicio = $this->mes($inicio[1]);
            $mesFim = $this->mes($fim[1]);
            $ano = explode("-",$dataInicio);
            $anoRealizacao = $ano[0];
            $mesEmissao = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', 'B', 30);
            $this->SetXY(115,50);
            $textoCertificado = "CERTIFICADO";
            $this->MultiCell(200,10,utf8_decode($textoCertificado),'','J',0);
            $this->SetFont('Arial', '', 10);
            $texto = "Certificamos que ".$nomeUsuario." atuou como voluntário(a) no desenvolvimento do Projeto de Iniciação Científica Júnior intitulado ".$nomeEvento.", sob a orientação do(a) professor(a) ".strtoupper($orientador).", durante o(s) mês(meses) de ".$mesInicio." a ".$mesFim." de ".$anoRealizacao.", atuando cerca de 20 horas semanais para cumprimento das atividades do referido projeto.";
            $this->SetXY(50,64);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mesEmissao." de ".date('Y');
            $this->SetXY(125,119);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_amanda.png',40,149,'PNG');
            $this->Image('img/ass_conrado.png',180,151,'PNG');

            $this->Output('I',true);
        }
    }

?>