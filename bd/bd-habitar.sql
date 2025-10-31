CREATE DATABASE IF NOT EXISTS bd-habitar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bd-habitar;

-- Tabla de proyectos
CREATE TABLE projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  storytext TEXT,
  img_main VARCHAR(255) NOT NULL,
  galery JSON NOT NULL, -- almacenaremos el arreglo de strings como JSON
  structural_calc VARCHAR(255) NOT NULL,
  ubication VARCHAR(255) NOT NULL,
  surface VARCHAR(255) NOT NULL,
  studio VARCHAR(255) NOT NULL,
  system_build VARCHAR(255) NOT NULL,
  duration INT NULL,
  instagram VARCHAR(255) NULL,
  year_build VARCHAR(4) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de integrantes del equipo
CREATE TABLE team_members (
  id INT AUTO_INCREMENT PRIMARY KEY,
  photo VARCHAR(255) NOT NULL,
  team_mate VARCHAR(255) NOT NULL,
  position VARCHAR(255) NOT NULL,
  instagram VARCHAR(255) NOT NULL,
  linkedin VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
