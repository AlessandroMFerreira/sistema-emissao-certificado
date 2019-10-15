<?php

    namespace Classes;
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
    
    class eventopai extends conexao{

        private function GerarCodigoAleatorio(){
            $parte1 = rand(0,100); //gera um numero aleatório de 0 a 100
            $parte2 = rand(65,90); //gera um numero aleatório de 65 a 90 correspondente ao decimal das letras A a Z da tabela ASCII
            $parte3 = rand(65,90); //gera um numero aleatório de 65 a 90 correspondente ao decimal das letras A a Z da tabela ASCII
            $parte4 = rand(65,90); //gera um numero aleatório de 65 a 90 correspondente ao decimal das letras A a Z da tabela ASCII
            $parte5 = rand(1,1000); //gera a parte fnal do código numero aleatório entre 1 e 1.000

            
            $letra1 = chr($parte2);
            $letra2 = chr($parte3);
            $letra3 = chr($parte4);

            $codigo = $parte1.$letra1.$letra2.$letra3.$parte5;

            $verificaCodigo = $this->VerificaSeCodigoExiste($codigo);
            
            if(!$verificaCodigo){
                return $codigo;
            }else{
                $this->GerarCodigoAleatorio();
            }
        }
        public function VerificaSeCodigoExiste($codigo){
            $sql = "SELECT codigo FROM eventopai WHERE codigo = "."'".$codigo."'";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $tuplas = $stmt->fetchColumn();

            if($tuplas > 0){
                return true;
            }else{
                return false;
            }
        }
        public function NovoEventoPai($descricao,$dataInicio,$dataFim,$curso,$idusuario){
            $codigo = $this->GerarCodigoAleatorio();
            $sql = "INSERT INTO eventopai (descricao,codigo,data_inicio,data_fim,curso,id_usuario_responsavel) VALUES ("."'".$descricao."',"."'".$codigo."',"."'".$dataInicio."',"."'".$dataFim."',"."'".$curso."',".$idusuario.")";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
        }
        public function ExibeTodosEventosPai(){
            $sql = "SELECT * FROM eventopai";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();

            $data = $stmt->fetchAll();

            return $data;
        }

        public function ExcluiEventoPai($idEventoPai){
            $sql = "DELETE FROM eventopai WHERE idEventopai = ".$idEventoPai;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
        }

        public function BuscaEventoPaiPorCodigo($codigo){
            $sql = "SELECT * FROM eventopai WHERE codigo = "."'".$codigo."'";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;
        }
    }

?>