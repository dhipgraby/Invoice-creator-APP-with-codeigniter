<script>
    function change_option(name) {

        var set_value = 2;
        var input_checked = $("input:checkbox[name='" + name + "']");
        if (input_checked.is(":checked")) {
            set_value = 1;
            $("[name='" + name + "']").addClass('t-purple');
        } else {
            $("[name='" + name + "']").removeClass('t-purple');
        }

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>configuracion/option/" + name,
            data: {
                set_value
            },
            success: function(data) {
                $('#resultados').html(data);
                disable_alert();
            }
        });
    }

    function update_text() {

        var name = $('#text_title').attr('name');
        var content = $('#text_content').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>configuracion/text/" + name,
            data: {
                content
            },
            success: function(data) {
                $('#resultados').html(data);
                $('#text_modal').modal('hide');
                disable_alert();
            }
        });
    }

    $("input:checkbox[name='proyecto']").on('change', function() {

        var direccion = $("[name='input_direccion']");
        if ($(this).is(':checked')) {
            direccion.css('display', 'inline-block');
            $("input:checkbox[name='direccion']").attr('checked', false);
            $("[name='direccion']").removeClass('t-purple');
        } else {
            var set_value = 2;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>configuracion/option/direccion",
                data: {
                    set_value
                },
            });
            direccion.css('display', 'none');
        }
    });

    //FUNCTION USE FOR PARTIDAS Y SIN PARTIDAS. AT LEAST ONE OF BOTH GOTTA BE ACTIVE
    function check_product(name, o_name) {

        var box1 = $("input:checkbox[name='" + name + "']");
        var box2 = $("input:checkbox[name='" + o_name + "']");
        if (box1.not(':checked')) {
            if (box2.not(':checked')) {
                box2.prop('checked', true);
                var set_value = 1;
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>configuracion/option/" + o_name,
                    data: {
                        set_value
                    },
                });
            }
        }
    }

    //DISABLE TEXT BTN WHEN OPTION IS NOT ACTIVE
    function check_text(name) {
        var btn = $('#' + name);
        var input_checkbox = $("input:checkbox[name='" + name + "']");
        if (input_checkbox.is(':checked')) {
            btn.removeClass('btn-default');
            btn.addClass('btn-primary');
            btn.prop("disabled", false);
        } else {
            btn.removeClass('btn-primary');
            btn.addClass('btn-default');
            btn.prop("disabled", true);
        }
    }

    function change_btn_mode(name, self_name) {
        var btn = $("[name='" + name + "']");
        var input_checkbox = $("input:checkbox[name='" + self_name + "']");
        if (input_checkbox.is(':checked')) {
            btn.prop("disabled", false);
        } else {
            btn.prop("disabled", true);
        }
    }

    function text_info(name) {

        $('#text_title').attr('name', name);
        var content = '';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>configuracion/load_text/" + name,
            data: {},
            success: function(data) {
                $('#text_res').html(data);
            }
        });
        switch (name) {
            case 'c_contratacion':
                name = 'Condiciones de contratación';

                break;
            case 'c_venta':
                name = 'Condiciones de venta';

                break;
            case 'lopd':
                name = 'LOPD (ley organica de protección de datos)';
                break;
        }
        $('#text_title').html('Editar ' + name);
    }

    function set_products() {
        var config_num = products_config();
        var products_checkbox = $('#units').find("input[type=checkbox]").prop('disabled', true);
        var products_radio = $('#units').find("input[type=radio]").prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>configuracion/products_unit",
            data: {
                config_num
            },
            success: function(data) {
                $('#resultados').html(data);
            }
        }).then(function() {
             products_checkbox.prop('disabled',false);
             products_radio.prop('disabled',false);
        });

    }

    function products_config() {
        var config_num = "";
        var products_checkbox = $('#units').find("input[type=checkbox]");
        var products_radio = $('#units').find("input[type=radio]");

        for (var x = 0; x < products_checkbox.length; x++) {
            var product_id = products_checkbox[x].id;

            if ($('#' + product_id).is(':checked')) {
                var radio_id = products_radio[x].id;
                if ($('#' + radio_id).is(':checked')) {
                    config_num += "3";
                } else {
                    config_num += "1";
                }

            } else {
                config_num += "2";
            }
        }
        return config_num;
    }

    $('[name="unit_predet"]').on('change', function() {
        var current = $(this);
        var group = $('[name="unit_predet"]');
        if (current.is(':checked')) {
            group.prop('checked', false);
        }
        current.prop('checked', true);
    });
</script>