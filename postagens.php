<?php
    require_once ("./templates/header.php");
    require_once ("./dao/UsuarioDAO.php");
    require_once ("./dao/PostagemDAO.php");

    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);
    $dadosUsuario = $usuarioDao->verifyToken();
    $postagemDao = new PostagemDAO($conn, $BASE_URL);
    $postagens = $postagemDao->getPostagens();

?>
<div class="container postagens-container">
    <h2 class="subtitulo">postagens</h2>
    <?php foreach ($postagens as $postagem): ?>
        <div class="border-container">
            <?php if($postagem->id_usuario === $dadosUsuario->id): ?>
                <a class="btn-deletar" href="<?= $BASE_URL?>deletar.php?id=<?=$postagem->id?>">Deletar</a>
            <?php else: ?>
                <a class="post-autor" href="<?=$BASE_URL?>perfil_autor.php?id=<?=$postagem->id_usuario?>">@<?= $postagem->nome_autor ?></a>
            <?php endif; ?>
            <a href="<?= $BASE_URL?>postagem.php?id=<?= $postagem->id?>">
                <img  style="margin: 10px 0;" src="<?=$BASE_URL?>assets/img/postagem/<?= $postagem->imagem?>" alt="Foto da postagem" />
            </a>
            <div class="postagem-info">
                <p  style="margin: 5px 0;"  class="postagem-titulo"><?= $postagem->titulo?></p>
            </div>
            <p style="margin: 5px;" class="postagem-curtidas">Curtidas: <?= $postagem->curtidas ?></p>
        </div>
    <?php endforeach;?>
</div>
<?php
    require_once ("./templates/footer.php");
?>