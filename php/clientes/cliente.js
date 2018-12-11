$(document).ready(function(e){
	//habilitar elementos para persona jurídica
	 $('#tipocliente').change(function() {
        if( $(this).is(':checked') ){
        // Hacer algo si el checkbox ha sido seleccionado
        $("#contri").show();
        $("#nacimiento").hide();
        $("#fdui").hide();
        $("#nrc").prop("required",true);
        $("#nit").prop("required",true);
        $("#tipocontribuyente").prop("required",true);
    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        $("#contri").hide();
        $("#nacimiento").show();
        $("#fdui").show();
        $('#nrc').removeAttr('required');
        $('#nit').removeAttr('required');
        $('#tipocontribuyente').removeAttr('required');
    }
    });

	 //dar de baja a un cliente
	 $(document).on("click","#btn_baja", function(e){
          swal({
        title: '¿Está seguro de dar de baja al cliente?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'si, continuar!'
      }).then((result) => {
        if (result.value) {
          console.log("aqui");
        }
      });
    });
	 //validar dui
	 $(document).on('blur', '#dui', function(event) {
            event.preventDefault();
            var valor = $(this);
            if (valor.val() != "") {
                $.ajax({
                    url: "json_clientes.php",
                    dataType: "json",
                    data: { data_id: "val_dui", dui: valor.val() },
                    method: "POST",
                    success: function(json) {
                        console.log(json);
                        if (json[1]) {
                            val_nrc = false;
                            swal({
                                title: '¡Advertencia!',
                                html: $('<div>')
                                    .addClass('some-class')
                                    .text('El DUI ingresado ya fue registrado. Por favor ingrese uno diferente'),
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

	 //validar nit
	 $(document).on('blur', '#nit', function(event) {
            event.preventDefault();
            var valor = $(this);
            if (valor.val() != "") {
                $.ajax({
                    url: "json_clientes.php",
                    dataType: "json",
                    data: { data_id: "val_nit", nit: valor.val() },
                    method: "POST",
                    success: function(json) {
                        console.log(json);
                        if (json[1]) {
                            val_nrc = false;
                            swal({
                                title: '¡Advertencia!',
                                html: $('<div>')
                                    .addClass('some-class')
                                    .text('El NIT ingresado ya fue registrado. Por favor ingrese uno diferente'),
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

	 //validar nrc
	 $(document).on('blur', '#nrc', function(event) {
            event.preventDefault();
            var valor = $(this);
            if (valor.val() != "") {
                $.ajax({
                    url: "json_clientes.php",
                    dataType: "json",
                    data: { data_id: "val_nrc", nrc: valor.val() },
                    method: "POST",
                    success: function(json) {
                        console.log(json);
                        if (json[1]) {
                            val_nrc = false;
                            swal({
                                title: '¡Advertencia!',
                                html: $('<div>')
                                    .addClass('some-class')
                                    .text('El NRC ingresado ya fue registrado. Por favor ingrese uno diferente'),
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

	 //validar email
	 $(document).on('blur', '#email', function(event) {
            event.preventDefault();
            var valor = $(this);
            if (correo_g != valor.val() && valor.val() != "") {
                $.ajax({
                    url: "json_clientes.php",
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

	 //validar telefono
	 $(document).on('blur', '#telefono', function(event) {
            event.preventDefault();
            var valor = $(this);
            if (valor.val() != "") {
                $.ajax({
                    url: "json_clientes.php",
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

	 $(document).on("click","#btn_guardar", function(e){
	 	var valid = $("#fm_cliente").valid();
	 	if(valid){
	 		var datos=$("#fm_cliente").serialize();
	 		console.log(datos);
	 		swal({
                title: '¡Cargando!',
                allowOutsideClick: false,
                allowEscapeKey: false,
                onOpen: function() {
                    swal.showLoading()
                }
            });
	 		$.ajax({
	 			url:'json_clientes.php',
	 			type:'POST',
	 			dataType:'json',
	 			data:datos,
	 			success: function(json){
	 				console.log(json);
	 				if(json[0]==1){
				 		iziToast.success({
				            title: EXITO,
				            message: EXITO_MENSAJE,
				            timeout: 3000,
			          	});
			          	var timer=setInterval(function(){
			            location.reload();
			            clearTimeout(timer);
			          	},3500);
	 				}else{
	 					swal.close();
				        iziToast.error({
				          title: ERROR,
				          message: ERROR_MENSAJE,
				          timeout: 3000,
				        });
	 				}
	 			}
	 		});
	 	}
	 });

	 $(document).on("click","#btn_editar", function(e){
	 	var valid=$("#fm_cliente").valid();
	 	if(valid){
	 		datos = $("#fm_cliente").serialize();
	 		swal({
                title: '¡Cargando!',
                allowOutsideClick: false,
                allowEscapeKey: false,
                onOpen: function() {
                    swal.showLoading()
                }
            });
	 		$.ajax({
	 			url:'json_clientes.php',
	 			type:'POST',
	 			dataType:'json',
	 			data:datos,
	 			success: function(json){
	 				console.log(json);
	 				if(json[0]==1){
				 		iziToast.success({
				            title: EXITO,
				            message: EXITO_MENSAJE,
				            timeout: 3000,
			          	});
			          	var timer=setInterval(function(){
			            location.reload();
			            clearTimeout(timer);
			          	},3500);
	 				}else{
	 					swal.close();
				        iziToast.error({
				          title: ERROR,
				          message: ERROR_MENSAJE,
				          timeout: 3000,
				        });
	 				}
	 			}
	 		});
	 	}
	 })
});

function editar(id){
	//alert(id);
	$.ajax({
        url: 'json_clientes.php',  
        type: 'POST',
        dataType: 'json',
        data: {id:id,data_id:'modal_natural'},
        success: function(json){
          console.log(json);
          $("#modal_edit").html(json[3]);
          $("#md_editar").modal('show'); // lanza el modal
        }
      });
    }

    function editarj(id){
	//alert(id);
	$.ajax({
        url: 'json_clientes.php',  
        type: 'POST',
        dataType: 'json',
        data: {id:id,data_id:'modal_juridico'},
        success: function(json){
          console.log(json);
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
          
        }
      })
      */
    $.ajax({
      url:'json_clientes.php',
      type:'POST',
      dataType:'json',
      data:{data_id:'eliminar_cliente',id:id},
      success: function(json){
        if(json[0]==1){
              iziToast.success({
                  title: ELIMINAR,
                  message: ELIMINAR_MENSAJE,
                  timeout: 3000,
              });
              var timer=setInterval(function(){
                  location.reload();
                  clearTimeout(timer);
              },3500);
          }else
            iziToast.error({
                title: ERROR,
                message: ERROR_MENSAJE,
                timeout: 3000,
            });
       }
	  });
    }