<?php
    namespace Classes;
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
    class evento extends conexao{

        private $descricao;
        private $carga_horaria;
        private $data_criacao;
        private $tipo;
        private $extensao;
        private $projeto_bolsista;
        private $projeto_orientador;
        private $projeto_voluntario;
        private $projeto_colaborador;
        private $id_siga_extansao;
        private $informado_ao_colegiado_do_curso;
        private $numero_ata;
        private $data_ata;
        private $evento_organizador;
        private $evento_palestrante;
        private $evento_ministrante;
        private $evento_apresentador;
        private $evento_monitor;
        private $evento_mediador;
        private $evento_participante;
        private $evento_avaliador;
        private $curso_organizador;
        private $curso_ministrante;
        private $curso_participante;
        private $solicitacao_projeto_ic_orientador;
        private $solicitacao_projeto_ic_bolsista;
        private $solicitacao_projeto_ic_voluntario;
        private $solicitacao_projeto_icj_orientador;
        private $solicitacao_projeto_icj_bolsista;
        private $solicitacao_projeto_icj_voluntario;
        private $id_map;
        private $outras_ocorrencias;
        private $id_curso;
        private $id_usuario_responsavel;

        public function NovoEvento($descricao,$oficina_minicurso,$tipoApresentacao,$cargahoraria,$datainicio,$datafim,$datacriacao,$tipo,$extensao,$pesquisa,$bolsista_projeto,$orientador_projeto,$voluntario_projeto,$colaborador_projeto,$organizador_evento,$palestrante_evento,$ministrante_evento,$apresentador_evento,$monitor_evento,$mediador_evento,$participante_evento,$avaliador_evento,$organizador_curso,$ministrante_curso,$participante_curso,$orientador_iniciacao_cientifica,$bolsista_iniciacao_cientifica,$voluntario_iniciacao_cientifica,$orientador_iniciacao_cientifica_jr,$bolsista_iniciacao_cientifica_jr,$voluntario_iniciacao_cientifica_jr,$sigaextensao,$idsiga,$map,$idmap,$colegiado,$numeroata,$dataata,$outrasocorrencias,$curso,$iduser,$eventopaicodigo,$fomento)
        {
            $sql = "INSERT INTO evento(validado,permiteemimssaocertificado,oficina_minicurso,extencao_ou_ic,descricao,carga_horaria,data_inicio,data_fim,data_criacao,tipo,extensao,pesquisa,projeto_bolsista,projeto_orientador,projeto_voluntario,projeto_colaborador,evento_organizador,evento_palestrante,evento_ministrante,evento_apresentador,evento_monitor,evento_mediador,evento_participante,evento_avaliador,curso_organizador,curso_ministrante,curso_participante,pesquisa_projeto_ic_orientador,pesquisa_projeto_ic_bolsista,pesquisa_projeto_ic_voluntario,pesquisa_projeto_icj_orientador,pesquisa_projeto_icj_bolsista,pesquisa_projeto_icj_voluntario,sigaextensao,id_siga_extensao,map,idmap,informado_ao_colegiado_do_curso,numero_ata,data_ata,outras_ocorrencias,curso,colaboracao,id_usuario_responsavel,codigo_evento_pai,fomento) VALUES(0,0,"."'".$oficina_minicurso."',"."'".$tipoApresentacao."',"."'".strtoupper($descricao)."',"."'".$cargahoraria."',"."'".$datainicio."',"."'".$datafim."',"."'".$datacriacao."',"."'".$tipo."',"."'".$extensao."',"."'".$pesquisa."',".$bolsista_projeto.",".$orientador_projeto.",".$voluntario_projeto.",".$colaborador_projeto.",".$organizador_evento.",".$palestrante_evento.",".$ministrante_evento.",".$apresentador_evento.",".$monitor_evento.",".$mediador_evento.",".$participante_evento.",".$avaliador_evento.",".$organizador_curso.",".$ministrante_curso.",".$participante_curso.",".$orientador_iniciacao_cientifica.",".$bolsista_iniciacao_cientifica.",".$voluntario_iniciacao_cientifica.",".$orientador_iniciacao_cientifica_jr.",".$bolsista_iniciacao_cientifica_jr.",".$voluntario_iniciacao_cientifica_jr.",".$sigaextensao.","."'".$idsiga."',".$map.","."'".$idmap."',".$colegiado.","."'".$numeroata."',"."'".$dataata."',"."'".$outrasocorrencias."',"."'".$curso."','',".$iduser.","."'".$eventopaicodigo."',"."'".$fomento."'".")";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
        }

        public function ExibeTodosEventos(){
            $sql = "SELECT * FROM evento ORDER BY codigo_evento_pai,data_inicio,curso";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;        
        }

        public function EditarEvento(){

        }
        
        public function ExibeEventoExpecifico($idEvento){
            $sql = "SELECT * FROM evento WHERE idEvento = ".$idEvento;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;
        }

        public function ExcluirEvento($idEvento){
            $sql = "DELETE FROM evento WHERE idEvento = ".$idEvento;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();

            $testeValidacao = $this->ExibeEventoExpecifico($idEvento);

        }
        public function ValidarEvento($idEvento){
            $sql = "UPDATE evento SET validado = 1 WHERE idEvento = ".$idEvento;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
        }

        public function ListarEventosValidados(){

            $sql = "SELECT * FROM evento WHERE validado = 1";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;
        }

        public function ListaEventosNaoValidados(){

            $sql = "SELECT * FROM evento WHERE validado = 0";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;
        }

        public function PermiteEmissaoDeCertificado($idEvento){
            $sql = "UPDATE evento SET permiteemimssaocertificado = 1 WHERE idEvento = ".$idEvento;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
        }

        public function mes($mes){
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

        public function alterarColaboracao($idEvento,$colaboracao){
            $sql = "UPDATE evento SET colaboracao = "."'".$colaboracao."'"." WHERE idEvento = ".$idEvento;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
        }

    }


?>