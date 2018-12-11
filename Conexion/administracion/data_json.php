<?php 

	require_once('Usuarios.php'); 
	require_once('../Empleado.php'); 
	if($_POST['data_id']== 'val_email'){
		$result = Usuarios::val_email($_POST['email']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']== 'val_tel'){
		$result = Usuarios::val_tel($_POST['email']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='nuevo_empleado'){
		$result=Empleado::nuevo_empleado($_POST);
		echo json_encode($result);
		exit();
	}
	if($_GET['data_id']=='modal_editar'){
		$result = Empleado::modal_editar($_GET['id']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='editar_empleado'){
		$result=Empleado::editar_empleado($_POST);
		echo json_encode($result);
		exit();
	}
	if($_GET['data_id']=='eliminar_empleado'){
		$result = Empleado::eliminar_empleado($_GET['id']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']== 'nuevo_usuario'){
		$result = Usuarios::set_usuario_perosonas($_POST);
		if($result[0]==1){
			$contra = $result[1][2];
			require_once('../../inc/config.php');
			$html_mail_titulo="<h3>Bienvenido a Gente de ca&ntilde;a</h3>";
			$html_mail_cuerpo="
				<h4>Hola $_POST[nombre]</h4>
				<p>Para poder ingresar a la aplicaci&oacute;n utilice los siguientes datos:</p>
				<p><b>Cuenta:</b> $_POST[email] </p>
			";
			if($_POST['nivel'] == '1' || $_POST['nivel'] == '2'){
				$html_mail_cuerpo.="<p><b>Contrase&ntilde;a:</b> $contra</p>";
				$link=="http://xn--gentedecaa-19a.com/sys/";
				//$html_mail_cuerpo.='<p>Inicia sesión <a href="'.$link.'">aqui</a>.</p>';
				$link = 'http://xn--gentedecaa-19a.com/sys/';
				$link_text = 'Inicia sesión';
			}
			else {
				$html_mail_cuerpo.="<p><b>Para poder ingresar a la App ingrese el siguiente codigo:</b> ".$result[1][3]."</p>";
				$link_text = 'Descarga la app';
				$link = "https://estudioagil.com/gentedecaa19a/sys/php/ingreso/respuesta.php?token=".$result[1][4]."&codigo=".$result[1][0];
			}
			require_once('../email/html_mail1.php');
			$html_mail_cuerpo.=$email_boton;
			$mensaje = $html_mail;
			$para=$_POST['email'];
			  // Para enviar un correo HTML, debe establecerse la cabecera Content-type
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

			// Cabeceras adicionales
			$cabeceras .= 'To: '.$para. "\r\n";
			$cabeceras .= 'From: '.$template['name']."\r\n";
			//$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
			$cabeceras .= 'Bcc: ogomez@contenucompany.com' . "\r\n";
			//echo $mensaje;

			$to = $_POST['nombre']." <".$para.">";
			$subject = "$template[name] Nuevo Registro";
			if(mail($para, $subject, $mensaje, $cabeceras)){
				echo json_encode($result);
				exit();
			}
			else{
				echo json_encode(array("-1","no email",$mensaje,$_POST));
				exit();
			}
		}
	}
	else{
		echo json_encode(array("-1","no entro a ningun if"));
		exit();
	}

?>