<?php
    require_once ("./dao/UsuarioDAO.php");
    require_once ("./dao/PostagemDAO.php");

    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);
    $dadosUsuario = $usuarioDao->verifyToken();
    $postagemDao = new PostagemDAO($conn, $BASE_URL);
    $postagensUsuario = $postagemDao->getPostagensUsuario($dadosUsuario->id);
?>

<div class="perfil-postagens">
    <?php foreach ($postagensUsuario as $postagem): ?>
        <div class="border-container">
            <a  href="<?= $BASE_URL?>postagem.php?id=<?= $postagem->id?>">
                <img src="<?=$BASE_URL?>assets/img/postagem/<?= $postagem->imagem?>" alt="Foto da postagem" />
            </a>
            <div class="postagem-info">
                <p class="postagem-titulo"><?= $postagem->titulo?></p>
                <p>Total de curtidas: <?= $postagem->curtidas?></p>
            </div>
        </div>
    <?php endforeach;?>
</div>
