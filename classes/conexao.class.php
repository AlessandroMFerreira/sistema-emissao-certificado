<?php
    namespace Classes;
    require_once __DIR__."/vendor/autoload.php";
    class conexao{

        public function con(){
            $con = new PDO("mysql:host=localhost;dbname=tcc", "root", "");
            return $con;
        }
    }

?>