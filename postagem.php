<?php
    require_once ("./templates/header.php");
    require_once ("./dao/PostagemDAO.php");
    require_once ("./dao/UsuarioDAO.php");
    require_once ("./dao/ComentarioDAO.php");

    $postagemDao = new PostagemDAO($conn, $BASE_URL);
    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);
    $comentarioDao = new ComentarioDAO($conn, $BASE_URL);

    $id = $_GET["id"];
    $postagem = $postagemDao->findByIdPostagem($id);
    $dadosUsuario = $usuarioDao->verifyToken();

    $comentarios = $comentarioDao->getComentarios($id);

?>
<section class="container postagem-container min-height">
    <div class="border-container">
        <div class="postagem-titulo">
            <h2 class="postagem-subtitulo"><?= $postagem->titulo ?></h2>
            <?php if($dadosUsuario->id == $postagem->id_usuario): ?>
                <a class="btn-deletar" href="<?=$BASE_URL?>deletar.php?id=<?=$postagem->id?>">deletar</a>
            <?php else: ?>
                <a class="post-autor" href="<?=$BASE_URL?>perfil_autor.php?id=<?=$postagem->id_usuario?>">@<?= $postagem->nome_autor ?></a>
            <?php endif; ?>
        </div>
        <img class="" src="<?=$BASE_URL?>/assets/img/postagem/<?=$postagem->imagem?>" alt="Imagem da postagem" />
        <div class="postagem-descricao-decoracao">
            <p class="postagem-descricao"><?= $postagem->descricao?></p>
        </div>
        <form action=""></form>
        <p class="postagem-curtidas">Curtidas: <?= $postagem->curtidas ?></p>
    </div>
    <div class="postagem-comentario-container">
        <h2>Comentários</h2>
        <div>
            <div class="postagem-comentario-div">
                <ul class="postagem-comentarios-lista">
                    <?php foreach ($comentarios as $comentario): ?>
                        <li class="postagem-comentario-item">
                            <?= $comentario->nome_autor?>
                            <?= $comentario->comentario?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="postagem-comentario-form">
                <form style="display: grid;" method="POST" action="<?= $BASE_URL ?>comentario_process.php">
                    <input type="hidden" name="type" value="comentar" />
                    <input type="hidden" name="id-postagem" value="<?= $postagem->id ?>"/>
                    <div>
                        <label class="usuario-edit" for="comentario">Comente:</label>
                        <textarea class="bio-dados" style="resize: none" name="comentario" id="comentario" cols="40" rows="5">Comente aqui!</textarea>
                    </div>
                    <div class="postagem-comentario-form-btns">
                        <button class="usuario-btn" type="submit">Comentar!</button>
                        <a href="<?= $BASE_URL?>curtir.php?id=<?= $id ?>" class="usuario-btn" type="submit">Curtir!</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php
    require_once ("./templates/footer.php");
?>
