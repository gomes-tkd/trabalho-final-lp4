<?php
    require_once ("./templates/header.php");
?>
    <main class="container container-index">
            <div class="intro">
                <h1>Bem-vindo(a) Ciclista</h1>
                <p>
                    A Bikcraft é uma rede social pensada em pessoas como tu apaixonadas pelo pedal.
                    Venha fazer parte desta família e compartilhe seus melhores momentos com todos!
                </p>
                <a class="usuario-btn" href="<?= $BASE_URL ?>auth.php">Login | Cadastrar</a>
            </div>
            <img src="<?= $BASE_URL ?>assets/img/logo/index.jpg" alt="Pessoa para em cima de uma bicicleta" />
    </main>
<?php require_once ("./templates/footer.php")?>