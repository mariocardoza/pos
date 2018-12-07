<?php 
    @session_start();
    //echo $_SESSION['autentica']."STO TRAE"; exit();
    if(!isset($_SESSION['loggedin']) && $_SESSION['autentica'] != "simon"){
        if($_SESSION['autentica'] != "simon" )
        {
             header("Location: ../../php/home/destruir.php");  
            exit(); 
        }else{
          
             header("Location: ../../php/home/destruir.php");  
            exit(); 

        }
    }else{
        
    }//prueba

    $cod=date("Yidisus");
?>

<?php include '../../inc/config.php'; ?>
<?php include '../../inc/template_start.php'; ?>
<style type="text/css" media="screen">
    .block-title h2 {
        font-size: 23px;
    }
</style>
<?php include '../../inc/page_head.php'; 
include_once("../../Conexion/Producto.php");
$result = Producto::obtener_inventario($_GET[id]);
?>

<!-- Page content -->
<div id="page-content">
    <!-- eCommerce Products Header -->
    <div class="content-header">
        <ul class="nav-horizontal text-center">
            <li>
                <a href="../home/index.php"><i class="fa fa-bar-chart"></i> Dashboard</a>
            </li>
            <li class="active">
                <a href="#"><i class="gi gi-shopping_bag"></i> Productos</a>
            </li>
            <li>
                <a href="../../php/productos/registro_producto.php"><i class="gi gi-pencil"></i> Registrar</a>
            </li>
        </ul>
    </div>
    <!-- END eCommerce Products Header -->

    <!-- Quick Stats -->
    <!--div class="row text-center">
        <div class="col-sm-6 col-lg-3">
            <a href="../../php/productos/registro_producto.php" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background-success">
                    <h4 class="widget-content-light"><strong>Agregar</strong> Producto</h4>
                </div>
                <div class="widget-extra-full"><span class="h2 text-success animation-expandOpen"><i class="fa fa-plus"></i></span></div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a href="javascript:void(0)" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background-danger">
                    <h4 class="widget-content-light"><strong>Fuera</strong>  de existencia</h4>
                </div>
                <div class="widget-extra-full"><span class="h2 text-danger animation-expandOpen">71</span></div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a href="javascript:void(0)" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background-dark">
                    <h4 class="widget-content-light"><strong>Más</strong> vendidos</h4>
                </div>
                <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">20</span></div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a href="javascript:void(0)" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background-dark">
                    <h4 class="widget-content-light"><strong>Todos</strong> los productos</h4>
                </div>
                <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen"><?=count($result[1])?></span></div>
            </a>
        </div>
    </div-->
    <!-- END Quick Stats -->

    <!-- All Products Block -->
    <div class="block full">
        <!-- All Products Title -->
        <div class="block-title">
            <div class="block-options pull-right">
                <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Settings"><i class="fa fa-cog"></i></a>
            </div>
            <h2><strong>Detalle del inventario</strong></h2>
        </div>
        <!-- END All Products Title -->

        <!-- All Products Content -->
        <table id="productos_table" class="table table-bordered table-striped table-vcenter">
            <thead>
                <th colspan="3">Detalles</th>
                <th colspan="3">Entrada</th>
                <th colspan="3">Salida</th>
                <th colspan="3">saldos</th>
                <tr>
                    <th class="text-center">Producto</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $labels['0']['class']   = "label-success";
                $labels['0']['text']    = "Disponible";
                $labels['1']['class']   = "label-warning";
                $labels['1']['text']    = "Pocas disponibles";
                $labels['2']['class']   = "label-danger";
                $labels['2']['text']    = "Fuera de inventario";
                $subcantidad=0;
                ?>
                <?php foreach($result[1] as $key => $producto) { 
                    //guardo el precio anterior
                    if($key==0){
                        $primer_precio=$producto[precio_unitario];
                        $precio_anterior=$producto[precio_unitario];
                    }else{
                        $precio_actual=$producto[precio_unitario];
                        $precio_anterior_aux=$precio_anterior;
                        $precio_actual=($precio_actual+$precio_anterior_aux)/2;
                        $precio_anterior=$producto[precio_unitario];
                    }

                    $preciopromedio=0.0;
                    $precioanterior = $producto[precio_unitario];
                    if($producto[tipo]==1){
                        $subcantidad=$subcantidad+$producto[cantidad];
                        
                    }else{
                        
                    }

                  
                    ?>
                <tr>
                   <td><?php echo $producto[nombre] ?></td>
                   <td><?php echo $producto[fecha] ?></td>
                   <td><?php echo $producto[descripcion] ?></td>
                   <?php if($producto[tipo]==1): ?>
                   <td>$<?php echo number_format($producto[precio_unitario],2) ?></td>
                   <td><?php echo $producto[cantidad] ?></td>
                   <td>$<?php echo number_format(($producto[cantidad]*$producto[precio_unitario]),2) ?></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <?php else: ?>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>$<?php echo number_format($producto[precio_unitario],2) ?></td>
                    <td><?php echo $producto[cantidad] ?></td>
                    <td>$<?php echo number_format(($producto[cantidad]*$producto[precio_unitario]),2) ?></td>
                <?php endif; ?>
                    <?php if($key==0): ?>
                        <td>$<?php echo $producto[precio_unitario]  ?></td>
                        <td><?php echo $producto[cantidad] ?></td>
                        <td>$<?php echo number_format($producto[cantidad]*$producto[precio_unitario]) ?></td>
                    <?php else: ?>
                        <td>$<?php echo number_format($precio_actual,2)  ?></td>
                        <td><?php echo $subcantidad ?></td>
                        <td>$<?php echo number_format($precio_actual*$subcantidad,2) ?></td>
                    <?php endif; ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- END All Products Content -->
    </div>
    <!-- END All Products Block -->
</div>
<div id="aqui_modal"></div>
<!-- modales -->


<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="../../js/pages/ecomProducts.js"></script>
<script src="producto.js?cod=<?php echo $cod ?>"></script>
<script>$(function(){ EcomProducts.init(); });</script>
<?php include '../../inc/template_end.php'; ?>

