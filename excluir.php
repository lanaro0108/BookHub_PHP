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

        .botao-menu {
            font-size: 25px;
            color: #fff
        }

        .container-main {
            margin: 30px;
        }

        .container-confirmacao {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08)
        }

        .container-confirmacao h2 {
            color: #032b5c;
            margin-bottom: 25px;
            text-align: center;
        }

        .info-livro {
            background: #f9f9f9;
            border-left: 4px solid #c41e3a;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 30px;
        }

        .info-livro p {
            margin: 8px 0;
            color: #333;
        }

        .info-livro strong {
            color: #032b5c;
        }

        .aviso {
            background: #ffe5e5;
            border: 1px solid #ff9999;
            color: #c41e3a;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }

        .tabela-livros {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08)
        }

        .tabela-livros h2 {
            color: #032b5c;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f5f5f5;
            font-weight: 600;
            color: #032b5c;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .btn-remover {
            display: inline-block;
            padding: 6px 12px;
            background: #c41e3a;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
        }

        .btn-remover:hover {
            opacity: 0.9;
        }

        .form-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            height: 42px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s ease;
        }

        .btn-deletar {
            background: #c41e3a;
            color: #fff;
        }

        .btn-deletar:hover {
            opacity: 0.9;
        }

        .btn-cancelar {
            background: #f5f5f5;
            color: #032b5c;
        }

        .btn-cancelar:hover {
            opacity: 0.8;
        }

        .mensagem {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }

        .erro {
            background: #ffe5e5;
            color: #c41e3a;
            border: 1px solid #ff9999;
        }

        .sucesso {
            background: #e5ffe5;
            color: #1e7e1e;
            border: 1px solid #99ff99;
        }

        .vazio {
            text-align: center;
            padding: 40px 0;
            color: #032b5c;
        }
    </style>
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
