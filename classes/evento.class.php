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

        public function NovoEvento($descricao,$cargahoraria,$datainicio,$datafim,$datacriacao,$tipo,$extensao,$pesquisa,$bolsista_projeto,$orientador_projeto,$voluntario_projeto,$colaborador_projeto,$organizador_evento,$palestrante_evento,$ministrante_evento,$apresentador_evento,$monitor_evento,$mediador_evento,$participante_evento,$avaliador_evento,$organizador_curso,$ministrante_curso,$participante_curso,$orientador_iniciacao_cientifica,$bolsista_iniciacao_cientifica,$voluntario_iniciacao_cientifica,$orientador_iniciacao_cientifica_jr,$bolsista_iniciacao_cientifica_jr,$voluntario_iniciacao_cientifica_jr,$sigaextensao,$idsiga,$map,$idmap,$colegiado,$numeroata,$dataata,$outrasocorrencias,$curso,$iduser)
        {
            $sql = "INSERT INTO evento(validado,permiteemimssaocertificado,descricao,carga_horaria,data_inicio,data_fim,data_criacao,tipo,extensao,pesquisa,projeto_bolsista,projeto_orientador,projeto_voluntario,projeto_colaborador,evento_organizador,evento_palestrante,evento_ministrante,evento_apresentador,evento_monitor,evento_mediador,evento_participante,evento_avaliador,curso_organizador,curso_ministrante,curso_participante,pesquisa_projeto_ic_orientador,pesquisa_projeto_ic_bolsista,pesquisa_projeto_ic_voluntario,pesquisa_projeto_icj_orientador,pesquisa_projeto_icj_bolsista,pesquisa_projeto_icj_voluntario,sigaextensao,id_siga_extansao,map,idmap,informado_ao_colegiado_do_curso,numero_ata,data_ata,outras_ocorrencias,curso,id_usuario_responsavel) VALUES(0,0,"."'".$descricao."',"."'".$cargahoraria."',"."'".$datainicio."',"."'".$datafim."',"."'".$datacriacao."',"."'".$tipo."',"."'".$extensao."',"."'".$pesquisa."',".$bolsista_projeto.",".$orientador_projeto.",".$voluntario_projeto.",".$colaborador_projeto.",".$organizador_evento.",".$palestrante_evento.",".$ministrante_evento.",".$apresentador_evento.",".$monitor_evento.",".$mediador_evento.",".$participante_evento.",".$avaliador_evento.",".$organizador_curso.",".$ministrante_curso.",".$participante_curso.",".$orientador_iniciacao_cientifica.",".$bolsista_iniciacao_cientifica.",".$voluntario_iniciacao_cientifica.",".$orientador_iniciacao_cientifica_jr.",".$bolsista_iniciacao_cientifica_jr.",".$voluntario_iniciacao_cientifica_jr.",".$sigaextensao.","."'".$idsiga."',".$map.","."'".$idmap."',".$colegiado.","."'".$numeroata."',"."'".$dataata."',"."'".$outrasocorrencias."',"."'".$curso."',".$iduser.")";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
        }

        public function ExibeTodosEventos(){
            $sql = "SELECT * FROM evento ORDER BY data_inicio, curso";
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

    }

?>