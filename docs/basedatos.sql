CREATE TABLE Administracion (
    nIdAdministracion SMALLINT NOT NULL AUTO_INCREMENT,
    sNombre VARCHAR(50) NOT NULL,
    sApePat VARCHAR(50) NOT NULL,
    sApeMat VARCHAR(50) NOT NULL,
    dFecNacim DATE NOT NULL,
    sSexo CHAR(1) NOT NULL,
    nTipo TINYINT NOT NULL,
    PRIMARY KEY (nIdAdministracion)
);

CREATE TABLE Usuario (
    nCveUsu SMALLINT NOT NULL AUTO_INCREMENT,
    sContrasenia VARCHAR(16) NOT NULL,
    nIdAdministracion SMALLINT NOT NULL,
    PRIMARY KEY (nCveUsu),
    FOREIGN KEY (nIdAdministracion) REFERENCES Administracion(nIdAdministracion)
);

CREATE UNIQUE INDEX usuario_idx ON Usuario (nIdAdministracion ASC);

CREATE TABLE Contacto (
    nIdContacto INTEGER NOT NULL AUTO_INCREMENT,
    sNombre VARCHAR(50) NOT NULL,
    sApePat VARCHAR(50) NOT NULL,
    sApeMat VARCHAR(50),
    dFecNacim DATE NOT NULL,
    sSexo CHAR(1) NOT NULL,
    sTelefono VARCHAR(20) NOT NULL,
    sDireccion VARCHAR(100),
    id_usuario SMALLINT,
    PRIMARY KEY (nIdContacto),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(nCveUsu)
);

CREATE TABLE Agenda (
    nIdAgenda INTEGER NOT NULL AUTO_INCREMENT,
    nIdContacto INTEGER NOT NULL,
    nIdAdministracion SMALLINT NOT NULL,
    dCreacion DATE NOT NULL,
    sDescripcion VARCHAR(100) NOT NULL,
    PRIMARY KEY (nIdAgenda),
    FOREIGN KEY (nIdContacto) REFERENCES Contacto(nIdContacto),
    FOREIGN KEY (nIdAdministracion) REFERENCES Administracion(nIdAdministracion)
);

DROP USER IF EXISTS 'agendaContactos'@'localhost';
FLUSH PRIVILEGES;

CREATE USER 'agendaContactos'@'localhost' IDENTIFIED BY 'agendaContactos';

GRANT SELECT, INSERT, DELETE, UPDATE ON Contacto TO 'agendaHospital'@'localhost';
GRANT SELECT, INSERT, DELETE, UPDATE ON Administracion TO 'agendaHospital'@'localhost';
GRANT SELECT, INSERT, DELETE, UPDATE ON Agenda TO 'agendaHospital'@'localhost';
GRANT SELECT, INSERT, DELETE, UPDATE ON Usuario TO 'agendaHospital'@'localhost';

INSERT INTO Contacto (sNombre, sApePat, sApeMat, dFecNacim, sSexo, sDireccion, sTelefono)
VALUES 
('Susan', 'Richards', 'Lee', '1989-06-30', 'F', 'Calle Falsa 3', '2728902192'),
('Carlos', 'Ramírez', 'López', '1990-03-15', 'M', 'Av. Central 123', '2714567890'),
('Ana', 'Martínez', 'Gómez', '1985-11-22', 'F', 'Calle Luna 45', '2721234567'),
('Luis', 'García', 'Fernández', '1978-07-05', 'M', 'Calle Sol 89', '2717890123'),
('María', 'Hernández', 'Cruz', '1995-02-10', 'F', 'Av. Reforma 100', '2725556789'),
('Jorge', 'Sánchez', 'Reyes', '1982-09-01', 'M', 'Calle Norte 12', '2719988776'),
('Lucía', 'Torres', 'Ortiz', '1993-12-17', 'F', 'Calle Sur 90', '2723344556'),
('David', 'Flores', 'Mendoza', '1987-04-25', 'M', 'Blvd. del Río 56', '2711239876'),
('Elena', 'Morales', 'Castillo', '1991-10-08', 'F', 'Priv. Jacarandas 15', '2724455667'),
('Ricardo', 'Navarro', 'Aguilar', '1980-01-19', 'M', 'Callejón del Parque 7', '2716677889'),
('Isabel', 'Pérez', 'Salinas', '1988-08-12', 'F', 'Calle Cedros 34', '2727788990');

INSERT INTO Administracion (sNombre, sApePat, sApeMat, dFecNacim, sSexo, nTipo)
VALUES 
('Peter', 'Par', 'Ker', '1970-11-17', 'M', 3),
('Bruce', 'Barner', 'Smith', '1980-09-22', 'M', 1),
('Minnie', 'Mouse', 'Disney', '1995-01-01', 'F', 2);

INSERT INTO Usuario (sContrasenia, nIdAdministracion) VALUES 
('abc123', 1),
('abc124', 2),
('abc125', 3);

INSERT INTO Agenda (nIdContacto, nIdAdministracion, dCreacion, sDescripcion) VALUES 
(4, 2, '2017-12-20', 'ACTUALIZAR DESCRIPCION'),
(1, 2, '2017-12-20', 'ACTUALIZAR DESCRIPCION'),
(3, 2, '2017-12-20', 'ACTUALIZAR DESCRIPCION'),
(2, 2, '2017-12-20', 'ACTUALIZAR DESCRIPCION');

