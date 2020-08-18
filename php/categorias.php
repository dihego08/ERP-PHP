<?php 
	declare(strict_types=1);
	require_once '../vendor/autoload.php';
	require_once '../config.php';

	use App\Models\Categoria;
	use App\Container;
	use App\Services\CategoriaService;


	Container::set('logger', function () {
	    $logger = new \Monolog\Logger(__CONFIG__['log']['channel']);
	    $file_handler = new \Monolog\Handler\StreamHandler(__CONFIG__['log']['path'] . date('Ymd') . '.log');
	    $logger->pushHandler($file_handler);

	    return $logger;
	});
	
	$categoria = new CategoriaService;

	$accion = $_GET['parAccion'];

	if($accion == "get_all"){
		echo json_encode($categoria->getAll());
	}elseif ($accion == "editar_producto") {
		echo json_encode($producto->get(intval($_POST['id'])));
	}elseif ($accion == "actualizar_producto") {
		$new_producto = new Categoria;
		$new_producto->nombre = $_POST['nombre'];
		$new_producto->descripcion = $_POST['descripcion'];
		$new_producto->id_categoria = $_POST['id_categoria'];
		$new_producto->precio = $_POST['precio'];
		$new_producto->id = $_POST['id'];
		echo json_encode($producto->update($new_producto));
	}elseif ($accion == "guardar_producto") {
		$new_producto = new Categoria;
		$new_producto->nombre = $_POST['nombre'];
		$new_producto->descripcion = $_POST['descripcion'];
		$new_producto->id_categoria = $_POST['id_categoria'];
		$new_producto->precio = $_POST['precio'];
		
		echo json_encode($producto->create($new_producto));
	}elseif ($accion == "eliminar_producto") {
		echo json_encode($producto->delete(intval($_POST['id'])));
	}