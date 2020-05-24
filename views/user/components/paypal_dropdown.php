
<label name="paypal_box" class="control-label pt-2">Cuentas</label>
<div name="paypal_box">

        <select class="custom-select input-sm" id="paypal_acc" name="paypal_acc">
            <?php if (!empty($paypals)) {
                foreach ($paypals as $paypal) {
                    $selected = '';
                    if(!empty($info) && $info->id_payment == $paypal->id){
                        $selected = 'selected';
                    }  else {
                        if(empty($info) &&  $paypal->current == 1){
                            $selected = 'selected';
                        }               
                    }
                    ?>
                    <option value="<?php echo $paypal->id; ?>" <?php echo $selected; ?>><?php echo $paypal->email; ?></option>
            <?php }
            } ?>

        </select>
</div>
