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

    }

?>