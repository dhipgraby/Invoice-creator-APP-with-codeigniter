<script>
    $('#send_request').click(function() {
        $('#send_request').prop('disabled', true);
        var email = $('#email').val();
        var pages_priv = config_option('new_pages_option');
        var config_priv = config_option('new_config_option');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>usuarios/send_request",
            data: {
                email,
                pages_priv,
                config_priv
            },
            success: function(data) {
                $('#send_request').prop('disabled', false);
                $("#add_res").html(data);
                update_users();
                disable_alert();
            }
        });
    });

    $('#update_user').click(function() {

        var firstname = $('#edit_firstname').val();
        var user_email = $('#edit_user_email').val();
        var user_id = $('#user_id').val();
        $('#update_user').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>usuarios/editar/" + user_id,
            data: {
                firstname,
                user_email
            },
            success: function(data) {
                $('#update_user').prop('disabled', false);
                var array = JSON.parse(data);
                if (array.result == 'success') {
                    $("#resultados").html(array.msg);
                    $('#editarUsuario').modal('hide');
                    update_users();

                }
                if (array.result == 'error') {
                    $("#edit_res_user").html(array.msg);
                }
                disable_alert();
            }
        });
    });

    $('#update_pass').click(function() {
        var new_password = $('#new_password').val();
        var new_password_confirm = $('#new_password_confirm').val();
        var user_id = $('#user_id').val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>usuarios/change_password/" + user_id,
            data: {
                new_password,
                new_password_confirm
            },
            success: function(data) {
                var array = JSON.parse(data);
                if (array.result == 'success') {
                    $("#resultados").html(array.msg);
                    $('#editarUsuario').modal('hide');
                }
                if (array.result == 'error') {
                    $("#edit_pass_user").html(array.msg);
                }
                disable_alert();
            }
        });
    });
    //UPDATE USER TABLE
    function update_users() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>usuarios/user_table",
            data: {},
            success: function(data) {
                $('#user_table').html(data);
            }
        }).then(function() {
            setTimeout(function() {
                $('[data-toggle="tooltip"]').tooltip();
            }, 500);
        });
    }
    //HELPERS
    function fill_user(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>usuarios/user_data/" + id,
            data: {},
            success: function(data) {
                $('#edit_userdata').html(data);
            }
        });
    }
    //GUARDAR ORDEN DE PRIVILEGIOS DE PAGINAS
    $('#pages_option').find('input:checkbox').on('click', function() {
        setTimeout(function() {
            var user_id = $('#user_priv_id').val();
            var pages_priv = pages_option('pages_option');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>usuarios/pages_priv/" + user_id,
                data: {
                    pages_priv
                },
                success: function(data) {
                    var array = JSON.parse(data);
                    $('#res_priv').html(array.msg);
                    update_users();
                    disable_alert();
                }
            });
        }, 200);

    });
    //GUARDAR ORDEN DE PRIVILEGIOS DE CONFIG
    $('#config_option').find('input:checkbox').on('click', function() {
        setTimeout(function() {
            var user_id = $('#user_priv_id').val();
            var config_priv = config_option('config_option');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>usuarios/config_priv/" + user_id,
                data: {
                    config_priv
                },
                success: function(data) {
                    var array = JSON.parse(data);
                    $('#res_priv').html(array.msg);
                    update_users();
                    disable_alert();
                }
            });
        }, 200);
    });

    //RECOGER COMBINACION DE PRIVILEGIOS DE PAGINAS
    function pages_option(id) {
        var selected_group = $('#' + id).find('input:checkbox:checked');
        var pages_priv = selected_group[0].value;
        pages_priv += selected_group[1].value;
        pages_priv += selected_group[2].value;
        return pages_priv;
    }
    //RECOGER COMBINACION DE PRIVILEGIOS DE CONFIG
    function config_option(id) {
        var selected_group = $('#' + id).find('input:checkbox:checked');
        var config_priv = selected_group[0].value;
        config_priv += selected_group[1].value;
        config_priv += selected_group[2].value;
        return config_priv;

    }
    //RELLENA FORMULARIO DE PRIVILEGIOS DE UN USUARIO EN PAGINAS
    function set_pages_priv(id, priv) {
        $('#pages_option').find('input:checkbox').prop('checked', false);
        $('#user_priv_id').val(id);
        var number = priv,
            output = [],
            sNumber = number.toString();

        for (var i = 0, len = sNumber.length; i < len; i += 1) {
            output.push(+sNumber.charAt(i));
            //FACTURAS
            $('#foption' + output[0]).prop('checked', true).prop('disabled', true);
            var foption = $('#foption' + output[0]).prev().html();
            $('#fselected').html(foption);
            //PRESUPUESTOS
            $('#poption' + output[1]).prop('checked', true).prop('disabled', true);
            var poption = $('#poption' + output[1]).prev().html();
            $('#pselected').html(poption);
            //CLIENTES
            $('#clioption' + output[2]).prop('checked', true).prop('disabled', true);
            var clioption = $('#clioption' + output[2]).prev().html();
            $('#cliselected').html(clioption);
        }
    }
    //RELLENA FORMULARIO DE PRIVILEGIOS DE UN USUARIO EN CONFIG
    function set_config_priv(priv) {
        $('#config_option').find('input:checkbox').prop('checked', false);
        var number = priv,
            output = [],
            sNumber = number.toString();
        for (var i = 0, len = sNumber.length; i < len; i += 1) {
            output.push(+sNumber.charAt(i));
            //DATOS FISCALES
            $('#doption' + output[0]).prop('checked', true).prop('disabled', true);
            var doption = $('#doption' + output[0]).prev().html();
            $('#dselected').html(doption);
            //USUARIOS
            $('#uoption' + output[1]).prop('checked', true).prop('disabled', true);
            var uoption = $('#uoption' + output[1]).prev().html();
            $('#uselected').html(uoption);
            //SUBSCRIPCION
            $('#suboption' + output[2]).prop('checked', true).prop('disabled', true);
            var suboption = $('#suboption' + output[2]).prev().html();
            $('#subselected').html(suboption);
        }
    }

    function clean_form() {
        $('#user_name').val('');
        $('#firstname').val('');
        $('#user_email').val('');
        $('#password').val('');
        $('#password_confirm').val('');
    }

    function delete_user(id) {
        var id = $('#' + id).attr('data-user-id');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>usuarios/delete_user/" + id,
            data: {},
            success: function(data) {
                $('#resultados').html(data);
                disable_alert();
                update_users();
            }
        });
    }

    function change_option(id) {

        var input_checked = $('#check-' + id);
        var check_id = $("#status-" + id);
        if (input_checked.is(":checked")) {
            var set_value = 3;
            input_checked.prop('checked', false);
            check_id.removeClass('badge-success').addClass('badge-warning');
            check_id.html('Inactivo');
        } else {
            var set_value = 1;
            input_checked.prop('checked', true);
            check_id.removeClass('badge-warning').addClass('badge-success');
            check_id.html('Activo');
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>usuarios/set_status",
            data: {
                set_value,
                id
            },
            success: function(data) {
                $('#resultados').html(data);
                disable_alert();
            }
        });
    }
    $("input:checkbox").on('click', function() {
        var $box = $(this);
        var name = $box.attr('name');
        if ($box.is(":checked")) {
            var group = "input:checkbox[name='" + name + "']";
            $(group).prop("checked", false).prop('disabled', false);
            $box.prop("checked", true).prop('disabled', true);
        } else {
            $box.prop("checked", true).prop('disabled', true);
        }
        var label_content = $box.prev().html();
        $('#' + name).html(label_content);
    });
</script>