# BookHub - Sistema de Gerenciamento de Biblioteca

**Versão:** 1.0.0

**Data:** 28/05/2026

**Autor:** Pedro Lanaro

Sistema web para gerenciamento de bibliotecas, permitindo autenticação de usuários, cadastro, edição, exclusão e pesquisa de livros, além de controle de disponibilidade.

---

## Índice

* Instalação
* Configuração do Banco de Dados
* Como Executar
* Estrutura do Projeto
* Funcionalidades
* Páginas e Rotas
* Tecnologias Utilizadas
* Configurações Adicionais
* Troubleshooting

---

# Instalação

## 1. Clone o repositório

```bash
git clone https://github.com/lanaro0108/BookHub_PHP.git
cd BookHub_PHP
```

## 2. Verifique os requisitos

* PHP 7.4 ou superior
* PostgreSQL 12 ou superior
* Extensão PDO PostgreSQL habilitada

---

# Configuração do Banco de Dados

## 1. Crie um banco vazio

```sql
CREATE DATABASE bookhub;
```

## 2. Restaure o arquivo de backup

Dentro da pasta do projeto:

```bash
psql -U postgres -d bookhub -f dump.sql
```

ou

```bash
psql -U postgres bookhub < dump.sql
```

## 3. Verifique a restauração

Conecte-se ao banco:

```bash
psql -U postgres -d bookhub
```

Liste as tabelas:

```sql
\dt
```

Resultado esperado:

```text
livros
usuarios
```

Verifique os usuários cadastrados:

```sql
SELECT * FROM usuarios;
```

O arquivo `dump.sql` já contém toda a estrutura do banco de dados (tabelas, sequências, constraints e dados de exemplo). Não é necessário executar um arquivo `schema.sql`.

---

# Como Executar

## Utilizando o servidor embutido do PHP

No diretório do projeto:

```bash
php -S localhost:8000
```

Abra o navegador:

```text
http://localhost:8000
```

---

# Estrutura do Projeto

```text
BookHub/
├── index.php
├── cadastrar.php
├── home.php
├── add_livro.php
├── editar.php
├── excluir.php
├── logout.php
├── db/
│   └── conexao.php
├── includes/
│   ├── header.php
│   └── sidebar.php
├── assets/
├── css/
│   └── styles.css
├── dump.sql
└── README.md
```

---

# Configuração da Conexão

Arquivo:

```text
db/conexao.php
```

Exemplo:

```php
$host = 'localhost';
$port = '5432';
$dbname = 'bookhub';
$user = 'postgres';
$password = 'postgres';
```

Altere os valores conforme sua instalação do PostgreSQL.

---

# Funcionalidades

## Autenticação

* Cadastro de usuários
* Login com validação de credenciais
* Senhas protegidas com `password_hash()`
* Encerramento seguro de sessão

## Gerenciamento de Livros

* Cadastro de livros
* Edição de informações
* Exclusão de registros
* Pesquisa por título ou autor
* Controle de disponibilidade

## Dashboard

* Total de livros
* Livros disponíveis
* Livros emprestados
* Listagem rápida do acervo

## Segurança

* Sessões protegidas
* Prepared Statements (PDO)
* Proteção contra SQL Injection
* Escape de saída com `htmlspecialchars()`

---

# Páginas e Rotas

| Página          | Rota             |
| --------------- | ---------------- |
| Login           | `/index.php`     |
| Cadastro        | `/cadastrar.php` |
| Dashboard       | `/home.php`      |
| Adicionar Livro | `/add_livro.php` |
| Editar Livro    | `/editar.php`    |
| Excluir Livro   | `/excluir.php`   |
| Logout          | `/logout.php`    |

---

# Tecnologias Utilizadas

| Tecnologia | Finalidade      |
| ---------- | --------------- |
| PHP        | Backend         |
| PostgreSQL | Banco de Dados  |
| HTML5      | Estrutura       |
| CSS3       | Estilização     |
| JavaScript | Interatividade  |
| PDO        | Acesso ao banco |

---

# Configurações Adicionais

### Alterar credenciais do banco de dados

Edite o arquivo `db/conexao.php`:

```php
$host = 'seu_host';
$port = 'sua_porta';
$dbname = 'seu_banco';
$user = 'seu_usuario';
$password = 'sua_senha';
```

### Alterar a porta do servidor PHP

```bash
php -S localhost:3000
```

---

# Troubleshooting

### Erro de conexão com o banco

Verifique:

* Se o PostgreSQL está em execução.
* Se as credenciais em `db/conexao.php` estão corretas.
* Se o banco `bookhub` foi criado e restaurado.

### Erro "relation does not exist"

Execute novamente:

```bash
psql -U postgres -d bookhub -f dump.sql
```

### Página em branco

Ative temporariamente a exibição de erros:

```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

### Porta já em uso

Inicie o servidor em outra porta:

```bash
php -S localhost:3000
```

---

Desenvolvido por Pedro Lanaro para facilitar o gerenciamento de bibliotecas.