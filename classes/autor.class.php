<?php    
    
    namespace Classes;
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

    class autor extends conexao{

        public function ExibeTodosAutores(){

            $sql = "SELECT * FROM autor";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();

            $data = $stmt->fetchALl();
            return $data;
        }

        public function ExibeAutorEventoEspecifico($idEvento){
            $sql = "SELECT * FROM autor WHERE id_evento = ".$idEvento;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();

            $data = $stmt->fetchALl();
            return $data;
        }

        public function NovoAutor($nome,$idEvento){
            $sql = "INSERT INTO autor (nome,id_evento) VALUES ("."'".$nome."',".$idEvento.")";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();

            var_dump($sql);
        }
        
        public function ExcluirAutor($idAutor){
            $sql = "DELETE FROM autor WHERE idAutor = ".$idAutor;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
        }

    }

?>