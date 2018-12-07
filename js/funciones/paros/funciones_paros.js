
$(function(){
    $(document).on("click", "#consultar_filtroparo", function (e) {
        console.log("simon asi es");
        var fecha_inicial = $("#fecha_inicial_ver").val();
        var fecha_final = $("#fecha_final_ver").val();
        var ingenio = $("#ingeio_filtro").val();
        var region = $("#por_region").val();
        var tipo_paro = $("#tipoparo_lista").val();
        var razonparo =$("#razones_lista :selected").val();
        var paro =$("#paro_lista :selected").val();
        var etapas = $("#por_etapa").val();
        var flota = $("#flota_lista").val();
        var anulados = $("#select_anulados").val();
        var dependencias = $("#select_dependencias").val();

        var datos={cargar_datos:"si_cargar_datos_222",fecha_inicial:fecha_inicial,fecha_final:fecha_final,ingenio:ingenio,region:region,tipo_paro:tipo_paro,razonparo:razonparo,paro:paro,etapas:etapas,flota:flota,anulados:anulados,dependencias:dependencias};
        console.log("los datos",datos);
        NProgress.start();
        $.ajax({ 
            dataType: "json",
            method: "POST",
            url:'administrar_json_paros.php',
            data : datos,
        }).done(function(msg) {
            console.log("el mensaje",msg);
            if(msg.exito){   
                console.log("mensaje exito",msg.exito);
                $("#tabla_datos_paro").empty();
                $("#tabla_datos_paro").html(msg.exito[0]);
                $("#html_paros2").empty().html(msg.exito[1]);
                data_ideventos = msg.exito[2];
                sql_datos = msg.exito[3];
                cargar_tabla("t_final");
                $("[rel='tooltip']").tooltip();
                $('[data-toggle="tooltip"]').tooltip();
                NProgress.done();
            }else{
                NProgress.done();
                iziToast.error({
                   title: 'Error',
                   message: 'Intentalo nuevamente, la acción no se ha podido completar intentelo nuevamente',
                   timeout: 3000,
                });
            }
        });

        

    });
    /*****inicializando filtros*****/
    $('#fecha_inicial_ver').datepicker({
        format: 'dd/mm/yyyy',
        language: "es",
        autoclose: true,
        todayBtn: "linked", 
        todayHighlight: false,
        toggleActive: true,
        setDate:fecha_minima,
        startDate: fecha_minima, 
        endDate: fecha_maxima
    });
    $('#fecha_inicial_ver').change(function() { 
        var fecha_seleccionada = $('#fecha_inicial_ver').val();
        $('#fecha_final_ver').datepicker({

            format: 'dd/mm/yyyy',
            language: "es",
            autoclose: true,
            todayBtn: "linked", 
            todayHighlight: false,
            toggleActive: true,
            startDate: fecha_seleccionada, 
            endDate: fecha_maxima
             
        });

        $('#fecha_final_ver').val(fecha_seleccionada);
    });

    /****abrir modales*******/

    /****reasignar mecanico*****/
    $(document).on("click", "#btn_asignar_mecanico2", function (e) {
        var elem=$(this);
        console.log("el nivel",elem.attr('data-id_evento'));
        var datos={mandando:"reasignar",id_paro:elem.attr('data-id_evento'),codmecanico:elem.attr("data-codmecanico")};
        console.log("el datos",datos);
        swal({
          title: '¡Cargando!',  
          allowOutsideClick: false,
          allowEscapeKey:false,
          onOpen: function () {
            swal.showLoading()
          }
        });
        $.ajax({
            dataType: "json",
            method: "POST",
            url:'administrar_json_paros.php',
            data : datos,
        }).done(function(msg) {
            swal.closeModal();
            console.log("el mensaje",msg);
            if(msg.exito){   
                
                $("#evento_seleccionado2").val(elem.attr('data-id_evento'));
                $("#mecanicos_lista2").html('<option disabled selected></option>'+msg.exito[1]);
                $("#mecanicos_lista2").trigger('chosen:updated');  

                $("#mecanico_asignado").empty().html(msg.exito[3]);

                $("#equipo_tabla2").html(elem.attr('data-equipo'));
                $("#estado_tabla2").html(elem.attr('data-estado'));
                $("#descripcion_tabla2").html(elem.attr('data-comentario'));
                $("#flota_tabla2").html(elem.attr('data-flota'));
                $("#hacienda_tabla2").html(elem.attr('data-hacienda'));
                $("#region_tabla2").html(elem.attr('data-region'));
                
                $("#tabla_reasignardatos").html(msg.exito[2]);

                $("#moda_reasignar_mecanico").modal({
                    show: 'false'
                });

            }
        });
        

    });

    
    /*****asignar mecanico abre modal****/

    $(document).on("change", "#mecanicos_lista", function(e) {//CLICK EN EL BOTON CANCELAR DE LA MODAL AGREGAR REPUESTO
          var valor = $(this);
          var option = $("#mecanicos_lista :selected");
          $("#nombre_mecanico").val(option.data("nombre"));
          console.log($("#nombre_mecanico").val());
    });

    $(document).on("click", "#btn_asignar_mecanico", function (e) {
        var elem=$(this);
        console.log("el nivel dek necanico ejemplo dato",elem.attr('data-id_evento'));
        var datos={mandando:"nuevo",id_paro:elem.attr('data-id_evento')};
        swal({
          title: '¡Cargando!',  
          allowOutsideClick: false,
          allowEscapeKey:false,
          onOpen: function () {
            swal.showLoading()
          }
        });
        $.ajax({
            dataType: "json",
            method: "POST",
            url:'administrar_json_paros.php',
            data : datos,
        }).done(function(msg) {
            swal.closeModal();
            console.log("el mensaje",msg);
            if(msg.exito){   
                $("#lahidden").val("save");
                $("#evento_seleccionado").val(elem.attr('data-id_evento'));
                $("#mecanicos_lista").html(msg.exito[1]);
                $("#mecanicos_lista").trigger('chosen:updated');  

                $("#equipo_tabla").html(elem.attr('data-equipo'));
                $("#estado_tabla").html(elem.attr('data-estado'));
                $("#descripcion_tabla").html(elem.attr('data-comentario'));
                $("#flota_tabla").html(elem.attr('data-flota'));
                $("#hacienda_tabla").html(elem.attr('data-hacienda'));
                $("#region_tabla").html(elem.attr('data-region'));
                $("#region_tabla").html(elem.attr('data-region'));


                $("#moda_asignar_mecanico").modal({
                    show: 'false'
                });

               
            } else if(msg.error){       
                 
                console.log("al else");
            }
        });
         
    });


    $(document).on("submit", "#asignar_mecanico", function (e) {
        e.preventDefault();
        swal({
          title: '¡Cargando!',
          allowOutsideClick: false,
          allowEscapeKey:false,
          onOpen: function () {
            swal.showLoading()
          }
        });
        console.log("este hace submit ele");
        var datos = $("#asignar_mecanico").serialize();
        console.log(datos);
        $.ajax({
            dataType: "json",
            method: "POST",
            url:'../../Servicio/json_paros_desde_dashboard.php',
            data : datos,
        }).done(function(msg) {
            swal.closeModal();
            console.log("el mensaje",msg);
            if(msg.exito){   
                $("#moda_asignar_mecanico").modal('toggle');
                console.log("simon esta llegando");
                iziToast.success({
                   title: 'Excelente',
                   message: 'El mecánico ha sido asignado exitosamente',
                   timeout: 3000,
                });

                var timer=setInterval(function(){
                    location.reload();
                    clearTimeout(timer);
                },3500);

            }else if(msg.error){  
                NProgress.done();
                $("#moda_asignar_mecanico").modal('toggle');
                iziToast.error({
                   title: 'Error',
                   message: 'Intentalo nuevamente, el paro no puso ser asignado',
                   timeout: 3000,
                });
            }
        });
    });


    $(document).on("submit", "#reasignar_mecanico", function (e) {
        e.preventDefault();
        
        var datos={lahidden:"reasignar",evento_seleccionado:$("#evento_seleccionado2").val(),mecanicos_lista:$("#mecanicos_lista2").val(),nombre:$("#mecanicos_lista2 :selected").attr("data-nombre"),UsuarioCrea:UsuarioCrea};
        console.log("reasignación",datos);
        swal({
          title: '¡Cargando!',
          allowOutsideClick: false,
          allowEscapeKey:false,
          onOpen: function () {
            swal.showLoading()
          }
        });
        $.ajax({
            dataType: "json",
            method: "POST",
            url:'../../Servicio/json_paros_desde_dashboard.php',
            data : datos,
        }).done(function(msg) {
            swal.closeModal();
            console.log("el mensaje",msg);
            if(msg.exito){   
                NProgress.done();
                $("#moda_reasignar_mecanico").modal('toggle');
                console.log("simon esta llegando");
                iziToast.success({
                   title: 'Excelente',
                   message: 'El mecánico ha sido reasignado exitosamente',
                   timeout: 3000,
                });

                var timer=setInterval(function(){
                    location.reload();
                    clearTimeout(timer);
                },3500);

            }else if(msg.error){  
                NProgress.done();
                $("#moda_reasignar_mecanico").modal('toggle');
                iziToast.error({
                   title: 'Error',
                   message: 'Intentalo nuevamente, el paro no puso ser reasignado',
                   timeout: 3000,
                });
            }
        });

    });


 });