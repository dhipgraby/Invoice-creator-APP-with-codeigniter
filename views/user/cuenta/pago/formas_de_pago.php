<?php $this->load->view('user/modal/cuenta/add_banc'); ?>
<?php $this->load->view('user/modal/cuenta/add_paypal'); ?>

<h3><i class="fas fa-tasks" aria-hidden="true"></i> Formas de pago <small class="light-c">(Efectivo, tarjeta, paypal, transferencia)</small></h3>

<p> Habilite y deshabilite las opciones de pago para usar en sus documentos</p>
<h3 class="light-c"><i class="fas fa-cash-register"></i> Selección de metodos</h3>
<div class="row">
    <div class="col-sm-5 table-responsive">
        <?php $this->load->view('user/cuenta/pago/payment_options'); ?>
    </div>
    <div class="col-sm-5 table-responsive">
        <table class="table">
            <tr>
                <td>
                    <?php if ($payment_config->transferencia == 1) {
                        $checked =  'checked';
                        $color = 't-purple';
                        $disabled_banc = '';
                    } else {
                        $color = 'light-c';
                        $disabled_banc = 'disabled';
                        $checked = '';
                    } ?>
                    <div name="switch-button" class="switch-button switch-button-yesno">
                        <input type="checkbox" id="switch44" name="transferencia" onclick="swicht_payment(this.name,'current3',this.id);change_btn_mode('btn_transferencia',this.name);" <?php echo $checked ?>>
                        <span><label for="switch44"></label></span>
                    </div>
                </td>
                <td>
                    <p class="ml-3 <?php echo $color; ?>" name="transferencia"><i class="fas fa-university"></i> Transferencia </p>
                </td>
                <td>
                    <?php $check = '';
                    if ($payment_config->current == 3) {
                        $check = 'checked';
                    } ?>
                    <label class="custom-control custom-radio custom-control-inline pointer">
                        <input id="current3" onclick="current_option(3)" type="radio" name="btn_current" class="custom-control-input" <?php echo $check; ?> <?php echo $disabled_banc ?>>
                        <span class="custom-control-label"><small>PREDET.</small></span>
                    </label>
                </td>
            </tr>
            <tr>
                <td>
                    <?php if ($payment_config->paypal == 1) {
                        $checked =  'checked';
                        $disabled_paypal = '';
                        $color = 't-purple';
                    } else {
                        $color = 'light-c';
                        $disabled_paypal = 'disabled';
                        $checked = '';
                    } ?>
                    <div name="switch-button" class="switch-button switch-button-yesno">
                        <input type="checkbox" id="switch55" name="paypal" onclick="swicht_payment(this.name,'current4',this.id);change_btn_mode('btn_paypal',this.name);" <?php echo $checked; ?>>
                        <span><label for="switch55"></label></span>
                    </div>
                </td>
                <td>
                    <p class="ml-3 <?php echo $color; ?>" name="paypal"><i class="fab fa-paypal"></i> Paypal</p>
                </td>
                <td>
                    <?php $check = '';
                    if ($payment_config->current == 4) {
                        $check = 'checked';
                    } ?>
                    <label class="custom-control custom-radio custom-control-inline pointer">
                        <input id="current4" onclick="current_option(4)" type="radio" name="btn_current" class="custom-control-input" <?php echo $check; ?> <?php echo $disabled_paypal; ?>>
                        <span class="custom-control-label"><small>PREDET.</small></span>
                    </label>
                </td>
            </tr>
        </table>
    </div>
</div>
<br>
<div class="mt-4">
    <h3 class="light-c"><i class="fas fa-university" aria-hidden="true"></i> Bancos</h3>

    <?php echo new_button('<i class="fas fa-plus-circle" aria-hidden="true"></i> Añadir nuevo banco', '', 'default btn-sm ml-3 mb-3', 'name="btn_transferencia" data-toggle="modal" data-target="#bancos_modal" onclick="clean_banc()" '.$disabled_banc); ?>
    <br>
    <div id="bancos_table" class="table-responsive">
        <?php $this->load->view('user/cuenta/pago/bancos_table') ?>
    </div>
    <br>
    <h3 class="light-c"><i class="fab fa-paypal"></i> Cuentas Paypal</h3>
    <?php echo new_button('<i class="fas fa-plus-circle" aria-hidden="true"></i> Añadir cuenta paypal', '', 'default btn-sm ml-3 mb-3', 'name="btn_paypal" data-toggle="modal" data-target="#paypal_modal" onclick="clean_paypal()" '.$disabled_paypal); ?>
    <br>
    <div id="paypal_table" class="table-responsive">

        <?php $this->load->view('user/cuenta/pago/paypal_table') ?>
    </div>
    <?php $this->load->view('user/js/payment'); ?>
</div>