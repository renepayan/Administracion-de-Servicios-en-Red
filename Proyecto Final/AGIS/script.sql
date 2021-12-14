CREATE DATABASE db_pbx;
USE db_pbx;
CREATE TABLE tbl_Nodos(
    idNodo INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Numero INT NOT NULL,
    IP VARCHAR(15) NOT NULL,
    Dominio VARCHAR(50) NOT NULL,
    Nombre VARCHAR(50) NOT NULL
);
CREATE TABLE tbl_Grupos(
    idGrupo INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Extension VARCHAR(3) NOT NULL,
    Nombre VARCHAR(50) NOT NULL
);
CREATE TABLE `tbl_Usuarios` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Usuario` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Nivel` int(11) NOT NULL,
  `Grupo` int(11) NOT NULL,
  `GrabarLlamadas` tinyint(1) NOT NULL,
  `LlamarAGrupos` tinyint(1) NOT NULL,
  `LlamarExtensiones` tinyint(1) NOT NULL,
  `Extension` varchar(10) NOT NULL,
  Nodo INT NOT NULL,
  PRIMARY KEY (`idUsuario`),
  FOREIGN KEY (Grupo) REFERENCES tbl_Grupos(idGrupo),
  FOREIGN KEY(Nodo) REFERENCES tbl_Nodos(idNodo)
);
CREATE TABLE `tbl_HorariosDeServicios` (
  `idHorario` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` int(11) NOT NULL,
  `DiaDeLaSemana` int(11) NOT NULL,
  `HoraInicio` time NOT NULL,
  `HoraFin` time NOT NULL,
  PRIMARY KEY (`idHorario`),
  KEY `Usuario` (`Usuario`),
  CONSTRAINT `tbl_HorariosDeServicios_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `tbl_Usuarios` (`idUsuario`)
);
CREATE TABLE tbl_PermisosLlamadas(
    idPermiso INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Usuario INT NOT NULL,
    NodoOrigen INT NOT NULL,
    NodoDestino INT NOT NULL,
    FOREIGN KEY (Usuario) REFERENCES tbl_Usuarios(idUsuario),
    FOREIGN KEY (NodoOrigen) REFERENCES tbl_Nodos(idNodo),
    FOREIGN KEY (NodoDestino) REFERENCES tbl_Nodos(idNodo)
);
CREATE TABLE tbl_Llamadas(
    idLlamada INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Usuario INT NOT NULL,
    NodoOrigen INT NOT NULL,
    NodoDestino INT NOT NULL,
    Telefono VARCHAR(15),
    FechaInicio DATETIME NOT NULL,
    FechaFin DATETIME NOT NULL,
    Grabada BOOLEAN NOT NULL,
    idAsterisk VARCHAR(30) NOT NULL,
    FOREIGN KEY (Usuario) REFERENCES tbl_Usuarios(idUsuario),
    FOREIGN KEY (NodoOrigen) REFERENCES tbl_Nodos(idNodo),
    FOREIGN KEY (NodoDestino) REFERENCES tbl_Nodos(idNodo)
);
CREATE TABLE tbl_Alias(
  idAlias INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  tipoAlias INT NOT NULL,
  Usuario INT NOT NULL,
  Alias VARCHAR(50) NOT NULL,
  FOREIGN KEY (Usuario) REFERENCES tbl_Usuarios(idUsuario)
);