-- =============================================
-- GameZone — Torneig de Videojocs
-- =============================================

DROP DATABASE IF EXISTS gamezone;
CREATE DATABASE gamezone CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gamezone;

CREATE TABLE equips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    ciutat VARCHAR(50) NOT NULL,
    any_fundacio INT NOT NULL
);

CREATE TABLE jugadors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(50) NOT NULL,
    nom_real VARCHAR(100) NOT NULL,
    edat INT NOT NULL,
    id_equip INT NOT NULL,
    FOREIGN KEY (id_equip) REFERENCES equips(id)
);

CREATE TABLE partides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_equip_local INT NOT NULL,
    id_equip_visitant INT NOT NULL,
    punts_local INT NOT NULL,
    punts_visitant INT NOT NULL,
    data DATE NOT NULL,
    joc VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_equip_local) REFERENCES equips(id),
    FOREIGN KEY (id_equip_visitant) REFERENCES equips(id)
);

-- Equips
INSERT INTO equips (nom, ciutat, any_fundacio) VALUES
('Phoenix Esports', 'Barcelona', 2019),
('Barcelona Wolves', 'Barcelona', 2020),
('Madrid Thunder', 'Madrid', 2018),
('Valencia Storm', 'València', 2021),
('Sevilla Raptors', 'Sevilla', 2020),
('Bilbao Titans', 'Bilbao', 2019);

-- Jugadors
INSERT INTO jugadors (nickname, nom_real, edat, id_equip) VALUES
('Blaze', 'Marc Torres', 22, 1),
('Frost', 'Anna López', 19, 1),
('Shadow', 'Pau Garcia', 21, 1),
('Viper', 'Laura Martín', 23, 2),
('Storm', 'David Sánchez', 20, 2),
('Pixel', 'Clara Ruiz', 18, 2),
('Thunder', 'Javier Pérez', 24, 3),
('Byte', 'María Fernández', 21, 3),
('Ghost', 'Andrés Gil', 22, 4),
('Nova', 'Elena Vidal', 20, 4),
('Razor', 'Iker Alonso', 23, 5),
('Cipher', 'Lucía Navarro', 19, 6);

-- Partides
INSERT INTO partides (id_equip_local, id_equip_visitant, punts_local, punts_visitant, data, joc) VALUES
(1, 2, 16, 14, '2025-01-10', 'Valorant'),
(3, 1, 10, 13, '2025-01-12', 'League of Legends'),
(1, 4, 3, 1, '2025-01-15', 'Rocket League'),
(5, 1, 16, 16, '2025-01-18', 'Valorant'),
(2, 3, 8, 13, '2025-01-11', 'League of Legends'),
(4, 2, 2, 3, '2025-01-14', 'Rocket League'),
(1, 6, 13, 7, '2025-01-20', 'League of Legends'),
(6, 3, 11, 13, '2025-01-22', 'Valorant'),
(2, 5, 16, 12, '2025-01-25', 'Valorant'),
(4, 6, 2, 2, '2025-01-27', 'Rocket League'),
(3, 4, 13, 9, '2025-01-28', 'League of Legends'),
(1, 3, 14, 16, '2025-02-01', 'Valorant'),
(5, 6, 1, 3, '2025-02-03', 'Rocket League'),
(2, 1, 9, 13, '2025-02-05', 'League of Legends');