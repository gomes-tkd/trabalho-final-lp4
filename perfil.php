<?php
    require_once ("./templates/header.php");
    require_once ("./dao/UsuarioDAO.php");
    require_once ("./dao/PostagemDAO.php");

    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);
    $postagemDao = new PostagemDAO($conn, $BASE_URL);
    $dadosUsuario = $usuarioDao->verifyToken();

    if($dadosUsuario->imagem == NULL) {
        $dadosUsuario->imagem = "user.png";
    }

    $totalCurtidas = $postagemDao->getTotalCurtidas($dadosUsuario->id);
    $totalPostagens = $postagemDao->getTotalPostagens($dadosUsuario->id);
    $totalSeguidores = $usuarioDao->getTotalSeguidores($dadosUsuario->id);
?>
<section class="container min-height">
    <h2 style="margin: 20px 0;">Perfil do Usuário</h2>
    <div>
        <div class="perfil-info">
            <div class="perfil-status">
                <div class="perfil-status-usuario">
                    <img style="width: 60px; height: 60px;" src="<?= $BASE_URL ?>assets/img/perfil/<?= $dadosUsuario->imagem ?>" alt="Imagem do usuário" />
                    <p>Total de postagens: <?= $totalPostagens ?></p>
                    <p>Curtidas: <?= $totalCurtidas ?></p>
                    <p>Seguidores: <?= $totalSeguidores ?></p>
                </div>
                <a class="perfil-editar" style="place-self: center" href="<?= $BASE_URL ?>editarperfil.php">Editar</a>
            </div>
            <div class="perfil-bio">
                <h3><?= $dadosUsuario->nome ?></h3>
                <p><?= $dadosUsuario->bio ?></p>
            </div>
        </div>
    </div>
    <h3 style="margin: 25px 0" class="">Postagens</h3>
    <div>
        <a class="usuario-add" href="<?= $BASE_URL ?>adicionar_postagem.php">Adicionar postagem</a>
        <?php require_once ("postagem-lista.php") ?>
    </div>
</section>
<?php require_once ("./templates/footer.php")?>