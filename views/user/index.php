<div class="bg-white row">

    <div class="col-sm-6 img-log">
    
    </div>

    <?php if (!isset($email)) {
        $email = '';
    } ?>
    <div class="col-sm-6 pad-3" align="right">


        <div class="ta-c">
            <h3 class="modal-title tsp-2" id="exampleModalLabel"><i class="fas fa-user-check"></i><br> Login<br></h3>
            <p>Introduzca sus credenciales</p>
        </div>
        <form id="login_form" onsubmit="return false;">
            <table class="table">

                <tr>
                    <td><label for="email" class="pointer mt-2"><i class="far fa-envelope"></i> Email</label></td>
                    <td>
                        <input type="email" value="<?php echo $email; ?>" data-parsley-type="email" class="form-control" id="email" name="email" placeholder="Correo Electronico (email)" required></td>
                </tr>
                <tr>
                    <td><label for="password" class="pointer mt-2"><i class="fas fa-key"></i> Contraseña</label></td>
                    <td>
                        <?php echo form_password('password', '', 'class="form-control" id="password" placeholder="contraseña"'); ?>
                        <br>
                        <p>¿Olvido su contraseña? Click <a href="<?php echo base_url('password_reset') ?>">Aquí</a></p>
                    </td>
                </tr>

                <tr>
                    <td><span id="btn_log"><?php echo new_button('<i class="fas fa-sign-in-alt"></i> Login', 'login', ' purchase purchase-blue grow', 'type="submit"'); ?></span>
                        <span id="log_errors"></span>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<div align="center" class="p-5">
    <button class="purchase purchase-btn grow btn-lg pointer" onclick="open_slapp('planes')"><h3 class="blue m-0"><i class="fas fa-paper-plane"></i> Contratar plan</h3></button>
</div>


<script type="text/javascript">
    $('#login_form').submit(function() {
        var datos = $('#login_form').serialize();
        $('#login').prop("disabled", true);
        $('#log_errors').html(loadgif + '<b style="color:#2ba6f2">Procesando...</b>');

        var box = $('#remember');

        if (box.is(":checked")) {
            var remember = box.val();
        }

        $.ajax({

            url: "<?php echo base_url(); ?>main/login",
            type: "POST",
            data: datos,

            success: function(data) {

                var array = JSON.parse(data);

                if (array.log == 'success') {
                    $('#log_errors').html(array.view);
                }
                if (array.log == 'error') {
                    $('#login').prop("disabled", false);
                    $('#log_errors').html(array.view);
                    disable_alert();
                }
            }
        });
    });
</script>