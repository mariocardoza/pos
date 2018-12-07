<?php 
	
	require 'Firebase.php';

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		if (isset($_GET['usuario'])) {
			$usuario = $_GET['usuario'];
			$retorno = Firebase::enviartoken($usuario);
		}
	}


?>