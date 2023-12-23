DROP DATABASE IF EXISTS testProject1;
CREATE DATABASE testProject1;

use testProject1;

CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    cognoms VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    contrasenya VARCHAR(50) NOT NULL,
    dataNaixement DATE NOT NULL,
    carrer VARCHAR(100) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    ciutat VARCHAR(50) NOT NULL,
    cp VARCHAR(10) NOT NULL,
    grup VARCHAR(50) NOT NULL
);

CREATE TABLE Resguard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(255),
    idParticipants INT,
    FOREIGN KEY (idParticipants) REFERENCES participants(id)
);