CREATE DATABASE biblioteca;

CREATE TABLE livros (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    genero VARCHAR(100) NOT NULL,
    ano_publicacao INT NOT NULL,

    status_livro VARCHAR(20) DEFAULT 'Disponível'
        CHECK (status_livro IN ('Disponível', 'Emprestado'))
);

CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
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
    'Ficção',
    1949,
    'Emprestado'
);

INSERT INTO usuarios (
    nome,
    email,
    senha
)
VALUES
(
    'Pedro Lanaro',
    'pedro.lanaro@gmail.com',
    'senha123'
);

SELECT * FROM livros;