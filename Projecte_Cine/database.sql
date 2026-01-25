DROP DATABASE IF EXISTS cine_app;
CREATE DATABASE cine_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cine_app;

-- TAULA ROLS
CREATE TABLE rols (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nom_rol VARCHAR(50) NOT NULL UNIQUE
);

-- TAULA USUARIS
CREATE TABLE usuaris (
    id_usuari INT AUTO_INCREMENT PRIMARY KEY,
    id_rol INT NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    nom_usuari VARCHAR(50),
    data_registre DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_rol) REFERENCES rols(id_rol)
);

-- TAULA PEL·LÍCULES
CREATE TABLE pelicules (
    id_pelicula INT AUTO_INCREMENT PRIMARY KEY,
    titol VARCHAR(100) NOT NULL UNIQUE,
    genere VARCHAR(255) NOT NULL,
    director VARCHAR(100),
    any_estrena INT,
    sinopsi TEXT,
    puntuacio DECIMAL(3,1)
);

-- TAULA SEGUIMENT
CREATE TABLE seguiment (
    id_seguiment INT AUTO_INCREMENT PRIMARY KEY,
    id_usuari INT NOT NULL,
    id_pelicula INT NOT NULL,
    estat ENUM('Pendent', 'Vista') DEFAULT 'Pendent',
    comentari_personal VARCHAR(255),
    data_afegit DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuari) REFERENCES usuaris(id_usuari) ON DELETE CASCADE,
    FOREIGN KEY (id_pelicula) REFERENCES pelicules(id_pelicula) ON DELETE CASCADE,
    UNIQUE KEY uk_usuari_peli (id_usuari, id_pelicula)
);

-- INSERCIONS INICIALS
INSERT INTO rols (nom_rol) VALUES ('Usuari'), ('Moderador');

INSERT INTO usuaris (id_rol, email, password_hash, nom_usuari) VALUES
(1, 'usuari@cine.com', '$2a$12$s9TbVDxQXogQiAImlpMQY.tSqGnJB3VeMErgOUveLYF.GSkLXXYlC', 'Usuari1'),
(2, 'admin@cine.com', '$2a$12$hlANQwmPtY.0L3rBc71LKesYUFDEwhlvoMoFjAFOrLSORH5gVvhwa', 'Administrador');

INSERT INTO pelicules (titol, genere, director, any_estrena, puntuacio, sinopsi) VALUES 
('Inception', 'Ciència Ficció', 'Christopher Nolan', 2010, 8.8, 'Un lladre que roba secrets a través dels somnis.'),
('The Godfather', 'Drama', 'Francis Ford Coppola', 1972, 9.2, 'El control d''un imperi clandestí.'),
('Pulp Fiction', 'Acció', 'Quentin Tarantino', 1994, 8.9, 'Vides creuades de gàngsters.'),
('The Matrix', 'Ciència Ficció', 'Lana Wachowski', 1999, 8.7, 'La naturalesa real de la realitat.'),
('Parasite', 'Drama', 'Bong Joon-ho', 2019, 8.6, 'Discriminació de classe i cobdícia.'),
('The Dark Knight', 'Acció', 'Christopher Nolan', 2008, 9.0, 'El Joker sembra el caos a Gotham.'),
('Interstellar', 'Ciència Ficció', 'Christopher Nolan', 2014, 8.7, 'Viatge espacial a través d''un forat de cuc.'),
('The Shawshank Redemption', 'Drama', 'Frank Darabont', 1994, 9.3, 'Dos homes empresonats troben consol en la redempció.'),
('Schindler''s List', 'Històrica', 'Steven Spielberg', 1993, 9.0, 'Un empresari salva jueus durant l''Holocaust.'),
('Spirited Away', 'Animació', 'Hayao Miyazaki', 2001, 8.6, 'Una nena s''endinsa en un món d''esperits.'),
('The Silence of the Lambs', 'Thriller', 'Jonathan Demme', 1991, 8.6, 'Una agent del FBI busca l''ajuda d''un assassí caníbal.');

INSERT INTO seguiment (id_usuari, id_pelicula, estat, comentari_personal) VALUES 
(2, 1, 'Vista', 'Increïble, l''he vista 3 vegades.'),
(2, 2, 'Pendent', 'La tinc pendent des de fa anys.'),
(1, 3, 'Vista', 'Molt bona banda sonora.'),
(2, 5, 'Vista', 'Final inesperat.'),
(1, 4, 'Pendent', 'M''han dit que és un clàssic.'),
(1, 6, 'Vista', 'La millor de Batman.'),
(2, 7, 'Vista', 'Molt visual, m''ha encantat.'),
(1, 10, 'Vista', 'Màgica i visualment preciosa.'),
(2, 8, 'Pendent', 'Recomanada per un amic.'),
(1, 9, 'Vista', 'Molt dura però necessària.');