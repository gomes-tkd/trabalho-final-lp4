<?php
    require_once ("./models/Postagem.php");
    require_once ("./models/Mensagem.php");
    require_once ("./models/Usuario.php");
    require_once ("./dao/UsuarioDAO.php");

    class PostagemDAO implements PostagemDAOInterface {
        private $conn;
        private $url;
        private $msg;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->msg = new Mensagem($url);
        }


        public function buildPostagem($data)
        {
            // TODO: Implement buildPostagem() method.
            $postagem = new Postagem();

            $postagem->id = $data["id"];
            $postagem->titulo = $data["titulo"];
            $postagem->descricao = $data["descricao"];
            $postagem->imagem = $data["imagem"];
            $postagem->data_postagem = $data["data_postagem"];
            $postagem->curtidas = $data["curtidas"];
            $postagem->id_usuario = $data["id_usuario"];
            $postagem->nome_autor = $data["nome_autor"];

            return $postagem;
        }

        public function create(Postagem $postagem)
        {
            // TODO: Implement create() method.
            if ($postagem->titulo != "" && $postagem->descricao != "" && $postagem->imagem != "") {
                $stmt = $this->conn->prepare("
                        INSERT INTO postagem(titulo, descricao, imagem, data_postagem, curtidas, id_usuario, nome_autor)
                            VALUES (:titulo, :descricao, :imagem, :data_postagem, :curtidas, :id_usuario, :nome_autor)
                    ");

                $stmt->bindParam(":titulo", $postagem->titulo);
                $stmt->bindParam(":descricao", $postagem->descricao);
                $stmt->bindParam(":imagem", $postagem->imagem);
                $stmt->bindParam(":data_postagem", $postagem->data_postagem);
                $stmt->bindParam(":curtidas", $postagem->curtidas);
                $stmt->bindParam(":id_usuario", $postagem->id_usuario);
                $stmt->bindParam(":nome_autor", $postagem->nome_autor);

                $stmt->execute();

                $this->msg->setMensagem("Momento compartilhado com sucesso!", "success", "postagens.php");
            } else {
                $this->msg->setMensagem("Para compartilhar o seu momento preencha todos os campos!", "error", "back");
            }
        }

        public function update(Postagem $postagem, $id)
        {
            // TODO: Implement update() method.
            $stmt = $this->conn->prepare("
                    UPDATE postagem
                        SET titulo = :titulo,
                            descricao = :descricao,
                            imagem = :imagem,
                            data_postagem = :data_postagem,
                            curtidas = :curtidas,
                            nome_autor = :nome_autor
                        WHERE id = :id
                ");

            $stmt->bindParam(":titulo", $postagem->titulo);
            $stmt->bindParam(":descricao", $postagem->descricao);
            $stmt->bindParam(":imagem", $postagem->imagem);
            $stmt->bindParam(":data_postagem", $postagem->data_postagem);
            $stmt->bindParam(":curtidas", $postagem->curtidas);
            $stmt->bindParam(":nome_autor", $postagem->nome_autor);
            $stmt->bindParam(":id", $id);

            $stmt->execute();

            $this->msg->setMensagem("Momento atualizado com sucesso!", "success", "postagens.php");
        }

        public function deletePostagem($id)
        {
            // TODO: Implement deletePostagem() method.
            $stmt = $this->conn->prepare("DELETE FROM postagem WHERE id = :id");
            $stmt->bindParam(":id", $id);

            $stmt->execute();

            $this->msg->setMensagem("Momento removido com sucesso!", "success", "postagens.php");

        }

        public function getPostagem($id)
        {
            // TODO: Implement getPostagem() method.
            if ($id != "") {

                $stmt = $this->conn->prepare("SELECT * FROM postagem WHERE id = :id");
                $stmt->bindParam(":id", $id);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $data = $stmt->fetch();
                    return $this->buildPostagem($data);
                } else {
                    return false;
                }
            }
            return false;
        }

        public function getPostagensUsuario($id)
        {
            // TODO: Implement getPostagensUsuario() method.
            if ($id != "") {
                $postagens = [];

                $stmt = $this->conn->prepare("SELECT * FROM postagem WHERE id_usuario = :id_usuario");
                $stmt->bindParam(":id_usuario", $id);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $datas = $stmt->fetchAll();

                    foreach ($datas as $data) {
                        $postagens[] = $this->buildPostagem($data);
                    }

                    return $postagens;
                } else {
                    return false;
                }
            }
            return false;
        }

        public function getPostagens()
        {
            // TODO: Implement getPostagens() method.
            $postagens = [];

            $stmt = $this->conn->prepare("SELECT * FROM postagem");
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $datas = $stmt->fetchAll();

                foreach ($datas as $data) {
                    $postagens[] = $this->buildPostagem($data);
                }
            }

            return $postagens;
        }

        public function likePostagem($id)
        {
            // TODO: Implement likePostagem() method.
            if ($id != "") {
                $postagem = $this->getPostagem($id);
                $likesCount = $postagem->curtidas;

                $likesCount += 1;
                $postagem->curtidas = $likesCount;
                $this->update($postagem, $id);

                return true;
            }

            return false;
        }

        public function findByIdPostagem($id)
        {
            // TODO: Implement findByIdPostagem() method.
            if ($id != "") {
                $stmt = $this->conn->prepare("SELECT * FROM postagem WHERE id = :id");
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $data = $stmt->fetch();

                    return $this->buildPostagem($data);
                }
            }
            return false;
        }

        public function findByIdPostagemUsuarioDados($id)
        {
            // TODO: Implement findByIdPostagemUsuarioDados() method.
            if ($id != "") {
                $usuarioDao = new UsuarioDAO($this->conn, $this->url);
                return $usuarioDao->findById($id);
            }
            return false;
        }

        public function getTotalCurtidas($id)
        {
            // TODO: Implement getTotalCurtidas() method.

            if ($id != "") {
                $totalCurtidas = 0;
                $stmt = $this->conn->prepare("SELECT * FROM postagem WHERE id_usuario = :id");
                $stmt->bindParam(":id", $id);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $dataPostagens = $stmt->fetchAll();

                    foreach ($dataPostagens as $postagem) {
                        $dataPostagem = $this->buildPostagem($postagem);
                        $totalCurtidas += $dataPostagem->curtidas;
                    }
                }

                return $totalCurtidas;
            }

            return false;
        }

        public function getTotalPostagens($id)
        {
            // TODO: Implement getTotalPostagens() method.
            if ($id != "") {
                $totalPostagens = 0;
                $postagens = [];
                $stmt = $this->conn->prepare("SELECT * FROM postagem WHERE id_usuario = :id");
                $stmt->bindParam(":id", $id);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $dataPostagens = $stmt->fetchAll();
                    $totalPostagens = sizeof($dataPostagens);
                }

                return $totalPostagens;
            }

            return false;
        }
    }
?>