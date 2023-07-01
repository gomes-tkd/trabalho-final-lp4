<?php
    session_start();
    require_once ("./config/url.php");
    require_once ("./config/conn.php");
    require_once("./models/Mensagem.php");
    require_once("./dao/UsuarioDAO.php");

    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);

    $message = new Mensagem($BASE_URL);
    $flashMessage = $message->getMensagem();

    if(!empty($flashMessage["msg"])) {
        $message->clearMensagem();
    }

    $dadosUsuario = $usuarioDao->verifyToken(false);
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= $BASE_URL ?>style.css">
    <title>Document</title>
</head>
    <header class="header-bg">
        <div class="container header">
            <?php if ($dadosUsuario): ?>
                <a href="<?= $BASE_URL ?>postagens.php">
                    <img src="<?= $BASE_URL ?>assets/img/logo/bikcraft.svg" alt="Logo">
                </a>
                <nav aria-label="Navegação principal">
                    <ul class="header-menu">
                        <li><a href="<?= $BASE_URL ?>postagens.php">Postagens</a></li>
                        <li><a href="<?= $BASE_URL ?>perfil.php">Perfil</a></li>
                        <li><a href="<?= $BASE_URL ?>sair.php">Sair</a></li>
                    </ul>
                </nav>
            <?php else: ?>
                <a href="<?= $BASE_URL ?>index.php">
                    <img src="<?= $BASE_URL ?>assets/img/logo/bikcraft.svg" alt="Logo">
                </a>
                <nav aria-label="Navegação principal">
                    <ul class="header-menu" style="justify-content: end">
                        <li><a href="<?= $BASE_URL ?>auth.php">Entrar | Cadastrar</a></li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
        <?php if(!empty($flassMessage["msg"])): ?>
            <div class="msg-container">
                <p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
            </div>
        <?php endif; ?>
    </header>
    <body>