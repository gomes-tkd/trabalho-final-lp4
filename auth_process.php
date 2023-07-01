<?php
    require_once ("./config/conn.php");
    require_once ("./config/url.php");
    require_once ("./models/Usuario.php");
    require_once ("./models/Mensagem.php");
    require_once ("./dao/UsuarioDAO.php");

    $type = filter_input(INPUT_POST, "type");

    $usuarioDao = new UsuarioDAO($conn, $BASE_URL);
    $msg = new Mensagem($BASE_URL);

    if ($type === "entrar") {
        $email = filter_input(INPUT_POST, "emailEntrar");
        $senha = filter_input(INPUT_POST, "senhaEntrar");

        if ($usuarioDao->authUsuario($email, $senha)) {
            $msg->setMensagem("Seja bem-vindo!", "success", "perfil.php");
        } else {
            $msg->setMensagem("Email ou senha inválidos!", "error", "auth.php");
        }

    }

    if ($type === "cadastrar") {
        $nome = filter_input(INPUT_POST, "nomeCadastrar");
        $email = filter_input(INPUT_POST, "emailCadastrar");
        $senha = filter_input(INPUT_POST, "senhaCadastrar");
        $confirmarSenha = filter_input(INPUT_POST, "confirmarSenha");

        if ($senha === $confirmarSenha) {
            if (!$usuarioDao->findByEmail($email)) {
                $usuario = new Usuario();
                $senhaUsuario = password_hash($senha, PASSWORD_DEFAULT);
                $tokenUsuario = $usuario->generateToken();

                $usuario->nome = $nome;
                $usuario->email = $email;
                $usuario->senha = $senhaUsuario;
                $usuario->token = $tokenUsuario;
                $usuario->seguidores = 0;
                $usuario->postagens = 0;
                $usuario->curtidas = 0;

                $usuarioDao->create($usuario, true);

            } else {
                $msg->setMensagem("Email já cadastrado!", "error", "back");
            }
        } else {
            $msg->setMensagem("As senhas devem ser iguais!", "error", "back");
        }
    }

?>