<?php
    namespace Classes;
    require_once __DIR__."/vendor/autoload.php";
    class certificado extends fpdf{

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
                $mme = "Outubro";
                return $mes;
            }
            else if($mes == '11' || $mes == 11){
                $mme = "Novembro";
                return $mes;
            }
            else if($mes == '12' || $mes == 12){
                $mme = "Dezembro";
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
        public function CertificadoProjetoBolsista($idEvento){

        }
        public function CertificadoProjetoColaborador($idEvento){

        }
        public function CertificadoProjetoOrientador($idEvento){

        }
        public function CertificadoProjetoVoluntario($idEvento){

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