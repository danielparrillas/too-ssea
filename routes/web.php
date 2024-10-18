<?php
session_start();

require_once __DIR__ . '/../middlewares/authMiddleware.php';
require_once __DIR__ . '/../middlewares/roleMiddleware.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
	case '/':
		require_once __DIR__ . '/../app/views/home.php';
		break;
	case '/dashboard':
		auth();
		role('admin');
		require_once __DIR__ . '/../app/controllers/DashboardController.php';
		$dashboardController = new DashboardController();
		$dashboardController->showDashboard();
		break;
	case '/login':
		require_once __DIR__ . '/../app/controllers/AuthController.php';
		$authController = new AuthController();
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				$authController->mostrarLogin();
				break;
			case 'POST':
				$authController->login();
				break;
		}
		break;
	case '/logout':
		require_once __DIR__ . '/../app/controllers/AuthController.php';
		$authController = new AuthController();
		$authController->logout();
		break;
	case '/register':
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				require_once __DIR__ . '/../app/views/register.php';
				break;
			case 'POST':
				require_once __DIR__ . '/../app/controllers/AuthController.php';
				$authController = new AuthController();
				$authController->registrar();
				break;
		}
		break;
	case '/productos':
		require_once __DIR__ . '/../app/controllers/ProductController.php';
		$productController = new ProductController();
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				$productController->index();
				break;
			case 'POST':
				if ($_POST['_method'] === 'DELETE') {
					$id = $_GET['id'];
					$productController->delete($id);
				} else if ($_POST['_method'] === 'PUT') {
					$id = $_GET['id'];
					$productController->update($id);
				} else
					$productController->create();
				break;
			case 'DELETE':
				$id = $_GET['id'];
				$productController->delete($id);
				break;
		}
		break;
	case '/atender-llamada':
		auth();
		role('operador');
		require_once __DIR__ . '/../app/controllers/OperadorController.php';
		$operadorController = new OperadorController();
		$operadorController->atenderLlamada();
		break;
	case '/llamadas-atendidas':
		auth();
		role('operador');
		require_once __DIR__ . '/../app/controllers/OperadorController.php';
		$operadorController = new OperadorController();
		$operadorController->obtenerLlamadasAtendidas();
		break;
	case '/seguimiento-llamada';
		auth();
		role('operador');
		require_once __DIR__ . '/../app/controllers/OperadorController.php';
		$operadorController = new OperadorController();
		$operadorController->darSeguimientoLlamada();
		break;
	case '/editar-llamada':
		auth();
		role('operador');
		require_once __DIR__ . '/../app/controllers/OperadorController.php';
		$operadorController = new OperadorController();
		$operadorController->editarLlamada();
		break;
	case '/cancelar-llamada':
		auth();
		role('operador');
		require_once __DIR__ . '/../app/controllers/OperadorController.php';
		$operadorController = new OperadorController();
		$operadorController->cancelarLlamada();
		break;
	default:
		http_response_code(404);
		require_once __DIR__ . '/../app/views/404.php';
		break;
}
