<?php
    require_once ("./config/url.php");
    require_once ("./config/conn.php");
    require_once ("./dao/ComentarioDAO.php");
    require_once ("./dao/UsuarioDAO.php");
    require_once ("./dao/PostagemDAO.php");
    require_once ("./models/Comentario.php");
    require_once ("./models/Usuario.php");
    require_once ("./models/Mensagem.php");

    $type = filter_input(INPUT_POST, "type");
    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);
    $comentarioDao = new ComentarioDAO($conn, $BASE_URL);
    $postagemDao = new PostagemDAO($conn, $BASE_URL);
    $mensagem = new Mensagem($BASE_URL);

    $idPostagem = filter_input(INPUT_POST, "id-postagem");

    $usuario = $usuarioDao->verifyToken();

    if ($type === "comentar") {
        $comentario = new Comentario();

        $comment = filter_input(INPUT_POST, "comentario");
        $dataPostagem = date("d/m/Y H:i");

        $comentario->id_postagem = $idPostagem;
        $comentario->nome_autor = $usuario->nome;
        $comentario->comentario = $comment;
        $comentario->data_comentario = $dataPostagem;

        $comentarioDao->create($comentario);
        $mensagem->setMensagem("Comentário adicionado com sucesso!", "success", "postagem.php?id=$comentario->id_postagem");
    }
?>