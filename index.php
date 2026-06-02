<?php
session_start();
require_once 'db/conexao.php';

if (isset($_SESSION['id_usuario'])) {
    header('Location: home.php');
    exit();
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $sql = "SELECT * FROM usuarios WHERE email = :email"; // Procura o usuário pelo email

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch();

    if ($usuario && $senha === $usuario['senha']) {
        $_SESSION['id_usuario'] = $usuario['id'];
        $_SESSION['nome_usuario'] = $usuario['nome'];
        header('Location: home.php');
        exit();
    }

    $erro = "E-mail ou senha inválidos."; // Se chegar aqui, é pq o login falhou
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login - BookHub</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif
        }

        body {
            min-height: 100vh;
            background: #fff
        }

        .login-container {
            display: flex;
            width: 100%;
            height: 100vh
        }

        .login-box {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #fff
        }

        .login-box img {
            width: 250px
        }

        .login-box form {
            width: 320px
        }

        .login-box label {
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
            color: #111;
            font-weight: 500
        }

        .login-box input,
        .login-box button {
            width: 100%;
            height: 42px;
            padding: 0 15px;
            border-radius: 10px;
            outline: none
        }

        .login-box input {
            border: 1px solid #d4d4d4;
            margin-bottom: 25px;
            background: #fff
        }

        .login-box input:focus {
            border-color: #032b5c
        }

        .login-box input::placeholder {
            color: #cfcdcc
        }

        .login-box button {
            border: none;
            background: #032b5c;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: .3s
        }

        .login-box button:hover {
            background: #eee;
            color: #032b5c
        }

        .erro {
            margin-top: 15px;
            color: red;
            text-align: center
        }

        .banner {
            width: 50%;
            background: url("../assets/banner.png") center/cover
        }

        @media(max-width:900px) {
            .banner {
                display: none
            }

            .login-box {
                width: 100%
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <img src="assets/LogoLightTransparente.png" alt="BookHub">
            <form method="POST">
                <label>Email</label>
                <input type="email" name="email" placeholder="Insira seu email...">

                <label>Senha</label>
                <input type="password" name="senha" placeholder="Insira sua senha...">

                <button type="submit">Entrar</button>
                <?php if ($erro): ?>
                    <div class="erro"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </form>
        </div>
        <div class="banner"></div>
    </div>
</body>

</html>