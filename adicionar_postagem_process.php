<?php

    require_once ("./config/conn.php");
    require_once ("./config/url.php");
    require_once ("./models/Postagem.php");
    require_once ("./models/Usuario.php");
    require_once ("./models/Mensagem.php");
    require_once ("./dao/UsuarioDAO.php");
    require_once ("./dao/PostagemDAO.php");

    $idUsuario = filter_input(INPUT_POST, "id-usuario");
    $type = filter_input(INPUT_POST, "type");

    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);
    $postagemDao = new PostagemDAO($conn, $BASE_URL);

    $usuario = new Usuario();
    $postagem = new Postagem();
    $mensagem = new Mensagem($BASE_URL);

    $usuario = $usuarioDao->verifyToken();

if ($type === "postar") {

    $titulo = filter_input(INPUT_POST, "titulo");
    $descricao = filter_input(INPUT_POST, "descricao");

    $dataPostagem = date("d/m/Y H:i");

    $postagem->titulo = $titulo;
    $postagem->descricao = $descricao;
    $postagem->data_postagem = $dataPostagem;
    $postagem->curtidas = 0;
    $postagem->id_usuario = $usuario->id;
    $postagem->nome_autor = $usuario->nome;

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

            $imageName = $postagem->imageGenerateName($ext);
            imagejpeg($imageFile, "./assets/img/postagem/" . $imageName, 100);
            $postagem->imagem = $imageName;
        } else {
            $mensagem->setMensagem("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
        }
    }

        $postagemDao->create($postagem);
    } else {
        $mensagem->setMensagem("Preencha todos os campos para compartilhar o seu momento!", "error", "back");
    }
?>