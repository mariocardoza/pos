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
            <li class="active">
                <a href="#"><i class="gi gi-pencil"></i> Registro de cliente</a>
            </li>
            <li >
                <a href="#"><i class="gi gi-user"></i> Clientes</a>
            </li>
        </ul>
    </div>
    <!-- END eCommerce Product Edit Header -->

    <!-- Product Edit Content -->
        <!-- General Data Content -->
        <form action="#" method="post" name="fm_cliente" id="fm_cliente" class="form-horizontal form-bordered">
            <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-title"></div>
                <div class="form-group">
                <div class="col-md-3">
                    <label class="control-label" for="">Tipo de cliente</label>
                </div>
                <div class="col-md-9">
                    Persona natural
                <label class="switch switch-success">
                <input name="tipocliente" id="tipocliente" value="juridica" type="checkbox"><span></span></label>
                Persona jurídica
                </div>
            </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Información</strong> general</h2>
                </div>
                <div class="row">
                    <div class="col-lg-6">
            <div class="form-group">
                <label class="col-md-3 control-label" for="nombre">Nombre</label>
                <div class="col-md-9">
                    <input type="hidden" name="data_id" value="nuevo_cliente">
                    <input required type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del nombre">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" for="direccion">Dirección</label>
                <div class="col-md-9">
                    <textarea required id="direccion" name="direccion" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="form-group" id="fdui">
                <label class="col-md-3 control-label" for="departamento">DUI</label>
                <div class="col-md-9">
                    <input type="text" name="dui"id="dui" class="form-control dui">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" for="categoria">NIT</label>
                <div class="col-md-9">
                    <input type="text" name="nit" id="nit" class="form-control nit">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="col-md-3 control-label" for="telefono">Número de teléfono</label>
                <div class="col-md-9">
                    <input type="text" name="telefono" id="telefono" class="form-control telefono">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="email">Email</label>
                <div class="col-md-9">
                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-control" >
                    </div>
                </div>
            </div>

            <div class="form-group" id="nacimiento">
                <label for="" class="col-md-3 control-label">Fecha de nacimiento</label>
                <div class="col-md-9">
                    <input type="text" class="form-control nacimiento" name="fecha_nacimiento" id="fecha_nacimiento">
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12" id="contri" style="display: none;">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Datos</strong> del contribuyente</h2>
                </div>
                <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Número de registro</label>
                        <div class="col-md-9">
                            <input type="text" name="nrc" id="nrc" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Giro</label>
                        <div class="col-md-9">
                            <input type="text" name="giro" id="giro" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Razón social</label>
                        <div class="col-md-9">
                            <input type="text" id="razon_social" name="razon_social" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Tipo contribuyente</label>
                        <div class="col-md-9">
                            <select name="tipocontribuyente" id="tipocontribuyente" style="width:auto;"data-live-search="true" class="select_piker2">
                                <option value="">Seleccione...</option>
                                <option value="1">Pequeño</option>
                                <option value="2">Mediano</option>
                                <option value="3">Grande</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Nombre del representante legal</label>
                        <div class="col-md-9">
                            <input type="text" id="nombre_r" name="nombre_r" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Teléfono del representante legal</label>
                        <div class="col-md-9">
                            <input type="text" id="telefono_r" name="telefono_r" class="form-control telefono">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Dirección del representante legal</label>
                        <div class="col-md-9">
                            <textarea name="direccion_r" id="direccion_r" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Retiene 1%</label>
                        <div class="col-md-9">
                            <input type="radio" checked name="retiene" value="0">No
                            <input type="radio" name="retiene" value="1">Si
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="block">
                <div class="form-group">
                <div class="col-md-10">
                    <center>
                        <button type="button" id="btn_guardar" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Guardar</button>
                    <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>  
                    </center>
                </div>
            </div>
            </div>
        </div>
        </div>
    </form>
    <!-- END Product Edit Content -->
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<script src="cliente.js?cod=<?=$cod?>"></script>

<!-- Load and execute javascript code used only in this page -->
<script src="../../js/helpers/ckeditor/ckeditor.js"></script>      
<?php include '../../inc/template_end.php'; ?>

