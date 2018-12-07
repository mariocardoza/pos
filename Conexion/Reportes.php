<?php

require_once 'Conexion.php';

class Reportes
{
    function __construct()
    {
    }

    public static function categoria(){
        $consulta_cat = "SELECT count(DISTINCT  categoria) as total  from meta";

        try {
                    $contando = $total = "";
                    $comando = Conexion::getInstance()->getDb()->prepare($consulta_cat);
                    $comando->execute();
                    while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                        $contando = $row['total'];
                       
                      
                    }

                    $html = "+$contando <small>Tipos de Reporte</small>";
                   
                    return $html;
 
            } catch (PDOException $e) {
                 
                return -1;
            }

    }
   
    public static function getAll()
    {
        $consulta = "SELECT count(id) as contando,
                    (SELECT COUNT(`id`) FROM Reportes) as total 
                    from Reportes
                    where estado =?";
        try {
                    $contando = $total = "";
                    $comando = Conexion::getInstance()->getDb()->prepare($consulta);
                    $comando->execute(array("1"));
                    while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                        $contando = $row['contando'];
                        $total = $row['total'];
                      
                    }

                    $html = "$contando/$total <small>Atendidos</small>";
                    //$arradatosgrafica = ["categoria" => $total_categoria,"prioridad" => $total_prioridad1];
                   //$arradatosgrafica = array("retorna" => $total_categoria,"prioridad" => $total_prioridad1,"total" => $total_enbd );
                    
                    return $html;
 
            } catch (PDOException $e) {
                 
                return -1;
            }
    }

   
    public static function getById($idMeta)
    {
        // Consulta de la meta
        $consulta = "SELECT idMeta,
                             UPPER(titulo) AS titulo,
                             UPPER(descripcion) AS descripcion,
                             prioridad,
                             date_format(fechaLim, '%d-%m-%Y') as fechaLim,
                             categoria,nombre_victima,nombre_victimario,grado_victima,
                             seccion_victma,lugar_victima,testigo_victima,anonimo,hora_sistema,estado
                             FROM meta
                             WHERE idMeta = ?";

                            /* `idMeta`, `titulo`, `descripcion`, `prioridad`, `fechaLim`, `categoria`, `email`, 
                             `nombre_victima`, `nombre_victimario`, 
                             `grado_victima`, `seccion_victma`, `lugar_victima`, 
                             `fecha_sistema`, `hora_sistema`, `testigo_victima`, `estado`, `anonimo`*/

        try {
            // Preparar sentencia
            $comando = Conexion::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idMeta));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $idMeta      identificador
     * @param $titulo      nuevo titulo
     * @param $descripcion nueva descripcion
     * @param $fechaLim    nueva fecha limite de 
     * @param $categoria   nueva categoria
     * @param $prioridad   nueva prioridad
     */
    public static function update(
        $idMeta,
        $titulo,
        $descripcion,
        $fechaLim,
        $categoria,
        $prioridad
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE meta" .
            " SET titulo=?, descripcion=?, fechaLim=?, categoria=?, prioridad=? " .
            "WHERE idMeta=?";

        // Preparar la sentencia
        $cmd = Conexion::getInstance()->getDb()->prepare($consulta);
        //formato de fecha
        //12-03-2017
        
        $dia = substr($fechaLim, 0,2);
        $mes = substr($fechaLim, 3,2);
        $anio = substr($fechaLim, -4);
        //$fechaLim = $anio.'-'.$mes.'-'.$dia;
        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($titulo, $descripcion, $fechaLim, $categoria, $prioridad, $idMeta));

        return $cmd;
    }

    /**
     * Insertar una nueva meta
     *
     * @param $titulo      titulo del nuevo registro
     * @param $descripcion descripción del nuevo registro
     * @param $fechaLim    fecha limite del nuevo registro
     * @param $categoria   categoria del nuevo registro
     * @param $prioridad   prioridad del nuevo registro
     * @return PDOStatement
     * $body['hora'],
     */
    public static function insert(
        $titulo,
        $descripcion,
        $fechaLim,
        $categoria,
        $prioridad,
        $email,
        $hora,
        $victima,
        $victimario,
        $grado,
        $seccion,
        $lugar,
        $testigo,
        $fecha,
        $estado1,
        $anonimo
    )
    {
        // Sentencia INSERT
        //$comando = "INSERT INTO meta ( "."titulo," ." descripcion," ." fechaLim," ." categoria," ." prioridad)" .
         //   " VALUES( ?,?,?,?,?)";
         //     $comando = "INSERT INTO meta ( titulo,descripcion,fechaLim,categoria,prioridad,email) VALUES (?,?,?,?,?,?)";
        $comando = "INSERT INTO meta ( titulo,descripcion,fechaLim,categoria,prioridad,email,nombre_victima,nombre_victimario,grado_victima,seccion_victma,lugar_victima,fecha_sistema,hora_sistema,testigo_victima,estado,anonimo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        // Preparar la sentencia
        $sentencia = Conexion::getInstance()->getDb()->prepare($comando);
        if ($anonimo == true) {
            $anonimo = 1;
        }else{$anonimo = 0;}
        return $sentencia->execute(
            array(
                $titulo,
                $descripcion,
                $fechaLim,
                $categoria,
                $prioridad,
                $email, 
                $victima, 
                $victimario, $grado, $seccion,$lugar, $fecha,$hora ,$testigo,$estado1,$anonimo
            )
        );

    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idMeta identificador de la meta
     * @return bool Respuesta de la eliminación
     */
    public static function delete($idMeta)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM meta WHERE idMeta=?";

        // Preparar la sentencia
        $sentencia = Conexion::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idMeta));
    }



    /****CLASES NUEVO DISEÑO*****/

    public static function obtenerreportes()
    {
        $consulta = "SELECT count(id) as contando,
                    (SELECT COUNT(`id`) FROM Reportes) as total 
                    from Reportes
                    where estado =?";
        try {
                    $contando = $total = "";
                    $comando = Conexion::getInstance()->getDb()->prepare($consulta);
                    $comando->execute(array("1"));
                    $html1='';
                    while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                        $contando = $row['contando'];
                        $total = $row['total'];
                        $html1 = '
                            <div class="col-sm-3 text-center col-sm-height">
                                <!-- Widget -->
                                <a href="../../reportes/reportes.php" class="widget widget-hover-effect1" style="background:transparent;">
                                    <div class="block ele_shadow" style="background: '.$color.';border-radius: 15px;">
                                        <h1>
                                            <strong>'.$contando.'/'.$total.'</strong> <small></small><br>
                                            <small><i class="'.$icon.'"></i> Atendidos/Reportados</small>
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