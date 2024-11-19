<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Usuario.php';
require_once __DIR__ . '/../../app/models/Cliente.php';

// Crear una conexión con la base de datos
$database = new Database();
$db = $database->connect();

// Crear el modelo de usuario y cliente
$usuario = new Usuario($db);
$cliente = new Cliente($db);

// Array de usuarios y clientes para el seeder
$usuariosClientes = [
	[
		'correo' => 'cliente1@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Emily',
		'apellido' => 'Johnson',
		'rol' => 'cliente',
		'telefono' => '22334455',
		'dui' => '12345678-1',
		'email' => 'cliente1@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente2@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Michael',
		'apellido' => 'Brown',
		'rol' => 'cliente',
		'telefono' => '33445566',
		'dui' => '23456789-2',
		'email' => 'cliente2@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente3@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Super',
		'apellido' => 'Admin',
		'rol' => 'cliente',
		'telefono' => '44556677',
		'dui' => '34567890-3',
		'email' => 'cliente3@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente4@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Sophia',
		'apellido' => 'Williams',
		'rol' => 'cliente',
		'telefono' => '55667788',
		'dui' => '45678901-4',
		'email' => 'cliente4@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente5@too.ues',
		'contrasena' => '1234',
		'nombre' => 'James',
		'apellido' => 'Jones',
		'rol' => 'cliente',
		'telefono' => '66778899',
		'dui' => '56789012-5',
		'email' => 'cliente5@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente6@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Olivia',
		'apellido' => 'Garcia',
		'rol' => 'cliente',
		'telefono' => '77889900',
		'dui' => '67890123-6',
		'email' => 'cliente6@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente7@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Benjamin',
		'apellido' => 'Martinez',
		'rol' => 'cliente',
		'telefono' => '88990011',
		'dui' => '78901234-7',
		'email' => 'cliente7@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente8@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Emma',
		'apellido' => 'Hernandez',
		'rol' => 'cliente',
		'telefono' => '99001122',
		'dui' => '89012345-8',
		'email' => 'cliente8@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente9@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Liam',
		'apellido' => 'Lopez',
		'rol' => 'cliente',
		'telefono' => '11002233',
		'dui' => '90123456-9',
		'email' => 'cliente9@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente10@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Isabella',
		'apellido' => 'Gonzalez',
		'rol' => 'cliente',
		'telefono' => '22003344',
		'dui' => '01234567-0',
		'email' => 'cliente10@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente11@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Noah',
		'apellido' => 'Perez',
		'rol' => 'cliente',
		'telefono' => '33004455',
		'dui' => '12345678-1',
		'email' => 'cliente11@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente12@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Ava',
		'apellido' => 'Ramirez',
		'rol' => 'cliente',
		'telefono' => '44005566',
		'dui' => '23456789-2',
		'email' => 'cliente12@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente13@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Elijah',
		'apellido' => 'Torres',
		'rol' => 'cliente',
		'telefono' => '55006677',
		'dui' => '34567890-3',
		'email' => 'cliente13@too.ues',
		'status' => 'activo'
	],
];

// Registrar los usuarios y clientes
foreach ($usuariosClientes as $data) {
	$usuario->correo = $data['correo'];
	$usuario->contrasena = $data['contrasena'];
	$usuario->nombre = $data['nombre'];
	$usuario->rol = $data['rol'];

	// Registrar el usuario
	try {
		if ($usuario->registrar()) {
			echo "Usuario {$usuario->correo} registrado con éxito.\n";

			// Obtener el ID del usuario recién creado
			$usuarioId = $db->lastInsertId();

			// Registrar el cliente asociado
			$cliente->id_usuario = $usuarioId;
			$cliente->nombre = $data['nombre'];
			$cliente->apellido = $data['apellido'];
			$cliente->telefono = $data['telefono'];
			$cliente->dui = $data['dui'];
			$cliente->email = $data['email'];
			$cliente->status = $data['status'];

			if ($cliente->create()) {
				echo "Cliente asociado al usuario {$usuario->correo} registrado con éxito.\n";
			} else {
				echo "Error al registrar al cliente asociado al usuario {$usuario->correo}.\n";
			}
		} else {
			echo "Error al registrar al usuario {$usuario->correo}.\n";
		}
	} catch (Exception $e) {
		echo "Error al registrar al usuario {$usuario->correo}: {$e->getMessage()}\n";
	}
}
