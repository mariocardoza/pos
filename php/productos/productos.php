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
$result = Producto::obtener_productos();
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
    <div class="row text-center">
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
    </div>
    <!-- END Quick Stats -->

    <!-- All Products Block -->
    <div class="block full">
        <!-- All Products Title -->
        <div class="block-title">
            <div class="block-options pull-right">
                <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Settings"><i class="fa fa-cog"></i></a>
            </div>
            <h2><strong>Productos</strong></h2>
        </div>
        <!-- END All Products Title -->

        <!-- All Products Content -->
        <table id="productos_table" class="table table-bordered table-striped table-vcenter">
            <thead>
                <tr>
                    <th class="text-center">SKU</th>
                    <th>Nombre del producto</th>
                    <th class="text-right">Precio</th>
                    <th>Estado</th>
                    <th class="text-center">Código de barras</th>
                    <th class="text-center">Acciones</th>
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
                ?>
                <?php foreach($result[1] as $producto) { ?>
                <tr>
                    <td class="text-center"><a onclick="<?php echo "verproducto(".$producto[id].")" ?>" href="#"><strong><?php echo $producto[sku]; ?></strong></a></td>
                    <td><a onclick="<?php echo "verproducto(".$producto[id].")" ?>" href="#"><?php echo $producto[nombre]; ?></a></td>
                    <td class="text-right"><strong>$<?php echo number_format($producto[precio_unitario],2) ?></strong></td>
                    <td>
                        <?php if($producto[cantidad]>10){ $rand=0;

                        }else if($producto[cantidad]<10 && $producto[cantidad]>4) $rand=1; 
                        else{
                            $rand=2;
                        }?>
                        <span class="label<?php echo ($labels[$rand]['class']) ? " " . $labels[$rand]['class'] : ""; ?>">
                            <?php
                            echo $labels[$rand]['text'] ." ( ". $producto[cantidad]. " )" ?>
                                
                        </span>
                    </td>
                    <td class="text-center"><img src="../../lib/Barcode/barcode.php?text=<?php echo $producto[codigo_barra] ?>&print=true" width="220" height="70" alt=""></td>
                    <td class="text-center">
                        <div class="btn-group btn-group-xs">
                            <a data-id="<?php echo $producto[id] ?>" data-nombre="<?php echo $producto[nombre] ?>" id="asignar_mas" href="javascript:void(0)" data-toggle="tooltip" title="Más existencias" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>
                            <a href="#" data-toggle="tooltip" title="Edit" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                            <a href="inventario.php?id=<?php echo $producto[id] ?>" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                            <a href="javascript:void(0)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                    </td>
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
<div class="modal fade modal-side-fall" id="md_agregar_mercaderia" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Agregar mercadería</h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="#" class="form-horizontal form-bordered">
                <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="col-md-4 col-md-offset-2">Producto</label>
                        <div class="col-md-6">
                            <b><span id="md_titulo"></span></b>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 col-md-offset-2">Cantidad a agregar</label>
                        <div class="col-md-6">
                            <input type="hidden" id="id_producto">
                            <input type="number" id="canti" name="canti" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 col-md-offset-2">Precio</label>
                        <div class="col-md-6">
                            <input type="number" id="precio" name="precio" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3">
                            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
                            <button type="button" id="agregar_existencia" class="btn btn-primary btn-pure">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
          </div>
          <!--div class="modal-footer">
            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-default btn-pure">Guardar</button>
          </div-->
          
        </div>
      </div>
    </div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="../../js/pages/ecomProducts.js"></script>
<script src="producto.js?cod=<?php echo $cod ?>"></script>
<script>$(function(){ EcomProducts.init(); });</script>
<?php include '../../inc/template_end.php'; ?>

