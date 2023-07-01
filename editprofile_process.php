<?php
    require_once ("./config/conn.php");
    require_once ("./config/url.php");
    require_once ("./dao/UsuarioDAO.php");
    require_once ("./models/Usuario.php");
    require_once ("./models/Mensagem.php");

    $usuario = new Usuario();
    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);
    $mensagem = new Mensagem($BASE_URL);

    $idUsuario = filter_input(INPUT_POST, "id-usuario");

    $type = filter_input(INPUT_POST, "type");

    if ($type === "dados") {
        $nome = filter_input(INPUT_POST, "nome");
        $email = filter_input(INPUT_POST, "email");
        $bio = filter_input(INPUT_POST, "bio");

        $usuario = $usuarioDao->findById($idUsuario);
        $usuario->nome = $nome;
        $usuario->email = $email;
        $usuario->bio = $bio;

        $usuarioDao->update($usuario);
    }

    if ($type === "senha") {
        $senha = filter_input(INPUT_POST, "senha");
        $confirmarSenha = filter_input(INPUT_POST, "confirmarSenha");

        if ($senha === $confirmarSenha) {
            $senhaUsuario = $usuario->generatePassword($senha);

            $usuario->senha = $senhaUsuario;

            $usuarioDao->changePassword($senhaUsuario, $idUsuario);
        } else {
            $mensagem->setMensagem("As senhas devem ser iguais!", "error", "editarperfil.php");
        }
    }

    if ($type === "imagem") {
        $usuario = $usuarioDao->findById($idUsuario);

        if(isset($_FILES["imagem"]) && !empty($_FILES["imagem"]["tmp_name"])) {
            $image = $_FILES["imagem"];

            $imageTypes = ["image/jpeg", "image/jpg", "image/png", "image/gif" , "image/bmp"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            //PEGANDO EXTENSÃO DO ARQUIVO
            $ext = strtolower(substr($image['name'],-4));

            // Checagem de tipo de imagem
            if(in_array($image["type"], $imageTypes)) {

                $imageName = $_FILES['imagem']['name'];

                if($ext == ".jpg") {
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                } else if($ext == ".png") {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                } else {
                    $mensagem->setMensagem("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
                }

                $imageName = $usuario->imageGenerateName($ext);
                imagejpeg($imageFile, "./assets/img/perfil/" . $imageName, 100);
                $usuario->imagem = $imageName;
                $usuarioDao->update($usuario);
                return json_encode($usuario);
            } else {
                $mensagem->setMensagem("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
            }
        }
    }

?>