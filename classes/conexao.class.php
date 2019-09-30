<?php
    namespace Classes;
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
    class conexao{

        public function con(){
            $con = new \PDO("mysql:host=localhost;dbname=tcc", "root", "");
            return $con;
        }
    }

?>