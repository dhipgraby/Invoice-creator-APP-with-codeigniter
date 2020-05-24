<div class="container" align="center">
        <h2 class="blue">Gestiona tu negocio con Slapp Invoice</h2>
   
    <h3 class="mt-3 mb-3 light-c">Subscribete gratis hoy!</h3>

    <form id="email_form" onsubmit="return false">
        <div class="input-group minw-80" align="center">
            <input type="email" data-parsley-type="email" class="form-control" id="email" name="email" placeholder="Correo Electronico (email)" required>
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary blue-gr p-2">
                    <h3 class="m-0 c-white">Probar ahora <i class="fas fa-chevron-right"></i></h3>
                </button>
            </div>
        </div>
    </form>
<br>
    <p>Ya tienes cuenta? Entra en <a href="<?php echo base_url('main') ?>">Login</a></p>

    <h3 class="light-c">Sistema de facturación sencillo y personalizado</h3>
<div class="mt-3" id="land_res"></div>
</div>

<script>
    $("#email_form").submit(function(event) {
        event.preventDefault();
        var email = $('#email').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>register/email_check",
            data: {
                email
            },
            success: function(data) {
                $("#land_res").html(data);                
            }
        });
    });
</script>