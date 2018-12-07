<?php 
include_once("../../Conexion/Producto.php");
if($_POST['data_id']=="nuevo_producto"){
	$resultado = Producto::guardar($_POST);
	echo json_encode($resultado);
	exit();
}
if($_GET['data_id']=='ver_producto'){
	$resultado=Producto::modal_ver($_GET['id']);
	echo json_encode($resultado);
	exit();
}
if($_POST['data_id']=='agregar_existencia'){
	$resultado=Producto::actualizar_inventario($_POST[id],$_POST[cantidad],$_POST[precio],1);
	echo json_encode($resultado);
	exit();
}
?>