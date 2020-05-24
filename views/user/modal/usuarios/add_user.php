<div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-user-plus" aria-hidden="true"></i> Agregar nuevo usuario </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <form onsubmit="return false;">
                    <div class="form-group">
                        <label for="email" class="col-sm-12 control-label"><i class="far fa-envelope"></i> Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                    </div>
               
                <div id="add_res"></div>
            </div>
            <div class="modal-header justify-content-center bg-light-grey">
                <h4 class="modal-title"><i class="fas fa-layer-group" aria-hidden="true"></i> Privilegios de usuario </h4>
            </div>
            <div class="modal-body">

                <h4 class="light-c"><i class="far fa-copy"></i> Paginas</h4>
                <?php $this->load->view('user/usuarios/new_pages_option') ?>

                <h4 class="light-c"><i class="fas fa-cogs"></i> Configuracion</h4>
                <?php $this->load->view('user/usuarios/new_config_option') ?>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="send_request">Enviar solicitud</button>
                </form>
            </div>

        </div>
    </div>
</div>