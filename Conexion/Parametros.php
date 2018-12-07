<?php 

/**
* 
*/
@session_start();
require_once 'Conexion.php';
class Parametros {
	
	function __construct(){
			# code...
		}

	public static function parametro($string){
		$contado =0;
		try {
            $comando = Conexion::getInstance()->getDb()->prepare($string);
            $comando->execute();
            while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
            	$contado = $row[contado];
            }

           
           return $contado;
        } catch (PDOException $e) {
            return $e;
        }
	}
}



?>