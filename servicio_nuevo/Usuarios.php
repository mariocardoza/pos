<?php 
	
	require_once '../Conexion/Conexion.php';

	/**
	 * 
	 */
	class Usuarios
	{
		
		function __construct($argument)
		{
			# code... 
		}


		public static function getById_accesos($usuario,$contrasenia){
            // Consulta de la meta
            $consulta = "SELECT u.codigo, u.email_persona, u.nivel,estado,upper(p.nombre) as nombre, p.codigo as codigopersona
						FROM tb_usuarios  as u
						JOIN tb_persona as p
						ON p.email = u.email_persona
						WHERE u.email_persona = '$usuario' and u.contrasena = PASSWORD('$contrasenia')";

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