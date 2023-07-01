<?php
    require_once ("./models/Comentario.php");
    require_once ("./models/Mensagem.php");

    class ComentarioDAO implements ComentarioDAOInterface {
        private $conn;
        private $url;
        private $msg;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->msg = new Mensagem($url);
        }

        public function buildComentario($data)
        {
            // TODO: Implement biuldComentario() method.
            $comentario = new Comentario();

            $comentario->id = $data["id"];
            $comentario->comentario = $data["comentario"];
            $comentario->nome_autor = $data["nome_autor"];
            $comentario->data_comentario = $data["data_comentario"];
            $comentario->id_postagem = $data["id_postagem"];

            return $comentario;
        }

        public function create(Comentario $comentario) {
            $stmt = $this->conn->prepare("
                    INSERT INTO postagem_comentario (nome_autor, comentario, data_comentario, id_postagem)
                        VALUES (:nome_autor, :comentario, :data_comentario, :id_postagem)
                ");

            $stmt->bindParam(":nome_autor", $comentario->nome_autor);
            $stmt->bindParam(":comentario", $comentario->comentario);
            $stmt->bindParam(":data_comentario", $comentario->data_comentario);
            $stmt->bindParam(":id_postagem", $comentario->id_postagem);

            $stmt->execute();

            $this->msg->setMensagem("Comentário adicionado com sucesso!", "success", "show-postagem.php?id=$comentario->id_postagem");
        }

        public function update(Comentario $comentario) {
            $stmt = $this->conn->prepare("
                    UPDATE postagem_comentario 
                        SET comentario = :comentario,
                            data_comentario = :data_comentario
                        WHERE id_postagem = :id_postagem
                ");

            $stmt->bindParam(":comentario", $comentario->comentario);
            $stmt->bindParam(":data_comentario", $comentario->data_comentario);
            $stmt->bindParam(":id_postagem", $comentario->id_postagem);

            $stmt->execute();

            $this->msg->setMensagem("Comentário Atualizado com sucesso!", "success", "show-postagem.php?id=$comentario->id_postagem");
        }

        public function getComentarios($id)
        {
            // TODO: Implement getComentarios() method.
            if ($id != "") {
                $comentarios = [];

                $stmt = $this->conn->prepare(" SELECT * FROM postagem_comentario WHERE id_postagem = :id_postagem");
                $stmt->bindParam(":id_postagem", $id);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $comentariosData = $stmt->fetchAll();

                    foreach ($comentariosData as $comentario) {
                        $comentarios[] = $this->buildComentario($comentario);
                    }

                    return $comentarios;

                } else {
                    return false;
                }
            }
            return false;
        }

        public function removeComentario($id)
        {
            // TODO: Implement removeComentario() method.
            if ($id != "") {
                $stmt = $this->conn->prepare("DELETE FROM postagem_comentario WHERE id = :id");
                $stmt->bindParam(":id", $id);

                $stmt->execute();

                return true;
            }

            return false;
        }
    }
?>