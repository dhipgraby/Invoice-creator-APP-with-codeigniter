<script>
	var datos = <?php echo (!isset($cliente)) ? '0' : $cliente; ?>;
	var myUrl = "<?php echo base_url() ?>clientes/nuevo";

	if (datos != '0') {

		myUrl = "<?php echo base_url() ?>clientes/editar/" + datos.id_cliente;

		contactos_table(1, 0);
		fill_client_form(datos);
		fill_client_info(datos);
	}

	//CREAR CLIENTE
	$("#guardar_cliente").click(function() {
		
		guardar();

	});

	$("#guardar_cliente_modal").click(function() {
		
		guardar_modal();

	});

	function guardar() {
        
		var parametros = $('#datos_cliente').serialize() + '&action=submit';
		$("#guardar_cliente").prop('disabled', true);
		$.ajax({
			type: "POST",
			url: myUrl,
			data: parametros,
			success: function(data) {
				var array = JSON.parse(data);
				if (array.result == 'success') {					
					setTimeout(function() {
						go_to(array.client_id);
					}, 2000);
				}
				if (array.result == 'error') {
					setTimeout(function() {
						$("#guardar_cliente").prop('disabled', false);
					}, 1000);
				}
				$("#resultados").html(array.msg);
				disable_alert();
			}
		});
	}

	function guardar_modal() {
		
		$("#guardar_cliente_modal").prop('disabled', true);
		var parametros = $('#datos_cliente').serialize() + '&action=submit';

		$.ajax({
			type: "POST",
			url: myUrl,
			data: parametros,
			success: function(data) {

				var array = JSON.parse(data);
				if (array.result == 'success') {
					var client = JSON.parse(array.client);
					$("#resultados").html(array.msg);
					$('#nuevoCliente').modal('hide');
					fill_client_info(client);
				}
				if (array.result == 'error') {
					$("#res_clientes").html(array.msg);
				}
				disable_alert();
			}
		}).then(setTimeout(function() {
			$("#guardar_cliente_modal").prop('disabled',false);
		}, 1000));
	}

	$('#guardar_contacto').click(function() {
		$("#guardar_contacto").prop('disabled',true);
		var parametros = $('#p_contacto').serialize();
		var uri = "clientes/nuevo_contacto/<?php echo $cliente_id; ?>";
		var id = $('#id_contacto').val();
		if (id != '' && id > 0) {
			uri = "clientes/editar_contacto/" + id;
		}
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>" + uri,
			data: parametros,
			success: function(data) {

				var array = JSON.parse(data);
				if (array.result == 'success') {
					$("#resultados").html(array.msg);
					$('#contactoCliente').modal('hide');
					contactos_table(1, 1);
				}
				if (array.result == 'error') {
					$("#res_contacto").html(array.msg);
				}
				disable_alert();

			}
		}).then(setTimeout(function() {
			$("#guardar_contacto").prop('disabled',false);
		}, 1000));

	});

	$("#actualizar_datos").click(function() {
		var id_cliente = $("#id_cliente").val();
		var notas = encodeURIComponent($('#notas').val().replace(/\n/g, "<br />"));
		var iva = $('#iva').find('option:selected').val();
		var documento = '<?php echo $documento; ?>';

		var parametros = $('#datos_factura').serialize() + "&notas=" + notas + "&iva=" + iva + "&documento=" + documento + "&iva=" + iva;

		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>guardar/<?php echo $id_doc; ?>",
			data: parametros,
			success: function(data) {

				$("#resultados").html(data);
				disable_alert();
				update_partidas();

			}
		});


	});

	//HELPERS

	$('button[name="search_btn"]').click(function() {

		var docname = $(this).val();

		$('#docname').val(docname);

	});

	function load_doc(page, btn, doc) {

		if (btn != 0) {
			btn = 1;
		}
		var fecha = $('option:selected', '#fecha').attr('value');
		var estado = $('option:selected', '#estado').attr('value');
		var table = $('#result_table');		

		$.ajax({
			url: "<?php echo base_url(); ?>clientes/load_doc/" + doc + "/" + datos.id_cliente,
			type: "POST",
			data: {
				estado, page, btn, fecha
			},
			success: function(data) {
				table.html(data);
			}
		}).then(function() {
					$('[data-toggle="tooltip"]').tooltip();
				});

	}

	function buscar(page, btn, filter) {

		$('#search').prop("disabled", true);
		if (btn != 0) {
			btn = 1;
			update_filter();
		}
		var filter = $(filter).val();
		var page = page;

		var table = $('#result_table');
		$.ajax({

			url: "<?php echo base_url(); ?>clientes/buscar",
			type: "POST",
			data: {
				filter: filter,
				page: page,
				btn: btn
			},

			success: function(data) {
				$('#search').prop("disabled", false);
				table.html(data);

			}
		}).then(function() {
					$('[data-toggle="tooltip"]').tooltip();
				});

	}


	pagination(0, <?php echo $total_pages; ?>);

	function pagination(page, total) {

		if (page <= total) {
			$.ajax({
				url: "<?php echo base_url(); ?>clientes/page_buttons/" + page + "/" + total,
				type: "POST",
				data: {},
				success: function(data) {
					$('#pagination').html(data);
				}
			});
		}
	}

	function doc_pagination(page, total, doc) {

		var id = datos.id_cliente;

		if (page <= total) {
			$.ajax({
				url: "<?php echo base_url(); ?>clientes/page_buttons/" + page + "/" + total,
				type: "POST",
				data: {
					doc: doc,
					id: id
				},
				success: function(data) {
					$('#pagination').html(data);
				}
			});
		}
	}

	pagination_contact(0, <?php echo $total_c_pages; ?>);

	function pagination_contact(page, total) {

		if (page <= total) {
			$.ajax({
				url: "<?php echo base_url(); ?>clientes/page_buttons_contact/" + page + "/" + total,
				type: "POST",
				data: {},
				success: function(data) {
					$('#pagination_c').html(data);
				}
			});
		}
	}

	function contactos_table(page, btn = 0) {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>clientes/contactos_table/<?php echo $cliente_id; ?>/" + page,
			data: {
				btn
			},
			success: function(data) {

				$('#contactos').html(data);
			}
		}).then(function() {
					$('[data-toggle="tooltip"]').tooltip();
				});
	}

	//elimina clientes
	function eliminar_cliente(id) {
		$("#resultados").html(alert_msg('Eliminando cliente...', 'info'));
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>clientes/eliminar",
			data: "id=" + id,
			success: function(datos) {
				var array = JSON.parse(datos);
				if (array.result == 'success') {
					$('#filter').val('');
					buscar(0, 1, "#filter");
				}
				$("#resultados").html(array.msg);
				disable_alert();
			}
		}).then(function() {
			
			$('[data-toggle="tooltip"]').tooltip();
		});
	}

	function eliminar_contacto(id) {
		$("#resultados").html(alert_msg('Eliminando contacto...', 'info'));
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>clientes/eliminar_contacto",
			data: "id=" + id,
			success: function(datos) {
				$("#resultados").html(datos);
				contactos_table(1, 1);
				disable_alert();
			}
		});
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
			}
		});
	}

	function clean_contact() {

		$('#nombre').val('');
		$('#cargo').val('');
		$('#telefono').val('');
		$('#email').val('');
		$('#id_contacto').attr('value', '');
	}
	//autocomplte de los datos del cliente a editar

	function fill_contact_form(id) {

		var nombre = $('#nombre' + id).html();
		var cargo = $('#cargo' + id).html();
		var telefono = $('#telefono' + id).html();
		var email = $('#email' + id).html();

		$('#nombre').val(nombre);
		$('#cargo').val(cargo);
		$('#telefono').val(telefono);
		$('#email').val(email);
		$('#id_contacto').attr('value', id);

	}

	function fill_client_form(datos) {

		var datosArr = Object.entries(datos);
		for (var i = 0; i < datosArr.length; i++) {

			$('#' + datosArr[i][0]).val(datosArr[i][1]);

		}
	}

	function fill_client_info(datos) {

		var datosArr = Object.entries(datos);
		for (var i = 0; i < datosArr.length; i++) {

			$('#' + datosArr[i][0] + '2').html(datosArr[i][1]);

		}
	}
</script>