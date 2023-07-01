<?php
    require_once ("./templates/header.php");
    require_once ("./dao/UsuarioDAO.php");
    require_once ("./dao/PostagemDAO.php");
    $id = $_GET["id"];



    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);
    $postagemDao = new PostagemDAO($conn, $BASE_URL);
    $dadosUsuario = $usuarioDao->verifyToken();

    $dadosPerfilAutor = $usuarioDao->findById($id);
    $postagensAutor = $postagemDao->getPostagensUsuario($dadosPerfilAutor->id);

    if($dadosPerfilAutor->imagem == NULL) {
        $dadosPerfilAutor->imagem = "user.png";
    }

    $totalCurtidas = $postagemDao->getTotalCurtidas($dadosPerfilAutor->id);
    $totalPostagens = $postagemDao->getTotalPostagens($dadosPerfilAutor->id);
    $totalSeguidores = $usuarioDao->getTotalSeguidores($dadosPerfilAutor->id);
?>
<section class="container min-height">
    <h2 style="margin: 20px 0;">Perfil do Usuário</h2>
    <div>
        <div class="perfil-info">
            <div class="perfil-status">
                <div class="perfil-status-usuario">
                    <img style="width: 60px; height: 60px;" src="<?= $BASE_URL ?>assets/img/perfil/<?= $dadosPerfilAutor->imagem ?>" alt="Imagem do usuário" />
                    <p>Total de postagens: <?= $totalPostagens ?></p>
                    <p>Curtidas: <?= $totalCurtidas ?></p>
                    <p>Seguidores: <?= $totalSeguidores ?></p>
                </div>
            </div>
            <div class="perfil-bio">
                <h3><?= $dadosPerfilAutor->nome ?></h3>
                <p><?= $dadosPerfilAutor->bio ?></p>
            </div>
        </div>
    </div>
    <h3 style="margin: 25px 0" class="">Postagens</h3>
    <div>
        <a class="usuario-add" href="<?= $BASE_URL ?>seguir_usuario.php?id=<?= $dadosPerfilAutor->id?>">Seguir ciclista!</a>
        <div class="perfil-postagens">
            <?php foreach ($postagensAutor as $postagem): ?>
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
    </div>
</section>
<?php
    require_once ("./templates/footer.php");
?>
