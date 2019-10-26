<?php
    namespace Classes;
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
    class conexao{

        protected function con(){
            try{
                $con = new \PDO("mysql:host=localhost;dbname=tcc", "root", "");
            }catch(Exception $e){
                die("Erro ao conectar com banco de dados! Contate o suporte.");
            }
            return $con;
        }
    }

?>