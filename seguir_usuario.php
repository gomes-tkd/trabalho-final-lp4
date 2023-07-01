<?php
    require_once ("./config/conn.php");
    require_once ("./config/url.php");
    require_once ("./dao/UsuarioDAO.php");
    require_once ("./models/Mensagem.php");

    $id = $_GET["id"];
    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);
    $usuario = $usuarioDao->findById($id);
    $mensagem = new Mensagem($BASE_URL);

    $usuarioDao->followUsuario($usuario->id);

    $mensagem->setMensagem("Momento curtido com sucesso!", "succes", "perfil_autor.php?id=$id");

?>