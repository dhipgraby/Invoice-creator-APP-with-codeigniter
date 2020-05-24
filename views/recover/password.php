<div class="container" align="center">
    <h2 class="blue"><i class="mb-3 mt-3 fas fa-key light-c"></i>
        <br>
        Recuperación de contraseña
    </h2>

    <h4 class="mt-3">Escriba el correo electronico (email) asociado a su cuenta de Slapp </h4>
<br>
    <form id="email_form" onsubmit="return false">
        <div class="input-group minw-80" align="center">
            <input type="email" data-parsley-type="email" class="form-control" id="email" name="email" placeholder="Correo Electronico (email)" required>
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary blue-gr p-2">
                    <h3 class="m-0 c-white">Enviar <i class="fas fa-chevron-right"></i></h3>
                </button>
            </div>
        </div>
    </form>
<br>
    <p>Si tiene problemas con su cuenta, contacte a soporte clickando <a href="https://slappinvoice.com/soporte/">Aquí</a> </p>
    <div id="form_res"></div>
</div>

<script>
    $("#email_form").submit(function(event) {
        event.preventDefault();
        var email = $('#email').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>password_reset/reset",
            data: {
                email
            },
            success: function(data) {
                $("#form_res").html(data);
            }
        });
    });
</script>