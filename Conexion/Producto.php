<?php 
include_once('Conexion.php');
 class Producto
 {
 	
 	function __construct($argument)
 	{
 		# code...
 	}

 	public static function obtener_productos(){
 		$sql = "SELECT
 			p.id,
			p.nombre,
			p.descripcion,
			p.sku,
			p.codigo_barra,
			p.cantidad,
			p.imagen,
			p.precio_unitario,
			d.nombre AS departamento,
			c.nombre AS categoria,
			s.nombre AS sub
		FROM
			tb_producto AS p
		INNER JOIN tb_departamento AS d ON d.id = p.departamento
		INNER JOIN tb_categoria AS c ON c.id = p.categoria
		INNER JOIN tb_subcategoria AS s ON s.id = p.subcategoria
		WHERE
			p.estado = 1
		ORDER BY
			p.nombre ASC";
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

 	//obtener inventario
 	public static function obtener_inventario($id){
 		$sql = "SELECT
			p.nombre,
			 p.descripcion,
			 p.sku,
			i.tipo,
			i.cantidad,
			i.fecha,
			i.precio_unitario,
			p.precio_unitario as precio
			FROM
				tb_inventario AS i
			INNER JOIN tb_producto AS p ON i.producto = p.id
			WHERE
				p.estado = 1
			AND p.id=$id
			ORDER BY
				p.nombre ASC";
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

 	public static function guardar($data){
 		$oculto=date("Yidisus");
 		$codigo_barra = "0 ".date("Yidisus");
 		$sku = date("Yidisus").rand(1,100);
 		$last_insert = "";
 		if($data['fecha_vencimiento']==''){
 			$sql="INSERT INTO `tb_producto`(`nombre`, `departamento`, `categoria`, `subcategoria`, `descripcion`, `precio_unitario`, `cantidad`, `proveedor`, `sku`, `codigo_barra`, `porcentaje_ganancia`, `codigo_oculto`) VALUES ('$data[nombre]','$data[departamento]','$data[categoria]','$data[subcategoria]','$data[descripcion]','$data[precio]','$data[cantidad]','$data[proveedor]','$sku','$codigo_barra',0.4,'$oculto')";
 		}else{
 			$sql="INSERT INTO `tb_producto`(`nombre`, `departamento`, `categoria`, `subcategoria`, `descripcion`, `precio_unitario`, `cantidad`, `fecha_vencimiento`, `proveedor`, `sku`, `codigo_barra`, `porcentaje_ganancia`, `codigo_oculto`) VALUES ('$data[nombre]','$data[departamento]','$data[categoria]','$data[subcategoria]','$data[descripcion]','$data[precio]','$data[cantidad]','$data[fecha_vencimiento]','$data[proveedor]','$sku','$codigo_barra',0.4,'$oculto')";
 		}
 		try{
 			$comando=Conexion::getInstance()->getDb()->prepare($sql);
 			$comando->execute();
 			if($comando){
 				$sql_select="SELECT p.id,p.cantidad,p.precio_unitario FROM tb_producto as p WHERE p.codigo_oculto='$oculto'";
 				$comando4=Conexion::getInstance()->getDb()->prepare($sql_select);
 				$comando4->execute();
 				while ($row=$comando4->fetch(PDO::FETCH_ASSOC)) {
 					$last_insert=$row;
 				}
 				$fech=date("Y-m-d");
 				$sql1="INSERT INTO `tb_inventario`(`fecha`, `producto`, `cantidad`, `precio_unitario`, `tipo`) VALUES ('$fech','$last_insert[id]','$data[cantidad]','$data[precio]',1)";
 				try{
 					$comando2=Conexion::getInstance()->getDb()->prepare($sql1);
 					$comando2->execute();
 				}catch(Exception $e){
 					return array("-1","error2",$e->getMessage(),$sql);
 				}

 				
 			}
 			return array("1",$oculto,$sql);
 		}catch(Exception $e){
 			return array("-1","error",$e->getMessage(),$sql);
 		}
 	}

 	//actualizar inventario
 	public static function actualizar_inventario($producto,$cantidad,$precio,$tipo){
 		$fecha=date("Y-m-d");
 		$productito="";
 		$sql_producto="";
 		$sql="INSERT INTO `tb_inventario`(`fecha`, `producto`, `cantidad`, `precio_unitario`, `tipo`) VALUES ('$fecha','$producto','$cantidad','$precio','$tipo')";
 		try{
 			$comando=Conexion::getInstance()->getDb()->prepare($sql);
 			$comando->execute();
 			if($comando){
 				$sql_producto="SELECT p.cantidad,p.precio_unitario FROM tb_producto as p WHERE p.id=$producto";
 				$comando2=Conexion::getInstance()->getDb()->prepare($sql_producto);
 				$comando2->execute();
 				while ($row=$comando2->fetch(PDO::FETCH_ASSOC)) {
 					$productito=$row;
 				}

 				if($productito){
 					if($tipo==1){
 						$canti=$productito['cantidad'];
		 				$canti=$canti+$cantidad;
		 				$preci=$productito['precio_unitario'];
		 				$preci=($preci+$precio)/2;
 					}else{
 						$canti=$productito['cantidad'];
		 				$canti=$canti-$cantidad;
		 				$preci=$productito['precio_unitario'];
 					}

	 				$sql_update="UPDATE tb_producto SET cantidad=$canti, precio_unitario=$preci WHERE id=$producto";

	 				try{
	 					$comando3=Conexion::getInstance()->getDb()->prepare($sql_update);
	 					$comando3->execute();
	 					return array("1",$sql,$productito,$sql_update);
	 				}catch(Exception $e){
	 					return array("-1","error2",$e->getMessage(),$sql,$sql_producto);
	 				}
 				}


 			}
 			return array("1",$sql,$productito,$sql_update);
 		}catch(Exception $e){
 			return array("-1","error",$e->getMessage(),$sql,$sql_producto);
 		}
 	}

 	public static function get_img_anterior($id){
		$sql="SELECT imagen FROM tb_producto WHERE codigo_oculto = '$id';";
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
		$sql="UPDATE `tb_producto` SET `imagen` = '$imagen' WHERE `codigo_oculto` = '$id';";
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

	public static function modal_ver($id){
		$sql="SELECT
 			p.id,
			p.nombre,
			p.descripcion,
			p.sku,
			p.codigo_barra,
			p.cantidad,
			p.imagen,
			p.precio_unitario,
			d.nombre AS departamento,
			c.nombre AS categoria,
			s.nombre AS sub
		FROM
			tb_producto AS p
		INNER JOIN tb_departamento AS d ON d.id = p.departamento
		INNER JOIN tb_categoria AS c ON c.id = p.categoria
		INNER JOIN tb_subcategoria AS s ON s.id = p.subcategoria
		WHERE
			p.estado = 1
		AND p.id=$id
		ORDER BY
			p.nombre ASC";
			try {
		$comando = Conexion::getInstance()->getDb()->prepare($sql);
        $comando->execute();
        $producto="";
        //$datos = $comando->fetchAll(PDO::FETCH_ASSOC);
        while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
        	$producto=$row;
        }

        $modal='<div class="modal fade modal-side-fall" id="md_ver_producto" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <div class="row">
            	<div class="col-md-6">
            		<img src="../../img/productos/'.$producto[imagen].'" width="400" height="400">
            	</div>
            	<div class="col-md-6">
            		<table class="table">
                <tbody>
                    <tr>
                        <th>SKU</th>
                        <td>'.$producto[sku].'</td>
                    </tr>
                    <tr>
                        <th>Nombre del producto</th>
                        <td>'.$producto[nombre].'</td>
                    </tr>
                    <tr>
                        <th>Descripción</th>
                        <td>'.$producto[descripcion].'</td>
                    </tr>
                    <tr>
                        <th>Precio</th>
                        <td>$'.number_format($producto[precio_unitario],2).'</td>
                    </tr>
                    <tr>
                        <th>Cantidad disponible</th>
                        <td>'.$producto[cantidad].'</td>
                    </tr>
                    <tr>
                        <th>Departamento</th>
                        <td>'.$producto[departamento].'</td>
                    </tr>
                    <tr>
                        <th>Categoría</th>
                        <td>'.$producto[categoria].'</td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>'.$producto[subcategoria].'</td>
                    </tr>
                    <tr>
                        <td colspan="2"><img src="../../lib/Barcode/barcode.php?text='.$producto[codigo_barra].'&print=true" width="300" height="70"></td>
                    </tr>
                </tbody>
            </table>
            	</div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>';

            return array("1",$producto,$sql,$modal);
		} catch (Exception $e) {
			return array("-1",$e->getMessage(),$e->getLine(),$sql);
			exit();
		}
	}
 } 
 ?>