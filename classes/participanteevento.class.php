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
        
        public function NovoParticipanteEvento($tipo,$nome,$mes_inicio,$mes_fim,$posteres,$idUsuarioEvento,$idEvento){
            $sql = "INSERT INTO participanteevento (tipo,nome,mes_inicio,mes_fim,numero_posteres,data_inscricao,entrada,saida,id_usuario,id_evento) VALUES ("."'".$tipo."',"."'".$nome."',"."'".$mes_inicio."',"."'".$mes_fim."',"."'".$posteres."',"."'".CURDATE()."',"."'00:00:00','00:00:00',".$idUsuarioEvento.",".$idEvento.")";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
        }
    }

?>