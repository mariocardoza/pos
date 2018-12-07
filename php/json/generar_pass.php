<?php 
 	@session_start();
	require_once("../../Conexion/Envios.php");
	$email = Envios::recupearenviarmail($_POST[elcorreo]);
	///echo json_encode(array("exito" => $email ));
	  
	if ($email=='-1') {
		echo json_encode(array("error" => "error en el comando"));
	}else if($email=='1') {

		$exito = array("1",$email,"2","Actualizado");
		echo json_encode(array("exito" => $exito));
	}

?>