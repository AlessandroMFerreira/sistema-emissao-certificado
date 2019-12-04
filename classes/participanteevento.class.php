<?php
    namespace Classes;
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

    class participante extends conexao{


        public function ExibeTodosParticipantes(){
            $sql = "SELECT * FROM participanteevento";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;
        }
        public function ExibeParticipanteEventoEspecifico($idEvento){
            $sql = "SELECT * FROM participanteevento WHERE id_evento = ".$idEvento;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;
        }
        
        public function NovoParticipanteEvento($tipo,$posteres,$tipoPoster,$idUsuarioEvento,$idEvento){
            $sql = "INSERT INTO participanteevento (tipo,numero_posteres,tipoPoster,data_inscricao,entrada,saida,id_usuario,id_evento) VALUES ("."'".$tipo."',"."'".$posteres."',"."'".$tipoPoster."',"."'".\date('Y-m-d')."',"."'00:00:00','00:00:00',".$idUsuarioEvento.",".$idEvento.")";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            
        }

        public function ExcluirParticipante($idEvento, $idUsuarioPlanilha){
            $sql = "DELETE FROM participanteevento WHERE idParticipanteEvento = ".$idUsuarioPlanilha." AND id_evento = ".$idEvento;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
        }
        public function BuscaParticipanteExpecificoEventoExpecifico($idUsuario,$idEvento){
            $sql = "SELECT * FROM participanteevento WHERE id_usuario = ".$idUsuario." AND id_evento = ".$idEvento;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchALl();
            return $data;
        }
        public function BuscaEventosDoUsuarioEspecifico($idUsuario){
            $sql = "SELECT * FROM participanteevento WHERE id_usuario = ".$idUsuario;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();

            $data = $stmt->fetchAll();

            return $data;
        }

        public function CancelarInscricao($idEvento, $idUsuario){
            $sql = "DELETE FROM participanteevento WHERE id_usuario = ".$idUsuario." AND id_evento = ".$idEvento;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();

        }

        public function InscreverParticipante($idEvento, $idUsuario){
            $sql = "INSERT INTO participanteevento (tipo,data_inscricao,entrada,saida,id_usuario,id_evento) VALUES ('ouvinte',"."'".\date('Y-m-d')."',"."'00:00:00','00:00:00',".$idUsuario.",".$idEvento.")";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
        }
        public function VerificaSeUsuarioJaInscrito($idEvento, $idUsuario){
            $sql = "SELECT * FROM participanteevento WHERE id_usuario = ".$idUsuario." AND id_evento = ".$idEvento;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();

            $tuplas = $stmt->fetchColumn();

            if($tuplas > 0){
                return true;
            }else{
                return false;
            }
        }
        public function gravaParticipacao($idEvento,$idUsuario){
            $sql = "INSERT INTO inscricao_participante (id_evento, id_usuario,inscrito) VALUES(".$idEvento.",".$idUsuario.",1)";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
        }

        public function buscaSeUsuarioJaFoiCadastrado($idEvento,$idUsuario){
            $sql = "SELECT id_evento, id_usuario,inscrito FROM inscricao_participante WHERE id_evento = ".$idEvento." AND id_usuario = ".$idUsuario;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();

            $data = $stmt->fetchAll();
            
            return $data;
        }
    }

?>