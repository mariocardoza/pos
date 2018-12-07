<?php 
/**
* 
*/
@session_start();
require_once 'Conexion.php';
class Perfilempresa
{
	
	function __construct(){
	}

	public static function lasenfermedades($empresa){
		$html="";
		$array_enfermedades="";
		$as=0;
		try {
			$sql="SELECT id,historia_medica as letra, COUNT(*) as repeticiones
					FROM consulta_empleados
					WHERE id_empresa = '$empresa'
					GROUP BY historia_medica
					ORDER BY repeticiones DESC";
			$comando = Conexion::getInstance()->getDb()->prepare($sql);
          	$comando->execute();
          	$array_enfermedades = $comando->fetchAll();
          	$html.='<table class="table table-borderless table-striped table-condensed table-vcenter">
                        <thead>
                          <tr>
                              <th class="text-left">No.</th>
                              <th class="text-left">Enfermedad</th>
                              <th class="text-left">Cantidad</th>
                          </tr>
                        </thead>
                      <tbody>';
          	
          	foreach ($array_enfermedades as $row) {
          		$as++;
          		$html.='<tr>';
	                $html.='<td style="width: 10px;">'.$as.'</td>';
	                $html.='<td><a href="javascript:void(0)"><strong>'.$row[letra].'</strong></a></td>';
	                $html.='<td><strong>'.$row[repeticiones].'</strong></td>';
                $html.='</tr>';
          	}	
          	$html.='</tbody></table>';
			 
            return $html;

		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	public static function enfermedades($id){
		$html="";
		$array_enfermedades="";
		$as=0;
		try {
			$sql="SELECT
					id,
					uno_diagnostico,
					COUNT( * ) AS repeticiones 
				FROM
					cuestionario_empleados 
				GROUP BY
					uno_diagnostico 
				ORDER BY
					id DESC";
			$comando = Conexion::getInstance()->getDb()->prepare($sql);
          	$comando->execute();
          	$array_enfermedades = $comando->fetchAll();
          	$html.='<table class="table table-borderless table-striped table-condensed table-vcenter">
                        <thead>
                          <tr>
                              <th class="text-left">No.</th>
                              <th class="text-left">Enfermedad</th>
                              <th class="text-left">Cantidad</th>
                          </tr>
                        </thead>
                      <tbody>';
          	
          	foreach ($array_enfermedades as $row) {
          		$as++;
          		$html.='<tr>';
	                $html.='<td style="width: 10px;">'.$as.'</td>';
	                $html.='<td><a href="javascript:void(0)"><strong>'.$row[uno_diagnostico].'</strong></a></td>';
	                $html.='<td><strong>'.$row[repeticiones].'</strong></td>';
                $html.='</tr>';
          	}	
          	$html.='</tbody></table>';
			 
            return $html;

		} catch (Exception $e) {
			return $e->getMessage();
		}

	}



	public static function reducciones_por_mes($empresa){
		$html=$array_hconsultas="";
		$as=0;
		try {
			$sql = "SELECT
			ce.id,
			ce.fecha_registro,
			ce.pesolb, ce.id_empleado,ce.id_empresa,
			cu.id_empleado, cu.id_empresa, cu.pesolb,ce.pesolb,
			sum(cu.pesolb-ce.pesolb) as resta,MONTH(ce.fecha_registro) as mes,
			CASE
				WHEN MONTH(ce.fecha_registro) = '1' THEN 'ENERO'
				WHEN MONTH(ce.fecha_registro) = '2' THEN 'FEBRERO'
				WHEN MONTH(ce.fecha_registro) = '3' THEN 'MARZO'
				WHEN MONTH(ce.fecha_registro) = '4' THEN 'ABRIL'
				WHEN MONTH(ce.fecha_registro) = '5' THEN 'MAYO'
				WHEN MONTH(ce.fecha_registro) = '6' THEN 'JUNIO'
				WHEN MONTH(ce.fecha_registro) = '7' THEN 'JULIO'
				WHEN MONTH(ce.fecha_registro) = '8' THEN 'AGOSTO'
				WHEN MONTH(ce.fecha_registro) = '9' THEN 'SEPTIEMBRE'
				WHEN MONTH(ce.fecha_registro) = '10' THEN 'OCTUBRE'
				WHEN MONTH(ce.fecha_registro) = '11' THEN 'NOVIEMBRE'
				ELSE 'DICIEMBRE'
			END AS mesletra
		FROM
			consulta_empleados as ce
		JOIN cuestionario_empleados as cu
		ON ce.id_empleado = cu.id_empleado
		WHERE
			ce.id_empresa = '$empresa'
			and ce.id IN (SELECT id from consulta_empleados WHERE id_empresa='$empresa')
		GROUP BY MONTH(ce.fecha_registro)";
			$comando = Conexion::getInstance()->getDb()->prepare($sql);
          	$comando->execute();
          	$array_hconsultas = $comando->fetchAll();
          	
          	$html.='<table class="table table-borderless table-striped table-condensed table-vcenter">
          				<thead>
                          	<tr>
                              	<th class="text-left">Mes</th>
                              	<th class="text-right">Reducido(lb)</th>
                          	</tr>
                        </thead>
                    <tbody>
                    ';
            $ele="";
            $sumando=0;
            $as2=0;
          	foreach ($array_hconsultas as $row) {
          		$as++;
          		/*$ele = $row[mes];
          		if ($ele == $row[mes]) {
          			$sumando=$row[resta]+$sumando;
          			
          		}else{
          			$html.='<tr>';
	                $html.='<td><a href="javascript:void(0)"><strong>'.$row[mesletra].'</strong></a></td>';
	                $html.='<td class="text-right">'.$sumando.'</td>';
	                $html.='</tr>';
          		}*/

          		$html.='<tr>';
	            $html.='<td><a href="javascript:void(0)"><strong>'.$row[mesletra].'</strong></a></td>';
	            $html.='<td class="text-right">'.$row[resta].'</td>';
	            $html.='</tr>';
            }
           

            $html.='</tbody>
                    </table>';

			return $html;
		} catch (Exception $e) {
			return $e->getMessage();
			
		}
	}


	public static function metabolicos($empresa){

		$html=$array_hconsultas="";
		$as=0;
		try {
			$sql = "SELECT id,tipopaciente, COUNT(*) as repeticiones,
					CASE 
						WHEN tipopaciente = '1' THEN 'Metabólicos'
						WHEN tipopaciente = '2' THEN 'Condicion Normal'
					END AS letras
					FROM empleados
					WHERE empresa = '$empresa'
					GROUP BY tipopaciente
					ORDER BY repeticiones DESC";
			$comando = Conexion::getInstance()->getDb()->prepare($sql);
          	$comando->execute();
          	$array_hconsultas = $comando->fetchAll();
          	
          	$html.='<table class="table table-borderless table-striped table-condensed table-vcenter">
          				<thead>
                          	<tr>
                              	<th class="text-left">Tipo </th>
                              	<th class="text-right">Cantidad</th>
                          	</tr>
                        </thead>
                    <tbody>
                    ';
            $ele="";
            $sumando=0;
            $as2=0;
          	foreach ($array_hconsultas as $row) {
          		$as++;
          		 

          		$html.='<tr>';
	            $html.='<td><a href="javascript:void(0)"><strong>'.$row[letras].'</strong></a></td>';
	            $html.='<td class="text-right">'.$row[repeticiones].'</td>';
	            $html.='</tr>';
            }
           

            $html.='</tbody>
                    </table>';

			return $html;
		} catch (Exception $e) {
			return $e->getMessage();
			
		}
 




	}









}


?>