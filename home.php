<?php
session_start();

require_once 'db/conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit();
}

$busca = $_GET['busca'] ?? '';

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
    <link rel="stylesheet" href="css/home.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif
        }

        body {
            background: #fff
        }

        header {
            height: 120px;
            background: #032b5c;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px
        }

        .botao-menu {
            font-size: 25px;
            color: #fff
        }

        .cards {
            display: flex;
            gap: 20px;
            margin: 30px
        }

        .card,
        .livros,
        .acoes {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08)
        }

        .card {
            flex: 1;
            text-align: center
        }

        .card h3 {
            color: #032b5c;
            font-size: 32px
        }

        .container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin: 30px
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px
        }

        th,
        td {
            padding: 15px;
            border-bottom: 1px solid #ddd
        }

        .botao-acao {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 18px;
            margin-top: 15px;
            text-decoration: none;
            color: #032b5c;
            background: #f5f5f5;
            border-radius: 10px;
        }

        .vazio {
            text-align: center;
            padding: 80px 0
        }

        .vazio p {
            color: #032b5c;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <?php include 'includes/sidebar.php' ?>
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
            <a href="cadastrar.php" class="botao-acao">
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