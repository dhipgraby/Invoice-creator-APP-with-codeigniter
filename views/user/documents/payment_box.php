<hr>

<div class="row">
    <div class="col-md-4">
        <label class="control-label pt-2"><i class="fas fa-check-double"></i> Estado</label>
        <select class='custom-select' id="estado_factura" name="estado_factura">
            <option value="1" <?php if ($info->estado_factura == 1) {
                                    echo "selected";
                                } ?>>Pendiente</option>
            <option value="2" <?php if ($info->estado_factura == 2) {
                                    echo "selected";
                                } ?>>
                <?php $estado_pagado =  ($documento == 'proforma' || $documento == 'factura') ? 'Pagada' : 'Aprobado';
                if ($documento == 'abono') {
                    $estado_pagado = 'Abonado';
                } ?>
                <?php echo $estado_pagado; ?></option>

        </select>
    </div>
    <div class="col-md-4">
        <label class=" control-label pt-2"><i class="far fa-money-bill-alt"></i> Pago</label>
        <select class='custom-select' id="condiciones" onchange="payment_box()" name="condiciones">

            <?php if ($payment_config->efectivo == 1) { ?>
                <?php
                $selected = "";
                if ($info->condiciones == 1) {
                    $selected = "selected";
                } else {
                    if (empty($info) && $payment_config->current == 1) {
                        $selected = "selected";
                    }
                } ?>
                <option value="1" <?php echo $selected ?>>Efectivo</option>
            <?php } ?>

            <?php
            $selected = "";
            if ($payment_config->tarjeta == 1) { ?>
                <?php if ($info->condiciones == 2) {
                    $selected = "selected";
                } else {
                    if (empty($info) && $payment_config->current == 2) {
                        $selected = "selected";
                    }
                } ?>
                <option value="2" <?php echo $selected ?>>Tarjeta</option>

            <?php } ?>
            <?php
            $selected = "";
            if ($payment_config->transferencia == 1) { ?>
                <?php if ($info->condiciones == 3) {
                    $selected = "selected";
                } else {
                    if (empty($info) && $payment_config->current == 3) {
                        $selected = "selected";
                    }
                } ?>
                <option value="3" <?php echo $selected ?>>Transferencia bancaria</option>
            <?php  } ?>
            <?php
            $selected = "";
            if ($payment_config->paypal == 1) { ?>
                <?php if ($info->condiciones == 4) {
                    $selected = "selected";
                } else {
                    if (empty($info) && $payment_config->current == 4) {
                        $selected = "selected";
                    }
                } ?>
                <option value="4" <?php echo $selected ?>>Paypal</option>
            <?php  } ?>


        </select>
    </div>

    <div class="col-md-3">
        <?php $this->load->view('user/components/paypal_dropdown') ?>
        <?php $this->load->view('user/components/banc_dropdown') ?>

    </div>
</div>



<?php $this->load->view('user/js/documents_payment') ?>

<script src="<?php echo base_url(); ?>js/iban_check.js"></script>