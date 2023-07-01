<?php
    class Postagem {
        public $id;
        public $titulo;
        public $descricao;
        public $imagem;
        public $data_postagem;
        public $curtidas;
        public $id_usuario;
        public $nome_autor;

        public function imageGenerateName($ext){
            return bin2hex(random_bytes(60)). $ext;
        }
    }

    interface PostagemDAOInterface {
        public function buildPostagem($data);
        public function create(Postagem $postagem);
        public function update(Postagem $postagem, $id);
        public function deletePostagem($id);
        public function getPostagem($id);
        public function getPostagensUsuario($id);
        public function getPostagens();
        public function likePostagem($id);
        public function findByIdPostagem($id);
        public function findByIdPostagemUsuarioDados($id);
        public function getTotalCurtidas($id);
        public function getTotalPostagens($id);
    }
?>