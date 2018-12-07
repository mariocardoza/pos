<?php 

require 'Usuarios.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
//$_POST['usuario']='eangel@grupolah.com';
    if (isset($_GET['usuario'])) {

        // Obtener parámetro idMeta
        $parametro = $_GET['usuario'];
        $contrasenia = $_GET['contrasenia'];

        // Tratar retorno
        $retorno = Usuarios::getById_accesos($parametro,$contrasenia);
     
        if ($retorno) {

            $meta["estado"] = "1";
            $meta['mensaje']="Bienvenido a la apliación".' '.$parametro;
            $meta["usuario"] = $retorno;
            // Enviar objeto json de la meta
            print json_encode($meta);
        } else {
            // Enviar respuesta de error general
            print json_encode(
                array(
                    'estado' => '2',
                    'mensaje' => 'Error en los datos!! '
                )
            );
        }

    } else {
        // Enviar respuesta de error
        print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Esta llegando vacio se necesita un identificador'.$_GET['usuario'].'elenilson'
            )
        );
    }
}

 ?>