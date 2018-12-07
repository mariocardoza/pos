<?php 
    include_once("../../Conexion/administracion/Usuarios.php");
    $codigo = $_GET['codigo'];
    $token = $_GET['token'];
    $fecha = date('Y-m-d G:i:s');
    $result = Usuarios::get_temporales($codigo,$token,$fecha);
    $bandera = false;
    if(count($result[1])>0){
        // print_r(($result));
        // echo "\n".$fecha;
        // echo(($result[1][0]['codigo']));exit;
        // $fecha_1 = date_create($result[1][0]['tiempo']);
        $path = "../../../App/Appgente.apk";
        $type = ""; 
         
        $TIENE_PERMISO = true; 
         
        if (is_file($path) && $TIENE_PERMISO) { 
            $result = Usuarios::set_temporales($codigo,$token);
            $bandera = true;
            // Definir headers 
            header("Content-Type: application/force-download"); 
            header("Content-Disposition: attachment; filename=Appgente.apk"); 
            header("Content-Transfer-Encoding: binary"); 
            header("Content-Length: " . filesize($path)); 
             
            // Descargar archivo 
            readfile($path); 
            exit();
        } 
        else echo "No se ha encontrado el archivo."; 
    }
?>
<?php include '../../inc/config.php'; ?>
<?php include '../../inc/template_start2.php'; ?>

<!-- Login Full Background -->
<!-- For best results use an image with a resolution of 1280x1280 pixels (prefer a blurred image for smaller file size) -->
<img src="../../img/valle_joboa.jpg" alt="Login Full Background" class="full-bg animation-pulseSlow">
<!-- END Login Full Background -->

<!-- Login Container -->

<?php include '../../inc/template_scripts2.php'; ?>
<?php include '../../inc/template_end.php'; ?>

<script type="text/javascript">
    $(function(){
        <?php if(!$bandera): ?>
        swal({
            type: "info",
            title: "¡Información!",   
            text: "Este link ha caducado...",   
            timer: 5000,   
            showConfirmButton: true 
        }).then(function (result) {
            window.close(); 
        });
        timer=setInterval(function(){
            window.close(); 
            clearTimeout(timer);
        },5000);
        <?php endif; ?>
    });
	window.history.forward();
    function sinVueltaAtras(){ window.history.forward(); }
	function nobackbutton(){
	   window.location.hash="no-back-button";
	   window.location.hash="Again-No-back-button" //chrome
	   window.onhashchange=function(){window.location.hash="no-back-button";}
	}
</script>