<?php
    require_once ("./templates/header.php");
?>

    <section class="container add-postagem-container">
        <h3 class="subtitulo">Poste seu momento!</h3>
        <form
            class="border-container"
            action="<?= $BASE_URL?>adicionar_postagem_process.php"
            method="POST" enctype="multipart/form-data"
        >
            <input type="hidden" name="id-usuario" value="<?= $dadosUsuario->id?>" />
            <input type="hidden" id="type" name="type" value="postar" />
                <div class="postagem-dados">
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo" />
                </div>
                <div class="postagem-dados">
                    <label for="descricao">Descreva o momento</label>
                    <textarea name="descricao" id="descricao" cols="30" rows="10"></textarea>
                </div>
                <div>
                    <label for="imagem">Selecione a imagem</label>
                    <input type="file" id="imagem" name="imagem" />
                </div>
            <button class="usuario-btn" type="submit">Postar!</button>
        </form>
        <div>
            <img id="preview-image" src="" alt="Imagem da postagem" />
        </div>
    </section>
<?php
    require_once ("./templates/footer.php");
?>
