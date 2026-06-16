<?php
// Inicializa sessão, conecta ao banco e processa o cadastro de novos usuários.
session_start();
require_once 'db/conexao.php';

$erro = '';
$sucesso = '';
$nome = '';
$email = '';

// Processa submissão do formulário de cadastro.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Valida campos e formato de e-mail.
    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = 'Preencha todos os campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Informe um e-mail válido.';
    } else {
        // Verifica se o e-mail já está cadastrado.
        $sql = 'SELECT id FROM usuarios WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->fetch()) {
            $erro = 'Este e-mail já está cadastrado.';
        } else {
            // Insere novo usuário com senha hash.
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = 'INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senhaHash);

            if ($stmt->execute()) {
                // Redireciona para a página de login após cadastro bem-sucedido
                $mensagem = urlencode('Cadastro realizado com sucesso! Faça login.');
                header('Location: index.php?sucesso=' . $mensagem . '&email=' . urlencode($email));
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
    <link rel="stylesheet" href="css/styles.css">
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