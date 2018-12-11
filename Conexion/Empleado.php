<?php 
require_once("Conexion.php");
require_once("Genericas2.php");
@session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
date_default_timezone_set('America/El_Salvador');
//require_once(__ROOT__.'/Conexion.php');
//require_once(__ROOT__.'/Genericas2.php');
class Empleado 
{
	
	function __construct($argument)
	{
		# code...
	}

	public static function obtener_empleados(){
		$sql = "
			SELECT
				p.id,
				p.nombre,
				p.telefono,
				p.email,
				p.direccion,
				p.nit,
				p.dui,
				p.genero,
				p.imagen,
				p.fecha_nacimiento,
				TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) AS edad
			FROM
				persona AS p
			WHERE p.estado=1
				
			ORDER BY p.nombre ASC;
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

	public static function obtener_empleados_guardar(){
		$sql="SELECT p.id as id, p.nombre as nombre FROM persona as p WHERE p.email NOT IN(SELECT u.email FROM tb_usuario as u)";
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
	public static function nuevo_empleado($data){
		$id_persona=Genericas2::retonrar_id_insertar("persona");
		$oculto=date("Yisisus");
		$sql="INSERT INTO `persona`(`nombre`, `telefono`, `email`, `codigo_oculto`, `dui`, `nit`, `genero`, `direccion`,`fecha_nacimiento`) VALUES ('$data[nombre]','$data[telefono]','$data[email]','$oculto','$data[dui]','$data[nit]','$data[genero]','$data[direccion]','1990-12-03')";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$datos = array($oculto);
	 		return array("1",$datos,$sql);
	 		exit();
		}catch(Exception $e){
			$datos = array("error");
	 		return array("-1",$datos,$sql,$e->getMessage());
	 		exit();
		}
		
		
	}

	//funcion editar empleado
	public static function editar_empleado($data){
		$sql="UPDATE `persona` SET `nombre`='$data[nombre]',`telefono`='$data[telefono]',`email`='$data[email]',`dui`='$data[dui]',`nit`='$data[nit]',`genero`='$data[genero]',`direccion`='$data[direccion]',`fecha_nacimiento`='$data[fecha_nacimiento]' WHERE $data[id]";
		return array("1","exito",$sql);
	}

	//crear modal para editar
	public static function modal_editar($id){
		$sql="SELECT * FROM persona WHERE id=$id";
		$empleado="";
		$comando=Conexion::getInstance()->getDb()->prepare($sql);
		$comando->execute();
		while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
			$empleado=$row;
		}

		$html.='<div class="modal fade modal-side-fall" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Editar empleado '.$empleado[nombre].'</h4>
          </div>
          <div class="modal-body">
          <form method="post" accept-charset="utf-8" name="fm_editar_empleado" id="fm_editar_empleado">
            <input type="hidden" name="data_id" value="editar_empleado">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Nombre(*)</label>
                      <input type="hidden" name="id_empleado" value="'.$empleado[id].'"
                      <input type="text" class="form-control" id="n_nombre" name="nombre" required="" placeholder="Ingrese el nombre" value="'.$empleado[nombre].'" >
                    </div>
                    <div class="form-group">
                      <label for="n_precio">Email(*)</label>
                      <input type="email" class="form-control" id="n_email" value="'.$empleado[email].'" name="email" placeholder="Ingrese el email" required="">
                    </div>
                    <div class="form-group">
                      <label for="np_nombre">Teléfono(*)</label>
                      <input type="text" required class="form-control telefono" id="n_telefono" name="telefono" aria-describedby="nombrelHelp" placeholder="Ingrese el teléfono" value="'.$empleado[telefono].'">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Dirección(*):</label>
                        <textarea name="direccion" required class="form-control" id="n_direccion" cols="30" rows="4">'.$empleado[direccion].'</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label class="control-label" for="rol">DUI(*):</label>
                        <input type="text" required name="dui" id="n_dui" value="'.$empleado[dui].'" class="form-control dui">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">NIT(*):</label>
                        <input type="text" value="'.$empleado[nit].'" required name="nit" id="n_nit" class="form-control nit">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Género(*):</label>
                        <select id="genero" required name="genero" class="form-control select_piker2" data-plugin="selectpicker" data-live-search="true" data-placeholder="Seleccione el Municipio" readonly="" style="width: 250px;">
                            <option value="" disabled="" selected="">seleccione..</option>';
                            if($empleado[genero]=='Femenino'){
                            	$html.='<option selected value="Femenino">Femenino</option>
                            		<option value="Másculino">Másculino</option>';
                            }else{
                            	$html.='<option value="Femenino">Femenino</option>
                            		<option selected value="Másculino">Másculino</option>';
                            } 
                        $html.='</select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                           <!--label for="firma1">Imagen(*):</label-->
                           <div class="form-group eleimagen" >';
                           if($empleado[imagen]==""){
                           	$html.='<img src="../../img/imagenes_subidas/image.svg" style="width: 200px;height: 202px;" id="img_file">';
                           }else{
                           	$html.='<img src="../../img/usuario/'.$empleado[imagen].'" style="width: 200px;height: 202px;" id="img_file">';
                           }
                              
                              $html.='<input type="file" class="archivos hidden" value="'.$empleado[imagen].'" id="file_1" name="file_1" />
                           </div>
                        </div>
                        <div class="col-md-6 col-xs-6 ele_div_imagen">
                            <div class="form-group">
                                  <h5>La imagen debe de ser formato png o jpg con un peso máximo de 3 MB</h5>
                            </div><br><br>
                            <div class="form-group">
                              <button type="button" class="btn btn-sm btn-primary" id="btn_subir_img"><i class="icon md-upload" aria-hidden="true"></i> Seleccione Imagen</button>
                            </div>
                            <div class="form-group">
                              <div id="error_formato1" class="hidden"><span style="color: red;">Formato de archivo invalido. Solo se permiten los formatos JPG y PNG.</span>
                              </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
          </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btn_actualizar">Actualizar</button>
          </div>
        </div>
      </div>
    </div>';

		return array("1",$empleado,$sql,$html);
	    exit();

	}

	public static function eliminar_empleado($id){
		$sql="UPDATE persona SET estado=2 WHERE id=$id";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			return array("1","exito",$sql);
		}catch(Exception $e){
			return array("-1",$e->getMessage(),$e->getLine(),$sql);
		}

		
	}

	public static function get_img_anterior($id){
		$sql="SELECT imagen FROM persona WHERE codigo_oculto = '$id';";
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
		$sql="UPDATE `persona` SET `imagen` = '$imagen' WHERE `codigo_oculto` = '$id';";
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
}
 ?>