<?php
	include_once('monodon/Monodon_v2.php');
	$mono = new Monodon_v2();
	$accion = $_GET['parAccion'];
	if ($accion == 'save_redes') {
		$_POST['id'] = 1;
        echo $mono->update_data("redes_sociales", $_POST);
	}elseif($accion == "get_redes"){
		echo $mono->select_one("redes_sociales", array("id" => 1));
	}
?>