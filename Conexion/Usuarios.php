<?php 
require_once 'Conexion.php';
/**
* 
*/
class Usuarios  
{
    
    
    function __construct()
    {
         
         
        
    }

    public static function total(){
        $consulta_total = "SELECT count(*) as total from Users ";
        try{
                    $total_c = "";
                    $comando = Conexion::getInstance()->getDb()->prepare($consulta_total);
                    $comando->execute();
                    while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                        $total_c = $row['total'];
                          
                    }
                    $html = "$total_c <small>Registrados</small>";
                    return $html;
 

        } catch (PDOException $e) {
                return -1;
        }
    }
    public static function getall($usuario){
            // Consulta de la meta
            $consulta = "SELECT * FROM person JOIN Users 
            ON person.emailp=Users.email 
            where email = ? 
            GROUP BY person.emailp";

            try {
                // Preparar sentencia
                $comando = Conexion::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($usuario));
                // Capturar primera fila del resultado
                $row = $comando->fetch(PDO::FETCH_ASSOC);
                return $row;

            } catch (PDOException $e) {
                // Aquí puedes clasificar el error dependiendo de la excepción
                // para presentarlo en la respuesta Json
                return -1;
            }
        }





    public static function getById_accesos($idMeta,$contrasenia){
            // Consulta de la meta
            $consulta = "SELECT * FROM `Users` WHERE `email`=? and pass=?";

            try {
                // Preparar sentencia
                $comando = Conexion::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idMeta,$contrasenia));
                // Capturar primera fila del resultado
                $row = $comando->fetch(PDO::FETCH_ASSOC);
                return $row;

            } catch (PDOException $e) {
                // Aquí puedes clasificar el error dependiendo de la excepción
                // para presentarlo en la respuesta Json
                return -1;
            }
        }


 

    public static function insert(
            $nombre,
            $telefono,
            $correo,
            $codigo,
            $pass,
            $level
        )
        {
            $data = "";
            $select = "SELECT * FROM Users where email = (?)";
            $consultar1 = Conexion::getInstance()->getDb()->prepare($select);

            $consultar1->execute(array($correo) );
            if ($consultar1->fetchAll(PDO::FETCH_ASSOC)) {
                $data = 1; 
            }else{


                    // Sentencia INSERT tabla user
                    $comando = "INSERT INTO Users ( email, pass, level) VALUES (?,?,?)";

                    // Sentencia INSERT tabla user
                    $comando1 = "INSERT INTO person (nombre,Codigo,telefono) VALUES (?,?,?)";

                    // Preparar la sentencia
                    $sentencia = Conexion::getInstance()->getDb()->prepare($comando);
                    $sentencia1 = Conexion::getInstance()->getDb()->prepare($comando1);
                    $largo = 10;
                    $pass2 = Usuarios::generarcontrasenia($largo);

                   $sentencia->execute(
                        array(
                            $correo,
                            $pass2,
                            $level)
                    );

                    $data =  $sentencia1->execute(
                        array(
                            $nombre,
                            $codigo,
                            $telefono)
                    );

                    $data = 2;
                    Usuarios::ele($correo,$pass2);

                }

            return $data;

        }


/*******************actualizo contrasenia ********************/
public static function update_contrasenia($contrasenia,$correo){
            $data = "";
                    // Sentencia INSERT tabla user
                    $comando1 = "UPDATE `Users` SET `pass`=(?) WHERE `email`=(?)";

                    // Preparar la sentencia
                    $sentencia1 = Conexion::getInstance()->getDb()->prepare($comando1);
                    $data =  $sentencia1->execute(
                        array(
                            $contrasenia,$correo)
                    );         

            return $data;

        }
/**************************termino actualizar contrasenia****************************/
  public static function ele($correo,$pass2){
         
    // Varios destinatarios
    //$para  = 'aidan@example.com' . ', '; // atención a la coma
    $para = $correo ;

    // título
    $título = 'Registration mail';

    // mensaje
    $mensaje = '
    <html>
    <head>
      <title>You have registered in See Something Say Something</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
       
    </head>
    <body>
        <div class="alert alert-warning" style="
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;">
            <strong>Congratulations!</strong> now you can log in your app See something Say something.
        </div>

       <div class="alert alert-warning" style="
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;">
            <strong>Your password: </strong>'.$pass2.'
        </div>


        <div class="alert alert-info" style=" color: #31708f;
            background-color: #d9edf7;
            border-color: #bce8f1;
             padding: 15px;
                margin-bottom: 20px;
                border: 1px solid transparent;
                border-radius: 4px;
            " >
          <strong>Success!</strong> You can now report.
        </div>
    </body>
    </html>
    ';

    // Para enviar un correo HTML, debe establecerse la cabecera Content-type
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $cabeceras .= 'From: seesomethinsaysomethin@grupolah.com' . "\r\n" . //La direccion de correo desde donde supuestamente se envió
                'X-Mailer: PHP/' . phpversion();  //información sobre el sistema de envio de correos, en este caso la version de PHP
    // Cabeceras adicionales
    $cabeceras .= 'To: EleAnGL <eangel@grupolah.com>' . "\r\n";
    // Enviarlo
    mail($para, $título, $mensaje, $cabeceras);
     
    }



    public static function generarcontrasenia($largo){
          $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
          $cadena_base .= '0123456789' ;
          $cadena_base .= '!@#%^&*()_,./<>?;:[]{}\|=+';
         
          $password = '';
          $limite = strlen($cadena_base) - 1;
         
          for ($i=0; $i < $largo; $i++)
            $password .= $cadena_base[rand(0, $limite)];
         
          return $password;

    }


    /*****reporte usuarios****/

    public static function obteneruempleados(){
        $consulta_total = "SELECT count(*) as total from Users where leveles <> '1' ";
        try{
                    $total_c = "";
                    $comando = Conexion::getInstance()->getDb()->prepare($consulta_total);
                    $comando->execute();
                    $html1 = "";
                    while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                        $total_c = $row['total'];
                        $html1 =  '
                            <div class="col-sm-3 text-center col-sm-height">
                                <!-- Widget -->
                                <a href="javascript:void(0)" class="widget widget-hover-effect1" style="background:transparent;">
                                    <div class="block ele_shadow" style="background: '.$color.';border-radius: 15px;">
                                        <h1>
                                            <strong>'.$total_c.'</strong> <small></small><br>
                                            <small><i class="'.$icon.'"></i> Empleados</small>
                                        </h1>
                                    </div>
                                </a>
                            </div>';
                    }
                    return $html1;
 

        } catch (PDOException $e) {
                return -1;
        }
    }



    public static function obteneradmiistradores(){
        $consulta_total = "SELECT count(*) as total from Users where leveles = '1' ";
        try{
                    $total_c = "";
                    $comando = Conexion::getInstance()->getDb()->prepare($consulta_total);
                    $comando->execute();
                    $html1='';
                    while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                        $total_c = $row['total'];
                        $html1 = '
                            <div class="col-sm-3 text-center col-sm-height">
                                <!-- Widget -->
                                <a href="../../reportes/reportes.php" class="widget widget-hover-effect1" style="background:transparent;">
                                    <div class="block ele_shadow" style="background: '.$color.';border-radius: 15px;">
                                        <h1>
                                            <strong>'.$total_c.'</strong> <small></small><br>
                                            <small><i class="'.$icon.'"></i> Aministradores</small>
                                        </h1>
                                    </div>
                                </a>
                            </div>
                        ';
                    }
                    return $html1;
 

        } catch (PDOException $e) {
                return -1;
        }
    }

}


 ?>