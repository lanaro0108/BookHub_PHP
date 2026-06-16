<?php
// Inicializa sessão, garante autenticação e processa a adição de novos livros.
session_start();
require_once 'db/conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit();
}

$erro = '';
$sucesso = '';

// Processa o envio do formulário para adicionar um novo livro.
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Método POST
    $titulo = trim($_POST['titulo'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $ano_publicacao = trim($_POST['ano_publicacao'] ?? '');
    $status_livro = trim($_POST['status_livro'] ?? 'Disponível');
    // trim() é usado para remover espaços em branco extras do início e do fim dos valores dos campos

    // Validação básica dos campos.
    if (empty($titulo) || empty($autor) || empty($genero) || empty($ano_publicacao)) { // Empty verifica se os campos estão vazios
        $erro = 'Preencha todos os campos.';
    } elseif (!is_numeric($ano_publicacao) || $ano_publicacao < 1000 || $ano_publicacao > date('Y')) {
        $erro = 'Ano de publicação inválido.';
    } else {
        // Insere novo registro de livro no banco de dados usando parâmetros preparados.
        $sql = 'INSERT INTO livros (titulo, autor, genero, ano_publicacao, status_livro) VALUES (:titulo, :autor, :genero, :ano_publicacao, :status_livro)';
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([ // execute() é usado para executar a consulta SQL com os parâmetros fornecidos
                ':titulo' => $titulo,
                ':autor' => $autor,
                ':genero' => $genero,
                ':ano_publicacao' => $ano_publicacao,
                ':status_livro' => $status_livro
            ]);
            $sucesso = 'Livro adicionado com sucesso!';
            $_POST = [];
        } catch (PDOException $e) {
            $erro = 'Erro ao adicionar livro.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="assets/Icone.png">
    <title>Adicionar Livro - BookHub</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php include 'includes/header.php' ?>
    <?php include 'includes/sidebar.php' ?>

    <div class="container-formulario">
        <h2>Adicionar Novo Livro</h2>

        <?php if ($erro): ?>
            <div class="mensagem erro"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <div class="mensagem sucesso"><?= htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" placeholder="Digite o título do livro" required value="<?= htmlspecialchars($_POST['titulo'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="form-group">
                <label for="autor">Autor</label>
                <input type="text" id="autor" name="autor" placeholder="Digite o nome do autor" required value="<?= htmlspecialchars($_POST['autor'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="form-group">
                <label for="genero">Gênero</label>
                <input type="text" id="genero" name="genero" placeholder="Digite o gênero do livro" required value="<?= htmlspecialchars($_POST['genero'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="form-group">
                <label for="ano_publicacao">Ano de Publicação</label>
                <input type="number" id="ano_publicacao" name="ano_publicacao" placeholder="Digite o ano de publicação" required min="1000" max="<?= date('Y') ?>" value="<?= htmlspecialchars($_POST['ano_publicacao'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="form-group">
                <label for="status_livro">Status</label>
                <select id="status_livro" name="status_livro" required>
                    <option value="Disponível" <?= (($_POST['status_livro'] ?? 'Disponível') === 'Disponível') ? 'selected' : '' ?>>Disponível</option>
                    <option value="Emprestado" <?= (($_POST['status_livro'] ?? '') === 'Emprestado') ? 'selected' : '' ?>>Emprestado</option>
                </select>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-submit">Adicionar Livro</button>
                <a href="home.php" class="btn btn-cancelar" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        function toggleSidebar() {
            document
                .getElementById("sidebar")
                .classList
                .toggle("active");
        }
    </script>
</body>

</html>