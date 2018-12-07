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
?>

<?php include '../../inc/config.php'; ?>
<?php include '../../inc/template_start.php'; ?>
<style type="text/css" media="screen">
    .block-title h2 {
        font-size: 23px;
    }
</style>
<?php include '../../inc/page_head.php'; 
include_once("../../Conexion/administracion/Usuarios.php");
include_once("../../Conexion/Empleado.php");
$datos = null;
$result = Usuarios::get_usuario_personas();
$result2 = Empleado::obtener_empleados_guardar();
//print_r($empleados[1]);
$empleados=$result2[1];
if($result[0] == 1)$datos = $result[1];
// else print_r($result);
?>

<!-- Page content -->
<div id="page-content">
    <div class="row">
      <div class="col-xs-12">
        <div class="block full">
          <div class="block-title">
            <h2> <strong> Usuarios (<?=count($datos)?>)</strong></h2>
            <div class="block-options pull-right">
              <a href="javascript:void(0)" class="btn btn-lg bg-white" id="btn_nuevo"><i class="fa pull-left" style="width: 20px;"><img src="../../img/icon_mas.svg" class="svg" alt=""></i> Agregar usuario</a>
            </div>
          </div>
          <div class="">
            <table id="exampleTableSearch" class="table table-vcenter table-condensed table-bordered" >
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Nivel</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Nivel</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </tfoot>
              <tbody>
                <?php $n=1; foreach ($datos as $row) { ?>
                <tr id="tr_<?=$n?>">
                  <td ><?=$n?></td>
                  <td class="nombre"><?=($row['nombre'])?></td>
                  <td nowrap class="email"><?=($row['email'])?></td>
                  <td class="nivel"><?=($row['n_nivel'])?></td>
                  <td nowrap class="text-center actions">
                    <div class="btn-group">
                      <a class="btn btn-danger btn-xs" title="Deshabilitar usuario" data-id="<?php echo $row[cod_usuario] ?>" href="#" id="deshabilitar"><span class="fa fa-remove"></span></a>
                      <a class="btn btn-warning btn-xs" data-id="<?php echo $row[email] ?>" href="#" id="nuevo_pass" title="Generar nueva contraseña"><span class="fa fa-key"></span></a>
                    </div>
                  </td>
                </tr>
                <?php 
                  $n++;}
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade modal-side-fall" id="md_nuevo" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Agregar usuario</h4>
          </div>
          <div class="modal-body">
          <form method="post" accept-charset="utf-8" id="fm_nuevo">
            <input type="hidden" name="data_id" value="nuevo_usuario">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Seleccione el empleado(*)</label>
                      <select name="empleado_id" id="empleado_id" class="form-control select_piker2" data-plugin="selectpicker" data-live-search="true" data-placeholder="Seleccione un empleado" readonly="" style="width: 250px;">
                        <?php foreach ($empleados as $empleado) {?>
                            <option value="<?php echo $empleado[id] ?>"><?php echo $empleado[nombre] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="n_precio">Email(*)</label>
                      <input type="email" class="form-control" id="n_email" name="email" placeholder="Ingrese el email" required="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Contraseña(*):</label>
                        <input type="text" name="pass" id="pass" class="form-control">
                    </div>
                   
                </div>
            </div>
          </form>
          </div>
          <div class="modal-footer"><!-- margin-0 -->
            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary hide guarda1" id="btn_guardar">Guardar</button>
            <button type="button" data-formulario="fm_nuevo" class="btn btn-primary valida1">Validar</button>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<?php include '../../inc/template_end.php'; ?>

<script type="text/javascript">
    var correo_g = "";
    var table_procesos = cargar_tabla2("exampleTableSearch"); //inicializar tabla
    var cod_ed = "";
    var nom_ed = "";
    var data_n = -1;
    var validar_cambios=val_email=val_tel= false;
    $(function() {
        $(document).on('input', '#n_email, #e_email', function(event) {
            validar_cambios = false;
            $(".guarda1").addClass("hide");
            $(".valida1").removeClass("hide");
        });
        $(document).on("click",".valida1",function (e) {
            var esto = $(this);
            //var valid = $("#"+esto.data("formulario")).valid();
            if(val_tel && val_email){
                $(".guarda1").removeClass("hide");
                esto.addClass("hide");
            }
            else{
                $(".guarda1").addClass("hide");
                esto.removeClass("hide");
            }
        });

        $(document).on("click","#nuevo_pass", function(e){
          var valor = $(this).attr('data-id');
            //var estado = $(this).attr('data-estado');
            
            console.log(valor);
            NProgress.start();
            var get = { elcorreo:valor,des:"1"};
            console.log(get);
            $.ajax({
                dataType: "json",
                method: "POST",
                url:'../json/generar_pass.php',
                data : get,
            }).done(function(msg) {
                console.log("esto trae",msg);
                
                if(msg.exito[0]=='1'){
                        $.bootstrapGrowl('<h4>Excelente !</h4> <p>Se ha enviado un correo con la nueva contraseña al usuario!</p>', {
                        type: "success",
                        delay: 2500,
                        allow_dismiss: true
                    });

                    NProgress.done();
                    var timer=setInterval(function(){
                        location.reload();
                        clearTimeout(timer);
                    },2500);
                    
                }
                else {
                    NProgress.done();
                    $.bootstrapGrowl('<h4>Error!</h4> <p>no se generó la nueva contraseña !</p>', {
                        type: "danger",
                        delay: 2500,
                        allow_dismiss: true
                    });
                }

            });
        });
        /*$(document).on('blur', '#n_email', function(event) {
            event.preventDefault();
            var valor = $(this);
            if (correo_g != valor.val() && valor.val() != "") {
                $.ajax({
                    url: "../../Conexion/administracion/data_json.php",
                    dataType: "json",
                    data: { data_id: "val_email", email: valor.val() },
                    method: "POST",
                    success: function(json) {
                        console.log(json);
                        if (json[1]) {
                            val_email = false;
                            swal({
                                title: '¡Advertencia!',
                                html: $('<div>')
                                    .addClass('some-class')
                                    .text('El E-mail ingresado ya fue registrado. Par favor ingrese uno diferente'),
                                animation: false,
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                customClass: 'animated tada',
                                //timer: 2000
                            }).then(function(result) {
                                //$("#md_cantidad").focus();
                                valor.val("");
                                valor.focus();
                            });
                        } else {
                            val_email = true;
                            $(".valida1").trigger("click");
                        }

                    }
                });
            }
        });
        $(document).on('blur', '#n_telefono', function(event) {
            event.preventDefault();
            var valor = $(this);
            if (valor.val() != "") {
                $.ajax({
                    url: "../../Conexion/administracion/data_json.php",
                    dataType: "json",
                    data: { data_id: "val_tel", email: valor.val() },
                    method: "POST",
                    success: function(json) {
                        console.log(json);
                        if (json[1]) {
                            val_tel = false;
                            swal({
                                title: '¡Advertencia!',
                                html: $('<div>')
                                    .addClass('some-class')
                                    .text('El teléfono ingresado ya fue rejistrado. Par favor ingrese uno diferente'),
                                animation: false,
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                customClass: 'animated tada',
                                //timer: 2000
                            }).then(function(result) {
                                //$("#md_cantidad").focus();
                                valor.val("");
                                valor.focus();
                            });
                        } else {
                            val_tel = true;
                            $(".valida1").trigger("click");
                        }

                    }
                });
            }
        });*/
        $(document).on("click", "#btn_nuevo", function (e) {
            $(".guarda1").addClass("hide");
            $(".valida1").removeClass("hide");
            $("#n_nombre").val("");
            $("#n_email").val("");
            $("#n_telefono").val("");
            $("#md_nuevo").modal({
                show: 'false'
            }); 
        });
        /*** boton guardar nuevo ****/
        $(document).on("click", "#btn_guardar", function(e) {
            console.log("guardar");
            var valid = $("#fm_nuevo").valid();
            if (valid) {
                var datos = $("#fm_nuevo").serialize();
                console.log(datos);
                console.log(valid);

                $('#md_nuevo_proceso').modal('toggle');
                swal({
                    title: '¡Cargando!',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    onOpen: function() {
                        swal.showLoading()
                    }
                });
                $.ajax({
                    url: "../../Conexion/administracion/data_json.php",
                    dataType: "json",
                    data: datos,
                    method: "POST",
                    success: function(json) {
                        console.log(json);
                        if(json[0]==1){
                            if ($("#file_1").val()!="") {
                                insertar_imagen($("#file_1"),json[1][0]);
                            }else{
                                iziToast.success({
                                    title: '<?php echo EXITO; ?>',
                                    message: '<?php echo EXITO_MENSAJE;?>',
                                    timeout: 3000,
                                });
                                var timer=setInterval(function(){
                                    $("#md_nuevo").modal('toggle');
                                    location.reload();
                                    clearTimeout(timer);
                                },3500);
                            }
                        }if(json[0]==-1){
                            swal.close();
                            iziToast.error({
                                title: '<?php echo ERROR; ?>',
                                message: '<?php echo ERROR_MENSAJE;?>',
                                timeout: 3000,
                            });
                        }
                    }
                });
            }
        });
        $(document).on("click", "#img_file", function (e) {
            $("#file_1").click();
        });
        $(document).on("click", "#btn_subir_img", function (e) {
            $("#file_1").click();
        });
        $("#file_1").change(function(event) {
            validar_archivo($(this));
        });
    });
   
</script>