<?php 
	@session_start();
	require_once 'Conexion.php';
	require_once 'variables.php';
	/**
	* 
	*/
	class Envios 
	{
		
		function __construct()
		{
			# code...
		}

		public static function generarpass(){
            $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            $cadena_base .= '0123456789' ;
            //$cadena_base .= '!@#%^&*()_,./<>?;:[]{}\|=+';
            $cadena_base .= '%&()=+';

          $password = '';
          $limite = strlen($cadena_base) - 1;
            $largo = 10;
          for ($i=0; $i < $largo; $i++)
            $password .= $cadena_base[rand(0, $limite)];

          return $password;
        }

        public static function recupearenviarmail($email){
			$elpass = Envios::generarpass();
			$query1 = "UPDATE tb_usuario as u SET u.pass=PASSWORD('$elpass') WHERE u.email = '$email'";
			try {
				$comando1 = Conexion::getInstance()->getDb()->prepare($query1);
        		$comando1->execute();
        		 
			} catch (Exception $e) {
				return -1;
			}
			
            $para = $email;
            $asunto = 'BIENVENIDO';
			$anio = date("Y");
            $mensaje = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				    <head>
				        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				        <title>BIENVENIDO</title>
				        <meta name="viewport" content="width=device-width" />
				       <style type="text/css">
				            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
				                body[yahoo] .buttonwrapper { background-color: transparent !important; }
				                body[yahoo] .button { padding: 0 !important; }
				                body[yahoo] .button a { background-color: #1ec1b8; padding: 15px 25px !important; }
				            }

				            @media only screen and (min-device-width: 601px) {
				                .content { width: 600px !important; }
				                .col387 { width: 387px !important; }
				            }
				            td {
				            	box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
							}
				        </style>
				    </head>
				    <body bgcolor="#32323a" style="margin: 0; padding: 0;" yahoo="fix">
				        <!--[if (gte mso 9)|(IE)]>
				        <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
				          <tr>
				            <td>
				        <![endif]-->
				        <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;" class="content">
				             
				            <tr>
				                <td align="center" bgcolor="#ffffff" style="padding: 20px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;background-color: #575756;  box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);">
				                    <img src="http://contenucompany.com/nutriconsultores/img/imagenes_mias/esta.png" alt="ProUI Logo" width="105" height="83" style="display:block;" />
				                </td>
				            </tr>
				            <tr>
				                <td align="center" bgcolor="#ffffff" style="padding: 40px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6; box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);">
				                    <b>Bienvenido a la aplicación PUNTO DE VENTA</b><br>Para poder ingresar a la aplicaci&oacute;n utilice los siguientes datos:
				                </td>
				            </tr>
				            <tr>
				                <td align="center" bgcolor="#f9f9f9" style="padding: 20px 20px 0 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px;box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);">
				                    <b>Cuenta:</b> '.$email.' <br>
				                    <b>Contrase&ntilde;a:</b> '.$elpass.'
				                </td>
				            </tr>
				            <tr>
				                <td align="center" bgcolor="#f9f9f9" style="padding: 30px 20px 30px 20px; font-family: Arial, sans-serif; border-bottom: 1px solid #f6f6f6;box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);">
				                    <table bgcolor="#1ec1b8" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
				                        <tr>
				                            <td align="center" height="50" style=" padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);" class="button">
				                                <a href="#" style="color: #ffffff; text-align: center; text-decoration: none;">Descargar Aplicaci&oacute;n</a>
				                            </td>
				                        </tr>
				                    </table>
				                </td>
				            </tr>
				             
				            <tr>
				                <td align="center" bgcolor="#dddddd" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);">
				                    <b>CONTENU COMPANY</b><br/>
				                </td>
				            </tr>
				        </table>
				        <!--[if (gte mso 9)|(IE)]>
				                </td>
				            </tr>
				        </table>
				        <![endif]-->
				    </body>
				</html>';
            // Para enviar un correo HTML, debe establecerse la cabecera Content-type
            $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
            $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $cabeceras .= 'From: info@grupolah.com' . "\r\n" . //La direccion de correo desde donde supuestamente se envió
                        'X-Mailer: PHP/' . phpversion();  //información sobre el sistema de envio de correos, en este caso la version de PHP
            // Cabeceras adicionales
            $cabeceras .= 'To: Empresa Registro <mcardoza@estudioagil.com>' . "\r\n";
            // Enviarlo
            try {
                 if(mail($para, $asunto, $mensaje, $cabeceras)){

                    return 1;
                }else{
                    return -2;
                }

            } catch (Exception $e) {
                return -3;
            }


        }

         
	}


?>