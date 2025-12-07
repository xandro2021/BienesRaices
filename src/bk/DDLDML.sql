DROP DATABASE IF EXISTS BienesRaicesJuan;
CREATE DATABASE IF NOT EXISTS BienesRaicesJuan;
USE BienesRaicesJuan;

CREATE TABLE IF NOT EXISTS Vendedores (
id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
nombre VARCHAR(50),
apellido VARCHAR(50),
telefono VARCHAR(10)
);

CREATE TABLE IF NOT EXISTS Propiedades (
id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
titulo VARCHAR(45),
precio DECIMAL(10,2),
imagen VARCHAR(200),
descripcion LONGTEXT,
habitaciones INT(1),
wc INT(1),
estacionamiento INT(1),
creado DATE DEFAULT (CURRENT_DATE),
vendedores_id INT(11),
CONSTRAINT fk_PropiedadesVendedor
FOREIGN KEY (vendedores_id) REFERENCES Vendedores(id)
);

INSERT INTO Vendedores VALUES 
(1, 'Juan', 'De la torre', '12341991'),
(2, 'Karen', 'Perez', '13131313');

SELECT * FROM Vendedores v ;