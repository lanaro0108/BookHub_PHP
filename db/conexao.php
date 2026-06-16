<?php
// Configura e inicializa a conexão PDO com o banco de dados PostgreSQL.
$host = 'localhost';
$port = '5432';
$dbname = 'bookhub';
$user = 'postgres';
$password = 'postgres';

// Data Source Name (DSN) utilizado pelo PDO para estabelecer a conexão.
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname"; 
// Data Source Name, é a string de conexão que o PDO usa para se conectar ao banco de dados

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Configura o modo de busca para associativo, isso facilita o acesso aos dados pq usa os nomes das colunas
    ]);
} catch (PDOException $e) {
    die('Erro de conexão: ' . $e->getMessage()); // Em caso de erro, a mensagem de erro é exibida e a aplicação para
}
?>