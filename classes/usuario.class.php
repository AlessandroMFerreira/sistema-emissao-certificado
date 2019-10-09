<?php
    namespace Classes;
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
    class usuario extends conexao{

        private $isadm;
        private $isprofessor;
        private $isparticipante;
        private $nome;
        private $usuario;
        private $sexo;
        private $senha;
        private $cpf;
        private $email;
        private $endereco;
        private $numero;
        private $bairro;
        private $cidade;
        private $estado;
        private $cep;
        private $telefone;

        private function VerificaSeUsuarioCpfEmailJaCadastrados($nome, $usuario, $sexo, $senha, $cpf, $email, $endereco, $numero, $bairro, $cidade, $estado, $cep, $telefone){
            $data = $this->ListaTodosOsUsuarios();
            $verificaCampos = array('usuario' => 0, 'cpf' => 0, 'email' => 0);

            foreach($data as $row){
                if($row['usuario'] == $usuario){
                    $verificaCampos['usuario'] = 1;
                }
                if($row['cpf'] == $cpf){
                    $verificaCampos['cpf'] = 1;
                }
                if($row['email'] == $email){
                    $verificaCampos['email'] = 1;
                }
            }

            return $verificaCampos;
        }

        public function CriaNovoUsuario($nome, $usuario, $sexo, $senha, $cpf, $email, $endereco, $numero, $bairro, $cidade, $estado, $cep, $telefone){
            $this->nome = $nome;
            $this->usuario = $usuario;
            $this->sexo = $sexo;
            $this->senha = $senha;
            $this->cpf = $cpf;
            $this->email = $email;
            $this->endereco = $endereco;
            $this->numero = $numero;
            $this->bairro = $bairro;
            $this->cidade = $cidade;
            $this->estado = $estado;
            $this->cep = $cep;
            $this->telefone = $telefone;
            
            $verificaArray = $this->VerificaSeUsuarioCpfEmailJaCadastrados($nome, $usuario, $sexo, $senha, $cpf, $email, $endereco, $numero, $bairro, $cidade, $estado, $cep, $telefone);
            
            if($verificaArray['usuario'] == 0 && $verificaArray['cpf'] == 0 && $verificaArray['email'] == 0){

                if(!isset($_SESSION['tipo'])){
                    $sql = "INSERT INTO usuario(isadm,isprofessor,isparticipante,nome,usuario,sexo,senha,cpf,email,endereco,numero,bairro,cidade,estado,cep,telefone) VALUES(0,0,1,"."'".$this->nome."',"."'".$this->usuario."',"."'".$this->sexo."',"."'".$this->senha."',"."'".$this->cpf."',"."'".$this->email."',"."'".$this->endereco."',"."'".$this->numero."',"."'".$this->bairro."',"."'".$this->cidade."',"."'".$this->estado."',"."'".$this->cep."',"."'".$this->telefone."'".")";
                    $stmt = $this->con()->prepare($sql);
                    $stmt->execute();
                    echo "<script>
                        alert('Cadastro realizado com sucesso!');
                        window.location.href='../index.php';
                    </script>";
                }
                else if($_SESSION['tipo'] == 'administrador'){
                    $sql = "INSERT INTO usuario(isadm,isprofessor,isparticipante,nome,usuario,sexo,senha,cpf,email,endereco,numero,bairro,cidade,estado,cep,telefone) VALUES(0,0,1,"."'".$this->nome."',"."'".$this->usuario."',"."'".$this->sexo."',"."'".$this->senha."',"."'".$this->cpf."',"."'".$this->email."',"."'".$this->endereco."',"."'".$this->numero."',"."'".$this->bairro."',"."'".$this->cidade."',"."'".$this->estado."',"."'".$this->cep."',"."'".$this->telefone."'".")";
                    $stmt = $this->con()->prepare($sql);
                    $stmt->execute();
                    echo "<script>
                        alert('Cadastro realizado com sucesso!');
                        window.location.href='painelcontrole.php?id=2';
                    </script>";
                }
            }else{
                if($_SESSION['tipo']=='administrador'){

                    if($verificaArray['usuario'] == 1){
                        echo "<script>
                            alert('Este usuario ja está sendo utilizado');
                                window.location.href='painelcontrole.php?acao=cadastrarUsuario';
                            </script>";
                    }
                    if($verificaArray['cpf'] == 1){
                        echo "<script>
                                alert('Cpf já cadastrado');
                                window.location.href='painelcontrole.php?acao=cadastrarUsuario';
                            </script>";
                    }
                    if($verificaArray['email'] == 1){
                        echo "<script>
                                alert('Email já cadastrado');
                                window.location.href='painelcontrole.php?acao=cadastrarUsuario';
                            </script>";
                    }
                }
                if($_SESSION['tipo'] == 'participante'){
                    if($verificaArray['usuario'] == 1){
                        echo "<script>
                            alert('Este usuario ja está sendo utilizado');
                                window.location.href='cadastrousuario.php';
                            </script>";
                    }
                    if($verificaArray['cpf'] == 1){
                        echo "<script>
                                alert('Cpf já cadastrado');
                                window.location.href='cadastrousuario.php';
                            </script>";
                    }
                    if($verificaArray['email'] == 1){
                        echo "<script>
                                alert('Email já cadastrado');
                                window.location.href='cadastrousuario.php';
                            </script>";
                    }
                }
            }
        }

        public function CriaUsuarioProfessor($nome, $usuario, $sexo, $senha, $cpf, $email, $endereco, $numero, $bairro, $cidade, $estado, $cep, $telefone){
            
            $this->nome = $nome;
            $this->usuario = $usuario;
            $this->sexo = $sexo;
            $this->senha = $senha;
            $this->cpf = $cpf;
            $this->email = $email;
            $this->endereco = $endereco;
            $this->numero = $numero;
            $this->bairro = $bairro;
            $this->cidade = $cidade;
            $this->estado = $estado;
            $this->cep = $cep;
            $this->telefone = $telefone;

            $verificaArray = $this->VerificaSeUsuarioCpfEmailJaCadastrados($nome, $usuario, $sexo, $senha, $cpf, $email, $endereco, $numero, $bairro, $cidade, $estado, $cep, $telefone);
            
            if($verificaArray['usuario'] == 0 && $verificaArray['cpf'] == 0 && $verificaArray['email'] == 0){

                $sql = "INSERT INTO usuario(isadm,isprofessor,isparticipante,nome,usuario,sexo,senha,cpf,email,endereco,numero,bairro,cidade,estado,cep,telefone) VALUES(0,1,0,"."'".$this->nome."',"."'".$this->usuario."',"."'".$this->sexo."',"."'".$this->senha."',"."'".$this->cpf."',"."'".$this->email."',"."'".$this->endereco."',"."'".$this->numero."',"."'".$this->bairro."',"."'".$this->cidade."',"."'".$this->estado."',"."'".$this->cep."',"."'".$this->telefone."'".")";
                $stmt = $this->con()->prepare($sql);
                $stmt->execute();
                echo "<script>
                    alert('Cadastro realizado com sucesso!');
                    window.location.href='painelcontrole.php?id=2';
                </script>";
            }else{
                if($verificaArray['usuario'] == 1){
                    echo "<script>
                        alert('Este usuario ja está sendo utilizado');
                            window.location.href='painelcontrole.php?acao=cadastrarUsuario';
                        </script>";
                }
                if($verificaArray['cpf'] == 1){
                    echo "<script>
                            alert('Cpf já cadastrado');
                            window.location.href='painelcontrole.php?acao=cadastrarUsuario';
                        </script>";
                }
                if($verificaArray['email'] == 1){
                    echo "<script>
                            alert('Email já cadastrado');
                            window.location.href='painelcontrole.php?acao=cadastrarUsuario';
                        </script>";
                }
            }

        }
        
        public function ListaTodosOsUsuarios(){
            $sql = "SELECT * FROM usuario ORDER BY nome";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;
        }
        public function ListaUsuarioExpecifico($idUsuario){
            $sql = "SELECT * FROM usuario WHERE idUsuario = ".$idUsuario;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;
        }

        private function ListaUsuarioPorLogin($login){

            $sql = "SELECT * FROM usuario WHERE usuario = "."'".$login."'";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return $data;
        }

        public function UsuarioLogin($login, $senha){
            $validaLogin = $this->ListaUsuarioPorLogin($login);
            $dadosUsuario = array('idUsuario' => '','nomeUsuario' => '', 'adm' => 0, 'professor' => 0, 'participante' => 0 );

            foreach($validaLogin as $row){
                if($row['usuario'] == $login && password_verify($senha, $row['senha'])){
                    if($row['isadm'] == 1){
                        header('Location: painelcontrole.php');
                        $dadosUsuario['idUsuario'] = $row['idUsuario'];
                        $dadosUsuario['nomeUsuario'] = $row['nome'];
                        $dadosUsuario['adm'] = $row['isadm'];
                        $dadosUsuario['professor'] = $row['isprofessor'];
                        $dadosUsuario['participante'] = $row['isparticipante'];
                        return $dadosUsuario;
                    }else if($row['isprofessor'] == 1){
                        header('Location: painelprofessor.php');
                        $dadosUsuario['idUsuario'] = $row['idUsuario'];
                        $dadosUsuario['nomeUsuario'] = $row['nome'];
                        $dadosUsuario['adm'] = $row['isadm'];
                        $dadosUsuario['professor'] = $row['isprofessor'];
                        $dadosUsuario['participante'] = $row['isparticipante'];
                        return $dadosUsuario;
                    }
                    else if($row['isparticipante'] == 1){
                        header('Location: painelusuario.php');
                        $dadosUsuario['idUsuario'] = $row['idUsuario'];
                        $dadosUsuario['nomeUsuario'] = $row['nome'];
                        $dadosUsuario['adm'] = $row['isadm'];
                        $dadosUsuario['professor'] = $row['isprofessor'];
                        $dadosUsuario['participante'] = $row['isparticipante'];
                        return $dadosUsuario;
                    }
                }else{
                    echo "<script>
                            alert('Email ou senha incorretos');
                            window.location.href='index.php';
                            </script>";
                    session_destroy();
                }
            }
        }
        public function UsuarioLogOut(){
            session_destroy();
            header('Location: index.php');
        }
        public function EditarUsuario($idUsuario, $nome, $sexo, $cpf, $email, $endereco, $numero, $bairro, $cidade, $uf, $cep, $telefone){
            $sql = "UPDATE usuario set nome = "."'".$nome."'".",sexo = "."'".$sexo."'".", email = "."'".$email."'".", endereco = "."'".$endereco."'".", numero = "."'".$numero."'".", bairro = "."'".$bairro."'".", cidade = "."'".$cidade."'".", estado = "."'".$uf."'".", cep = "."'".$cep."'".", telefone = "."'".$telefone."'"." WHERE idUsuario = ".$idUsuario;
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();

            echo "
                <script>
                    alert('Usuario editado com sucesso');
                    window.location.href='painelcontrole.php?id=2';
                </script>
            ";
        }
        public function BuscaUsuarioPorCpfParaRequisicao($cpf){
            $sql = "SELECT * FROM usuario WHERE cpf="."'".$cpf."'";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            $arrayDados = array();

            foreach($data as $row){
                $arrayDados['nome'] = $row['nome'];
            }
            return $arrayDados;
        }
        public function BuscaUsuarioPorCpf($cpf){
            $sql = "SELECT * FROM usuario WHERE cpf="."'".$cpf."'";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        }
    }
?>