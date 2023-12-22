DROP DATABASE IF EXISTS testProject1;
CREATE DATABASE testProject1;

use testProject1;

CREATE TABLE Participants (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(50) NOT NULL,
    Cognoms VARCHAR(50) NOT NULL,
    DataNaixement DATE NOT NULL,
    Carrer VARCHAR(100) NOT NULL,
    Numero VARCHAR(10) NOT NULL,
    Ciutat VARCHAR(50) NOT NULL,
    CP VARCHAR(10) NOT NULL,
    Grup VARCHAR(50) NOT NULL,
);

CREATE TABLE Resguard (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(255),
    IdParticipants INT,
    FOREIGN KEY (IdParticipants) REFERENCES Participants(Id)
);