<?php 
require_once('../../Conexion/Cliente.php');
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='nuevo_cliente'){
		$result = Cliente::guardar($_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']== 'val_email'){
		$result = Cliente::val_email($_POST['email']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']== 'val_tel'){
		$result = Cliente::val_tel($_POST['email']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']== 'val_nrc'){
		$result = Cliente::val_nrc($_POST['nrc']);
		echo json_encode($result);
		exit();
	}

	if($_POST['data_id']== 'val_nit'){
		$result = Cliente::val_nit($_POST['nit']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']== 'val_dui'){
		$result = Cliente::var_dui($_POST['dui']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']== 'modal_natural'){
		$result = Cliente::modal_natural($_POST['id']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='modal_juridico'){
		$result=Cliente::modal_juridico($_POST['id']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='editar_cliente'){
		$result=Cliente::editar($_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='eliminar_cliente'){
		$result=Cliente::eliminar($_POST['id']);
		echo json_encode($result);
		exit();
	}
}
?>