<?php
   @session_start();
   require_once 'Conexion.php';
   
   class Perfil
   {
   
       function __construct()
       {
           # code...
       }

        public static function yacuestionario($id, $em){
          $html="";
          $sql = "SELECT id from cuestionario_empleados WHERE id_empleado='$id' AND id_empresa = '$em' ";
          try {
            $elec1 = Conexion::getInstance()->getDb()->prepare($sql);
            $elec1->execute();
            return $elec1->rowCount();
          } catch (Exception $e) {
            return $e->getMessage();
          }
          



        }
        public static function recuperar_datos_paracuestionario($id, $em){
          $html = "";
          $sql = "SELECT
                    UPPER( e.nombre ) AS nombre,
                    DATE_FORMAT( e.fecha, '%d/%m/%Y' ) AS fecha,
                    TIMESTAMPDIFF( YEAR, e.fecha, CURDATE( ) ) AS edad,
                  CASE
                    
                    WHEN e.genero = '1' THEN
                    'MASCULINO' ELSE 'FEMININO' 
                    END AS genero,
                    e.correo,
                    UPPER( e.direccion ) AS direccion,
                  CASE
                      
                      WHEN e.estado_civil = '1' THEN
                      'SOLTERO' ELSE 'CASADO' 
                    END AS estado_civil,
                  CASE
                      
                      WHEN e.estado = '1' THEN
                      'ACTIVO' ELSE 'INACTIVO' 
                    END AS estado1,
                    UPPER( e.area ) AS area,
                    e.telefono,
                    e.imagen,
                    UPPER( ep.nombre ) AS empresanombre, ep.imagen as imagenempresa,
                    ep.contacto,ep.telefono as telefonoep,ep.email as emailep
                  FROM
                    empleados AS e
                    JOIN empresas AS ep ON e.empresa = ep.id 
                  WHERE
                  e.id = '$id' and e.empresa = '$em'";

          $elec1 = Conexion::getInstance()->getDb()->prepare($sql);
          $elec1->execute();
          $elgenero="";
          while ($row = $elec1->fetch(PDO::FETCH_ASSOC)) {
              $html.='<div class="block full">
                          <div class="block-title">
                              
                              <h2><strong>Datos </strong> Registrados</h2>
                          </div>
                          <div class="row block-section">
                              <div class="col-sm-6">
                                  <img src="json/imagenes/'.$row[imagen].'" style="width: 128px;height: 128px;" alt="avatar" class="img-circle">
                                  <hr>
                                  <h2><strong>'.$row[nombre].'</strong></h2>
                                  <address>
                                      Fecha de Nacimiento: '.$row[fecha].'<br>
                                      Edad: '.$row[edad].' años<br>
                                      Sexo: '.$row[genero].'<br>
                                      <i class="fa fa-phone"></i> Télefono: '.$row[telefono].'<br>
                                      <i class="fa fa-envelope-o"></i> Correo: <a href="javascript:void(0)">'.$row[correo].'</a><br>
                                      Área: '.$row[area].'<br><br>
                                      
                                  </address>
                              </div>
                              <div class="col-sm-6 text-right">
                                  <img src="json/imagenes/'.$row[imagenempresa].'" style="width: 128px;height: 128px;" alt="avatar" class="img-circle">
                                  <hr>
                                  <h2><strong>'.$row[empresanombre].'</strong></h2>
                                  <address>
                                      Teléfono: '.$row[telefonoep].' <i class="fa fa-phone"></i><br>
                                      Contacto: '.$row[contacto].'<br>
                                      Correo: <a href="javascript:void(0)">'.$row[emailep].'</a> <i class="fa fa-envelope-o"></i>
                                  </address>
                              </div>
                          </div>
                      </div>';
                      $elgenero = $row[genero];
          }
          $array = array($html,$elgenero);
          return $array;

          


        }
        public static function construir_historial_consultas($id,$em){
          $html = "";
          $array_hconsultas="";
          try {
              $sql = "(SELECT
                        DATE_FORMAT( fecha_registro, '%d/%m/%Y' ) AS fecha_registro,
                        pesolb,
                        estaturacm,
                        imc,
                        CONCAT( presion_arterial, '/', presion_diastolica ) AS presion_arterial,
                        edad_metabolica,'CONSULTA' AS laconsulta
                      FROM
                        consulta_empleados
                        
                      WHERE
                        id_empleado = '$id' AND id_empresa='$em'
                      ORDER BY
                        id DESC )
                       
                      UNION ALL 

                      (SELECT
                        DATE_FORMAT( fecha_registro, '%d/%m/%Y' ) AS fecha_registro,
                        pesolb,
                        estaturacm,
                        imc,
                        CONCAT( presion_arterial, '/', presion_diastolica ) AS presion_arterial,
                        edad_metabolica ,'CUESTIONARIO' AS laconsulta
                      FROM
                        cuestionario_empleados
                        
                      WHERE
                        id_empleado = '$id' AND id_empresa='$em'
                        ORDER BY
                        id DESC )";


              $comando = Conexion::getInstance()->getDb()->prepare($sql);
              $comando->execute();
              $array_hconsultas = $comando->fetchAll();
              $html.='<div class="block">
                        <div class="block-title">
                           
                          <h2><i class="gi gi-notes_2"></i> <strong>Historial Consultas</strong></h2>
                        </div>';
              $html.='<table class="table table-bordered table-striped table-vcenter">
                        <thead>
                          <tr>
                              <th class="text-left">Fecha</th>
                              <th class="text-left">Peso</th>
                              <th class="text-left">Estatura</th>
                              <th class="hidden-xs">IMC</th>
                              <th class="hidden-xs">Presión</th>
                              <th class="hidden-xs">Edad metabólica</th>
                              <th class="hidden-xs">TIPO</th>
                              
                          </tr>
                        </thead>
                      <tbody>';
              foreach ($array_hconsultas as $row) {
                $html.='<tr>';
                $html.='<td class="hidden-xs" style="width: 15%;"><a href="javascript:void(0)">'.$row[fecha_registro].'</a></td>';
                $html.='<td class="text-right hidden-xs">'.$row[pesolb].'</td>';
                $html.='<td class="text-right hidden-xs">'.$row[estaturacm].'</td>';
                $html.='<td class="hidden-xs text-center">'.$row[imc].'</td>';
                $html.='<td class="hidden-xs text-center">'.$row[presion_arterial].'</td>';
                $html.='<td class="hidden-xs text-center">'.$row[edad_metabolica].'</td>';
                $html.='<td class="hidden-xs text-center">'.$row[laconsulta].'</td>';
                $html.='</tr>';

              }
            $html.="</tbody> </table></div>";

            return $html;
          } catch (Exception $e) {
            return $e->getMessage();
          }
          
        }
        

        public static function dietas_asignadas($id){
          $html = "";
          $array_hconsultas="";
          try {
              $sql = "SELECT
                        DATE_FORMAT( da.fecha_registro, '%d/%m/%Y' ) AS fecha_registro,
                        da.id_dieta,
                      CASE
                        WHEN da.dedonde = '1' THEN
                        'CUESTIONARIO' ELSE 'REASIGNADA' 
                        END AS dedondev,
                        dt.nombre
                      FROM
                        dietas_asignadas as da
                      JOIN wp_dietas_tipo as dt
                      ON dt.id = da.id_dieta
                      WHERE
                        da.id_empleado = '$id'
                      ORDER BY da.id DESC 
                      LIMIT 10";
              $comando = Conexion::getInstance()->getDb()->prepare($sql);
              $comando->execute();
              $array_hconsultas = $comando->fetchAll();
              $html.='<div class="block">
                        <div class="block-title">
                           
                          <h2><i class="gi gi-notes_2"></i> <strong>Dietas Asignadas</strong></h2>
                        </div>';
              $html.='<table class="table table-bordered table-striped table-vcenter">
                        <thead>
                          <tr>
                              <th class="text-left">Nombre</th>
                              <th class="text-left">Fecha de Asignación</th>
                              <th class="text-left">Asignada en</th>
                              
                              
                          </tr>
                        </thead>
                      <tbody>';
              foreach ($array_hconsultas as $row) {
                $html.='<tr>';
                $html.='<td class="hidden-xs" style="width: 50%;"><a href="javascript:void(0)">'.$row[nombre].'</a></td>';
                $html.='<td class="text-left hidden-xs">'.$row[fecha_registro].'</td>';
                $html.='<td class="text-left hidden-xs">'.$row[dedondev].'</td>';
                $html.='</tr>';

              }
            $html.="</tbody> </table></div>";

            return $html;
          } catch (Exception $e) {
            return $e->getMessage();
          }
          
        }


        public static function avancesgenerales($id){
          $html = "";
          $array_hconsultas="";
          try {
              $sql = "SELECT
                        ce.pesolb as pesocuestion,co.pesolb as pesoconsulta,(ce.pesolb - co.pesolb) as resta
                      FROM
                        cuestionario_empleados AS ce
                        JOIN consulta_empleados AS co ON co.id_empleado = ce.id_empleado 
                      WHERE
                        ce.id_empleado = '$id' 
                        AND co.id = ( SELECT max( id ) FROM consulta_empleados WHERE id_empleado = '$id' )";
              $comando = Conexion::getInstance()->getDb()->prepare($sql);
              $comando->execute();
              if ($comando->rowCount()>0) {
               
                $array_hconsultas = $comando->fetchAll();
                 
                foreach ($array_hconsultas as $row) {
                  $html.='<div class="block">
                            <div class="block-title">
                                <h2><i class="fa fa-line-chart"></i> <strong>Avances</strong> Generales</h2>
                            </div>
                            <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                                <div class="widget-simple">
                                    <div class="widget-icon pull-right themed-background-muted">
                                        <i class="gi gi-heart_empty"></i>
                                    </div>
                                    <h4 class="text-left">
                                        <strong>'.$row[pesocuestion].' lb.</strong><br><small>Peso Inicial</small>
                                    </h4>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                                <div class="widget-simple">
                                    <div class="widget-icon pull-right themed-background">
                                        <i class="gi gi-alarm"></i>
                                    </div>
                                    <h4 class="text-left text-success">
                                        <strong>'.$row[pesoconsulta].' lb.</strong><br><small>Peso Actual</small>
                                    </h4>
                                </div>
                            </a>
                            
                            <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                                <div class="widget-simple">
                                    <div class="widget-icon pull-right themed-background-success">
                                        <i class="fa fa-child"></i>
                                    </div>
                                    <h4 class="text-left text-muted">
                                        <strong>'.$row[resta].' lb.</strong><br><small>Reducido</small>
                                    </h4>
                                </div>
                            </a>
                        </div>';

                }
              }else{
                $sql1 = "SELECT
                          ce.pesolb AS pesocuestion,
                          '0' AS resta 
                        FROM
                          cuestionario_empleados AS ce 
                        WHERE
                         ce.id_empleado = '$id'";
                $comando2 = Conexion::getInstance()->getDb()->prepare($sql1);
                $comando2->execute();
                $array_hconsultas2 = $comando2->fetchAll();

                foreach ($array_hconsultas2 as $row2) {
                  $html.='<div class="block">
                            <div class="block-title">
                                <h2><i class="fa fa-line-chart"></i> <strong>Avances</strong> Generales</h2>
                            </div>
                            <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                                <div class="widget-simple">
                                    <div class="widget-icon pull-right themed-background-muted">
                                        <i class="gi gi-heart_empty"></i>
                                    </div>
                                    <h4 class="text-left">
                                        <strong>'.$row2[pesocuestion].' lb.</strong><br><small>Peso Inicial</small>
                                    </h4>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                                <div class="widget-simple">
                                    <div class="widget-icon pull-right themed-background">
                                        <i class="gi gi-alarm"></i>
                                    </div>
                                    <h4 class="text-left text-success">
                                        <strong>'.$row2[pesocuestion].' lb.</strong><br><small>Peso Actual</small>
                                    </h4>
                                </div>
                            </a>
                            
                            <a href="javascript:void(0)" class="widget widget-hover-effect2 themed-background-muted-light">
                                <div class="widget-simple">
                                    <div class="widget-icon pull-right themed-background-success">
                                        <i class="fa fa-child"></i>
                                    </div>
                                    <h4 class="text-left text-muted">
                                        <strong>'.$row2[resta].' lb.</strong><br><small>Reducido</small>
                                    </h4>
                                </div>
                            </a>
                        </div>';

                }
              }
              
            
            return $html;
          } catch (Exception $e) {
            return $e->getMessage();
          }
          
        }

        public static function construir_perfil($id,$em){
          $codigo_oculto="";
          $html ="";
          $sql = "SELECT
                    UPPER( e.nombre ) AS nombre,
                    DATE_FORMAT( e.fecha, '%d/%m/%Y' ) AS fecha,
                    TIMESTAMPDIFF( YEAR, e.fecha, CURDATE( ) ) AS edad,
                  CASE
                    
                    WHEN e.genero = '1' THEN
                    'MASCULINO' ELSE 'FEMININO' 
                    END AS genero,
                    e.correo,
                    UPPER( e.direccion ) AS direccion,
                  CASE
                      
                      WHEN e.estado_civil = '1' THEN
                      'SOLTERO' ELSE 'CASADO' 
                    END AS estado_civil,
                  CASE
                      
                      WHEN e.estado = '1' THEN
                      'ACTIVO' ELSE 'INACTIVO' 
                    END AS estado1,
                    UPPER( e.area ) AS area,
                    e.telefono,
                    e.imagen,
                    UPPER( ep.nombre ) AS empresanombre 
                  FROM
                    empleados AS e
                    JOIN empresas AS ep ON e.empresa = ep.id 
                  WHERE
                  e.id = '$id' and e.empresa = '$em'";
          try {
                
                $elec1 = Conexion::getInstance()->getDb()->prepare($sql);
                $elec1->execute();
                while ($row = $elec1->fetch(PDO::FETCH_ASSOC)) {

                  $html.='<div class="block">
                
                            <div class="block-title">
                                <h2><i class="gi gi-user"></i> <strong>Información de</strong> Perfil</h2>
                            </div>
                            <div class="block-section text-center">
                                <a href="javascript:void(0)">
                                    <img src="json/imagenes/'.$row[imagen].'" style="width: 128px;height: 128px;" alt="avatar" class="img-circle">
                                </a>
                                <h3>
                                    <strong>'.$row[nombre].'</strong><br><small></small>
                                </h3>
                            </div>
                            <table class="table table-borderless table-striped table-vcenter">
                                <tbody>

                                    <tr>
                                        <td class="text-right" style="width: 50%;"><strong>Fecha de Nacimiento</strong></td>
                                        <td>'.$row[fecha].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Edad</strong></td>
                                        <td>'.$row[edad].' años </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Genero</strong></td>
                                        <td>'.$row[genero].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Télefono</strong></td>
                                        <td>'.$row[telefono].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Correo</strong></td>
                                        <td>'.$row[correo].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Estado Civil</strong></td>
                                        <td>'.$row[estado_civil].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Empresa</strong></td>
                                        <td><span class="label label-success">'.$row[empresanombre].'</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Área</strong></td>
                                        <td><span class="label label-primary">'.$row[area].'</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Status</strong></td>
                                        <td><span class="label label-info"><i class="fa fa-check"></i>'.$row[estado1].'</span></td>
                                    </tr>
                                </tbody>
                            </table>
               
                        </div>';


                }
                return $html;
          } catch (Exception $e) {
                return $e->getMessage();
          }

          
        }
   
      
   }
   
   
   
   ?>