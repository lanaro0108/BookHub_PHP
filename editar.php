<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
    $titulo = trim($_POST['titulo'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $ano_publicacao = trim($_POST['ano_publicacao'] ?? '');
    $status_livro = trim($_POST['status_livro'] ?? 'Disponível');

    if (empty($titulo) || empty($autor) || empty($genero) || empty($ano_publicacao)) {
        $erro = 'Preencha todos os campos.';
    } elseif (!is_numeric($ano_publicacao) || $ano_publicacao < 1000 || $ano_publicacao > date('Y')) {
        $erro = 'Ano de publicação inválido.';
    } else {
        $sql = 'UPDATE livros SET titulo = :titulo, autor = :autor, genero = :genero, ano_publicacao = :ano_publicacao, status_livro = :status_livro WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([
                ':titulo' => $titulo,
                ':autor' => $autor,
                ':genero' => $genero,
                ':ano_publicacao' => $ano_publicacao,
                ':status_livro' => $status_livro,
                ':id' => $id
            ]);
            $sucesso = 'Livro atualizado com sucesso!';
            header('Location: editar.php');
            exit();
        } catch (PDOException $e) {
            $erro = 'Erro ao atualizar livro.';
        }
    }
}

if ($id) {
    $sql = 'SELECT * FROM livros WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $livro = $stmt->fetch();
    
    if (!$livro) {
        $erro = 'Livro não encontrado.';
    }
} else {
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
    <title>Editar Livro - BookHub</title>
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

        .container-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .container-formulario {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08)
        }

        .container-formulario h2 {
            color: #032b5c;
            margin-bottom: 25px;
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

        .btn-editar {
            display: inline-block;
            padding: 6px 12px;
            background: #032b5c;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
        }

        .btn-editar:hover {
            opacity: 0.9;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #111;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            height: 42px;
            padding: 0 42px 0 15px;
            border: 1px solid #d4d4d4;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
            font-family: 'Segoe UI', sans-serif;
            background-position: right 18px center;
            background-repeat: no-repeat;
        }

        .form-group select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath fill='%23323232' d='M0 0l5 6 5-6z'/%3E%3C/svg%3E");
            background-size: 10px 6px;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #032b5c;
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

        .btn-submit {
            background: #032b5c;
            color: #fff;
        }

        .btn-submit:hover {
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

        @media (max-width: 900px) {
            .container-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php' ?>
    <?php include 'includes/sidebar.php' ?>

    <div class="container-main">
        <?php if ($livro): ?>
            <div class="container-formulario">
                <h2>Editar Livro</h2>

                <?php if ($erro): ?>
                    <div class="mensagem erro"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>

                <?php if ($sucesso): ?>
                    <div class="mensagem sucesso"><?= htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" id="titulo" name="titulo" placeholder="Digite o título do livro" required value="<?= htmlspecialchars($livro['titulo'], ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="form-group">
                        <label for="autor">Autor</label>
                        <input type="text" id="autor" name="autor" placeholder="Digite o nome do autor" required value="<?= htmlspecialchars($livro['autor'], ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="form-group">
                        <label for="genero">Gênero</label>
                        <input type="text" id="genero" name="genero" placeholder="Digite o gênero do livro" required value="<?= htmlspecialchars($livro['genero'], ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="form-group">
                        <label for="ano_publicacao">Ano de Publicação</label>
                        <input type="number" id="ano_publicacao" name="ano_publicacao" placeholder="Digite o ano de publicação" required min="1000" max="<?= date('Y') ?>" value="<?= htmlspecialchars($livro['ano_publicacao'], ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="form-group">
                        <label for="status_livro">Status</label>
                        <select id="status_livro" name="status_livro" required>
                            <option value="Disponível" <?= ($livro['status_livro'] === 'Disponível') ? 'selected' : '' ?>>Disponível</option>
                            <option value="Emprestado" <?= ($livro['status_livro'] === 'Emprestado') ? 'selected' : '' ?>>Emprestado</option>
                        </select>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn-submit">Salvar Alterações</button>
                        <a href="editar.php" class="btn btn-cancelar" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">Cancelar</a>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="tabela-livros">
                <h2>Selecione um Livro para Editar</h2>

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
                                    <td><a href="editar.php?id=<?= $l['id'] ?>" class="btn-editar">Editar</a></td>
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