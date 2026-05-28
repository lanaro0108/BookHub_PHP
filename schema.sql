CREATE DATABASE Biblioteca;

USE Biblioteca;

CREATE TABLE livros (
    id INT AUTO_INCREMENT PRIMARY KEY,

    titulo VARCHAR(100) NOT NULL,

    autor VARCHAR(100) NOT NULL,

    genero VARCHAR(100) NOT NULL,

    ano_publicacao INT NOT NULL,

    status_livro ENUM('Disponível', 'Emprestado')
    DEFAULT 'Disponível'
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL,

    email VARCHAR(100) NOT NULL UNIQUE,

    senha VARCHAR(255) NOT NULL
);

INSERT INTO livros (
    titulo,
    autor,
    genero,
    ano_publicacao,
    status_livro
)

VALUES
(
    'Dom Casmurro',
    'Machado de Assis',
    'Romance',
    1899,
    'Disponível'
),

(
    '1984',
    'George Orwell',
    'Ficção Científica',
    1949,
    'Emprestado'
);