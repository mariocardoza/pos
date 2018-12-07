<?php 
	@session_start();
	include_once("../../Conexion/Conexion.php");
    if(isset($_POST["data_id"]) && $_POST['data_id'] == 'cambiar_contra'){
        $sql="UPDATE `tb_usuarios` SET `estado` = 1, `contrasena` = password('$_POST[contra]') WHERE `codigo` = '$_POST[codigo]'";
        $contando=$codigo=$email=$level=$nombre=$telefono="";
        try {
            $comando = "";
            $comando = Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            $sql=" SELECT
                    p.codigo AS cod_persona,
                    p.nombre,
                    p.telefono,
                    p.email,
                    u.nivel,
                    u.estado,
                    u.contrasena,
                    u.codigo AS cod_usuario,
                    u.imagen
                FROM
                    tb_persona AS p
                    INNER JOIN tb_usuarios AS u ON p.email = u.email_persona
                WHERE u.codigo='$_POST[codigo]';";
            $comando = "";
            $comando = Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            $data= array();
            while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                $data[]= $row;
                $n++;
                $codigo = $row["codigo"];
                $email = $row["email"];
                $level = $row["nivel"];
                $estado = $row["estado"];
                $nombre = $row["nombre"];
                $telefono = $row["telefono"];
                $imagen = $row["imagen"];
            }
        }catch (PDOException $e) {
            $exito = array("-1","error",$e,$sql);
            echo json_encode(array("exito" => $exito));
            exit();
        }
        $_SESSION['loggedin'] = true;
        $_SESSION['usuario'] =$email; 
        $_SESSION['codigo'] =$codigo; 
        $_SESSION['level'] =$level; 
        $_SESSION['estado'] =$estado; 
        $_SESSION['nombre'] =$nombre; 
        $_SESSION['telefono'] =$telefono; 
        $_SESSION['imagen'] =$imagen; 
        //$_SESSION["autentica"] = "simon";
        $_SESSION['autentica']  = 'simon'; 

        $exito = array("1",$nombre,$sql);
        echo json_encode(array("exito" => $exito));
    }
	else if (isset($_POST["usuario"]) && isset($_POST["password"])) {
		$consulta_datos = "
            SELECT
                p.id AS cod_persona,
                p.nombre,
                p.telefono,
                p.email,
                u.nivel,
                u.estado,
                u.pass,
                p.imagen
            FROM
                persona AS p
                INNER JOIN tb_usuario AS u ON p.email = u.email
            WHERE p.email='".$_POST["usuario"]."' and u.pass = PASSWORD('".$_POST["password"]."')
            AND u.nivel IN(0,1,2) ";

            try {
                $contando=$codigo=$email=$level=$nombre=$telefono="";
                $comando = Conexion::getInstance()->getDb()->prepare($consulta_datos);
                $comando->execute();
                $data= array();
                $n=0;
                while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                    $data[]= $row;
                    $n++;
                    $codigo = $row["cod_usuario"];
                    $email = $row["email"];
                    $level = $row["nivel"];
                    $estado = $row["estado"];
                    $nombre = $row["nombre"];
                    $telefono = $row["telefono"];
                    $imagen = $row["imagen"];
                }
                if($n!=0 and $estado == 0){ 
                    $exito = array("2",$nombre);
                    echo json_encode(array("exito" => $exito));
                }
                else if($n!=0 and $estado == 1 ){ 
                    if(!$imagen || $imagen == "") $imagen = 'avatar2.jpg';
                    $_SESSION['loggedin'] = true;
                    $_SESSION['usuario'] =$email; 
                    $_SESSION['codigo'] =$codigo; 
                    $_SESSION['level'] =$level; 
                    $_SESSION['estado'] =$estado; 
                    $_SESSION['nombre'] =$nombre; 
                    $_SESSION['telefono'] =$telefono; 
                    $_SESSION['imagen'] =$imagen; 
                    //$_SESSION["autentica"] = "simon";
                    $_SESSION['autentica']  = 'simon'; 

                    $exito = array("1",$nombre);
                    echo json_encode(array("exito" => $exito));
                }
                else if($n!=0 and $estado == 2){ 
                    $exito = array("3",$nombre,$codigo);
                    echo json_encode(array("exito" => $exito));
                }
                else {
                    $exito = array("0",$consulta_datos);
                    echo json_encode(array("exito" => $exito));
                }

            } catch (PDOException $e) {
                $exito = array("-1","error",$e->getMessage(),$consulta_datos);
                echo json_encode(array("exito" => $exito));
            }
	}else{
		echo json_encode(array("error"=>"Datos vacios"));
	}

?>