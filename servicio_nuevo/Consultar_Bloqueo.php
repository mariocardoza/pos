<?php 
	
	require_once '../Conexion/Conexion.php';

	/**
	 * 
	 */
	class Consultar_Bloqueo
	{
		
		function __construct($argument)
		{
			# code...
		}

		public static function consultar_token($usuario,$codigo){

			$consulta = "SELECT
						tp.token, tp.estado_token,u.email_persona,u.estado, p.nombre,p.telefono
					FROM
						tb_temporales as tp
					JOIN tb_usuarios as u ON u.codigo = tp.cod_usuario
					JOIN tb_persona as p ON p.email = u.email_persona
					WHERE
						tp.estado_token = '1'
						and u.estado = '1'
						and u.email_persona= '$usuario'
					and tp.token = '$codigo'";

			try {
                $comando = Conexion::getInstance()->getDb()->prepare($consulta);
                $comando->execute();
                $row = $comando->fetch(PDO::FETCH_ASSOC);
                return $row;

            } catch (PDOException $e) {
               	$array = array($e->getLine(),$e->getMessage());
                return $array;
            }
		}
	}


?>