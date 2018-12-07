<?php 
    @session_start();
    unset ($_SESSION['loggedin']);
    unset ($_SESSION['usuario']);
    unset ($_SESSION["autentica"]); 
    //$_SESSION['loggedin'] = false;

    unset ($_SESSION['loggedin']);
    unset ($_SESSION["estado"]);
    unset ($_SESSION['autentica']);
    unset ($_SESSION['nivel']); 
    unset ($_SESSION['nombre']);
    unset ($_SESSION['correo']);
    unset ($_SESSION['imagen']);


    session_destroy();
/*

    require_once("conexion/Dclientes.php");
    $texto = "El usario $_SESSION[usuario] ha terminado su sesión y ha salido del sistema ";
    $date = date("Ymd h:i:s");
    $pruebas = Dclientes::insertar_bitacora($_SESSION['idclien'],$texto,$date);

*/

    header("Location: ../ingreso/ingreso.php");  
    
?>