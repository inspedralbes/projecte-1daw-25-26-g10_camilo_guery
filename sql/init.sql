USE gestorIncidencia;

CREATE TABLE TIPO(
    idTipo INT(11) AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(200)
);

CREATE TABLE DEPARTAMENT(
    idDepartament INT(11) AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(200)
);

CREATE TABLE TECNIC(
    idTecnic INT(11) AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(200)
);

CREATE TABLE INCIDENCIA(
    idIncidencia INT(11) AUTO_INCREMENT PRIMARY KEY,
    descripcio VARCHAR(2000),
    data TIMESTAMP,
    departament INT(11),
    tecnic INT(11),
    tipo INT(11),
    dataFinalitzacio DATE,
    prioritat ENUM('Alta', 'Mitja', 'Baixa'),

    FOREIGN KEY(departament) REFERENCES DEPARTAMENT(idDepartament),
    FOREIGN KEY(tecnic) REFERENCES TECNIC(idTecnic),
    FOREIGN KEY(tipo) REFERENCES TIPO(idTipo)
);

CREATE TABLE ACTUACIO(
    idActuacio INT(11) AUTO_INCREMENT PRIMARY KEY,
    descripcio VARCHAR(2000),
    data TIMESTAMP,
    temps INT(11),
    incidencia INT(11),
    visible INT(1),
    FOREIGN KEY(incidencia) REFERENCES INCIDENCIA(idIncidencia)
);