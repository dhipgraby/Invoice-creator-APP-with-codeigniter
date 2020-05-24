<?php
if (!empty($bancos)) {

    if ($payment_config->transferencia == 1) {
        $disabled =  '';        
    } else {        
        $disabled =  'disabled';
    } ?>
    <table class="table">
        <tr>
            <td><b class="black">Nombre entidad</b></td>
            <td><b class="black">N° Cuenta</b></td>
            <td><b class="black">BIC / SWIFT</b></td>
        </tr>
        <?php
        foreach ($bancos as $banco) { ?>


            <tr>
                <td>
                    <?php
                    $checked = '';
                    $span = '';
                    if ($banco->current == 1) {
                        $span = '<span class="badge badge-light ml-3 black">PREDET.</span>';
                        $checked = 'checked';
                    } ?>

                    <p>
                        <label class="custom-control custom-radio custom-control-inline pointer">
                            <input name="btn_transferencia" type="radio" onclick="set_current(<?php echo $banco->id ?>,'bancos')" class="custom-control-input" <?php echo $checked; ?> <?php echo $disabled; ?>>
                            <span class="custom-control-label" id="nombre<?php echo $banco->id; ?>"><?php echo $banco->nombre;  ?></span>
                        </label>                     
                        <?php echo $span; ?>
                    </p>
                </td>
                <td>
                    <p id="cuenta<?php echo $banco->id; ?>"><?php echo $banco->cuenta; ?></p>
                </td>
                <td>
                    <p id="bic<?php echo $banco->id; ?>"><?php echo $banco->bic; ?></p>
                </td>
                <td>

                    <div class="btn-group">
                        <button class="btn btn-default" name="btn_transferencia" onclick="edit_banc(<?php echo $banco->id ?>)" <?php echo $disabled; ?>><i class="fas fa-edit"></i></button>
                        <?php $this->data['function'] = 'eliminar_banco(' . $banco->id . ')'; ?>
                        <button class="btn btn-default btn-sm ml-2" name="btn_transferencia" tabindex="0" data-toggle="tooltip" data-trigger="focus" data-placement="right" data-html="true" title="<?php $this->load->view('user/components/delete_tooltip', $this->data); ?>" <?php echo $disabled; ?>>
                            <i class="fas fa-trash-alt" aria-hidden="true"></i>
                        </button>
                    </div>

                </td>
            </tr>


        <?php } ?>

    </table>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

<?php   }  ?>