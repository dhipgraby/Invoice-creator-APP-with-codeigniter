<div class="container" align="center">
<div id="user_div" class="col-sm-6 trans-normal fadeinright">
<h2 class="blue"><i class="mb-3 mt-3 fas fa-key light-c"></i>
        <br>
       Nueva contraseña
    </h2>
    <br>
    <p>Rellene el formulario para configurar una contraseña</p>
    
    <div class="form-group" align="left">

        <form id="user_data" onsubmit="return false">
           
            <label class="mt-2" for="password">Nueva contraseña</label>
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
    </div>
    </form>
    <div id="pass_res"></div>

</div>
<div id="success_div" class="col-sm-8 trans-normal pt-5 fadeinright">
    <h1 class="mt-5"><i class="far fa-check-circle blue"></i></h1>
    <br>
    <h2 class="mt-3">
       Nueva contraseña actualizada! </h2>
    <p>Ya puede ingresar a su cuenta cuenta.</p>
    <br>
    <a class="btn btn-primary blue-gr" href="<?php echo base_url('main') ?>">Ir a logear</a>
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
            url: "<?php echo base_url() ?>password_reset/set_password",
            data: parametros,
            success: function(data) {
                var array = JSON.parse(data);
                if (array.result == 'success') {
                    $("#resultados").html(array.msg);
                    success_div();                    
                }
                if (array.result == 'error') {
                    $("#pass_res").html(array.msg);
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

</div>