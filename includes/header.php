<style>
    .header {
        height: 120px;
        background: #032b5c;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 35px;
        border: none;
        box-shadow: none;
    }

    .botao-menu {
        color: white;
        font-size: 28px;
        cursor: pointer;
    }

    .logo-cabecalho {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-cabecalho img {
        width: 150px;
    }

    .search-form {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search-form input {
        width: 220px;
        background: transparent;
        border: none;
        border-bottom: 1px solid rgba(255, 255, 255, .4);
        color: white;
        padding: 8px;
        outline: none;
    }

    .search-form input::placeholder {
        color: #d1d1d1;
    }

    .search-form button {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
    }
</style>

<header class="header">
    <div class="botao-menu" onclick="toggleSidebar()">
        ☰
    </div>
    <div class="logo-cabecalho">
        <a href="home.php">
            <img src="assets/LogoDarkTransparente.png" alt="BookHub">
        </a>
    </div>
    <form class="search-form" method="GET" action="home.php">
        <input
            type="text"
            name="busca"
            placeholder="Pesquisar...">
        <button type="submit">
            <img src="assets/icon_lupa.png" alt="Pesquisar" width="16">
        </button>
    </form>
</header>