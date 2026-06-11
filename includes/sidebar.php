<style>
    .sidebar {
        position: fixed;
        top: 0;
        left: -260px;
        width: 260px;
        height: 100vh;
        background: #032b5c;
        z-index: 1000;
        padding-top: 30px;
    }

    .sidebar.active {
        left: 0;
    }

    .fechar-sidebar {
        position: absolute;
        top: 14px;
        left: 14px;
        width: 28px;
        height: 28px;
        border: none;
        border-radius: 50%;
        background: rgba(255, 255, 255, .15);
        color: #fff;
        font-size: 18px;
        line-height: 28px;
        cursor: pointer;
    }

    .logo-sidebar {
        text-align: center;
        margin-bottom: 40px;
    }

    .logo-sidebar img {
        width: 120px;
    }

    .sidebar ul {
        list-style: none;
    }

    .sidebar ul li {
        margin: 10px 0;
    }

    .sidebar ul li a {
        display: flex;
        align-items: center;
        gap: 12px;

        padding: 15px 25px;
        color: white;
        text-decoration: none;
    }
</style>

<div class="sidebar" id="sidebar">
    <button type="button" class="fechar-sidebar" onclick="toggleSidebar()">←</button>
    <div class="logo-sidebar">
        <img src="assets/LogoDarkTransparente.png" alt="BookHub">
    </div>
    <ul>
        <li>
            <a href="home.php">
                Dashboard
            </a>
        </li>
        <li>
            <a href="add_livro.php">
                Cadastrar livro
            </a>
        </li>
        <li>
            <a href="editar.php">
                Editar livro
            </a>
        </li>
        <li>
            <a href="excluir.php">
                Remover livro
            </a>
        </li>
        <li>
            <a href="logout.php">
                Sair
            </a>
        </li>
    </ul>
</div>