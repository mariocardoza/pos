<?php 
	@session_start();
	require_once 'Conexion.php';

	/**
	* 
	*/
	class Genericas2 
	{
		
		function __construct($argument)
		{
			# code...
		}
		public static function seleccionar_todo($array){
			$as = 0;
			$tabla= $campo = $llaves = $valor = "";

			foreach(array_keys($array) as $key ) {
				$as++;
				if ($key === 'table') {//obtengo tabla
	 				$tabla = $array[$key];
	 			}else if ($as===2) {//obtengo el where
	 				$valor = $array[$key];
	 				$campo = $key;
	 			}else if ($as>2) {//obtengo valores a sacar
	 				$llaves.=$key;
					if ($as <count($array)) {
							$llaves.=",";
					}
	 			} 
			}

			$sql = "SELECT $llaves FROM $tabla WHERE $campo = '$valor'";
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	       		$comando->execute();
	       		$resultado = $comando->fetchAll();
	       		return array("1",$resultado,$sql);
				//echo json_encode(array("exito" => $exito));
			} catch (Exception $e) {
				return array("0","error",$e->getMessage(),$e->getLine(),$sql);
	            //echo json_encode(array("error" => $error));
			}

		}


		public static function seleccionar_especifico_detabla($array){
			$as = 0;
			$tabla= $campo = "";

			foreach(array_keys($array) as $key ) {
				$as++;
				if ($key === 'table') {//obtengo tabla
	 				$tabla = $array[$key];
	 			}else if ($as===2) {//obtengo tabla
	 				$campo = $array[$key];
	 			} 
			}

			$sql = "SELECT $campo FROM $tabla";
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	       		$comando->execute();
	       		$resultado = $comando->fetchAll(PDO::FETCH_COLUMN, 0);
	       		return array($resultado[0],$sql);
				//echo json_encode(array("exito" => $exito));
			} catch (Exception $e) {
				return array("0","error",$e->getMessage(),$e->getLine(),$sql);
	            //echo json_encode(array("error" => $error));
			}

		}




		public static function seleccionar_cualquiera($array){
			$as = 0;
			$tabla= $campo = "";

			foreach(array_keys($array) as $key ) {
				$as++;
				if ($key === 'table') {//obtengo tabla
	 				$tabla = $array[$key];
	 			}else if ($as===2) {//obtengo tabla
	 				$campo = $array[$key];
	 			}else if ($as===3) {//obtengo tabla
	 				$whereid = $key;
	 				$valor_whereid = $array[$key];
	 			}
			}

			$sql = "SELECT $campo FROM $tabla WHERE $whereid = '$valor_whereid'";
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	       		$comando->execute();
	       		$resultado = $comando->fetchAll(PDO::FETCH_COLUMN, 0);
	       		return array($resultado[0],$sql);
				//echo json_encode(array("exito" => $exito));
			} catch (Exception $e) {
				return array("0","error",$e->getMessage(),$e->getLine(),$sql);
	            //echo json_encode(array("error" => $error));
			}

		}

		
		public static function retonrar_id_insertar($tabla){
			$gsent = Conexion::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM $tabla");
			$gsent->execute();
			$resultado = $gsent->fetchAll(PDO::FETCH_COLUMN, 0);
			return date("Yidisus").'-'.($resultado[0]+1);
		}

		public static function retornar_imagen($array_imagen){
			$tabla = $campo_buscar = $valor_campo_buscar = $campo_comparar = "";
			$as=0;

			foreach(array_keys($array_imagen) as $key ) {//recorro el array que me envia mi json
	 			$as++;
	 			if ($key === 'table') {//obtengo tabla
	 				$tabla = $array_imagen[$key];
	 			}else if ($as===2) {
	 				$valor_campo_buscar = $array_imagen[$key];
	 				$campo_comparar= $key;
	 			}
	 			else if ($key === 'campo') {//obtengo el campo a comparar
	 				$campo_buscar = $array_imagen[$key];
	 				 
				}
			}

			$sql = "SELECT $campo_buscar FROM $tabla WHERE $campo_comparar = '$valor_campo_buscar'";
			/*return array("1",$sql,$array_imagen);
			exit();*/
			$gsent = Conexion::getInstance()->getDb()->prepare($sql);
			$gsent->execute();
			$resultado = $gsent->fetchAll(PDO::FETCH_COLUMN, 0);
			if (isset($resultado[0]) && $resultado[0]!="") {
				return array("1",$resultado[0],$sql);
			}else{
				return array("0",$sql,$resultado,$sql);
			}
			
		}
		public static function retornar_contactos2($id_ingenio,$pertenece_a){
			$html='';
			$html.='<table id="tabla_telefonos" class="table table-bordered table-striped table-vcenter">
			            <thead>
			                <tr>
			                    
			                    <th class="text-left">Nombre</th>
			                    <th class="text-left">Tipo</th>
			                    <th class="text-left">Número de Teléfono</th>
			                    <th class="text-left">Email</th>
			                    <th class="text-left">Acciones</th>
			                </tr>
			            </thead>
			            <tbody>';
			$labels['0']['class']   = "label-success";
            $labels['0']['text']    = "Available";
            $labels['1']['class']   = "label-danger";
            $labels['1']['text']    = "Out of Stock";

			try {
				$sql = "SELECT 
							i.id as elid,
							i.id_ingenio,
							i.contacto as nombre,
							i.telefono,
							i.email,
							i.descripcion,
							i.id_tipo_contactos,
							tc.contacto as elcontacto,i.pertenece_a
						FROM
							ingenio_contactos as i
						JOIN tipo_contactos as tc
						ON tc.id = i.id_tipo_contactos
						WHERE
							i.id_ingenio = '$id_ingenio' and i.pertenece_a='$pertenece_a'";

                $comando = Conexion::getInstance()->getDb()->prepare($sql);
                $comando->execute();
                while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                	$html.="<tr>";
                    $html.="<td>$row[nombre]</td>";
                    $html.="<td>$row[elcontacto]</td>";
                    $html.="<td>$row[telefono]</td>";
                     $html.="<td>$row[email]</td>";
					$html.="<td class='text-center nowrap'> 
                            
                                <a id='a1' class='btn btn-sm btn-primary' data-pertenece_a ='$row[pertenece_a]' data-tipocontactos ='$row[id_tipo_contactos]' data-iid ='$row[elid]' data-contacto ='$row[nombre]' data-telefono ='$row[telefono]' data-email ='$row[email]' data-descripcion ='$row[descripcion]' data-nombre ='$row[nombre]' data-toggle='tooltip' title='Editar' href='javascript:void(0)' data-toggle='modal' ><i class='fa fa-pencil pull-center'></i></a>

                                
                                <a data-iid ='$row[elid]'  class='btn btn-sm btn-danger' id='btneliminar' data-toggle='tooltip' href='javascript:void(0)' title='Eliminar' ><i class='fa fa-trash pull-center'></i></a>
                                

                             
                        </td>
                    </tr>";



                }

                $html.='</tbody>
        		</table>';

        		$script="App.datatables();
        		$('#tabla_telefonos').dataTable({
	                columnDefs: [
	                    { type: 'date-custom', targets: [1] },
	                    { orderable: false, targets: [2] }
	                ],
	                order: [[ 0, 'desc' ]],
	                pageLength: 5,
	                lengthMenu: [[5, 20, 30, -1], [5, 20, 30, 'Todo']]
	            });";


               	return array('1',$sql,$html,$script);
			} catch (Exception $e) {
				return array('-1',$e->getMessage(),$e->getLine());
			}
		}

		public static function encriptar_datos($datos, $key){

		}
		public static function insertar_generica($array_values){
			$tabla = "";
	 		$values = "";
	 		$llaves = "";
			$as =0;
	 		foreach(array_keys($array_values) as $key ) {
	 			$as++;
	 			if ($key === 'table') {
	 				$tabla = $array_values[$key];
	 			} 
	 			if ($as>1) {
	 				$llaves.=$key;
					$values.="'".$array_values[$key]."'";
					if ($as <count($array_values)) {
							$values.=",";
							$llaves.=",";
					}
				}
	 		}
			$sql ="INSERT INTO $tabla($llaves)values($values)";;
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	       		$comando->execute();
	       		return array("1","Insertado");
				//echo json_encode(array("exito" => $exito));
			} catch (Exception $e) {
				return array("0","error",$e->getMessage(),$e->getLine(),$sql);
	            //echo json_encode(array("error" => $error));
			}
		}

		//insert into table ()values()
		//update table set campo = value()
		public static function actualizar_generica($array_values){
			//preparo variables
			$tabla = "";
			$wherid="";
	 		$valor_whereid="";
	 		$values = "";
	 		$llaves = "";
	 		$sentencia_update = "";
	 		$as =0;
			$agregando_as="";
			foreach(array_keys($array_values) as $key ) {//recorro el array que me envia mi json
	 			$as++;
	 			if ($key === 'table') {//obtengo tabla
	 				$tabla = $array_values[$key];
	 			}else if ($as===2) {//obtengo id para update
	 				$valor_whereid = $array_values[$key];
	 				$wherid= $key;
	 			} 
	 			else if ($as>2) {//creo los set
	 				$llaves.=$key;
					$values.="'".$array_values[$key]."'";
					$sentencia_update.= $key.'='."'".$array_values[$key]."'";
					if ($as <count($array_values)) {
							$values.=",";
							$llaves.=",";
							$sentencia_update.=',';
					}
					$agregando_as.=$as;
				}
	 		}

	 		$sql ="UPDATE $tabla SET $sentencia_update WHERE $wherid = '$valor_whereid'";//String de update creada
	 		/*return array("1","2",$sql,$as,$agregando_as);
	 		exit();*/
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);//ejecutro la actualización
	       		$comando->execute();
	       		return array("1",array("Actualizado",$sql));//retorno en caso de exito 
				//echo json_encode(array("exito" => $exito));
			} catch (Exception $e) {
				return array("0","Error al actualizar",$e->getMessage(),$e->getLine(),$sql);//retorno mensajes en caso de error
			}




		}

		public static function eliminar_generica($array_values){
			$tabla = $valor_campo=$campo="";
			$as=0;
			foreach(array_keys($array_values) as $key ) {
				$as++;
	 			if ($key === 'table') {//obtengo tabla
	 				$tabla = $array_values[$key];
	 			}else if ($as === 2) {//obtengo id para update
	 				$valor_campo = $array_values[$key];
	 				$campo= $key;
	 			} 
			}

			$sql = "DELETE FROM $tabla WHERE $campo = '$valor_campo'";
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	            $comando->execute();
	            return array("1","Eliminado");
	        }catch(Exception $e){
	        	return array("0","Error al eliminar",$e->getMessage(),$e->getLine(),$sql);
	        	exit();
	        }
			 
		}

		/***/
		//
		//emailte: valor del campo puede ser telefono o correo 
		//valor_delcampo: es el valor a buscar
		//tabla: el nombre de la tabla
		//quees: si es un insert o un update
		//valor_antiguo: si es una actualizacion sera el campo anterior, si es un insert sera 0
		public static function validar($emailte,$valor_delcampo,$tabla,$quees,$valor_antiguo){
			$campo = "";
			if ($emailte == "email" || $emailte =="correo") {
				$campo = ($emailte=="email") ? $emailte : "correo";
			}else{
				$campo = ($emailte=="telefono") ? $emailte : "telefono_movil";
			}

			$campo_sacado="";
			$sql = ($quees ==1) ? "SELECT $campo from $tabla WHERE $campo = '$valor_delcampo'" : "SELECT $campo from $tabla WHERE $campo = '$valor_delcampo' AND $campo <> '$valor_antiguo'";
			try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	            $comando->execute();

	            while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
	                $campo_sacado = $row[$campo];
            	}
            	if($cuenta = $comando->rowCount()>0){
            		return array("1",$campo_sacado,$sql);
					exit();
            	}else{
            		return array("2",$campo_sacado,$sql);
					exit();
            	}
				
				
			} catch (Exception $e) {
				return array("-1",$e->getMessage(),$e->getLine(),$sql);
				exit();
			}

		}

		public static function generarpass(){
		    $cadena_base =  'abcdefghijklmnopqrstuvwxyz';
		    $cadena_base .= '0123456789' ;
		    //$cadena_base .= '!@#%^&*()_,./<>?;:[]{}\|=+';
		    $cadena_base .= '';
			$password = '';
			$limite = strlen($cadena_base) - 1;
			$largo = 8;
			for ($i=0; $i < $largo; $i++)
			$password .= $cadena_base[rand(0, $limite)];

			return $password;
		}
		
		public static function generartoken(){
		    $cadena_base .= '0123456789' ;
		    //$cadena_base .= '!@#%^&*()_,./<>?;:[]{}\|=+';
		    $cadena_base .= '';
			$password = '';
			$limite = strlen($cadena_base) - 1;
			$largo = 6;
			for ($i=0; $i < $largo; $i++)
			$password .= $cadena_base[rand(0, $limite)];

			return $password;
		}
	}
	


?>