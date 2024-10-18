-- Active: 1726760977043@@127.0.0.1@3306@php_mvc
CREATE DATABASE ssea;
		DEFAULT CHARACTER SET = 'utf8mb4';

-- Crear tabla 'usuarios' para gestionar usuarios del sistema
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(255) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    rol ENUM('administrador', 'operador', 'gerente', 'cliente') DEFAULT 'operador',
    estado ENUM('activo', 'inactivo') DEFAULT 'activo'
) ENGINE=InnoDB;

-- Crear tabla 'operadores' para gestionar los agentes del sistema
CREATE TABLE operadores (
    id_agente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    codigo_empleado INT NOT NULL,
    extension_tel INT NOT NULL,
    status ENUM('inactivo', 'activo') NOT NULL, -- 0: inactivo, 1: activo
    usuario_creacion VARCHAR(255) NOT NULL,
    fecha_creacion DATE NOT NULL,
    usuario_modifico VARCHAR(255),
    fecha_modificacion DATE,
    id_usuario INT NOT NULL UNIQUE, -- Asegurar que un usuario solo puede ser un operador
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE=InnoDB;

-- Crear tabla 'clientes' para gestionar los clientes del sistema
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    dui VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    status ENUM('inactivo', 'activo') NOT NULL, -- 0: inactivo, 1: activo
    usuario_creacion VARCHAR(255) NOT NULL,
    fecha_creacion DATE NOT NULL,
    usuario_modifico VARCHAR(255),
    fecha_modificacion DATE
) ENGINE=InnoDB;

-- Crear tabla 'llamadas_emergencia' para almacenar las llamadas de emergencia
CREATE TABLE llamadas_emergencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    operador_id INT,
    cliente_id INT,
    tipo_emergencia ENUM('accidente', 'incendio', 'robo', 'emergencia médica', 'otro') NOT NULL,
    telefono VARCHAR(20) NOT NULL, -- teléfono del cliente
    resolucion ENUM('grúa', 'asistencia en accidente', 'compra de combustible', 'batería', 'otro'),
    estado ENUM('pendiente', 'completada', 'cancelada') DEFAULT 'pendiente',
    razon_cancelacion TEXT,
    fecha_llamada DATE, -- fecha de la llamada
    hora_llamada TIME, -- hora de la llamada
    duracion INT NOT NULL, -- duración de la llamada en segundos
    calidad_servicio ENUM('mala', 'aceptable', 'Excelente'),
    fecha_confirmacion DATETIME,
    observaciones TEXT, -- campo para observaciones adicionales
    FOREIGN KEY (operador_id) REFERENCES operadores(id_agente),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id_cliente)
) ENGINE=InnoDB;