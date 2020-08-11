<?php
	include_once('monodon/Monodon_v2.php');
	$mono = new Monodon_v2();
	$accion = $_GET['parAccion'];
	if ($accion == 'get_sliders') {
        echo $mono->select_all("slider", true);
	}elseif($accion == "eliminar"){
		$clase = json_decode($mono->select_one("slider", array('id' => $_POST['id'])));

        unlink($_SERVER['DOCUMENT_ROOT'].'/ogani/img/'.$clase->imagen);

        echo $mono->delete_data("slider", array('id' => $_POST['id']));
	}elseif ($accion == "guardar") {
		$_POST['id_empresa'] = $_SESSION['id_empresa'];
        $_POST['imagen'] = "";
        $fileName = $_FILES["file1"]["name"];
        $fileTmpLoc = $_FILES["file1"]["tmp_name"];
        $fileType = $_FILES["file1"]["type"];
        $fileSize = $_FILES["file1"]["size"];
        $fileErrorMsg = $_FILES["file1"]["error"];
        if (!$fileTmpLoc) {
            //exit();
        }
        if(move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT']."/ogani/img/$fileName")){
            $_POST['imagen'] = $fileName;
        } else {
        }
        $_POST['estado'] = 1;
        echo $mono->insert_data("slider", $_POST, false);
	}elseif ($accion == "add_index") {
		echo $mono->executor("UPDATE slider set estado = 1 WHERE id = ".$_POST['id'], "update");
    }elseif ($accion == "rem_index") {
        echo $mono->executor("UPDATE slider set estado = 0 WHERE id = ".$_POST['id'], "update");
    }
?>