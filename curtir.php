<?php
    require_once ("./config/conn.php");
    require_once ("./config/url.php");
    require_once ("./dao/PostagemDAO.php");
    require_once ("./models/Mensagem.php");

    $postagemDao = new PostagemDAO($conn, $BASE_URL);
    $mensagem = new Mensagem($BASE_URL);
    $id = $_GET["id"];

    $postagem = $postagemDao->getPostagem($id);
    $postagemDao->likePostagem($id);
    $mensagem->setMensagem("Momento curtido com sucesso!", "succes", "postagem.php?id=$id");
?>