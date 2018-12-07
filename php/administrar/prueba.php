<?php 
include_once("../../Conexion/Genericas2.php");
for($i=4;$i<(82+4);$i++){
	$id_persona=Genericas2::retonrar_id_insertar("tb_persona");
 	echo '<br>'.substr($id_persona,0,20).'-'.$i;
 	sleep ( 1 );
}
?>