<?php
// Inicializa a sessão, carrega a conexão com o banco de dados
// e processa as requisições de autenticação de usuário.
session_start();
require_once 'db/conexao.php';

$erro = '';
$sucesso = '';
$email = '';

if (isset($_GET['sucesso'])) {
    $sucesso = trim($_GET['sucesso']);
}

if (isset($_GET['email'])) {
    $email = trim($_GET['email']);
}

// Processa submissão do formulário de login e autentica o usuário.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $sql = "SELECT * FROM usuarios WHERE email = :email"; // Procura o usuário pelo email
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch();

    // Verifica credenciais e inicializa variáveis de sessão em caso de sucesso.
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['id_usuario'] = $usuario['id'];
        $_SESSION['nome_usuario'] = $usuario['nome'];
        header('Location: home.php');
        exit();
    }

    $erro = "E-mail ou senha inválidos."; // Login inválido
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login - BookHub</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <img src="assets/LogoLightTransparente.png" alt="BookHub">
            <form method="POST">
                <label>Email</label>
                <input type="email" name="email" placeholder="Insira seu email..." value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">

                <label>Senha</label>
                <input type="password" name="senha" placeholder="Insira sua senha...">

                <button type="submit">Entrar</button>
                <?php if ($erro): ?>
                    <div class="erro"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
                <?php if ($sucesso): ?>
                    <div class="sucesso"><?= htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </form>
            <div class="cadastro">
                <p>Não possui conta?</p>
                <a href="cadastrar.php" class="botao-cadastro">
                    Cadastre-se
                </a>
            </div>
        </div>
        <div class="banner"></div>
    </div>
</body>
</html>