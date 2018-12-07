<?php 
	
	require 'Consultar_Bloqueo.php';
	 
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		
        if (isset($_GET['usuario']) && isset($_GET['codigo'])) {

        	$retorno = Consultar_Bloqueo::consultar_token($_GET[usuario],$_GET[codigo]);
        	if ($retorno) {

	            $meta["estado"] = "1";
	            $meta['mensaje']="Código Valido";
	            $meta["usuario"] = $retorno;
	            print json_encode($meta);
	        } else {
	            print json_encode(
	                array(
	                    'estado' => '2',
	                    'mensaje' => 'Error en los datos!! '
	                )
	            );
	        }
        }
	}else{
		print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Esta llegando vacio se necesita un identificador'.$_GET['usuario'].'elenilson'
            )
        );
	}

?>