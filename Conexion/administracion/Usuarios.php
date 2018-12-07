<?php 
@session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
date_default_timezone_set('America/El_Salvador');
require_once(__ROOT__.'/Conexion.php');
require_once(__ROOT__.'/Genericas2.php');

class Usuarios 
{
	function __construct($argument)
	{
		date_default_timezone_set('America/El_Salvador');
	}

	public static function get_usuario_personas(){
		$sql = "
			SELECT
				p.id AS cod_persona,
				p.nombre,
				p.telefono,
				p.email,
				u.nivel,
				CASE
				    WHEN u.nivel = 1 THEN 'Administrador'
				    WHEN u.nivel = 2 THEN 'Vendedor'
				END as n_nivel,
				u.estado,
				u.pass,
				u.id AS cod_usuario
			FROM
				persona AS p
				INNER JOIN tb_usuario AS u ON p.email = u.email
			ORDER BY u.nivel, p.nombre ASC;
		";
		try {
			$comando = Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            $datos = $comando->fetchAll(PDO::FETCH_ASSOC);
            return array("1",$datos,$sql);
		} catch (Exception $e) {
			return array("-1",$e->getMessage(),$e->getLine(),$sql);
			exit();
		}
	}

	public static function get_caulquiera($tabla){
		$sql = "
			SELECT
				*
			FROM
				$tabla ;
		";
		try {
			$comando = Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            $datos = $comando->fetchAll(PDO::FETCH_ASSOC);
            return array("1",$datos,$sql);
		} catch (Exception $e) {
			return array("-1",$e->getMessage(),$e->getLine(),$sql);
			exit();
		}
	}

	public static function val_email($email){
		$sql="SELECT * FROM tb_usuario AS c WHERE c.email = '$email';"; 
	    	$html="";
	    	$datos=null;
	    	$bandera=false;
		 	$datos_modelo=array();
		 	try {
			    $comando = "";
			    $comando = Conexion::getInstance()->getDb()->prepare($sql);
			    $comando->execute();
			    $datos = $comando->fetchAll();
			    foreach ($datos as $lista) {
			    	$bandera=true;
			    }
			}catch (PDOException $e) {
		        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
				exit();
		    }
		    return array("1",$bandera,$datos,$sql);
		    exit();
	}

	public static function val_tel($telefono){
		$sql="SELECT * FROM persona AS c WHERE c.telefono = '$telefono';"; 
	    	$html="";
	    	$datos=null;
	    	$bandera=false;
		 	$datos_modelo=array();
		 	try {
			    $comando = "";
			    $comando = Conexion::getInstance()->getDb()->prepare($sql);
			    $comando->execute();
			    $datos = $comando->fetchAll();
			    foreach ($datos as $lista) {
			    	$bandera=true;
			    }
			}catch (PDOException $e) {
		        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
				exit();
		    }
		    return array("1",$bandera,$datos,$sql);
		    exit();
	}
	
	public static function set_usuario_perosonas($data){ 
    	$html="";
    	$datos=null;
    	$id_usuario=Genericas2::retonrar_id_insertar("tb_usuarios");
    	//$id_persona=Genericas2::retonrar_id_insertar("tb_persona");
    	$id_persona = $id_usuario;
    	$id_temporales=Genericas2::retonrar_id_insertar("tb_temporales");
    	$token=Genericas2::generartoken();
    	$link=Genericas2::generarpass();
    	$pass=Genericas2::generarpass();
    	$fecha = date('Y-m-d G:i:s');
    	$sql2="";

    	if($_POST['nivel'] == '3' || $_POST['nivel'] == '4'){
    		$sql2 = "INSERT INTO `tb_temporales`(`cod_usuario`, `tiempo`, `link`, `token`,`estado`, `estado_token`) VALUES ('$id_usuario', '$fecha', '$link', '$token', 1, 1);";
    	}
    	$sql="INSERT INTO `tb_persona`(`codigo`, `nombre`, `telefono`, `email`, `cod_municipio`, `cod_programa`) VALUES ('$id_persona', '$data[nombre]', '$data[telefono]', '$data[email]', $data[municipio], $data[programa]);

    		INSERT INTO `tb_usuarios`(`codigo`, `email_persona`, `contrasena`, `nivel`, `estado`) VALUES ('$id_usuario', '$data[email]', PASSWORD('$pass'), $data[nivel], 2);
    		".$sql2;
	 	$datos_modelo=array();
	 	try {
		    $comando = "";
		    $comando = Conexion::getInstance()->getDb()->prepare($sql);
		    $comando->execute();
		}catch (PDOException $e) {
	        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
			exit();
	    }
	 	$datos = array($id_usuario, $id_persona,$pass,$token,$link);
	 	return array("1",$datos,$sql);
	    exit();
	}

	public static function get_img_anterior($id){
		$sql="SELECT imagen FROM tb_usuarios WHERE codigo = '$id';";
		$html="";
    	$datos=null;
	 	$datos_modelo=array();
	 	try {
		    $comando = "";
		    $comando = Conexion::getInstance()->getDb()->prepare($sql);
		    $comando->execute();
		    $datos = $comando->fetchAll();
		}catch (PDOException $e) {
	        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
			exit();
	    }
	    return array("1",$datos,$sql);
	    exit();
	}

	public static function set_img($id,$imagen){
		$sql="UPDATE `tb_usuarios` SET `imagen` = '$imagen' WHERE `codigo` = '$id';";
		$html="";
    	$datos=null;
	 	$datos_modelo=array();
	 	try {
		    $comando = "";
		    $comando = Conexion::getInstance()->getDb()->prepare($sql);
		    $comando->execute();
		}catch (PDOException $e) {
	        return array("-1",$e->getMessage(),$e->getLine(),$sql);
			exit();
	    }
	    return array("1","exito",$sql);
	    exit();
	}

	public static function get_temporales($id,$link,$fecha){
		$sql="SELECT * FROM tb_temporales AS t WHERE t.estado = 1 and t.cod_usuario = '$id' and t.link = '$link' and TIMESTAMPDIFF(MINUTE,t.tiempo,'$fecha') <= 60;"; 
    	$html="";
    	$datos=null;
	 	$datos_modelo=array();
	 	try {
		    $comando = "";
		    $comando = Conexion::getInstance()->getDb()->prepare($sql);
		    $comando->execute();
		    $datos = $comando->fetchAll();
		}catch (PDOException $e) {
	        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
			exit();
	    }
	    return array("1",$datos,$sql);
	    exit();
	}
	public static function set_temporales($id,$link){
		$sql="UPDATE `tb_temporales` SET `estado` = 2 WHERE cod_usuario = '$id' and link = '$link';"; 
    	$html="";
    	$datos=null;
	 	$datos_modelo=array();
	 	try {
		    $comando = "";
		    $comando = Conexion::getInstance()->getDb()->prepare($sql);
		    $comando->execute();
		}catch (PDOException $e) {
	        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
			exit();
	    }
	    return array("1","exito",$sql);
	    exit();
	}
}

?>