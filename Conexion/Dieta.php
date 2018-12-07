<?php 
	@session_start();
    require_once 'Conexion.php';

    /**
    * 
    */
    class Dieta
    {
    	
    	function __construct()
    	{
    		# code...
    	}

    	public static function recuatroprincipales($id){
    		$html="";
    		try {
    			$sql = "SELECT
							pesolb,
							estaturacm,
							imc,
							edad_metabolica 
						FROM
							`consulta_empleados` 
						WHERE
							`id_empleado` = '$id'
							and id=(SELECT MAX(id) from consulta_empleados WHERE id_empleado='$id')";
	    		$ejecucion = Conexion::getInstance()->getDb()->prepare($sql);
	          	$ejecucion->execute();
	          	while ($row = $ejecucion->fetch(PDO::FETCH_ASSOC)) {
	          		

	          		$html.='<div class="row text-center">
						        <div class="col-sm-6 col-lg-3">
						            <div class="widget">
						                <div class="widget-extra themed-background-warning">
						                    <h4 class="widget-content-light"><strong>IMC</strong></h4>
						                </div>
						                <div class="widget-extra-full"><span class="h2 text-success animation-expandOpen">'.$row[imc].'</span></div>
						            </div>
						        </div>
						        <div class="col-sm-6 col-lg-3">
						            <div class="widget">
						                <div class="widget-extra themed-background-success">
						                    <h4 class="widget-content-light"> <strong>PESO</strong></h4>
						                </div>
						                <div class="widget-extra-full"><span class="h2 text-success animation-expandOpen">'.$row[pesolb].' lb</span></div>
						            </div>
						        </div>
						        <div class="col-sm-6 col-lg-3">
						            <div class="widget">
						                <div class="widget-extra themed-background-info">
						                    <h4 class="widget-content-light"> <strong>ESTATURA</strong></h4>
						                </div>
						                <div class="widget-extra-full"><span class="h2 text-info">'.$row[estaturacm].' cm</span></div>
						            </div>
						        </div>
						        <div class="col-sm-6 col-lg-3">
						            <div class="widget">
						                <div class="widget-extra themed-background-muted">
						                    <h4 class="widget-content-light"> <strong>EDAD METABOLICA</strong></h4>
						                </div>
						                <div class="widget-extra-full"><span class="h2 text-muted animation-pulse">'.round($row[edad_metabolica]).' años</span></div>
						            </div>
						        </div>
						    </div>';
	          		

	          	}
	          	return $html;
    		} catch (Exception $e) {
    			return $e->getMessage();
    		}
    		
    	}


    	public static function reseleccionar_dieta($id){


    		$html="";
    		$alimentos=0;
    		$alimentos_pri=0;
    		$enfermedades0="";
    		$dieta = 0;
    		
    		$sql="CALL clonar_dieta('0','$id');";
			try {
				$comandose = Conexion::getInstance()->getDb()->prepare($sql);
	        	$comandose->execute();
			} catch (Exception $e) {
				$html.= $e->getMessage();
			}
			

			

          	$sql = "SELECT  dt.id as elid, dt.nombre as nombre1, dt.descripcion,en.nombre as nombre2,en.id as eid,
    				en.descripcion,dt.descripcion as des
					from `wp_dietas_tipo` as dt
					JOIN enfermedades as en
					ON dt.id_enfermedad = en.id
					WHERE dt.id!=( SELECT id_dieta from dietas_asignadas WHERE id = ( 
																SELECT max( id ) FROM dietas_asignadas 
																WHERE id_empleado = '$id') )";

          	$sql_pri = "SELECT
							dt.id AS elid,
							dt.nombre AS nombre1,
							dt.descripcion,
							en.nombre AS nombre2,
							en.id AS eid,
							en.descripcion,
							dt.descripcion AS des 
						FROM
							`wp_dietas_tipo` AS dt
							JOIN enfermedades AS en ON dt.id_enfermedad = en.id 
						WHERE
						en.id = ( SELECT id_enfermedad FROM wp_dietas_tipo 
											WHERE id = ( 
																SELECT id_dieta FROM dietas_asignadas 
																WHERE id = ( 
																						SELECT max( id ) FROM dietas_asignadas 
																						WHERE id_empleado = '$id'    ) ) )
						AND dt.id=( SELECT id_dieta from dietas_asignadas WHERE id = ( 
																						SELECT max( id ) FROM dietas_asignadas 
																						WHERE id_empleado = '$id'    ) )";

			try {

				$ejecucion_pri = Conexion::getInstance()->getDb()->prepare($sql_pri);
	          	$ejecucion_pri->execute();


	          	$html.='<div class="block">
							        <div class="block-title">
							         	<h2><strong>Dieta</strong> Sugerida</h2>
							        </div>
							       	<p>A continuación se muestra la dieta actual, de igual manera más abajo se muestran las otras dietas para que pueda elegir.</p>
							    </div>';
	          	$html.='<div class="row">';


	          	while ($row_pri = $ejecucion_pri->fetch(PDO::FETCH_ASSOC)) {
	          		$sql1_pri="SELECT count(id_alimento) as cualime from `wp_dietas_admin`
							WHERE id_dieta = '$row_pri[elid]'";
					$ejecucion1_pri = Conexion::getInstance()->getDb()->prepare($sql1_pri);
	          		$ejecucion1_pri->execute();
	          		while ($row1_pri = $ejecucion1_pri->fetch(PDO::FETCH_ASSOC)) {
	          			$alimentos_pri=$row1_pri[cualime];
	          		}
	          		//$html.="eleangel";
	          		//$html.=$sql1.'<br>';
	          			
	          			$html.='<div class="col-md-4">
						            <!-- Specific Theme Color Widget with Extra Content -->
						            <div class="widget">
						                <div class="widget-simple themed-background-dark-autumn">
						                    <a href="javascript:void(0)" class="widget-icon pull-right themed-background-autumn">
						                        <img id="imagen_dieta" src="../img/imagenes_mias/diet2.svg" class="animation-floating">
						                    </a>
						                    <h4 class="widget-content widget-content-light">
						                        <a href="javascript:void(0)" class="themed-color-autumn"><strong>'.$row_pri[nombre1].'</strong></a>
						                        <small>Dieta Actual <em></em></small>
						                    </h4>
						                </div>
						                <div class="widget-extra themed-background-autumn">
						                    <div class="row text-center">
						                        <div class="col-xs-6">
						                            <h3 class="widget-content-light">
						                                <strong>'.$alimentos_pri.'</strong><br>
						                                <small>Alimentos</small>
						                            </h3>
						                        </div>
						                        <div class="col-xs-6">
						                            <h3 class="widget-content-light">
						                                <strong><small>Especialidad</small></strong><br>
						                                <small>'.$row_pri[nombre2].'</small>
						                            </h3>
						                        </div>
						                    </div>
						                </div>
						                <div class="widget-extra">
						                    <h4 class="sub-header">Enfermedad</h4>
						                    <p>'.$row_pri[descripcion].'</p>
						                   	<h4 class="sub-header">Dieta</h4>
						                    <p>'.$row_pri[des].'</p>
						                    
						                </div>
						            </div>
						            <!-- END Specific Theme Color Widget with Extra Content -->
						        </div>';

	          			 
	          	}
	          	$html.='</div>';

				/******demas dietas****/
				$ejecucion = Conexion::getInstance()->getDb()->prepare($sql);
	          	$ejecucion->execute();
	          	$html.='<div class="block">
							        <div class="block-title">

							            <h2><strong>Otras </strong> Dietas</h2>
							        </div>
							       	<p>A continuación se muestra otras dietas disponibles para su elección.</p>
							    </div>';
	          	$html.='<div class="row">';
	          	while ($row = $ejecucion->fetch(PDO::FETCH_ASSOC)) {
	          		$sql1="SELECT count(id_alimento) as cualime from `wp_dietas_admin`
							WHERE id_dieta = '$row[elid]'";
					$ejecucion1 = Conexion::getInstance()->getDb()->prepare($sql1);
	          		$ejecucion1->execute();
	          		while ($row1 = $ejecucion1->fetch(PDO::FETCH_ASSOC)) {
	          			$alimentos=$row1[cualime];
	          		}
	          		//$html.=$sql1.'<br>';
	          			$html.='<div class="col-md-4">
						            <!-- Active Theme Color Widget with Extra Content -->
						            <div class="widget">
						                <div class="widget-simple themed-background-dark">
						                    <a href="javascript:void(0)" class="widget-icon pull-right ">
						                        <!--i class="gi gi-film animation-floating"></i-->
						                        <img id="imagen_dieta" src="../img/imagenes_mias/diet2.svg" class="">
						                    </a>
						                    <h4 class="widget-content widget-content-light">
						                        <a href="javascript:void(0)"><strong><small>'.$row[nombre1].'</small></strong></a>
						                        <small>Otras dietas <em></em></small>
						                       
						                    </h4>
						                </div>
						                <div class="widget-extra themed-background">
						                    <div class="row text-center">
						                        <div class="col-xs-6">
						                            <h3 class="widget-content-light">
						                                <strong>'.$alimentos.'</strong><br>
						                                <small>Alimentos</small>
						                            </h3>
						                        </div>
						                        <div class="col-xs-6">
						                            <h3 class="widget-content-light">
						                                <strong><small>Especialidad</small></strong><br>
						                                <small>'.$row[nombre2].'</small>
						                            </h3>
						                        </div>
						                        
						                    </div>
						                </div>
						                <div class="widget-extra">
						                    <h4 class="sub-header">Enfermedad</h4>
						                    <p>'.$row[descripcion].'</p>
						                   	<h4 class="sub-header">Dieta</h4>
						                    <p>'.$row[des].'</p>


						                    <button type="button" id="asignar_dieta" data-dieta="'.$row[elid].'" data-empleado="'.$id.'" class="btn btn-block btn-primary ">Seleccionar dieta</button>
						                    <br>
						                </div>
						            </div>


						            <!-- END Active Theme Color Widget with Extra Content -->
						        </div>';
						
	          	}
	          	$html.='</div>';
	          	return $html;
			} catch (Exception $e) {
				
			}
    	}










    	public static function cuatroprincipales($id){
    		$html="";
    		try {
    			$sql = "SELECT pesolb,estaturacm,imc,edad_metabolica from `cuestionario_empleados` where `id_empleado`='$id'";
    			//$html.=$sql;
	    		$ejecucion = Conexion::getInstance()->getDb()->prepare($sql);
	          	$ejecucion->execute();
	          	while ($row = $ejecucion->fetch(PDO::FETCH_ASSOC)) {
	          		/*$row[pesolb]
	          		$row[estaturacm]
	          		$row[imc]
	          		$row[edad_metabolica]*/

	          		$html.='<div class="row text-center">
						        <div class="col-sm-6 col-lg-3">
						            <div class="widget">
						                <div class="widget-extra themed-background-warning">
						                    <h4 class="widget-content-light"><strong>IMC</strong></h4>
						                </div>
						                <div class="widget-extra-full"><span class="h2 text-success animation-expandOpen">'.$row[imc].'</span></div>
						            </div>
						        </div>
						        <div class="col-sm-6 col-lg-3">
						            <div class="widget">
						                <div class="widget-extra themed-background-success">
						                    <h4 class="widget-content-light"> <strong>PESO</strong></h4>
						                </div>
						                <div class="widget-extra-full"><span class="h2 text-success animation-expandOpen">'.$row[pesolb].' lb</span></div>
						            </div>
						        </div>
						        <div class="col-sm-6 col-lg-3">
						            <div class="widget">
						                <div class="widget-extra themed-background-warning">
						                    <h4 class="widget-content-light"> <strong>ESTATURA</strong></h4>
						                </div>
						                <div class="widget-extra-full"><span class="h2 text-warning">'.$row[estaturacm].' cm</span></div>
						            </div>
						        </div>
						        <div class="col-sm-6 col-lg-3">
						            <div class="widget">
						                <div class="widget-extra themed-background-muted">
						                    <h4 class="widget-content-light"> <strong>EDAD METABOLICA</strong></h4>
						                </div>
						                <div class="widget-extra-full"><span class="h2 text-muted animation-pulse">'.round($row[edad_metabolica]).' años</span></div>
						            </div>
						        </div>
						    </div>';
	          		

	          	}
	          	return $html;
    		} catch (Exception $e) {
    			return $e->getMessage();
    		}
    		
    	}


    	public static function seleccionar_dieta($id){

    		/******CLONO LA DIETA*****/
			
	        

    		/******END CLONAR DIETA***/

    		$html="";
    		$alimentos=0;
    		$alimentos_pri=0;
    		$enfermedades0="";
    		$dieta = 0;

    		$sql="CALL clonar_dieta('0','$id');";
			try {
				$comandose = Conexion::getInstance()->getDb()->prepare($sql);
	        	$comandose->execute();
			} catch (Exception $e) {
				$html.= $e->getMessage();
			}


			$select_enfer = "SELECT uno_diagnostico from cuestionario_empleados where id_empleado ='$id'";
			$ejecucion0 = Conexion::getInstance()->getDb()->prepare($select_enfer);
          	$ejecucion0->execute();
          	while ($row0 = $ejecucion0->fetch(PDO::FETCH_ASSOC)) {
          		$enfermedades0=$row0[uno_diagnostico];
          	}

          	if ($enfermedades0=='Sin Enfermedad') {
          		$dieta = '1';
          	}else if ($enfermedades0=='Hipertensión Arterial') {
          		$dieta = '3';
          	}else if ($enfermedades0=='Lípidos Alterados') {
          		$dieta = '4';
          	}else if ($enfermedades0=='Diabetes Mellitus') {
          		$dieta = '2';
          	}else if ($enfermedades0=='Hígado Graso') {
          		$dieta = '5';
          	}else if ($enfermedades0=='Enfermedad Renal') {
          		$dieta = '6';
          	}

          	/*$sql = "SELECT  dt.id as elid, dt.nombre as nombre1, dt.descripcion,en.nombre as nombre2,en.id as eid,
    				en.descripcion,dt.descripcion as des
					from `wp_dietas_tipo` as dt
					JOIN enfermedades as en
					ON dt.id_enfermedad = en.id
					WHERE en.id != '$dieta'";*/

			$sql = "SELECT dt.id as elid, dt.nombre as nombre1, dt.descripcion,en.nombre as nombre2,en.id as eid, 
						en.descripcion,dt.descripcion as des 
						from `wp_dietas_tipo` as dt 
						JOIN enfermedades as en ON dt.id_enfermedad = en.id 
						JOIN `wp_dietas_admin` as da ON dt.id = da.id_dieta
						WHERE en.id != '$dieta' and da.id_usuario = '$id'
						GROUP by dt.id";

          	/*$sql_pri = "SELECT  dt.id as elid, dt.nombre as nombre1, dt.descripcion,en.nombre as nombre2,en.id as eid,
							en.descripcion,dt.descripcion as des
						from `wp_dietas_tipo` as dt
						JOIN enfermedades as en
						ON dt.id_enfermedad = en.id
						WHERE en.id = '$dieta'";*/

			$sql_pri = "SELECT dt.id as elid, dt.nombre as nombre1, dt.descripcion,en.nombre as nombre2,en.id as eid, 
						en.descripcion,dt.descripcion as des 
						from `wp_dietas_tipo` as dt 
						JOIN enfermedades as en ON dt.id_enfermedad = en.id 
						JOIN `wp_dietas_admin` as da ON dt.id = da.id_dieta
						WHERE en.id = '$dieta' and da.id_usuario = '$id'
						GROUP by dt.id";

			//$html.=$sql_pri;
          	/*$html.=$sql_pri.'<br>';
          	$html.=$dieta.'ladieta<br>';*/
			try {

				$ejecucion_pri = Conexion::getInstance()->getDb()->prepare($sql_pri);
	          	$ejecucion_pri->execute();


	          	$html.='<div class="block">
							        <div class="block-title">
							         	<h2><strong>Dieta</strong> Sugerida</h2>
							        </div>
							       	<p>A continuación se muestra la dieta sugerida, de igual manera más abajo se muestran las otras dietas para que pueda elegir.</p>
							    </div>';
	          	$html.='<div class="row">';


	          	while ($row_pri = $ejecucion_pri->fetch(PDO::FETCH_ASSOC)) {
	          		$sql1_pri="SELECT count(id_alimento) as cualime from `wp_dietas_admin`
							WHERE id_dieta = '$row_pri[elid]'";
					$ejecucion1_pri = Conexion::getInstance()->getDb()->prepare($sql1_pri);
	          		$ejecucion1_pri->execute();
	          		while ($row1_pri = $ejecucion1_pri->fetch(PDO::FETCH_ASSOC)) {
	          			$alimentos_pri=$row1_pri[cualime];
	          		}
	          		//$html.="eleangel";
	          		//$html.=$sql1.'<br>';
	          			
	          			$html.='<div class="col-md-4">
						            <!-- Specific Theme Color Widget with Extra Content -->
						            <div class="widget">
						                <div class="widget-simple themed-background-dark-autumn">
						                    <a href="javascript:void(0)" class="widget-icon pull-right themed-background-autumn">
						                        <img id="imagen_dieta" src="../img/imagenes_mias/diet2.svg" class="animation-floating">
						                    </a>
						                    <h4 class="widget-content widget-content-light">
						                        <a href="javascript:void(0)" class="themed-color-autumn"><strong>'.$row_pri[nombre1].'</strong></a>
						                        <small>Dieta sugerida <em></em></small>
						                    </h4>
						                </div>
						                <div class="widget-extra themed-background-autumn">
						                    <div class="row text-center">
						                        <div class="col-xs-6">
						                            <h3 class="widget-content-light">
						                                <strong>'.$alimentos_pri.'</strong><br>
						                                <small>Alimentos</small>
						                            </h3>
						                        </div>
						                        <div class="col-xs-6">
						                            <h3 class="widget-content-light">
						                                <strong><small>Especialidad</small></strong><br>
						                                <small>'.$row_pri[nombre2].'</small>
						                            </h3>
						                        </div>
						                    </div>
						                </div>
						                <div class="widget-extra">
						                    <h4 class="sub-header">Enfermedad</h4>
						                    <p>'.$row_pri[descripcion].'</p>
						                   	<h4 class="sub-header">Dieta</h4>
						                    <p>'.$row_pri[des].'</p>
						                    <button type="button" id="asignar_dieta" data-dieta="'.$row_pri[elid].'" data-empleado="'.$id.'" class="btn btn-block btn-warning animation-floating">Seleccionar dieta</button>
						                    <br>
						                </div>
						            </div>
						            <!-- END Specific Theme Color Widget with Extra Content -->
						        </div>';

	          			 
	          	}
	          	$html.='</div>';

				/******demas dietas****/
				$ejecucion = Conexion::getInstance()->getDb()->prepare($sql);
	          	$ejecucion->execute();
	          	$html.='<div class="block">
							        <div class="block-title">

							            <h2><strong>Otras </strong> Dietas</h2>
							        </div>
							       	<p>A continuación se muestra otras dietas disponibles para su elección.</p>
							    </div>';
	          	$html.='<div class="row">';
	          	while ($row = $ejecucion->fetch(PDO::FETCH_ASSOC)) {
	          		$sql1="SELECT count(id_alimento) as cualime from `wp_dietas_admin`
							WHERE id_dieta = '$row[elid]'";
					$ejecucion1 = Conexion::getInstance()->getDb()->prepare($sql1);
	          		$ejecucion1->execute();
	          		while ($row1 = $ejecucion1->fetch(PDO::FETCH_ASSOC)) {
	          			$alimentos=$row1[cualime];
	          		}
	          		//$html.=$sql1.'<br>';
	          			$html.='<div class="col-md-4">
						            <!-- Active Theme Color Widget with Extra Content -->
						            <div class="widget">
						                <div class="widget-simple themed-background-dark">
						                    <a href="javascript:void(0)" class="widget-icon pull-right ">
						                        <!--i class="gi gi-film animation-floating"></i-->
						                        <img id="imagen_dieta" src="../img/imagenes_mias/diet2.svg" class="">
						                    </a>
						                    <h4 class="widget-content widget-content-light">
						                        <a href="javascript:void(0)"><strong><small>'.$row[nombre1].'</small></strong></a>
						                        <small>Otras dietas <em></em></small>
						                       
						                    </h4>
						                </div>
						                <div class="widget-extra themed-background">
						                    <div class="row text-center">
						                        <div class="col-xs-6">
						                            <h3 class="widget-content-light">
						                                <strong>'.$alimentos.'</strong><br>
						                                <small>Alimentos</small>
						                            </h3>
						                        </div>
						                        <div class="col-xs-6">
						                            <h3 class="widget-content-light">
						                                <strong><small>Especialidad</small></strong><br>
						                                <small>'.$row[nombre2].'</small>
						                            </h3>
						                        </div>
						                        
						                    </div>
						                </div>
						                <div class="widget-extra">
						                    <h4 class="sub-header">Enfermedad</h4>
						                    <p>'.$row[descripcion].'</p>
						                   	<h4 class="sub-header">Dieta</h4>
						                    <p>'.$row[des].'</p>


						                    <button type="button" id="asignar_dieta" data-dieta="'.$row[elid].'" data-empleado="'.$id.'" class="btn btn-block btn-primary ">Seleccionar dieta</button>
						                    <br>
						                </div>
						            </div>


						            <!-- END Active Theme Color Widget with Extra Content -->
						        </div>';
						
	          	}
	          	$html.='</div>';
	          	return $html;
			} catch (Exception $e) {
				
			}
    	}
    }

?>