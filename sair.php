<?php
    require_once ("./config/url.php");
    require_once ("./config/conn.php");
    require_once ("./dao/UsuarioDAO.php");
    require_once ("./models/Mensagem.php");

    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);

    $usuarioDao->destroyToken();
?>