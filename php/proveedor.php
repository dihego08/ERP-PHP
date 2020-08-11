<?php 
	declare(strict_types=1);
	require_once '../vendor/autoload.php';
	require_once '../config.php';

	use App\Models\Proveedor;
	use App\Container;
	use App\Services\ProveedorService;


	Container::set('logger', function () {
	    $logger = new \Monolog\Logger(__CONFIG__['log']['channel']);
	    $file_handler = new \Monolog\Handler\StreamHandler(__CONFIG__['log']['path'] . date('Ymd') . '.log');
	    $logger->pushHandler($file_handler);

	    return $logger;
	});
	
	$proveedor = new ProveedorService;

	$accion = $_GET['parAccion'];

	if($accion == "get_all"){
		echo json_encode($proveedor->getAll());
	}elseif ($accion == "editar_proveedor") {
		echo json_encode($proveedor->get(intval($_POST['id'])));
	}elseif ($accion == "actualizar_proveedor") {
		$new_proveedor = new Proveedor;
		$new_proveedor->ruc = $_POST['ruc'];
		$new_proveedor->razon_social = $_POST['razon_social'];
		$new_proveedor->direccion = $_POST['direccion'];
		$new_proveedor->telefono = $_POST['telefono'];
		$new_proveedor->id = $_POST['id'];
		echo json_encode($proveedor->update($new_proveedor));
	}elseif ($accion == "guardar_proveedor") {
		$new_proveedor = new Proveedor;
		$new_proveedor->ruc = $_POST['ruc'];
		$new_proveedor->razon_social = $_POST['razon_social'];
		$new_proveedor->direccion = $_POST['direccion'];
		$new_proveedor->telefono = $_POST['telefono'];
		
		echo json_encode($proveedor->create($new_proveedor));
	}elseif ($accion == "eliminar_proveedor") {
		echo json_encode($proveedor->delete(intval($_POST['id'])));
	}