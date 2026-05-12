DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS attendances;
DROP TABLE IF EXISTS absences;
DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS absencetypes;
DROP TABLE IF EXISTS departments;
DROP TABLE IF EXISTS statustypes;

CREATE TABLE departments
(
    id              INT PRIMARY KEY AUTO_INCREMENT,
    name            VARCHAR(50) NOT NULL
);

CREATE TABLE employees
(
    id              INT PRIMARY KEY AUTO_INCREMENT,
    firstName       VARCHAR(50) NOT NULL,
    lastName        VARCHAR(50) NOT NULL,
    birthDate       DATE NOT NULL,
    address         VARCHAR(100) NOT NULL,
    email           VARCHAR(50) NOT NULL UNIQUE,
    phone           VARCHAR(20) NOT NULL,
    position        VARCHAR(50) NOT NULL,
    departmentId    INT NULL,
    hireDate        DATE NOT NULL,

    FOREIGN KEY (departmentId) REFERENCES departments(id)
);

CREATE TABLE users
(
    id              INT PRIMARY KEY AUTO_INCREMENT,
    username        VARCHAR(50) NOT NULL UNIQUE,
    password        VARCHAR(100) NOT NULL,
    employeeId      INT NOT NULL UNIQUE,

    FOREIGN KEY (employeeId) REFERENCES employees(id)
);

CREATE TABLE statustypes
(
    id              INT PRIMARY KEY AUTO_INCREMENT,
    name            VARCHAR(20) NOT NULL
);

CREATE TABLE attendances
(
    id              INT PRIMARY KEY AUTO_INCREMENT,
    employeeId      INT NOT NULL,
    checkInTime     DATETIME NOT NULL,
    checkOutTime    DATETIME NULL,
    statusId        INT NOT NULL,

    CHECK (checkOutTime >= checkInTime),
    FOREIGN KEY (employeeId) REFERENCES employees(id),
    FOREIGN KEY (statusId) REFERENCES statustypes(id)
);

CREATE TABLE absencetypes
(
    id              INT PRIMARY KEY AUTO_INCREMENT,
    name            VARCHAR(50) NOT NULL
);

CREATE TABLE absences
(
    id              INT PRIMARY KEY AUTO_INCREMENT,
    employeeId      INT NOT NULL,
    absenceTypeId   INT NOT NULL,
    startDate       DATE NOT NULL,
    endDate         DATE NULL,

    CHECK (endDate >= startDate),
    FOREIGN KEY (employeeId) REFERENCES employees(id),
    FOREIGN KEY (absenceTypeId) REFERENCES absencetypes(id)
);