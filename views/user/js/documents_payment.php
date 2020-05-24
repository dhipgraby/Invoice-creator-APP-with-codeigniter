<script>
    $("#guardar_banco").click(function() {

        var myUrl = "<?php echo base_url() ?>payment/add_banc";
        var iban = $('#cuenta').val();
        var id_banco = $('#id_banco').val();
        var nombre = $('#nombre_banco').val();
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
                        $('#banc_acc').append('<option value="' + array.id + '" selected>' + nombre + '</option>');
                        $("#resultados").html(array.msg);
                        $("#bancos_modal").modal('hide');
                        break;
                    case 'error':
                        $("#banc_res").html(array.msg);
                        break;
                }
                disable_alert();

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
                        $('#paypal_acc').append('<option value="' + array.id + '" selected>' + email + '</option>');
                        $("#resultados").html(array.msg);
                        $("#paypal_modal").modal('hide');
                        break;
                    case 'error':
                        $("#paypal_res").html(array.msg);
                        break;
                }
                disable_alert();

            }
        });
    });

    payment_box();
    function payment_box(){

        var option = $('#condiciones').find('option:selected').val();

        if (option == 1 || option == 2) {
            $('[name="paypal_box"]').removeClass('dflex');
            $('[name="banc_box"]').removeClass('dflex');
            $('[name="banc_box"]').addClass('hidden');
            $('[name="paypal_box"]').addClass('hidden');
        }
        //BANCOS
        if (option == 3) {
            $('[name="paypal_box"]').removeClass('dflex');
            $('[name="paypal_box"]').addClass('hidden');
            $('[name="banc_box"]').addClass('dflex');
        }
        //PAYPAL
        if (option == 4) {
            $('[name="banc_box"]').removeClass('dflex');
            $('[name="banc_box"]').addClass('hidden');
            $('[name="paypal_box"]').addClass('dflex');
        }
    }


    //METHODO DE PAGO
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