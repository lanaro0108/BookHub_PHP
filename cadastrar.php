<?php
session_start();
require_once 'db/conexao.php';

$erro = '';
$sucesso = '';
$nome = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = 'Preencha todos os campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Informe um e-mail válido.';
    } else {
        $sql = 'SELECT id FROM usuarios WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->fetch()) {
            $erro = 'Este e-mail já está cadastrado.';
        } else {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = 'INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senhaHash);

            if ($stmt->execute()) {
                // Redireciona para a página de login após cadastro bem-sucedido
                header('Location: index.php');
                exit();
            } else {
                $erro = 'Erro ao realizar cadastro.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro - BookHub</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            min-height: 100vh;
            background: #fff;
        }

        .login-container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .login-box {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #fff;
        }

        .login-box img {
            width: 250px;
        }

        .login-box form {
            width: 320px;
        }

        .login-box label {
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
            color: #111;
            font-weight: 500;
        }

        .login-box input,
        .login-box button {
            width: 100%;
            height: 42px;
            padding: 0 15px;
            border-radius: 10px;
            outline: none;
        }

        .login-box input {
            border: 1px solid #d4d4d4;
            margin-bottom: 20px;
            background: #fff;
        }

        .login-box input:focus {
            border-color: #032b5c;
        }

        .login-box button {
            border: none;
            background: #032b5c;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
        }

        .login-box button:hover {
            opacity: .9;
        }

        .erro {
            margin-top: 15px;
            color: red;
            text-align: center;
        }

        .sucesso {
            margin-top: 15px;
            color: green;
            text-align: center;
        }

        .link-login {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #333;
        }

        .link-login a,
        .botao-cadastro {
            color: #032b5c;
            font-weight: 700;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            transition: color 0.2s ease, border-color 0.2s ease;
        }

        .link-login a:hover,
        .botao-cadastro:hover {
            color: #021f47;
            border-bottom-color: #032b5c;
        }

        .banner {
            width: 50%;
            background: url("assets/banner.png") center center;
            background-size: cover;
        }

        @media(max-width:900px) {
            .banner {
                display: none;
            }

            .login-box {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <img src="assets/LogoLightTransparente.png" alt="BookHub">
            <form method="POST">
                <label>Nome</label>
                <input type="text" name="nome" placeholder="Digite seu nome" value="<?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>" required>

                <label>E-mail</label>
                <input type="email" name="email" placeholder="Digite seu e-mail" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required>

                <label>Senha</label>
                <input type="password" name="senha" placeholder="Crie uma senha" required>

                <button type="submit">Cadastrar</button>

                <?php if ($erro): ?>
                    <div class="erro"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>

                <?php if ($sucesso): ?>
                    <div class="sucesso"><?= htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>

                <div class="link-login">
                    Já possui conta?
                    <a href="index.php" class="botao-cadastro">Entrar</a>
                </div>
            </form>
        </div>

        <div class="banner"></div>
    </div>
</body>

</html>