<style>
    .sidebar {
        position: fixed;
        top: 0;
        left: -260px;
        width: 260px;
        height: 100vh;
        background: #032b5c;
        transition: .3s;
        z-index: 1000;
        padding-top: 30px;
    }

    .sidebar.active {
        left: 0;
    }

    .sidebar-close {
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

    .sidebar-close:hover {
        background: rgba(255, 255, 255, .25);
    }

    .sidebar-logo {
        text-align: center;
        margin-bottom: 40px;
    }

    .sidebar-logo img {
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
        transition: .3s;
    }

    .sidebar ul li a:hover {
        background: rgba(255, 255, 255, .1);
    }

    .sidebar i {
        width: 20px;
    }
</style>

<div class="sidebar" id="sidebar">
    <button type="button" class="sidebar-close" onclick="toggleSidebar()">←</button>
    <div class="sidebar-logo">
        <img src="assets/LogoDarkTransparente.png" alt="BookHub">
    </div>
    <ul>
        <li>
            <a href="home.php">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="cadastrar.php">
                <i class="fa-solid fa-plus"></i>
                Cadastrar Livro
            </a>
        </li>
        <li>
            <a href="editar.php">
                <i class="fa-solid fa-pen"></i>
                Editar Livro
            </a>
        </li>
        <li>
            <a href="excluir.php">
                <i class="fa-solid fa-trash"></i>
                Remover Livro
            </a>
        </li>
        <li>
            <a href="logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Sair
            </a>
        </li>
    </ul>
</div>