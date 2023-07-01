<?php
    require_once ("./config/conn.php");
    require_once ("./config/url.php");
    require_once ("./dao/UsuarioDAO.php");

    $id = $_GET["id"];
    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);
    $usuario = $usuarioDao->findById($id);

    $usuarioDao->followUsuario($usuario->id);

?>