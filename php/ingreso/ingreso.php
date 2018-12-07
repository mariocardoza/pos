<?php 
    @session_start();
    //echo $_SESSION['autentica']."STO TRAE";
    if(isset($_SESSION['loggedin']) && $_SESSION['autentica'] == "simon"){
        if($_SESSION['autentica'] == "simon" )
        {
            header("Location: ../home/index.php");  
            exit(); 
        }else{
          
             

        }
    }else{
        
    }
?>
<?php include '../../inc/config.php'; ?>
<?php include '../../inc/template_start.php'; ?>

<!-- Login Full Background -->
<!-- For best results use an image with a resolution of 1280x1280 pixels (prefer a blurred image for smaller file size) -->
<img src="" alt="Login Full Background" class="full-bg animation-pulseSlow">
<!-- END Login Full Background -->

<!-- Login Container -->
<div id="login-container" class="animation-fadeIn">
    <!-- Login Title -->
    <div class="login-title text-center">
        <h1>  <strong><?php echo $template['name']; ?></strong><br><small>Por favor  <strong>Ingrese sus datos</strong></small></h1>
    </div>
    <!-- END Login Title -->

    <!-- Login Block -->
    <div class="block push-bit">
        <!-- Login Form -->
        <form action="duo_pass.php" method="post" id="form-login_duo" class="hidden-print">
            <input type="hidden" id="duo_user" name="user" value="">
            <input type="hidden" id="duo_mensaje2" name="mensaje2" value="">
        </form>

        <form action="index.php" method="post" id="form-login" class="form-horizontal form-bordered form-control-borderless">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                        <input type="text" id="login-email" name="login-email" class="form-control input-lg" placeholder="Email">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                        <input type="password" id="login-password" name="login-password" class="form-control input-lg" placeholder="Password">
                    </div>
                </div>
            </div>
            <div class="form-group form-actions">
                
                <div class="col-xs-12 text-right">
                    <button type="submit" id="boton_inicio" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Iniciar sesión</button>

                    <i id="cargando_inicio" class="fa fa-spinner fa-4x fa-spin hidden"></i>

                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 text-left">
                    <!--a href="javascript:void(0)" id="link-reminder-login"><small>Olvidó su contraseña?</small></a--> 
                </div>
            </div>
        </form>
       
    </div> 
</div>

 <div class="modal fade modal-side-fall" id="md_cambiar_contra" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Hola <span id="nom_span"></span> Bienvenido a <?php echo $template['name'] ?> Tu contraseña fue generada, por favor actualízala.</h4>
      </div>
      <div class="modal-body">
      <form method="post" accept-charset="utf-8" id="fm_nuevo">
        <input type="hidden" name="data_id" value="cambiar_contra">
        <input type="hidden" name="codigo" id="n_codigo" value="">
        <input type="hidden" name="nombre" id="n_nombre" value="">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                  <label for="">Nueva Contraseña(*)</label>
                  <input type="password" class="form-control" id="n_contra" name="contra" required="" minlength="8" maxlength="16" pattern="^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$">
                </div>
                <div class="form-group">
                  <label for="n_precio">Repetir Contraseña(*)</label>
                  <input type="password" class="form-control" id="n_recontra" required="">
                </div>
            </div>
        </div>
      </form>
      </div>
      <div class="modal-footer"><!-- margin-0 -->
        <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary guarda1" id="btn_guardar">Guardar</button>
      </div>
    </div>
  </div>
</div>

<?php include '../../inc/template_scripts.php'; ?>
<script src="../../js/pages/login.js"></script>
<script>
$(function(){ 
    Login.init(); 
   
    $(document).on("submit", "#form-login", function (e) {
        console.log("eleangel");
        e.preventDefault();
        $("#boton_inicio").addClass("hidden");
        $("#cargando_inicio").removeClass("hidden");
        var get = { usuario:$("#login-email").val(), password:$("#login-password").val() ,id:"1" };
        console.log(get);
        $.ajax({
            dataType: "json",
            method: "POST",
            url:'json_consultar_usuario.php', 
            data : get,
        }).done(function( msg ) {
            console.log("esto trae",msg);
            if(msg.exito[0] == '0'){
               
                NProgress.done();
                iziToast.error({
                    title: '<?php echo ERROR; ?>',
                    message: '<?php echo USUARIO_INVALIDO;?>',
                    timeout: 3000,
                });
                

                var timer=setInterval(function(){
                   $("#cargando_inicio").addClass("hidden");
                    $("#boton_inicio").removeClass("hidden");  
                },3500);


            }
            else if(msg.exito[0] == '1'){
                

                iziToast.success({
                    title: msg.exito[1],
                    message: '<?php echo BIENVENIDO;?>',
                    timeout: 3000,
                });
                NProgress.done();

                var timer=setInterval(function(){
                    $(location).attr('href','../index.php?id='+msg.exito[1]+'&date=<?php echo date("Yhmsi") ?>');
                    clearTimeout(timer);
                },3500);


                
            }
            else if(msg.exito[0] == '2'){
               
                NProgress.done();
                iziToast.error({
                    title: '<?php echo ERROR; ?>',
                    message: '<?php echo USUARIO_INACTIVO;?>',
                    timeout: 3000,
                });

                var timer=setInterval(function(){
                   $("#cargando_inicio").addClass("hidden");
                    $("#boton_inicio").removeClass("hidden");  
                },3500);



            }
            else if(msg.exito[0] == '3'){
                $("#boton_inicio").removeClass("hidden");
                $("#cargando_inicio").addClass("hidden");
                NProgress.done();
                $("#nom_span").empty().html(msg.exito[1]);
                $("#n_codigo").val(msg.exito[2]);
                $("#n_nombre").val(msg.exito[1]);

                $("#md_cambiar_contra").modal({show: 'false'}); 
            }
            else{
                NProgress.done();
                iziToast.error({
                    title: '<?php echo ERROR; ?>',
                    message: '<?php echo USUARIO_INVALIDO;?>',
                    timeout: 3000,
                });

                var timer=setInterval(function(){
                   $("#cargando_inicio").addClass("hidden");
                    $("#boton_inicio").removeClass("hidden");  
                },3500);
            }
        });

        return false;
    });

 
    $(document).on("click", "#btn_guardar", function(e) {
        console.log("guardar");
        var recontra = $("#n_recontra").val();
        var contra = $("#n_contra").val();
        var valid = $("#fm_nuevo").valid();
        if(recontra != contra){
            iziToast.warning({
                title: '<?php echo ERROR; ?>',
                message: 'Las contraseñas no coinciden',
                timeout: 3000,
            });
        }
        else if(valid){
            swal({
                title: '¡Cargando!',
                allowOutsideClick: false,
                allowEscapeKey: false,
                onOpen: function() {
                    swal.showLoading()
                }
            });
            var datos = $("#fm_nuevo").serialize();
            console.log(datos);
            $.ajax({
                url: "json_consultar_usuario",
                dataType: "json",
                data: datos,
                method: "POST",
                success: function( msg ) {
                    console.log("esto trae",msg);
                    if(msg.exito[0] == '0'){
                        NProgress.done();
                        iziToast.error({
                            title: '<?php echo ERROR; ?>',
                            message: '<?php echo USUARIO_INVALIDO;?>',
                            timeout: 3000,
                        });
                    }
                    else if(msg.exito[0] == '1'){
                        iziToast.success({
                            title: msg.exito[1],
                            message: '<?php echo BIENVENIDO;?>',
                            timeout: 3000,
                        });
                        NProgress.done();
                        var timer=setInterval(function(){
                            $(location).attr('href','../index.php?id='+msg.exito[1]+'&date=<?php echo date("Yhmsi") ?>');
                            clearTimeout(timer);
                        },3500);


                        
                    }
                }
            });

        }
        
    });
});


</script>

<?php include '../../inc/template_end.php'; ?>