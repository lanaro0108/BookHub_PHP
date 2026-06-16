<?php
// Inicializa sessão, garante autenticação e executa consultas para o dashboard.
session_start();

require_once 'db/conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit();
}

// Obtém termo de busca, se fornecido.
$busca = $_GET['busca'] ?? '';

// Consultas sumarizadas para estatísticas no painel.
$total = $pdo->query("SELECT COUNT(*) FROM livros")->fetchColumn();

$disponiveis = $pdo->query("
SELECT COUNT(*)
FROM livros
WHERE status_livro = 'Disponível'
")->fetchColumn();

$emprestados = $pdo->query("
SELECT COUNT(*)
FROM livros
WHERE status_livro = 'Emprestado'
")->fetchColumn();

// Consulta de listagem de livros com filtro de busca.
$sql = "
SELECT *
FROM livros
WHERE titulo ILIKE :busca
OR autor ILIKE :busca
ORDER BY id DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':busca' => "%$busca%"
]);

$livros = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>BookHub</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php include 'includes/header.php' ?>
    <?php include 'includes/sidebar.php' ?>
    <div style="margin: 30px;">
        <h2>Olá, <?= htmlspecialchars($_SESSION['nome_usuario'], ENT_QUOTES, 'UTF-8') ?>!</h2>
    </div>
    <div class="cards">
        <div class="card">
            <h3><?= $total ?></h3>
            <span>Total de livros</span>
        </div>
        <div class="card">
            <h3><?= $disponiveis ?></h3>
            <span>Disponíveis</span>
        </div>
        <div class="card">
            <h3><?= $emprestados ?></h3>
            <span>Emprestados</span>
        </div>
    </div>

    <div class="container">
        <div class="livros">
            <h2>Livros cadastrados</h2>
            <?php if (count($livros) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($livros as $livro):
                            echo "<tr>";
                            echo "<td>" . $livro['titulo'] . "</td>";
                            echo "<td>" . $livro['autor'] . "</td>";
                            echo "<td>" . $livro['status_livro'] . "</td>";
                            echo "</tr>";
                        endforeach; ?>
                    </tbody>
                </table>

            <?php else: ?>
                <div class="vazio">
                    <p>Nenhum livro cadastrado</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="acoes">
            <h2>Ações</h2>
            <a href="add_livro.php" class="botao-acao">
                Adicionar livro
            </a>
            <a href="editar.php" class="botao-acao">
                Editar livro
            </a>
            <a href="excluir.php" class="botao-acao">
                Remover livro
            </a>
        </div>
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