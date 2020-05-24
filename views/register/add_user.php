<div class="container" align="center">
<div id="user_div" class="col-sm-6 trans-normal fadeinright">

    <h2>Datos de usuario</h2>
    <br>
    <p>Complete el formulario de registro para activar su usuario</p>

    <h2><i class="fas fa-key"></i></h2>
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
            <button type="submit" class="btn btn-primary" id="save_user"> Guardar</button>
            <br>
            <div class="mt-3" id="user_res"></div>
    </div>
    </form>

</div>
<div id="success_div" class="col-sm-8 trans-normal pt-5 fadeinright">
    <h1 class="mt-5"><i class="far fa-check-circle"></i></h1>
    <br>
    <h2 class="mt-3">
        Usuario activado! </h2>
        <p>Ya puede ingresar a su cuenta.</p>
    <br>
    <a class="btn btn-primary blue-gr" href="<?php echo base_url('main') ?>">Ir a logear</a>
</div>

</div>

<script>
    
        $(document).ready(function() {
        setTimeout(function() {
            $('#user_div').removeClass('fadeinright');
        }, 1000);
    });
    $('#save_user').click(function() {
        var parametros = $('#user_data').serialize();        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>add_user/set_user",
            data: parametros,
            success: function(data) {
                var array = JSON.parse(data);
                switch (array.result) {
                    case 'success':
                        success_div();                
                    $("#resultados").html(array.msg);
                        break;
                        case 'error':                         
                    $("#user_res").html(array.msg);
                        break;
                }                             
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
            }, 100);
        }, 1100);
    }
</script>