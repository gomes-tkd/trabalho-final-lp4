<?php
    class Usuario {
        public $id;
        public $nome;
        public $email;
        public $senha;
        public $imagem;
        public $bio;
        public $seguidores;
        public $curtidas;
        public $postagens;
        public $token;

        public function generateToken() {
            return bin2hex(random_bytes(50));
        }

        public function generatePassword($senha) {
            return password_hash($senha, PASSWORD_DEFAULT);
        }

        public function imageGenerateName($ext){
            return bin2hex(random_bytes(60)). $ext;
        }
    }

    interface UsuarioDAOInterface {
        public function buildUsuario($data);
        public function create(Usuario $usuario, $auth = false);
        public function update(Usuario $usuario, $redirect = true);
        public function findByEmail($email);
        public function authUsuario($email, $senha);
        public function setTokenToSession($token, $redirect = true);
        public function findByToken ($token);
        public function verifyToken($protected = true);
        public function destroyToken();
        public function changePassword($senha, $id);

        public function findById($id);
        public function followUsuario($id);
        public function getTotalSeguidores($id);
    }
?>