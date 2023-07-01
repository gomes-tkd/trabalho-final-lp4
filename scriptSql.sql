DROP DATABASE bicicletas;

CREATE DATABASE bicicletas;

USE bicicletas;

CREATE TABLE usuarios (
                          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                          nome VARCHAR(80),
                          email VARCHAR(100),
                          senha VARCHAR(300),
                          imagem VARCHAR(300),
                          postagens INT UNSIGNED,
                          seguidores INT UNSIGNED,
                          curtidas INT USIGNED,
                          bio VARCHAR(200),
                          token VARCHAR(300)
);

CREATE TABLE postagem (
                          id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                          titulo VARCHAR(100),
                          descricao VARCHAR(250),
                          imagem VARCHAR(300),
                          data_postagem VARCHAR(300),
                          curtidas INT UNSIGNED,
                          id_usuario INT UNSIGNED,
                          nome_autor VARCHAR(80),
                          FOREIGN KEY (id_usuario) references usuarios(id)
);

CREATE TABLE postagem_comentario (
                                     id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                     nome_autor VARCHAR (80),
                                     comentario VARCHAR (300),
                                     id_postagem INT UNSIGNED,
                                     data_comentario VARCHAR(300),
                                     FOREIGN KEY (id_postagem) references postagem(id)
);

SELECT * FROM postagem;

SELECT * FROM usuarios;

SELECT * FROM postagem_comentario;
