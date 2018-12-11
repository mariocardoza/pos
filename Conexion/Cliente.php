<?php
@session_start(); 
require_once("Conexion.php");
/**
 * 
 */
class Cliente
{
	
	function __construct($argument)
	{
		# code...
	}

	public static function guardar($data){
		if($data['fecha_nacimiento']!=''){
			$var=explode('/',$data['fecha_nacimiento']);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
		}else{
			$fecha=date("Y-m-d");
		}
		if(isset($data['tipocliente']))$tipo=2;
		else $tipo=1;
		$codigo_oculto=date("Yidisus");
		$sql="INSERT INTO `tb_cliente`(`nombre`, `dui`, `direccion`, `telefono`, `email`, `fecha_nacimiento`, `nit`, `nrc`, `razon_social`, `giro`, `retiene`, `tipo`, `codigo_oculto`,`nombre_r`, `telefono_r`, `direccion_r`,`tipocontribuyente`) VALUES ('$data[nombre]','$data[dui]','$data[direccion]','$data[telefono]','$data[email]','$fecha','$data[nit]','$data[nrc]','$data[razon_social]','$data[giro]',$data[retiene],$tipo,'$codigo_oculto','$data[nombre_r]','$data[telefono_r]','$data[direccion_r]','$data[tipocontribuyente]')";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			return array(1,"exito",$sql);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}

	public static function obtener_naturales(){
		$sql="SELECT c.*,CASE WHEN c.tipo=1 THEN 'Persona Natural' else '' end as eltipo FROM tb_cliente as c WHERE c.tipo=1 AND c.estado=1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$datos = $comando->fetchAll(PDO::FETCH_ASSOC);
            return array(1,$datos,$sql);
            exit();
		}catch(Exception $e){
			return array(-1,$e->getMessage(),$e->getLine(),$sql);
			exit();
		}
	}

	public static function obtener_juridicos(){
		$sql="SELECT c.*,CASE WHEN c.tipo=2 THEN 'Persona Jurídica' else '' end as eltipo,case WHEN c.tipocontribuyente=1 THEN 'Pequeño contribuyente' WHEN c.tipocontribuyente=2 THEN 'Mediano contribuyente' ELSE 'Gran contribuyente' end as contri FROM tb_cliente as c WHERE c.tipo=2 AND c.estado=1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$datos = $comando->fetchAll(PDO::FETCH_ASSOC);
            return array(1,$datos,$sql);
            exit();
		}catch(Exception $e){
			return array(-1,$e->getMessage(),$e->getLine(),$sql);
			exit();
		}

	}

	public static function val_email($email){
		$sql="SELECT * FROM tb_cliente AS c WHERE c.email = '$email';"; 
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
		$sql="SELECT * FROM tb_cliente AS c WHERE c.telefono = '$telefono';"; 
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
	public static function val_nrc($nrc){
		$sql="SELECT * FROM tb_cliente AS c WHERE c.nrc = '$nrc';"; 
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
	public static function val_dui($dui){
		$sql="SELECT * FROM tb_cliente AS c WHERE c.dui = '$dui';"; 
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
	public static function val_nit($nit){
		$sql="SELECT * FROM tb_cliente AS c WHERE c.nit = '$nit';"; 
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

	public static function editar($data){
		$sql="UPDATE `tb_cliente` SET `nombre`='$data[nombre]',`dui`='$data[dui]',`direccion`='$data[direccion]',`telefono`='$data[telefono]',`email`='$data[email]',`fecha_nacimiento`='$data[fecha_nacimiento]',`nit`='$data[nit]',`nrc`='$data[nrc]',`razon_social`='$data[razon_social]',`giro`='$data[giro]',`retiene`=$data[retiene],`nombre_r`='$data[nombre_r]',`telefono_r`='$data[telefono_r]',`direccion_r`='$data[direccion_r]' WHERE id=$data[id]";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			return array(1,"exito",$sql);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}

		
	}

	public static function eliminar($id){
		$sql="UPDATE `tb_cliente` SET `estado`=2 WHERE id=$id";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			return array(1,"exito",$sql);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}

		
	}

	public static function modal_natural($id){
		$sql="SELECT * FROM tb_cliente WHERE id='$id'";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$cliente=$row;
			}
			$modal='<div class="modal fade modal-side-fall" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Editar cliente</h4>
          </div>
          <div class="modal-body">
            <form action="#" method="post" name="fm_cliente" id="fm_cliente" class="form-horizontal form-bordered">
            <div class="row">
		        <div class="col-lg-12">
		            <div class="block">
		                <div class="block-title">
		                    <h2><i class="fa fa-pencil"></i> <strong>Información</strong> general</h2>
		                </div>
		                <div class="row">
			        <div class="col-lg-6">
			            <div class="form-group">
			                <label class="col-md-3 control-label" for="nombre">Nombre</label>
			                <div class="col-md-9">
			                    <input type="hidden" name="data_id" value="editar_cliente">
			                    <input type="hidden" name="id" value="'.$cliente[id].'">
			                    <input type="hidden" name="retiene" value="0">
			                    <input required value="'.$cliente[nombre].'" type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del nombre">
			                </div>
			            </div>
			            <div class="form-group">
			                <label class="col-md-3 control-label" for="direccion">Dirección</label>
			                <div class="col-md-9">
			                    <textarea required id="direccion" name="direccion" class="form-control" rows="3">'.$cliente[direccion].'</textarea>
			                </div>
			            </div>
			            <div class="form-group" id="fdui">
			                <label class="col-md-3 control-label" for="departamento">DUI</label>
			                <div class="col-md-9">
			                    <input type="text" value="'.$cliente[dui].'" name="dui"id="dui" class="form-control dui">
			                </div>
			            </div>
			            <div class="form-group">
			                <label class="col-md-3 control-label" for="categoria">NIT</label>
			                <div class="col-md-9">
			                    <input type="text" value="'.$cliente[nit].'" name="nit" id="nit" class="form-control nit">
			                </div>
			            </div>
			        </div>
			        <div class="col-lg-6">
			            <div class="form-group">
			                <label class="col-md-3 control-label" for="telefono">Número de teléfono</label>
			                <div class="col-md-9">
			                    <input type="text" name="telefono" id="telefono" value="'.$cliente[telefono].'" class="form-control telefono">
			                </div>
			            </div>

			            <div class="form-group">
			                <label class="col-md-3 control-label" for="email">Email</label>
			                <div class="col-md-9">
			                    <div class="form-group">
			                        <input type="email" id="email" name="email" value="'.$cliente[email].'"class="form-control" >
			                    </div>
			                </div>
			            </div>

			            <div class="form-group" id="nacimiento">
			                <label for="" class="col-md-3 control-label">Fecha de nacimiento</label>
			                <div class="col-md-9">
			                    <input type="text" class="form-control nacimiento" value="'.$cliente[fecha_nacimiento].'" name="fecha_nacimiento" id="fecha_nacimiento">
			                </div>
			            </div>
			        </div>
		        </div>
        	</div>
       
        	<div class="col-lg-12">
            <div class="block">
                <div class="form-group">
                	<div class="col-md-10">
                    <center>
                        <button type="button" id="btn_editar" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Guardar</button>
                    <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal"><i class="fa fa-repeat"></i> Cerrar</button>  
                    </center>
                	</div>
            	</div>
            </div>
        	</div>
    		</form>          
		</div>
        </div>
      </div>
    </div>';

            return array("1",$cliente,$sql,$modal);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}

	public static function modal_juridico($id){
		$sql="SELECT * FROM tb_cliente WHERE id='$id'";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$cliente=$row;
			}
			$modal='<div class="modal fade modal-side-fall" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Editar cliente</h4>
          </div>
          <div class="modal-body">
            <form action="#" method="post" name="fm_cliente" id="fm_cliente" class="form-horizontal form-bordered">
            <div class="row">
		        <div class="col-lg-12">
		            <div class="block">
		                <div class="block-title">
		                    <h2><i class="fa fa-pencil"></i> <strong>Información</strong> general</h2>
		                </div>
		                <div class="row">
			        <div class="col-lg-6">
			            <div class="form-group">
			                <label class="col-md-3 control-label" for="nombre">Nombre</label>
			                <div class="col-md-9">
			                    <input type="hidden" name="data_id" value="editar_cliente">
			                    <input type="hidden" name="id" value="'.$cliente[id].'">
			                    <input required value="'.$cliente[nombre].'" type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del nombre">
			                </div>
			            </div>
			            <div class="form-group">
			                <label class="col-md-3 control-label" for="direccion">Dirección</label>
			                <div class="col-md-9">
			                    <textarea required id="direccion" name="direccion" class="form-control" rows="3">'.$cliente[direccion].'</textarea>
			                </div>
			            </div>
			            <div class="form-group" id="fdui">
			                <label class="col-md-3 control-label" for="departamento">DUI</label>
			                <div class="col-md-9">
			                    <input type="text" value="'.$cliente[dui].'" name="dui"id="dui" class="form-control dui">
			                </div>
			            </div>
			            <div class="form-group">
			                <label class="col-md-3 control-label" for="categoria">NIT</label>
			                <div class="col-md-9">
			                    <input type="text" value="'.$cliente[nit].'" name="nit" id="nit" class="form-control nit">
			                </div>
			            </div>
			        </div>
			        <div class="col-lg-6">
			            <div class="form-group">
			                <label class="col-md-3 control-label" for="telefono">Número de teléfono</label>
			                <div class="col-md-9">
			                    <input type="text" name="telefono" id="telefono" value="'.$cliente[telefono].'" class="form-control telefono">
			                </div>
			            </div>

			            <div class="form-group">
			                <label class="col-md-3 control-label" for="email">Email</label>
			                <div class="col-md-9">
			                    <div class="form-group">
			                        <input type="email" id="email" name="email" value="'.$cliente[email].'"class="form-control" >
			                    </div>
			                </div>
			            </div>

			            <div class="form-group" id="nacimiento">
			                <label for="" class="col-md-3 control-label">Fecha de nacimiento</label>
			                <div class="col-md-9">
			                    <input type="text" class="form-control nacimiento" value="'.$cliente[fecha_nacimiento].'" name="fecha_nacimiento" id="fecha_nacimiento">
			                </div>
			            </div>
			        </div>
		        </div>
        	</div>

        	 <div class="col-lg-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Datos</strong> del contribuyente</h2>
                </div>
                <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Número de registro</label>
                        <div class="col-md-9">
                            <input type="text" value="'.$cliente[nrc].'" name="nrc" id="nrc" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Giro</label>
                        <div class="col-md-9">
                            <input type="text" name="giro" id="giro" value="'.$cliente[giro].'"class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Razón social</label>
                        <div class="col-md-9">
                            <input type="text" value="'.$cliente[razon_social].'"id="razon_social" name="razon_social" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Tipo contribuyente</label>
                        <div class="col-md-9">
                            <select name="tipocontribuyente" id="tipocontribuyente" style="width:auto;"data-live-search="true" class="select_piker2">
                                <option value="">Seleccione...</option>
                                <option value="1">Pequeño</option>
                                <option value="2">Mediano</option>
                                <option value="3">Grande</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Nombre del representante legal</label>
                        <div class="col-md-9">
                            <input type="text" id="nombre_r" value="'.$cliente[nombre_r].'" name="nombre_r" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Teléfono del representante legal</label>
                        <div class="col-md-9">
                            <input type="text" id="telefono_r" value="'.$cliente[telefono_r].'"name="telefono_r" class="form-control telefono">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Dirección del representante legal</label>
                        <div class="col-md-9">
                            <textarea name="direccion_r" id="direccion_r" rows="2" class="form-control">'.$cliente[direccion_r].'</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Retiene 1%</label>
                        <div class="col-md-9">
                            <input type="radio" checked name="retiene" value="0">No
                            <input type="radio" name="retiene" value="1">Si
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
       
        	<div class="col-lg-12">
            <div class="block">
                <div class="form-group">
                	<div class="col-md-10">
                    <center>
                        <button type="button" id="btn_editar" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Guardar</button>
                    <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal"><i class="fa fa-repeat"></i> Cerrar</button>  
                    </center>
                	</div>
            	</div>
            </div>
        	</div>
    		</form>          
		</div>
        </div>
      </div>
    </div>';

            return array("1",$cliente,$sql,$modal);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}
}
?>