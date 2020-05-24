<script>
	$("#guardar_banco").click(function() {

		var myUrl = "<?php echo base_url() ?>payment/add_banc";
		var iban = $('#cuenta').val();
		var id_banco = $('#id_banco').val();
		if (id_banco != 0) {
			myUrl = "<?php echo base_url() ?>payment/edit_banc/" + id_banco;
		}
		if (!checkIBAN(iban)) {
			var msg = alert_msg('Número de cuenta incorrecto', 'warning');
			$("#banc_res").html(msg);
			disable_alert();
			return false;
		}

		var parametros = $('#form_banco').serialize();

		$.ajax({
			type: "POST",
			url: myUrl,
			data: parametros,

			success: function(data) {
				var array = JSON.parse(data);
				switch (array.result) {
					case 'success':
						$("#resultados").html(array.msg);
						$("#bancos_modal").modal('hide');
						break;
					case 'error':
						$("#banc_res").html(array.msg);
						break;
				}
				disable_alert();
				get_table('bancos');
			}
		});
	});

	$("#guardar_paypal").click(function() {

		var myUrl = "<?php echo base_url() ?>payment/add_paypal";
		var email = $('#paypal_email').val();
		var id_paypal = $('#id_paypal').val();
		if (id_paypal != 0) {
			myUrl = "<?php echo base_url() ?>payment/edit_paypal/" + id_paypal;
		}
		$.ajax({
			type: "POST",
			url: myUrl,
			data: {
				email
			},
			success: function(data) {
				var array = JSON.parse(data);

				switch (array.result) {
					case 'success':
						$("#resultados").html(array.msg);
						$("#paypal_modal").modal('hide');
						break;
					case 'error':
						$("#paypal_res").html(array.msg);
						break;
				}
				disable_alert();
				get_table('paypal');
			}
		});
	});



	function edit_banc(id) {
		if (empty(id)) {
			return false;
		}

		$('#ver_bancos').modal('hide');
		$('#text_banco').html('<i class="fas fa-university" aria-hidden="true"></i> Editar detalles de Banco');
		var nombre = $('#nombre' + id).html();
		var cuenta = $('#cuenta' + id).html();
		var bic = $('#bic' + id).html();
		$('#id_banco').val(id);
		$('#nombre_banco').val(nombre);
		$('#cuenta').val(cuenta);
		$('#bic').val(bic);
		$('#bancos_modal').modal('show');
	}

	function edit_paypal(id) {
		if (empty(id)) {
			return false;
		}
		$('#text_paypal').html('Editar');
		$('#ver_paypal').modal('hide');
		var email = $('#email' + id).html();
		$('#id_paypal').val(id);
		$('#paypal_email').val(email);
		$('#paypal_modal').modal('show');
	}

	function eliminar_banco(id) {
		var method = 'bancos';
		$.ajax({

			type: "POST",
			url: "<?php echo base_url() ?>payment/delete/" + id,
			data: {
				method
			},
			success: function(datos) {

				$("#resultados").html(datos);
				disable_alert();
				get_table('bancos');

			}

		});
	}

	function eliminar_paypal(id) {
		var method = 'paypal';
		$.ajax({

			type: "POST",
			url: "<?php echo base_url() ?>payment/delete/" + id,
			data: {
				method
			},
			success: function(datos) {

				$("#resultados").html(datos);
				disable_alert();
				get_table('paypal');

			}

		});
	}

	function set_current(id, method) {


		if (method == 'paypal') {
			name = $('#email' + id).html();
		}
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>payment/set_current/" + id,
			data: {
				method,
				name
			},
			success: function(data) {
				$('#resultados').html(data);
				disable_alert();
				get_table(method);
			}
		});
	}

	function current_option(id) {

		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>payment/current_option/" + id,
			data: {},
			success: function(data) {
				$('#resultados').html(data);
				disable_alert();
			}
		});
	}

	function swicht_payment(name, id_name, self_id) {
		var input_checked = $("input:checkbox[name='" + name + "']");  
		var mybtn = $('[name="switch-button"]').find('input:checked');
		//IF NO OPTION SELECTED, RETURN FALSE AND SET SELECTED TRUE
		if(mybtn.length == 0){
			var msg = alert_msg('Debe seleccionar al menos una opción de pago','warning');
			$('#resultados').html(msg);
			input_checked.prop('checked',true);
			disable_alert();
			return false;
		}
		var set_value = 2;		
		if (input_checked.is(":checked")) {
			set_value = 1;
			$("p[name='" + name + "']").removeClass('light-c');
			$("p[name='" + name + "']").addClass('t-purple');
		} else {
			$("p[name='" + name + "']").removeClass('t-purple');
			$("p[name='" + name + "']").addClass('light-c');
		}

		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>configuracion/payment/" + name,
			data: {
				set_value
			},
			success: function(data) {
				$('#resultados').html(data);
				change_switch_mode(id_name, self_id);
				disable_alert();
			}
		});
	}


	//HELPERS


	function change_switch_mode(id_name, self_id) {
		var btn = $("#" + id_name);
		var input_checkbox = $("#" + self_id);
		if (input_checkbox.is(':checked')) {
			btn.prop("disabled", false);
		} else {
			btn.prop("disabled", true);
		}
	}

	function get_table(name) {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>payment/get_table/" + name,
			data: {},
			success: function(data) {
				$('#' + name + '_table').html(data);
			}
		});
	}

	function clean_banc() {
		$('#text_banco').html('<i class="fas fa-university" aria-hidden="true"></i>  Añadir nuevo banco');
		$('#id_banco').val('0');
		$('#nombre_banco').val('');
		$('#cuenta').val('');
		$('#bic').val('');
	}

	function clean_paypal() {

		$('#text_paypal').html('Añadir');
		$('#id_paypal').val('0');
		$('#paypal_email').val('');

	}
</script>
<script src="<?php echo base_url(); ?>js/iban_check.js"></script>