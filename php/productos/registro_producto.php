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
    #submit{
          clear: both;
      }
      #barcodeTarget,
      #canvasTarget{
        margin-top: 20px;
      }  
</style>
<?php include '../../inc/page_head.php'; 
include_once("../../Conexion/Empleado.php");
?>

<div id="page-content">
    <!-- eCommerce Product Edit Header -->
    <div class="content-header">
        <ul class="nav-horizontal text-center">
            <li>
                <a href="../../php/home.index.php"><i class="fa fa-bar-chart"></i> Dashboard</a>
            </li>
            <li>
                <a href="../../php/productos/productos.php"><i class="gi gi-shopping_bag"></i> Products</a>
            </li>
            <li class="active">
                <a href="#"><i class="gi gi-pencil"></i> Registro de producto</a>
            </li>
            <li>
                <a href="#"><i class="gi gi-user"></i> Clientes</a>
            </li>
        </ul>
    </div>
    <!-- END eCommerce Product Edit Header -->

    <!-- Product Edit Content -->
    <div class="row">
        <!-- General Data Content -->
        <form action="#" method="post" name="form-producto" id="form-producto" class="form-horizontal form-bordered">
        <div class="col-lg-6">
            <!-- General Data Block -->
            <div class="block">
                <!-- General Data Title -->
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Información</strong> general</h2>
                </div>
                <!-- END General Data Title -->

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="nombre">Nombre</label>
                        <div class="col-md-9">
                            <input type="hidden" name="data_id" value="nuevo_producto">
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del nombre">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="descripcion">Descripción</label>
                        <div class="col-md-9">
                            <textarea  id="descripcion" name="descripcion" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="departamento">Departamento</label>
                        <div class="col-md-9">
                            <!-- Chosen plugin (class is initialized in js/app.js -> uiInit()), for extra usage examples you can check out http://harvesthq.github.io/chosen/ -->
                            <select id="departamento" name="departamento" class="select-chosen" data-placeholder="Seleccione un departamento" style="width: 250px;">
                                <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                <option value="1">Tablets</option>
                                <option value="2">Laptops</option>
                                <option value="3">PCs</option>
                                <option value="4">Consoles</option>
                                <option value="5">Movies</option>
                                <option value="6">Books</option>
                                <option value="7">Cables</option>
                                <option value="8">Adapters</option>
                                <option value="9">Office</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="categoria">Categoría</label>
                        <div class="col-md-9">
                            <!-- Chosen plugin (class is initialized in js/app.js -> uiInit()), for extra usage examples you can check out http://harvesthq.github.io/chosen/ -->
                            <select id="categoria" name="categoria" class="select-chosen" data-placeholder="Seleccione un categoría" style="width: 250px;">
                                <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                <option value="1">Dama</option>
                                <option value="2">Caballero</option>
                                <option value="3">Niños</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="subcategoria">Subcategoría</label>
                        <div class="col-md-9">
                            <select name="subcategoria" id="subcategoria" class="select-chosen" data-placeholder="Seleccione un departamento" style="width: 250px;">
                                 <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                 <option value="1">Subcategoría</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                            <label class="col-md-3 control-label" for="precio">Precio</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" id="precio" name="precio" class="form-control" placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="cantidad">Cantidad</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                    
                <!-- END General Data Content -->
            </div>
            <!-- END General Data Block -->
        </div>
        <div class="col-lg-6">
            <!-- Meta Data Block -->
            <div class="block">
                <!-- Meta Data Title -->
                <div class="block-title">
                    <h2><i class="fa fa-google"></i> <strong>Información</strong> Adicional</h2>
                </div>
                <!-- END Meta Data Title -->

                <!-- Meta Data Content -->
                    <div class="row">

                        <div class="form-group">
                            <div class="col-md-3">
                            <label class="control-label" for="">¿Producto perecedero?</label>
                        </div>
                        <div class="col-md-9">
                            No
                        <label class="switch switch-success">
                        <input name="perecedero" id="perecedero" value="si" type="checkbox"><span></span></label>
                        Si
                        </div>
                        </div>
                    </div>
                    <div class="form-group" style="display: none;" id="venci">
                        <label for="" class="col-md-3 control-label">Fecha de vencimiento</label>
                        <div class="col-md-9">
                            <input type="date" min="<?php echo date('Y-m-d') ?>" disabled name="vencimiento" id="vencimiento" class="form-control">
                        </div>
                    </div>
                    <div class="form-group hide">
                        <label class="col-md-3 control-label" for="product-meta-title">Cantidad</label>
                        <div class="col-md-9">
                            <input type="number" id="product-meta-title" name="product-meta-title" class="form-control" placeholder="Digite la cantidad">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="product-meta-keywords">Proveedor</label>
                        <div class="col-md-9">
                            <select name="proveedor" id="proveedor" class="select-chosen" data-placeholder="Seleccione un departamento" style="width: 250px;">
                                <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                <option value="1">Proveedor 1</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                           <!--label for="firma1">Imagen(*):</label-->
                           <div class="form-group eleimagen" >
                              <img src="../../img/imagenes_subidas/image.svg" style="width: 200px;height: 202px;" id="img_file">
                              <input type="file" class="archivos hidden" id="file_1" name="file_1" />
                           </div>
                        </div>
                        <div class="col-md-6 col-xs-6 ele_div_imagen">
                            <div class="form-group">
                                  <h5>La imagen debe de ser formato png o jpg con un peso máximo de 3 MB</h5>
                            </div><br><br>
                            <div class="form-group">
                              <button type="button" class="btn btn-sm btn-primary" id="btn_subir_img"><i class="icon md-upload" aria-hidden="true"></i> Seleccione Imagen</button>
                            </div>
                            <div class="form-group">
                              <div id="error_formato1" class="hidden"><span style="color: red;">Formato de archivo invalido. Solo se permiten los formatos JPG y PNG.</span>
                              </div>
                            </div>
                        </div>
                        
                    </div>
                <!-- END Meta Data Content -->
            </div>
            <!-- END Meta Data Block -->
        </div>
        <div class="col-lg-12">
            <div class="block">
                <div class="form-group">
                <div class="col-md-10">
                    <center>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Guardar</button>
                    <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                    </center>
                </div>
            </div>
            </div>
        </div>

        
        </form>
    </div>
    <!-- END Product Edit Content -->
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<script src="producto.js?cod=<?=$cod?>"></script>
<script type="text/javascript" src="../../js/jquery-barcode.js"></script>

<!-- Load and execute javascript code used only in this page -->
<script src="../../js/helpers/ckeditor/ckeditor.js"></script>      
<?php include '../../inc/template_end.php'; ?>

