<script>
	<?php if (empty($info)) {  ?>
		
		$('#fecha').datetimepicker({
			format: 'DD-MM-YYYY',			
			defaultDate: '<?php echo date('Y-m-d') ?>' ,
			widgetPositioning: {
				horizontal: 'left',
				vertical: 'bottom'
			},

		});
		$('#fecha_vencimiento').datetimepicker({
			format: 'DD-MM-YYYY',			
			defaultDate: '<?php echo date('Y-m-d') ?>',
			widgetPositioning: {
				horizontal: 'left',
				vertical: 'bottom'
			},

		});

	<?php } else {  ?>

		if ($("#fecha_vencimiento").length) {
		$('#fecha').datetimepicker({
			format: 'DD-MM-YYYY',			
			defaultDate: '<?php echo date('Y-m-d', strtotime($info->fecha_factura)); ?>' ,
			widgetPositioning: {
				horizontal: 'left',
				vertical: 'bottom'
			},

		});
		$('#fecha_vencimiento').datetimepicker({
			format: 'DD-MM-YYYY',			
			defaultDate: '<?php echo date('Y-m-d',strtotime($info->vencimiento)); ?>',
			widgetPositioning: {
				horizontal: 'left',
				vertical: 'bottom'
			},

		});
	}
	<?php } ?>

	//CREAR DOCUMENTO
	$("#send_form").click(function() {
		$("#send_form").prop('disabled', true);
		var id_cliente = $("#id_cliente").val();
		var id_vendedor = $("#id_vendedor").val();
		var condiciones = $("#condiciones").val();
		var n_original = $('#n_original').val();
		var fecha = $("#fecha").val();
		var fecha_vencimiento = $("#fecha_vencimiento").val();
		var proyecto = $("#proyecto").val();
		var direccion = $("#direccion_proyecto").val();
		var documento = '<?php echo $documento; ?>';
		var init_num = $("#init_num").val();
		var id_payment = 0;
		if (condiciones == 4) {
			id_payment = $('#paypal_acc').find('option:selected').val();
		}
		if (condiciones == 3) {
			id_payment = $('#banc_acc').find('option:selected').val();
		}

		if (empty(init_num) == true) {
			var msg = alert_msg('Escriba un numero de documento inicial', 'warning');
			$('#resultados').append(msg);
			$("#init_num").focus();
			$("#send_form").prop('disabled', false);
			disable_alert();
			return false;
		}
		if (empty(n_original) == true && documento == 'abono') {
			var msg = alert_msg('Escriba un numero de factura original', 'warning');
			$('#resultados').append(msg);
			$("#n_original").focus();
			$("#send_form").prop('disabled', false);
			disable_alert();
			return false;
		}

		$.ajax({

			url: "<?php echo base_url(); ?>documento/create",
			type: "POST",
			data: {
				init_num,
				documento,
				proyecto,
				id_payment,
				fecha,
				fecha_vencimiento,
				direccion,
				id_vendedor,
				id_cliente,
				condiciones,
				n_original
			},

			success: function(data) {
				var array = JSON.parse(data);
				switch (array.result) {
					case 'success':
						setTimeout(function() {
							go_to('editar/' + documento + '/' + array.max_id);
						}, 3000);
						break;
					case 'error':
						$("#send_form").prop('disabled', false);
						disable_alert();
						break;
				}
				$("#resultados").html(array.msg);

			}
		});
	});


	//GUARDADR DOCUMENTO 
	$("#actualizar_datos").click(function() {
		$("#actualizar_datos").prop('disabled', true);
		var id_cliente = $("#id_cliente").val();
		var iva = $('#iva').find('option:selected').val();
		var documento = '<?php echo $documento; ?>';
		var condiciones = $("#condiciones").val();
		var fecha_vencimiento = $("#fecha_vencimiento").val();
		var id_payment = 0;
		if (condiciones == 4) {
			id_payment = $('#paypal_acc').find('option:selected').val();
		}
		if (condiciones == 3) {
			id_payment = $('#banc_acc').find('option:selected').val();
		}
		var parametros = $('#datos_factura').serialize() + "&documento=" + documento + "&iva=" + iva + "&id_payment=" + id_payment + "&fecha_vencimiento=" + fecha_vencimiento;
		var notas = $('#notas').val();
		parametros += "&notas=" + notas;
		console.log(parametros);

		<?php if ($acc_config->notas == 1) {   ?>

		<?php  } ?>

		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>guardar/<?php echo $id_doc; ?>",
			data: parametros,
			success: function(data) {

				$("#resultados").html(data);
				disable_alert();
				update_partidas();
			}
		}).then(function() {
			$("#actualizar_datos").prop('disabled', false);
		});

	});

	$("#guardar_notas").click(function() {
		$("#guardar_notas").prop('disabled', true);
		var notas = $('#notas').val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>guardar_notas/<?php echo $id_doc; ?>",
			data: {
				notas
			},
			success: function(data) {
				$("#resultados").html(data);
				disable_alert();
				update_partidas();
			}
		}).then(setTimeout(function() {
			$("#guardar_notas").prop('disabled', false);
		}, 1000));

	});

	$("#guardar_producto").click(function() {
		$("#guardar_producto").prop('disabled', true);
		var parametros = $('#form_producto').serialize();
		var id = $('#id_factura').val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>documentos/productos/nuevo_producto/" + id,
			data: parametros,

			success: function(data) {

				var array = JSON.parse(data);
				switch (array.result) {
					case 'success':
						$("#resultados").html(array.msg);
						$("#nuevoProducto").modal('hide');
						update_partidas();
						break;
					case 'error':
						$("#res_product").html(array.msg);
						break;
				}
				disable_alert();
			}
		}).then(setTimeout(function() {
			$("#guardar_producto").prop('disabled', false);
		}, 1000));

	});
	$("#editar_producto").click(function() {
		$("#editar_producto").prop('disabled', true);
		var parametros = $('#form_producto').serialize();
		var id = $('#id_factura').val();

		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>documentos/productos/editar_producto/" + id,
			data: parametros,

			success: function(data) {
				var array = JSON.parse(data);
				switch (array.result) {
					case 'success':
						$("#resultados").html(array.msg);
						$("#nuevoProducto").modal('hide');
						update_partidas();
						break;
					case 'error':
						$("#res_product").html(array.msg);
						break;
				}
				disable_alert();

			}
		}).then(setTimeout(function() {
			$("#editar_producto").prop('disabled', false);
		}, 1000));

	});

	//OPEN MODAL LOAD THE INFO
	function editar_producto(id_producto) {
		var id_factura = $('#id_factura').val();

		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>documentos/productos/product_form/" + id_factura,
			data: {
				id_producto
			},

			success: function(datos) {

				$("#nuevoProducto").modal('show');
				$("#product_text").html('Editar');
				$("#form_producto").html(datos);
				$("#guardar_producto").addClass('hidden');
				$("#editar_producto").removeClass('hidden');
				$("#editar_producto").attr('type', 'submit');
				$("#guardar_producto").attr('type', 'button');
			}
		});
	}

	$("#guardar_partida").click(function() {
		$("#guardar_partida").prop('disabled', true);
		var partida = $('#partida').val();
		var numero_factura = $('#id_factura').val();
		$.ajax({
			url: "<?php echo base_url(); ?>documentos/partidas/nueva_partida/" + numero_factura,
			type: "POST",
			data: {
				partida,
				numero_factura
			},
			success: function(data) {
				var array = JSON.parse(data);
				switch (array.result) {
					case 'success':
						$("#resultados").html(array.msg);
						$("#nuevaPartida").modal('hide');
						update_partidas();
						break;
					case 'error':
						$("#res_partidas").html(array.msg);
						break;
				}
				disable_alert();
			}
		}).then(setTimeout(function() {
			$("#guardar_partida").prop('disabled', false);
		}, 1000));
	});

	$("#editar_partida").click(function() {
		$("#editar_partida").prop('disabled', true);
		var numero_factura = $('#id_factura').val();
		var id_partida = $('#edit_id_partida').val();
		var partida = $('#partida').val();

		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>documentos/partidas/editar_partida/" + id_partida,
			data: {
				numero_factura,
				partida
			},
			success: function(data) {
				var array = JSON.parse(data);
				switch (array.result) {
					case 'success':
						$("#resultados").html(array.msg);
						$("#partida_" + id_partida).html(partida);
						$("#nuevaPartida").modal('hide');
						update_partidas();
						break;
					case 'error':
						$("#res_partidas").html(array.msg);
						break;
				}
				disable_alert();
			}
		}).then(setTimeout(function() {
			$("#editar_partida").prop('disabled', false);
		}, 1000));;
	});

	function editar_partida(id_partida, current_name) {

		$("#edit_id_partida").val(id_partida);
		$("#partida").val(current_name);
		$("#partidas_text").html('Editar');
		$("#guardar_partida").addClass('hidden');
		$("#editar_partida").removeClass('hidden');
		$("#nuevaPartida").modal('show');
		$("#guardar_partida").attr('type', 'button');
		$("#editar_partida").attr('type', 'submit');

	}


	function facturar(id) {

		var r = confirm("Desea facturar este presupuesto?");
		if (r == true) {

			$.ajax({

				type: "POST",
				url: "<?php echo base_url() ?>documento/copiar/" + id,
				data: "",
				success: function(datos) {

					$("#resultados").html(datos);
					disable_alert();
				}
			});
		}
	}

	$('#abono_form').click(function() {

		var id = $('#id_factura').val();
		$("#productos_abono").html(loadgif);
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>documento/copiar_form/" + id,
			data: "",
			success: function(datos) {
				$("#productos_abono").html(datos);
			}
		});
	});

	$('#abonar').click(function() {
		$('#abonar').prop('disabled', true);
		var id = $('#id_factura').val();
		var detalles = $('[name="partida_abono"]').find('input:checkbox:checked');

		var ids = [];
		for (var i = 0; i < detalles.length; i++) {
			ids.push(detalles[i].id);
		}
		ids = JSON.stringify(ids);
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>documento/copiar/" + id,
			data: {
				ids
			},
			success: function(datos) {
				$("#res_abonos").html(datos);
			}
		}).then(setTimeout(function() {
			$('#abonar').prop('disabled', false);
		}, 1000));
	});





	//ORDEN PARTIDAS					
	$('#guardar_orden').click(function() {
		$("#guardar_orden").prop('disabled', true);
		var datos = new Array();
		jQuery('#sortable li').each(function() {
			datos.push($(this).attr("id").split("trackid_")[1]);
		});
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>documentos/partidas/save_order",
			data: {
				datos
			},
			success: function(datos) {
				$("#order").modal('hide');
				$("#resultados").html(datos);
				update_partidas();
				disable_alert();
			}
		}).then(setTimeout(function() {
			$("#guardar_orden").prop('disabled', false);
		}, 1000));

	});

	//CLIENTES

	$("#guardar_cliente_modal").click(function() {

		guardar('<?php echo $add_client; ?>');

	});

	function guardar(add) {
		$("#guardar_cliente_modal").prop('disabled', true);
		var parametros = $('#datos_cliente').serialize();
		if (add == 'true') {
			var id_factura = $('#id_factura').val();
			parametros += '&add=true&id_factura=' + id_factura;
		}

		$.ajax({
			type: "POST",
			url: '<?php echo base_url('clientes/nuevo_en_doc') ?>',
			data: parametros,
			success: function(data) {
				var array = JSON.parse(data);
				if (array.result == 'success') {
					var client = JSON.parse(array.client);
					$('#nuevoCliente').modal('hide');
					fill_cliente_info(client);
				}
				if (array.result == 'error') {
					$("#resultados").html(array.msg);
				}
				disable_alert();
			}
		}).then(function() {
			$("#guardar_cliente_modal").prop('disabled', false);
		});
	}

	//HELPERS

	function update_partidas() {

		var id = $('#id_factura').val();
		var total = $('#total_factura').val();

		$.ajax({

			url: "<?php echo base_url(); ?>documentos/partidas/update_partidas/" + id,
			type: "POST",
			data: {
				total: total
			},

			success: function(data) {
				$('#partidas_div').html(data);
				load_partidas();
			}
		});

	}

	function load_partidas() {

		var id = $('#id_factura').val();
		$.ajax({
			url: "<?php echo base_url(); ?>documentos/partidas/load_partidas/" + id,
			type: "POST",
			data: {},

			success: function(data) {

				$('#partidas_res').html(data);

			}
		});

	}

	function buscar(page, btn, filter, estado) {

		$('#search').prop("disabled", true);
		if (btn != 0) {

			btn = 1;
			update_filter();
			update_estado();
		}
		var filter = $(filter).val();
		var page = page;
		var estado = $('option:selected', estado).attr('value');
		var fecha = $('option:selected', '#fecha').attr('value');
		var documento = '<?php echo $documento; ?>';
		var table = $('#result_table');
		$.ajax({

			url: "<?php echo base_url(); ?>documento/buscar",
			type: "POST",
			data: {
				filter,
				estado,
				documento,
				page,
				btn,
				fecha
			},

			success: function(data) {
				$('#search').prop("disabled", false);
				table.html(data);
			}
		}).then(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});

	}

	<?php if (!empty($total_pages)) {  ?>
		pagination(0, '<?php echo $total_pages; ?>');
	<?php } ?>

	function pagination(page, total) {

		if (page <= total) {

			$.ajax({

				url: "<?php echo base_url(); ?>documento/page_buttons/" + page + "/" + total,
				type: "POST",
				data: {},

				success: function(data) {
					$('#pagination').html(data);
				}
			});
		}
	}

	function clean_partidas() {

		$('#partida').val("");
		$('#partidas_text').html('Agregar');
		$("#guardar_partida").attr('type', 'submit');
		$("#guardar_partida").removeClass('hidden');
		$("#editar_partida").addClass('hidden');
		$("#editar_partida").attr('type', 'button');

	}

	function clean_productos(id) {

		$('#nombre_producto').val(" ");
		$('#precio_producto').val("");
		$('#cantidad').val("");
		$('#id_partida').val(id);
		$("#product_text").html('Agregar');
		$("#guardar_producto").removeClass('hidden');
		$("#guardar_producto").attr('type', 'submit');
		$("#editar_producto").addClass('hidden');
		$("#editar_producto").attr('type', 'button');
	}

	function set_iva() {

		var iva = $('#iva').find('option:selected').val();
		iva = parseFloat(iva);
		var impuesto = 0;
		var subtotal = $('#subtotal').html();
		subtotal = subtotal.replace('.', "");
		subtotal = subtotal.replace(',', ".");
		var total = $('#total').html();
		total = total.replace('.', "");
		total = total.replace(',', ".");
		switch (iva) {
			case 1:
				impuesto = 21;
				break;
			case 2:
				impuesto = 10;
				break;
			case 0:
				impuesto = 0;
				break;
		}
		iva_res = parseFloat(subtotal * impuesto) / 100;
		total = parseFloat(subtotal) + parseFloat(iva_res);
		$('#total').html(total.toLocaleString('de-DE', {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		}));

		$('#iva_res').html(iva_res.toLocaleString('de-DE', {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		}));

	}

	function update_estado() {

		var estado = $('option:selected', estado).attr('value');

		$('#estado2').val(estado);
	}

	function fill_products_form(datos) {

		$('#nombre_producto').val(datos[0].nombre_producto);
		$('#precio_producto').val(datos[0].precio_producto);
		$('#cantidad').val(datos[0].cantidad);
		$('#codigo_producto').val(datos[0].codigo_producto);
		$('#id_producto').val(datos[0].id_producto);
		$('#id_partida').val(datos[0].id_partida);
		$('#tipo').val(datos[0].tipo);
	}


	$(function() {
		//AUTO-COMPLETE DE CLIENTES
		$("#info_cliente").autocomplete({
			source: "<?php echo base_url() ?>documento/clientes",
			minLength: 2,
			select: function(event, ui) {
				event.preventDefault();
				$('#id_cliente').val(ui.item.id_cliente);
				$('#info_cliente').val(ui.item.nombre_cliente);
				$('#tel1').val(ui.item.telefono_cliente);
				$('#mail').val(ui.item.email_cliente);
				$('#cif2').html(ui.item.cif);
				$('#tel2').html(ui.item.telefono_cliente);
				$('#mail2').html(ui.item.email_cliente);
				$('#nombre_cliente2').html(ui.item.nombre_cliente);
				$('#cp_cliente2').html(ui.item.cp_cliente);
				$('#direccion_cliente2').html(ui.item.direccion_cliente);
				$('#provincia_cliente2').html(ui.item.provincia_cliente);
				$('#poblacion_cliente2').html(ui.item.poblacion_cliente);


			}
		});


	});

	//ELIMINAR

	//elimina documento
	function eliminar_doc(id) {
		var r = confirm("Confirmación de seguridad antes de borrar el documento.");
		if (r == true) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url() ?>documento/borrar_doc/" + id,
				data: {},
				success: function(datos) {
					$("#resultados").html(datos);
					disable_alert();
					buscar(0, 1, '#filter', '#estado');
				}
			});
		}
	}
	//vaciar documento
	function vaciar_doc(id) {
		$("#resultados").html(alert_msg('Vaciando documento...', 'info'));
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>documento/vaciar_doc/" + id,
			data: {},
			success: function(datos) {
				$("#resultados").html(datos);
				disable_alert();
				buscar(0, 1, '#filter', '#estado');

			}
		});
	}
	//elimina documento en edit
	function vaciar_doc_edit(id) {
		$("#resultados").html(alert_msg('Vaciando documento...', 'info'));
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>documento/vaciar_doc/" + id,
			data: {},
			success: function(datos) {
				$("#resultados").html(datos);
				$("#resultados").append(alert_msg('Esta pagina se recargara automaticamente...', 'info'));
				setTimeout(function() {
					disable_alert();
					location.reload();
				}, 4000);
			}
		});
	}
	//elimina productos
	function eliminar(id, id_producto) {
		$("#resultados").html(alert_msg('Eliminando producto...', 'info'));
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>documentos/productos/borrar_producto",
			data: {
				id,
				id_producto
			},
			success: function(datos) {
				$("#resultados").html(datos);
				disable_alert();
				update_partidas();
			}
		});
	}

	function eliminar_partida(id_partida) {
		$("#resultados").html(alert_msg('Eliminando partida...', 'info'));
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>documentos/partidas/borrar_partida",
			data: "id_partida=" + id_partida,
			success: function(datos) {
				$("#resultados").html(datos);
				disable_alert();
				update_partidas();
			}
		});
	}

	$('#fecha').on('change', function() {
		$('#search').click();
	});
	$('#estado').on('change', function() {
		$('#search').click();
	});

	function fill_cliente_info(data) {

		$('#id_cliente').val(data.id_cliente);
		$('#info_cliente').val(data.info_cliente);
		$('#tel1').val(data.telefono_cliente);
		$('#mail').val(data.email_cliente);
		$('#cif2').html(data.cif);
		$('#tel2').html(data.telefono_cliente);
		$('#mail2').html(data.email_cliente);
		$('#nombre_cliente2').html(data.nombre_cliente);
		$('#cp_cliente2').html(data.cp_cliente);
		$('#direccion_cliente2').html(data.direccion_cliente);
		$('#provincia_cliente2').html(data.provincia_cliente);
		$('#poblacion_cliente2').html(data.poblacion_cliente);

	}

	//SUMMER NOTE
	$('#notas').summernote({
		toolbar: [    
    ['style', ['style','bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
		],
		height: 300, 
		minHeight: null,
		maxHeight: null,
		focus: false
	});
</script>