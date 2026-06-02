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

    .menu-btn {
        color: white;
        font-size: 28px;
        cursor: pointer;
    }

    .logo {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .logo img {
        width: 150px;
        margin-bottom: 5px;
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search-box input {
        width: 220px;
        background: transparent;
        border: none;
        border-bottom: 1px solid rgba(255, 255, 255, .4);
        color: white;
        padding: 8px;
        outline: none;
    }

    .search-box input::placeholder {
        color: #d1d1d1;
    }

    .search-box button {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
    }
</style>

<header class="header">
    <div class="menu-btn" onclick="toggleSidebar()">
        ☰
    </div>
    <div class="logo">
        <img src="assets/LogoDarkTransparente.png" alt="Logo">
    </div>
    <form class="search-box" method="GET" action="home.php">
        <input
            type="text"
            name="busca"
            placeholder="Pesquisar...">
        <button type="submit">
            <img src="assets/icon_lupa.png" alt="Pesquisar" width="16">
        </button>
    </form>
</header>