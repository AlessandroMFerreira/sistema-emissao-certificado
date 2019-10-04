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
        public function CertificadoCursoMinistrante($idEvento, $nomeEvento, $dataInicio, $dataFim, $cargaHoraria){
            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $idUsuario = $_SESSION['idUsuario'];
            $mes = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', '', 10);
            $texto = "Certificamos que ".$nomeUsuario." ministrou curso intitulado $nomeEvento, promovido em parceria pela Coordenação de Extensão e Coordenação de Pesquisa da UEMG, Unidade Ituiutaba. O curso ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).". A carga horária total da atividade foi de ".substr($cargaHoraria,0,5)." horas.";
            $this->SetXY(50,60);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mes." de ".date('Y');
            $this->SetXY(125,115);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);

        }
        public function CertificadoCursoOrganizador($idEvento, $nomeEvento, $dataInicio, $dataFim, $cargaHoraria){
            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $idUsuario = $_SESSION['idUsuario'];
            $mes = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', '', 10);
            $texto = "Certificamos que ".$nomeUsuario." atuou como organizador(a) do ".$nomeEvento.", promovido em parceria pela Coordenação de Extensão e Coordenação de Pesquisa da UEMG, Unidade Ituiutaba. O curso ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).", perfazendo carga horária total de ".substr($cargaHoraria,0,5)." horas.";
            $this->SetXY(50,60);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mes." de ".date('Y');
            $this->SetXY(125,115);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoCursoOuvinte($idEvento, $nomeEvento, $dataInicio, $dataFim, $cargaHoraria){
            $nomeUsuario = strtoupper($_SESSION['nomeUsuario']);
            $idUsuario = $_SESSION['idUsuario'];
            $mes = $this->mes(date('m'));

            $this->addPage("L");
            $this->Image('img/logo_uemg.jpg',190,10,'JPG');
            $this->SetFont('Arial', '', 10);
            $texto = "Certificamos que ".$nomeUsuario." participou como ouvinte das atividades do curso intitulado ".$nomeEvento.", promovido em parceria pela Coordenação de Extensão e Coordenação de Pesquisa da UEMG, Unidade Ituiutaba. O curso ocorreu no período de ".date('d/m/Y',strtotime($dataInicio))." a ".date('d/m/Y',strtotime($dataFim)).", perfazendo carga horária total de ".substr($cargaHoraria,0,5)." horas. ";
            $this->SetXY(50,60);            
            $this->MultiCell(200,10,utf8_decode($texto),'','J',0);
            $this->SetFont('Arial', 'B', 10);
            $texto2 = "Ituiutaba, ".$mes." de ".date('Y');
            $this->SetXY(125,115);
            $this->MultiCell(200,10,utf8_decode($texto2),'','J',0);
            $this->Image('img/ass_allison.png',40,140,'PNG');
            $this->Image('img/ass_conrado.png',110,165,'PNG');
            $this->Image('img/ass_amanda.png',200,142,'PNG');

            $this->Output('I',true);
        }
        public function CertificadoEventoApresentador($idEvento){

        }
        public function CertificadoEventoAvaliador($idEvento){

        }
        public function CertificadoEventoDebatedorMediador($idEvento){

        }
        public function CertificadoEventoMinistrante($idEvento){

        }
        public function CertificadoEventoMonitor($idEvento){

        }
        public function CertificadoEventoOrganizador($idEvento){

        }
        public function CertificadoEventoOuvinte($idEvento){

        }
        public function CertificadoEventoPalestrante($idEvento){

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
        public function CertificadoProjetoColaborador($orientador,$nomeEvento,$dataInicio,$dataFim,$cargaHoraria){

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
        public function CertificadoIcBolsista($idEvento){

        }
        public function CertificadoIcOrientador($idEvento){

        }
        public function CertificadoIcVoluntario($idEvento){

        }
        public function CertificadoIcjBolsista($idEvento){

        }
        public function CertificadoIcjOrientador($idEvento){

        }
        public function CertificadoIcjVoluntario($idEvento){

        }
    }

?>