<?php
    require_once ("./config/conn.php");
    require_once ("./config/url.php");
    require_once ("./templates/header.php");
?>
    <section class="container auth-container min-height">
        <div class="auth-div auth-content">
            <h2>Entrar</h2>
            <form class="auth-form" method="post" action="<?= $BASE_URL ?>auth_process.php">
                <input type="hidden" name="type" value="entrar" />
                <div class="auth-info">
                    <label for="emailEntrar">Nome</label>
                    <input type="email" id="emailEntrar" name="emailEntrar" />
                </div>
                <div class="auth-info">
                    <label for="senhaEntrar">Senha</label>
                    <input type="password" id="senhaEntrar" name="senhaEntrar" />
                </div>
                <button class="auth-btn" type="submit">Entrar</button>
            </form>
        </div>
        <div class="auth-div auth-content">
            <h2>Cadastrar</h2>
            <form class="auth-form" method="post" action="<?= $BASE_URL ?>auth_process.php">
                <input type="hidden" name="type" value="cadastrar" />
                <div class="auth-info">
                    <label for="nomeCadastrar">Nome</label>
                    <input type="text" id="nomeCadastrar" name="nomeCadastrar" />
                </div>
                <div class="auth-info">
                    <label for="emailCadastrar">Email</label>
                    <input type="email" id="emailCadastrar" name="emailCadastrar" />
                </div>
                <div class="auth-info">
                    <label for="senhaCadastrar">Senha</label>
                    <input type="password" id="senhaCadastrar" name="senhaCadastrar" />
                </div>
                <div class="auth-info">
                    <label for="confirmarSenha">Confirmar senha</label>
                    <input type="password" id="confirmarSenha" name="confirmarSenha" />
                </div>
                <button class="auth-btn" type="submit">Cadastrar</button>
            </form>
        </div>
    </section>
<?php require_once ("./templates/footer.php")?>