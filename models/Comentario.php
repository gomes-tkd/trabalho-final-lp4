<?php
    class Comentario {
        public $id;
        public $nome_autor;
        public $comentario;
        public $id_postagem;
        public $data_comentario;
    }

    interface ComentarioDAOInterface {
        public function buildComentario($data);
        public function create(Comentario $comentario);
        public function update(Comentario $comentario);
        public function getComentarios($id);
        public function removeComentario($id);
    }
?>