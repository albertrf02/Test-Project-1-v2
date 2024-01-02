DROP DATABASE IF EXISTS testproject1;
CREATE DATABASE testproject1;

use testproject1;

CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    cognoms VARCHAR(50) NOT NULL,
    dataNaixement DATE NOT NULL,
    carrer VARCHAR(100) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    ciutat VARCHAR(50) NOT NULL,
    cp VARCHAR(10) NOT NULL,
    grup VARCHAR(50) NOT NULL
);

CREATE TABLE Resguards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(255),
    idParticipant INT,
    FOREIGN KEY (idParticipant) REFERENCES participants(id)
);