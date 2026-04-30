USE gestorIncidencia;

CREATE TABLE TIPUS(
    idTipus INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(200)
);

CREATE TABLE DEPARTAMENT(
    idDepartament INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(200)
);

CREATE TABLE TECNIC(
    idTecnic INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(200)
);

CREATE TABLE INCIDENCIA(
    idIncidencia INT AUTO_INCREMENT PRIMARY KEY,
    descripcio VARCHAR(2000),
    data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    idDepartament INT,
    idTecnic INT,
    idTipus INT,
    dataFinalitzacio DATE,
    prioritat ENUM('Alta', 'Mitja', 'Baixa'),

    FOREIGN KEY(idDepartament) REFERENCES DEPARTAMENT(idDepartament),
    FOREIGN KEY(idTecnic) REFERENCES TECNIC(idTecnic),
    FOREIGN KEY(idTipus) REFERENCES TIPUS(idTipus)
);

CREATE TABLE ACTUACIO(
    idActuacio INT AUTO_INCREMENT PRIMARY KEY,
    descripcio VARCHAR(2000),
    data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    temps INT,
    idIncidencia INT,
    visible BOOLEAN,

    FOREIGN KEY(idIncidencia) REFERENCES INCIDENCIA(idIncidencia)
);

INSERT INTO TIPUS(nom) VALUES ('Hardware'), ('Software');
INSERT INTO DEPARTAMENT(nom) VALUES ('Programacio'), ('Sistemes'), ('Base de Dades');
INSERT INTO TECNIC(nom) VALUES ('Ermengol'), ('Gerard'), ('Alvaro'), ('Toni');