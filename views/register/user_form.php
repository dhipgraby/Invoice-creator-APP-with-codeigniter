<div id="user_div" class="col-sm-6 trans-normal fadeinright">

    <h2 class="blue">Datos de usuario</h2>
    <br>
    <p>Rellena los datos para completar tu subscripción gratuita</p>

    <h2><i class="fas fa-key light-c"></i></h2>
    <div class="form-group" align="left">

        <form id="user_data" onsubmit="return false">
            <label class="mt-2" for="firstname"> Nombre de contacto</label>
            <input class="form-control" type="text" id="firstname" name="firstname" placeholder="Introduzca su nombre">
            <label class="mt-2" for="password"> Contraseña</label>
            <div class="input-group mb-3">
                <input class="form-control" type="password" name="password" id="password" placeholder="Contraseña">
                <div class="input-group-append">
                    <label for="show" class="input-group-text" id="show_password"><i class="far fa-eye"></i></label>
                </div>
            </div>
            <label class="mt-2" for="user"> Confirme contraseña</label>
            <input class="form-control" type="password" id="password_confirm" name="password_confirm" placeholder="Confirmar contraseña">
            <br>
            <input class="hidden" name="show" id="show" type="checkbox" onclick="show_password()">
            <button type="submit" class="btn btn- purchase purchase-blue" id="save_user"> Guardar</button>
    </div>
    </form>

</div>
<div id="success_div" class="col-sm-8 trans-normal pt-5 fadeinright">
    <h1 class="mt-5"><i class="far fa-check-circle blue"></i></h1>
    <br>
    <h2 class="mt-3">
        Cuenta creada! </h2>
    <p class="light-c">Ahora selecciona tu plan gratuito.</p>
</div>


<script>
    
        $(document).ready(function() {
        setTimeout(function() {
            $('#user_div').removeClass('fadeinright');
        }, 1000);
    });
    $('#save_user').click(function() {

        var parametros = $('#user_data').serialize();
        parametros += '&action=submit&email=<?php echo $email ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>register/nuevo",
            data: parametros,
            success: function(data) {
                var array = JSON.parse(data);

                if (array.result == 'success') {
                    success_div();
                    setTimeout(function() {
                        go_to('register/plan_subscription');
                    }, 5000);
                }

                $("#resultados").html(array.msg);
                disable_alert();
            }
        });
    });

    function show_password() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            $('#show_password').html('<i class="far fa-eye-slash"></i>');
            x.type = "text";
        } else {
            $('#show_password').html('<i class="far fa-eye"></i>');
            x.type = "password";
        }
    }

    function success_div() {

        $('#user_div').addClass('fadeoutleft');
        setTimeout(function() {
            $('#user_div').addClass('hidden');
            $('#success_div').removeClass('hidden');
            setTimeout(function() {
                $('#success_div').removeClass('fadeinright');
                setTimeout(function() {
                    $('#success_div').addClass('fadeoutleft');
                }, 2800);
            }, 100);
        }, 1100);
    }
</script>