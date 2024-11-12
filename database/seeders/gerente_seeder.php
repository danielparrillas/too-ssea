<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Usuario.php';
require_once __DIR__ . '/../../app/models/Gerente.php';

// Crear una conexión con la base de datos
$database = new Database();
$db = $database->connect();

// Crear el modelo de usuario y gerente
$usuario = new Usuario($db);
$gerente = new Gerente($db);

// Array de usuarios y gerentes para el seeder
$usuariosGerentes = [
	[
		'correo' => 'gerente1@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Cesar',
		'apellido' => 'Mendez',
		'rol' => 'gerente',
		'codigo_empleado' => 1010,
		'extension_tel' => 110,
		'status' => 'activo'
	],
	[
		'correo' => 'gerente2@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Gabriela',
		'apellido' => 'López',
		'rol' => 'gerente',
		'codigo_empleado' => 1011,
		'extension_tel' => 111,
		'status' => 'activo'
	],
	
];

// Registrar los usuarios y gerentes
foreach ($usuariosGerentes as $data) {
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

			// Registrar el gerente asociado
			$gerente->id_usuario = $usuarioId;
			$gerente->nombre = $data['nombre'];
			$gerente->apellido = $data['apellido'];
			$gerente->codigo_empleado = $data['codigo_empleado'];
			$gerente->extension_tel = $data['extension_tel'];
			$gerente->status = $data['status'];

			if ($gerente->create()) {
				echo "Gerente asociado al usuario {$usuario->correo} registrado con éxito.\n";
			} else {
				echo "Error al registrar al gerente asociado al usuario {$usuario->correo}.\n";
			}
		} else {
			echo "Error al registrar al usuario {$usuario->correo}.\n";
		}
	} catch (Exception $e) {
		echo "Error al registrar al usuario {$usuario->correo}: {$e->getMessage()}\n";
	}
}
