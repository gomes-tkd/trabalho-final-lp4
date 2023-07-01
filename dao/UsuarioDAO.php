<?php
    require_once ("./models/Usuario.php");
    require_once ("./models/Mensagem.php");

    class UsuarioDAO implements UsuarioDAOInterface {
        private $conn;
        private $url;
        private $msg;

        public function __construct($conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->msg = new Mensagem($url);
        }

        public function buildUsuario($data)
        {
            // TODO: Implement buildUsuario() method.
            $usuario = new Usuario();

            $usuario->id = $data["id"];
            $usuario->nome = $data["nome"];
            $usuario->email = $data["email"];
            $usuario->senha = $data["senha"];
            $usuario->imagem = $data["imagem"];
            $usuario->bio = $data["bio"];
            $usuario->curtidas = $data["curtidas"];
            $usuario->postagens = $data["postagens"];
            $usuario->seguidores = $data["seguidores"];
            $usuario->token = $data["token"];

            return $usuario;
        }

        public function create(Usuario $usuario, $auth = false)
        {
            // TODO: Implement create() method.
            $stmt = $this->conn->prepare("
                INSERT INTO usuarios (nome, email, senha, token, curtidas, postagens, seguidores) 
                    VALUES (:nome, :email, :senha, :token, :curtidas, :postagens, :seguidores)
                ");

            $stmt->bindParam(":nome", $usuario->nome);
            $stmt->bindParam(":email", $usuario->email);
            $stmt->bindParam(":senha", $usuario->senha);
            $stmt->bindParam(":token", $usuario->token);
            $stmt->bindParam(":curtidas", $usuario->curtidas);
            $stmt->bindParam(":postagens", $usuario->postagens);
            $stmt->bindParam(":seguidores", $usuario->seguidores);

            $stmt->execute();

            if ($auth) {
                $this->setTokenToSession($usuario->token);
            }
        }

        public function update(Usuario $usuario, $redirect = true)
        {
            $stmt = $this->conn->prepare("UPDATE usuarios
                    SET nome = :nome,
                            email = :email,
                            imagem = :imagem,
                            bio = :bio,
                            token = :token,
                            seguidores = :seguidores
                        WHERE id = :id
                ");

            $stmt->bindParam(":nome", $usuario->nome);
            $stmt->bindParam(":email", $usuario->email);
            $stmt->bindParam(":imagem", $usuario->imagem);
            $stmt->bindParam(":bio", $usuario->bio);
            $stmt->bindParam(":token", $usuario->token);
            $stmt->bindParam(":seguidores", $usuario->seguidores);
            $stmt->bindParam(":id", $usuario->id);

            $stmt->execute();

            if ($redirect) {
                $this->msg->setMensagem("Dados atualizados com sucesso!", "success", "perfil.php");
            }

        }

        public function findByEmail($email)
        {
            if ($email != "") {
                $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = :email");

                $stmt->bindParam(":email", $email);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $data = $stmt->fetch();
                    $usuario = $this->buildUsuario($data);
                    return $usuario;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function authUsuario($email, $senha)
        {
            $usuario = $this->findByEmail($email);

            if ($usuario) {
                if (password_verify($senha, $usuario->senha)) {
                    $token = $usuario->generateToken();
                    $usuario->token = $token;

                    $this->setTokenToSession($token, false);
                    $this->update($usuario);
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function setTokenToSession($token, $redirect = true)
        {
            $_SESSION["token"] = $token;

            if ($redirect) {
                $this->msg->setMensagem("Seja bem-vindo!", "success", "perfil.php");
            }
        }

        public function findByToken($token)
        {
            if ($token != "") {
                $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE token = :token");

                $stmt->bindParam(":token", $token);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $data = $stmt->fetch();
                    $user = $this->buildUsuario($data);

                    return $user;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function verifyToken($protected = false)
        {
            if(!empty($_SESSION["token"])) {
                $token = $_SESSION["token"];
                $usuario = $this->findByToken($token);
                if ($usuario) {
                    return $usuario;
                } else if ($protected) {
                    $this->msg->setMensagem("Faça a autenticação para acessar esta página!", "error", "index.php");
                }
            } else if($protected) {
                $this->msg->setMensagem("Faça a autenticação para acessar esta página!", "error", "index.php");
            } else {
                return false;
            }
        }

        public function destroyToken()
        {
            // TODO: Implement destroyToken() method.
            $_SESSION["token"] = "";

            $this->msg->setMensagem("Usuário deslogado com sucesso!", "success", "auth.php");
        }

        public function changePassword($senha, $id)
        {
            // TODO: Implement changePassword() method.

            $stmt = $this->conn->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
            $stmt->bindParam(":senha", $senha);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $this->msg->setMensagem("Dados atualizados com sucesso!", "success", "perfil.php");

        }

        public function findById($id)
        {
            // TODO: Implement findById() method
            if ($id != "") {
                $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = :id");

                $stmt->bindParam(":id", $id);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $data = $stmt->fetch();

                    return $this->buildUsuario($data);

                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function followUsuario($id)
        {
            // TODO: Implement followUsuario() method.
            if ($id != "") {
                $usuario = $this->findById($id);
                $fallowCount = $usuario->seguidores;
                $fallowCount += 1;
                $usuario->seguidores = $fallowCount;

                $this->update($usuario);

                return true;
            }

            return false;
        }

        public function getTotalSeguidores($id)
        {
            // TODO: Implement getTotalSeguidores() method.
            if ($id != "") {
                 $usuario = new Usuario();
                 $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = :id");

                 $stmt->bindParam(":id", $id);
                 $stmt->execute();

                 if ($stmt->rowCount() > 0) {
                     $data = $stmt->fetch();
                     $usuario = $this->buildUsuario($data);
                 }

                return $usuario->seguidores;
            }

            return false;
        }
    }
?>