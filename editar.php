<?php
// Inicializa a sessão, carrega a conexão com o banco de dados e prepara o ambiente para processar operações de edição de livros.
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

// Trata submissão do formulário de edição quando um ID de livro é fornecido.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
    $titulo = trim($_POST['titulo'] ?? ''); // Trim para remover espaços extras
    $autor = trim($_POST['autor'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $ano_publicacao = trim($_POST['ano_publicacao'] ?? '');
    $status_livro = trim($_POST['status_livro'] ?? 'Disponível');

    // Validação dos campos do formulário
    if (empty($titulo) || empty($autor) || empty($genero) || empty($ano_publicacao)) {
        $erro = 'Preencha todos os campos.';
    } elseif (!is_numeric($ano_publicacao) || $ano_publicacao < 1000 || $ano_publicacao > date('Y')) {
        $erro = 'Ano de publicação inválido.';
    } else {
        // Atualiza o registro do livro no banco de dados utilizando parâmetros preparados.
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

// Quando um ID é fornecido, recupera os dados do livro específico para edição.
if ($id) {
    $sql = 'SELECT * FROM livros WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $livro = $stmt->fetch();
    
    if (!$livro) {
        $erro = 'Livro não encontrado.';
    }
} else {
    // Caso contrário, lista todos os livros para seleção.
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
    <link rel="stylesheet" href="css/styles.css">
</head>
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
    <?php
    // Inclui o cabeçalho compartilhado da aplicação.
    include 'includes/header.php';
    // Inclui a barra lateral com o menu de navegação.
    include 'includes/sidebar.php';
    ?>

    <div class="container-main">
        <?php // Exibe o formulário de edição quando um livro foi selecionado
        if ($livro): ?>
            <div class="container-formulario">
                <h2>Editar Livro</h2>

                <?php // Exibe mensagem de erro quando aplicável
                if ($erro): ?>
                    <div class="mensagem erro"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>

                <?php // Exibe mensagem de sucesso quando aplicável
                if ($sucesso): ?>
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
        <?php // Caso nenhum livro esteja selecionado, exibe a lista para escolha
        else: ?>
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