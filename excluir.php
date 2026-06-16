<?php
// Inicializa sessão, carrega conexão e processa remoção de registros de livros.
session_start();
require_once 'db/conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit();
}

$erro = '';
$sucesso = '';
$livro = null;
$livros = [];

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Processa confirmação de exclusão quando o formulário é submetido.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
    $sql = 'DELETE FROM livros WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([':id' => $id]);
        $sucesso = 'Livro removido com sucesso!';
        header('Location: excluir.php');
        exit();
    } catch (PDOException $e) {
        $erro = 'Erro ao remover livro.';
    }
}

// Se um ID for informado, recupera os dados do livro para confirmação.
if ($id) {
    $sql = 'SELECT * FROM livros WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $livro = $stmt->fetch();
    
    if (!$livro) {
        $erro = 'Livro não encontrado.';
    }
} else {
    // Caso contrário, lista todos os livros disponíveis para remoção.
    $sql = 'SELECT * FROM livros ORDER BY titulo ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $livros = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Remover Livro - BookHub</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php include 'includes/header.php' ?>
    <?php include 'includes/sidebar.php' ?>

    <div class="container-main">
        <?php if ($livro): ?>
            <div class="container-confirmacao">
                <h2>Remover Livro</h2>

                <div class="aviso">
                    ⚠️ Esta ação é irreversível. Tem certeza que deseja remover este livro?
                </div>

                <div class="info-livro">
                    <p><strong>Título:</strong> <?= htmlspecialchars($livro['titulo'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Gênero:</strong> <?= htmlspecialchars($livro['genero'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Ano:</strong> <?= htmlspecialchars($livro['ano_publicacao'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($livro['status_livro'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>

                <form method="POST">
                    <div class="form-buttons">
                        <button type="submit" class="btn btn-deletar">Remover Livro</button>
                        <a href="excluir.php" class="btn btn-cancelar" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">Cancelar</a>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="tabela-livros">
                <h2>Selecione um Livro para Remover</h2>

                <?php if (count($livros) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Gênero</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($livros as $l): ?>
                                <tr>
                                    <td><?= htmlspecialchars($l['titulo'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($l['autor'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($l['genero'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><a href="excluir.php?id=<?= $l['id'] ?>" class="btn-remover">Remover</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="vazio">
                        <p>Nenhum livro cadastrado</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
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
