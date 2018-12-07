<?php

/**
 * Representa el la estructura de los dias 
 * almacenados en la base de datos
 */
require 'Conexion.php';

class Dias{

    function __construct()
    {
    }

    /**
     * Retorna el join creado
     *
     * @param $idMeta Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll()
    {
        $consulta = "SELECT
                            id,
                            id_semana,
                            id_dia,
                            CASE 
                                    WHEN id_dia = '1' THEN 'LUNES'
                                    WHEN id_dia = '2' THEN 'MARTES'
                                    WHEN id_dia = '3' THEN 'MIERCOLES'
                                    WHEN id_dia = '4' THEN 'JUEVES'
                                    WHEN id_dia = '5' THEN 'VIERNES'
                                    WHEN id_dia = '6' THEN 'SABADO'
                                    WHEN id_dia = '7' THEN 'DOMINGO'
                            END AS dia_letra,
                            nombre_dieta as nombre,count(*) as contado
                             
                    FROM
                            data_dietas 
                    WHERE
                            id_comidas = '1' 
                            AND id_semana = '1' 
                            AND id_dieta = '5' 
                            AND id_usuario = '2'
                    GROUP BY id_dia";
        try {
            $comando = Conexion::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

     
}

?>