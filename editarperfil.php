<?php
    require_once ("./templates/header.php");
    require_once ("./dao/UsuarioDAO.php");

    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);
    $usuarioDados = $usuarioDao->verifyToken();
?>
<section class="container edit-perfil-container min-height">
    <h2 class="edit-perfil-subtitulo">Editar perfil</h2>
    <div class="border-container">
        <h3>Atualizar</h3>
        <form class="edit-perfil-form" method="post" action="<?= $BASE_URL ?>editprofile_process.php">
            <input type="hidden" id="dados" name="type" value="dados" />
            <input type="hidden" id="id-usuario" name="id-usuario" value="<?=$usuarioDados->id?>" />
            <div class="edit-perfil-dados">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value="<?= $usuarioDados->nome ?>" />
            </div>
            <div class="edit-perfil-dados">
                <label for="email">Email</label>
                <input type="text" id="nome" name="email" value="<?= $usuarioDados->email ?>" />
            </div>
            <div class="edit-perfil-bio">
                <label for="bio">Bio</label>
                <textarea name="bio" id="bio" cols="30" rows="16"><?= $usuarioDados->bio ?></textarea>
            </div>
            <button style="place-self: center" class="usuario-btn" type="submit">Atualizar Dados</button>
        </form>
    </div>
    <div class="border-container">
        <h3>Imagem</h3>
        <div class="">
            <img id="preview-image" src="<?= $BASE_URL ?>assets/img/perfil/<?= $usuarioDados->imagem; ?>" alt="Imagem do usuário" />
        </div>
        <form class="edit-perfil-form" method="post" action="<?= $BASE_URL ?>editprofile_process.php" enctype="multipart/form-data">
            <input type="hidden" id="dados" name="type" value="imagem" />
            <input type="hidden" id="id-usuario" name="id-usuario" value="<?=$usuarioDados->id?>" />
            <div class="">
                <label for="imagem">Selecione a imagem</label>
                <input type="file" id="imagem" name="imagem" />
            </div>
            <button class="usuario-btn" type="submit">Atualizar Dados</button>
        </form>
    </div>
    <div class="border-container edit-perfil-senha-posicao">
        <h3>Senha</h3>
        <form class="edit-perfil-form" method="post" action="<?= $BASE_URL ?>editprofile_process.php">
            <input type="hidden" id="dados" name="type" value="senha" />
            <input type="hidden" id="id-usuario" name="id-usuario" value="<?=$usuarioDados->id?>" />
            <div class="edit-perfil-senha-container">
                    <div class="edit-perfil-senha-dados">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" />
                    </div>
                    <div class="edit-perfil-senha-dados">
                        <label for="confirmarSenha">Confirmar senha</label>
                        <input type="password" id="confirmarSenha" name="confirmarSenha" />
                    </div>
            </div>
            <button class="usuario-btn" type="submit">Atualizar Dados</button>
        </form>
    </div>
</section>
<?php require_once ("./templates/footer.php")?>