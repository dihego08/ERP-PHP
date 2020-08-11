<?php
	include_once('monodon/Monodon_v2.php');
	$mono = new Monodon_v2();
	$accion = $_GET['parAccion'];
	if ($accion == 'get_familias') {
        echo $mono->select_all("familias", true);
	}elseif($accion == "guardar_familia"){
		echo $mono->insert_data("familias", $_POST, false);
	}elseif ($accion == "get_productos") {
		$sql = "SELECT p.*, c.categoria FROM productos as p, categorias as c WHERE p.id_categoria = c.id";
		echo $mono->run_query($sql, false);
	}elseif ($accion == "guardar_producto") {
        $_POST['imagen'] = "";
        $fileName = $_FILES["file1"]["name"];
        $fileTmpLoc = $_FILES["file1"]["tmp_name"];
        $fileType = $_FILES["file1"]["type"];
        $fileSize = $_FILES["file1"]["size"];
        $fileErrorMsg = $_FILES["file1"]["error"];
        if (!$fileTmpLoc) {
            //exit();
        }
        if(move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT']."/ogani/img/product/$fileName")){
            $_POST['imagen'] = $fileName;
        } else {
        }
        echo $mono->insert_data("productos", $_POST, false);
	}elseif ($accion == "editar_producto") {
		echo $mono->select_one("productos", array('id' => $_POST['id']));
	}elseif ($accion == "editar_f") {
		echo $mono->select_one("familias", array('id' => $_POST['id']));
	}elseif ($accion == "actualizar_familia") {
		echo $mono->update_data("familias", $_POST);
	}elseif ($accion == "actualizar_producto") {
		$categoria = json_decode($mono->select_one("productos", array("id" => $_POST['id'])));

		if($_FILES['file1']['size'] == 0 && $_FILES['file1']['error'] == 0){
            $_POST["imagen"] = $categoria->imagen;
            
        }else{
            $fileName = $_FILES["file1"]["name"];
			$fileTmpLoc = $_FILES["file1"]["tmp_name"];
			$fileType = $_FILES["file1"]["type"];
			$fileSize = $_FILES["file1"]["size"];
			$fileErrorMsg = $_FILES["file1"]["error"];
			if (!$fileTmpLoc) {
			    //exit();
			}
			if(move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT']."/ogani/img/product/$fileName")){
				
				$_POST["imagen"] = $fileName;
				
			} else {
			}
        }
        echo $mono->update_data("productos", $_POST);
	}elseif ($accion == "eliminar_c") {
		echo $mono->delete_data("categorias", array("id" => $_POST['id']));
	}
	elseif ($accion == "eliminar_f") {
		echo $mono->delete_data("familias", array("id" => $_POST['id']));
	}
?>