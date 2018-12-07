<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
require 'Dias.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petición GET
    $rutas = Dias::getAll();

    if ($rutas) {

        $datos["estado"] = 1;
        $datos["rutas"] = $rutas;

        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "No hay rutas asignadas a este usuario"
        ));
    }
}

?>