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
        
        public function NovoParticipanteEvento($tipo,$posteres,$idUsuarioEvento,$idEvento){
            $sql = "INSERT INTO participanteevento (tipo,numero_posteres,data_inscricao,entrada,saida,id_usuario,id_evento) VALUES ("."'".$tipo."',"."'".$posteres."',"."'".\date('Y-m-d')."',"."'00:00:00','00:00:00',".$idUsuarioEvento.",".$idEvento.")";
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
    }

?>