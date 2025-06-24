CREATE DATABASE gestion_pointage


-- Création de la table EMPLOYE
CREATE TABLE EMPLOYE (
    numEmp VARCHAR(20) PRIMARY KEY,
    Nom VARCHAR(50),
    Prenom VARCHAR(50),
    poste VARCHAR(50),
    salaire INT,
    email VARCHAR(255)
    
);

-- Création de la table POINTAGE
CREATE TABLE POINTAGE (
    datePointage DATETIME,
    numEmp VARCHAR(20),
    pointage BOOLEAN,  -- TRUE pour présent, FALSE pour absent
    PRIMARY KEY (datePointage, numEmp),
    FOREIGN KEY (numEmp) REFERENCES EMPLOYE(numEmp)
);

-- Création de la table CONGE
CREATE TABLE CONGE (
    numConge VARCHAR(20) PRIMARY KEY,
    numEmp VARCHAR(20),
    motif VARCHAR(255),
    nbrjr INT CHECK (nbrjr <= 30),  -- vérification que le nombre de jours ne dépasse pas 30
    dateDemande DATE,
    dateRetour DATE,
    FOREIGN KEY (numEmp) REFERENCES EMPLOYE(numEmp)
);



INSERT INTO EMPLOYE (numEmp, Nom, Prenom, poste, salaire, email) VALUES
('E001', 'Dupont', 'Jean', 'Manager', 5000,'charliewalter@gmail'),
('E002', 'Martin', 'Sophie', 'Secrétaire', 2500, 'charliewalter@gmail'),
('E003', 'Bernard', 'Luc', 'Technicien', 3000, 'charliewalter@gmail');
('E004', 'Bernard', 'Luc', 'Technicien', 3000, 'charliewalter@gmail');




INSERT INTO POINTAGE (datePointage, numEmp, pointage) VALUES
('2025-03-10 08:00:00', 'E001', TRUE),
('2025-03-10 08:05:00', 'E002', TRUE),
('2025-03-10 08:10:00', 'E003', FALSE);





INSERT INTO CONGE (numConge, numEmp, mo1tif, nbrjr, dateDemande, dateRetour) VALUES
('C001', 'E002', 'Vacances', 10, '2025-06-01', '2025-06-11'),
('C002', 'E003', 'Maladie', 5, '2025-07-15', '2025-07-20');






SELECT * FROM POINTAGE WHERE datePointage = '2025-03-10';






SELECT * FROM CONGE WHERE numEmp = 'E002';
