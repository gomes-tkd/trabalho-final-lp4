<?php
    require_once ("./config/conn.php");
    require_once ("./config/url.php");
    require_once ("./dao/PostagemDAO.php");

    $postagemDao = new PostagemDAO($conn, $BASE_URL);

    $id = $_GET["id"];

    $postagem = $postagemDao->getPostagem($id);
    $postagemDao->likePostagem($id);
?>