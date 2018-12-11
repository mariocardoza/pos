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
include_once("../../Conexion/Empleado.php");
$datos = null;
$result = Empleado::obtener_empleados();
//print_r($result);
if($result[0] == 1)$datos = $result[1];
// else print_r($result);
?>

<!-- Page content -->
<div id="page-content">
    <div class="row">
      <div class="col-xs-12">
        <div class="block full">
          <div class="block-title">
            <h2> <strong> Empleados (<?=count($datos)?>)</strong></h2>
            <div class="block-options pull-right">
              <a href="javascript:void(0)" class="btn btn-lg bg-white" id="btn_nuevo"><i class="fa pull-left" style="width: 20px;"><img src="../../img/icon_mas.svg" class="svg" alt=""></i> Agregar empleado</a>
            </div>
          </div>
          <div class="">
            <table id="exampleTableSearch" class="table table-vcenter table-condensed table-bordered" >
              <thead>
                <tr>
                  <th>#</th>
                  <th>Imagen</th>
                  <th>Nombre</th>
                  <th>Teléfono</th>
                  <th>DUI</th>
                  <th>NIT</th>
                  <th>Dirección</th>
                  <th>Edad</th>
                  <th>Email</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Imagen</th>
                  <th>Nombre</th>
                  <th>Teléfono</th>
                  <th>DUI</th>
                  <th>NIT</th>
                  <th>Dirección</th>
                  <th>Edad</th>
                  <th>Email</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </tfoot>
              <tbody>
                <?php $n=1; foreach ($datos as $row) {
                    $imagen = $row['imagen'];
                    if(!$imagen || $imagen==""){
                        $imagen= "avatar2.jpg";
                    }
                ?>
                <tr id="tr_<?=$n?>">
                  <td ><?=$n?></td>
                  <td><img src="../../img/usuario/<?= $imagen ?>" alt="avatar" class="img-circle img-circle-usuarios"></td>
                  <td class="nombre"><?=($row['nombre'])?></td>
                  <td nowrap class="telefono"><?=($row['telefono'])?></td>
                  <td class="nivel"><?=($row['dui'])?></td>
                  <td class="nivel"><?=($row['nit'])?></td>
                  <td class="nivel"><?=($row['direccion'])?></td>
                  <td class="nivel"><?=($row['edad'])?></td>
                  <td nowrap class="email"><?=($row['email'])?></td>
                  <td nowrap class="text-center actions">
                    <div class="btn-group">
                      <a onclick="<?php echo "editar(".$row[id].")" ?>" class="btn btn-warning btn-xs" href="#"><span class="fa fa-edit"></span></a>
                    <a onclick="<?php echo "eliminar(".$row[id].")" ?>" class="btn btn-danger btn-xs" href="#"><span class="fa fa-remove"></span></a>
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
            <h4 class="modal-title">Agregar empleado</h4>
          </div>
          <div class="modal-body">
          <form method="post" accept-charset="utf-8" name="fm_nuevo_empleado" id="fm_nuevo_empleado">
            <input type="hidden" name="data_id" value="nuevo_empleado">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Nombre(*)</label>
                      <input type="text" class="form-control" id="n_nombre" name="nombre" required="" placeholder="Ingrese el nombre" >
                    </div>
                    <div class="form-group">
                      <label for="n_precio">Email(*)</label>
                      <input type="email" class="form-control" id="n_email" name="email" placeholder="Ingrese el email" required="">
                    </div>
                    <div class="form-group">
                      <label for="np_nombre">Teléfono(*)</label>
                      <input type="text" required class="form-control telefono" id="n_telefono" name="telefono" aria-describedby="nombrelHelp" placeholder="Ingrese el teléfono">
                      <!--small id="nombrelHelp" class="form-text text-muted">Este campo es requerido no olvide completarlo</small-->
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Dirección(*):</label>
                        <textarea name="direccion" required class="form-control" id="n_direccion" cols="30" rows="4"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label class="control-label" for="rol">DUI(*):</label>
                        <input type="text" required name="dui" id="n_dui" class="form-control dui">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">NIT(*):</label>
                        <input type="text" required name="nit" id="n_nit" class="form-control nit">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Fecha de nacimiento(*):</label>
                        <input type="text" required name="fecha_nacimiento" id="n_fecha_nacimiento" class="form-control nacimiento">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Género(*):</label>
                        <select id="genero" required name="genero" class="form-control select_piker2" data-plugin="selectpicker" data-live-search="true" data-placeholder="Seleccione el Municipio" readonly="" style="width: 250px;">
                            <option value="" disabled="" selected="">seleccione..</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Másculino">Másculino</option>
                            <!--option value="2">Cliente</option--> 
                        </select>
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
                </div>
            </div>
          </form>
          </div>
          <div class="modal-footer"><!-- margin-0 -->
            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btn_guardar">Guardar</button>
            <!--button type="button" data-formulario="fm_nuevo" class="btn btn-primary valida1">Validar</button-->
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade modal-side-fall" id="md_editar_proveedor" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="btn_cancelar_ep">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Editar Proceso</h4>
          </div>
          <div class="modal-body">
          <form method="post" accept-charset="utf-8" id="fm_editar_proceso">
          <input type="hidden" name="data_id" value="epr_1">
          <input type="hidden" name="codigo_e" id="codigo_e">
          <input type="hidden" name="np_fecha_h" value="<?=$anyo?>/<?=$mes?>/<?=$dia?> <?=$hora?>">
            <div class="row">
              <div class="">
                 <div class="form-group col-md-12">
                  <label for="np_nombre">Nombre *</label>
                  <input type="text" class="form-control" id="np_nombre1" name="np_nombre1" aria-describedby="nombrelHelp" required="" placeholder="Ingrese el nombre del proveedor">
                  <!--small id="nombrelHelp" class="form-text text-muted">Este campo es requerido no olvide completarlo</small-->
                </div>
                <div class="form-group col-md-6">
                  <label for="">Código</label>
                  <input type="text" class="form-control" id="md_codigo_ed" name="md_codigo" placeholder="" >
                </div>
                <div class="form-group col-md-6">
                  <label for="md_precio">Precio($)</label>
                  <input type="number" class="form-control" id="md_precio_ed" name="md_precio" step="any" min="0" max="10000.00" placeholder="" required="">
                </div>
                 
              </div>
            </div>
          </form>
          </div>
          <div class="modal-footer"><!-- margin-0 -->
            <button type="button" class="btn btn-default btn-pure" id="btn_cancelar_ep">Cancelar</button>
            <button type="button" class="btn btn-primary hide guarda1" id="btn_editar_proceso">Guardar</button>
            <!--button type="button" class="btn btn-primary valida1">Validar</button-->
          </div>
        </div>
      </div>
    </div>
    <div id="modal_edit"></div>
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
        $(document).on('input', '#n_email', function(event) {
            validar_cambios = false;
            $(".guarda1").addClass("hide");
            $(".valida1").removeClass("hide");
        });
        /*$(document).on("click",".valida1",function (e) {
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
        });*/
        $(document).on('blur', '#n_email', function(event) {
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
                                    .text('El E-mail ingresado ya fue registrado. Por favor ingrese uno diferente'),
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
                                    .text('El teléfono ingresado ya fue registrado. Por favor ingrese uno diferente'),
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
        });

        //validacion del formulario
        /*$("form[name='fm_nuevo_empleado']").validate({
            ignore: ":hidden:not(select)",
            rules: {
                n_nombre: "required",
            },
            
            messages: {
                n_nombre: "Complete este campo por favor",            
            },
            submitHandler: function(form) {
              //form.submit();
              guardar();
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

        //boton para actualizar
        $(document).on("click",'#btn_actualizar', function(e){
          var valid = $("#fm_editar_proceso").valid();
          if(valid){
            var datos = $("#fm_editar_empleado").serialize();
            $.ajax({
                url: "../../Conexion/administracion/data_json.php",
                dataType: "json",
                data: datos,
                method: "POST",
                success: function(json) {
                    console.log(json);
                    /*if(json[0]=='1'){
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
                    }if(json[0]=='-1'){
                        swal.close();
                        iziToast.error({
                            title: '<?php echo ERROR; ?>',
                            message: '<?php echo ERROR_MENSAJE;?>',
                            timeout: 3000,
                        });
                    }*/
                }
            });
          }
        

        });
        /*** boton guardar nuevo ****/
        $(document).on("click", "#btn_guardar", function(e) {
            console.log("guardar");
            var valid = $("#fm_nuevo_empleado").valid();
            if (valid) {
                var datos = $("#fm_nuevo_empleado").serialize();
                console.log(datos);
                console.log(valid);

                $('#md_nuevo').modal('toggle');
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
    function validar_archivo(file){
        $("#img_file").attr("src","../../img/imagenes_subidas/image.svg");//31.gif
            //var ext = file.value.match(/\.(.+)$/)[1];

             //Para navegadores antiguos

             if (typeof FileReader !== "function") {
                $("#img_file").attr("src",'../../img/imagenes_subidas/image.svg');
                return;
             }
             var Lector;
             var Archivos = file[0].files;
             var archivo = file;
             var archivo2 = file.val();
             if (Archivos.length > 0) {

                Lector = new FileReader();

                Lector.onloadend = function(e) {
                    var origen, tipo, tamanio;
                    //Envia la imagen a la pantalla
                    origen = e.target; //objeto FileReader
                    //Prepara la información sobre la imagen
                    tipo = archivo2.substring(archivo2.lastIndexOf("."));
                    console.log(tipo);
                    tamanio = e.total / 1024;
                    console.log(tamanio);

                    //Si el tipo de archivo es válido lo muestra, 

                    //sino muestra un mensaje 

                    if (tipo !== ".jpeg" && tipo !== ".JPEG" && tipo !== ".jpg" && tipo !== ".JPG" && tipo !== ".png" && tipo !== ".PNG") {
                        $("#img_file").attr("src",'../../img/imagenes_subidas/photo.svg');
                        $("#error_formato1").removeClass('hidden');
                        //$("#error_tamanio"+n).hide();
                        //$("#error_formato"+n).show();
                        console.log("error_tipo");
                    }
                    else{
                        $("#img_file").attr("src",origen.result);
                        $("#error_formato1").addClass('hidden');
                    }


               };
                Lector.onerror = function(e) {
                console.log(e)
               }
               Lector.readAsDataURL(Archivos[0]);
       }
       
    }

    function insertar_imagen(archivo,id_prod){
        var file =archivo.files;
        var formData = new FormData();
        formData.append('formData', $("#fm_nuevo_empleado"));
        var data = new FormData();
         //Append files infos
         jQuery.each(archivo[0].files, function(i, file) {
            data.append('file-'+i, file);
         });

         console.log("data",data);
         $.ajax({  
            url: "../../Conexion/administracion/data_json_imagen.php?id="+id_prod,  
            type: "POST", 
            dataType: "json",  
            data: data,  
            cache: false,
            processData: false,  
            contentType: false, 
            context: this,
            success: function (json) {
                console.log(json);
                if(json.exito){  
                    iziToast.success({
                        title: '<?php echo EXITO; ?>',
                        message: '<?php echo EXITO_MENSAJE;?>',
                        timeout: 3000,
                    });
                    timer=setInterval(function(){
                        //location.reload();                        
                        clearTimeout(timer);
                    },2000);
                     NProgress.done();
                }
                if(json.error){
                    swal.close();
                    swal({
                      title: '¡Advertencia!',
                      html: $('<div>')
                      .addClass('some-class')
                      .text('No se logro insertar la imagen'),
                      animation: false,
                      allowEscapeKey:false,
                      allowOutsideClick:false,
                      customClass: 'animated tada',
                            //timer: 2000
                          }).then(function (result) {
                            //$("#md_cantidad").focus();
                            
                          });
                }

            }
        });
    }

    // funcion para cargar modal de editar
    function editar(id){
      $.ajax({
        url: "../../Conexion/administracion/data_json.php",  
        type: 'GET',
        dataType: 'json',
        data: {id:id,data_id:'modal_editar'},
        success: function(json){
          console.log(id);
          $("#modal_edit").html(json[3]);
          $("#md_editar").modal('show'); // lanza el modal
        }
      });
    }

    // funcion eliminar usuario
    function eliminar(id){
      /*swal({
        title: '¿Está seguro de eliminar el empleado?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'si, continuar!'
      }).then((result) => {
        if (result.value) {
          console.log("aqui");
          $.ajax({
              url:'../../Conexion/administracion/data_json.php',
              type:'GET',
              dataType:'json',
              data:{data_id:'eliminar_empleado',id:id},
              success: function(json){
                if(json[0]=='1'){
                      iziToast.success({
                          title: '<?php echo EXITO; ?>',
                          message: '<?php echo ELIMINAR_MENSAJE;?>',
                          timeout: 3000,
                      });
                      var timer=setInterval(function(){
                          location.reload();
                          clearTimeout(timer);
                      },3500);
                  }else
                    iziToast.error({
                        title: '<?php echo ERROR; ?>',
                        message: '<?php echo ERROR_MENSAJE;?>',
                        timeout: 3000,
                    });
               }
          });
        }
      })
      */
      $.ajax({
              url:'../../Conexion/administracion/data_json.php',
              type:'GET',
              dataType:'json',
              data:{data_id:'eliminar_empleado',id:id},
              success: function(json){
                if(json[0]=='1'){
                      iziToast.success({
                          title: '<?php echo EXITO; ?>',
                          message: '<?php echo ELIMINAR_MENSAJE;?>',
                          timeout: 3000,
                      });
                      var timer=setInterval(function(){
                          location.reload();
                          clearTimeout(timer);
                      },3500);
                  }else
                    iziToast.error({
                        title: '<?php echo ERROR; ?>',
                        message: '<?php echo ERROR_MENSAJE;?>',
                        timeout: 3000,
                    });
               }
          });
    }
</script>