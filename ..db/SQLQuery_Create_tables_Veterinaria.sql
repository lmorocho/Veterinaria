-- Tabla Rol_Usuario
CREATE TABLE Rol_Usuario (
    ID_Rol INT PRIMARY KEY,
    Nombre_Rol VARCHAR(50)
);

-- Tabla Cliente
CREATE TABLE Cliente (
    ID_Cliente INT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    Apellido VARCHAR(50) NOT NULL,
    DNI VARCHAR(15) UNIQUE,
    Telefono VARCHAR(20),
    Email VARCHAR(100) UNIQUE,
    Direccion VARCHAR(100),
    Fecha_nacimiento DATE,
    Usuario VARCHAR(50) NOT NULL,
    Password VARCHAR(100) NOT NULL,
    ID_Rol INT,
    FOREIGN KEY (ID_Rol) REFERENCES Rol_Usuario(ID_Rol)
);

-- Tabla Especie
CREATE TABLE Especie (
    ID_Especie INT PRIMARY KEY,
    Nombre_Especie VARCHAR(50)
);

-- Tabla Raza
CREATE TABLE Raza (
    ID_Raza INT PRIMARY KEY,
    Nombre_Raza VARCHAR(50),
    ID_Especie INT,
    Color VARCHAR(50),
    FOREIGN KEY (ID_Especie) REFERENCES Especie(ID_Especie)
);

-- Tabla Mascota
CREATE TABLE Mascota (
    ID_Mascota INT PRIMARY KEY,
    Nombre VARCHAR(50),
    Fecha_Nacimiento DATE,
    ID_Raza INT,
    ID_Cliente INT,
    FOREIGN KEY (ID_Raza) REFERENCES Raza(ID_Raza),
    FOREIGN KEY (ID_Cliente) REFERENCES Cliente(ID_Cliente)
);
