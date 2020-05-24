<label name="banc_box" class="control-label pt-2">Cuentas</label>
<div name="banc_box">
        <select  class="custom-select input-sm" id="banc_acc" name="banc_acc">
        <?php if (!empty($bancos)) {
                foreach ($bancos as $banco) {
                    $selected = '';
                    if(!empty($info)){
                       if($info->id_payment == $banco->id){
                        $selected = 'selected';
                       }                        
                    } else {
                        if(empty($info) &&  $banco->current == 1){
                            $selected = 'selected';
                        }
                    }                  
                    ?>
                    <option value="<?php echo $banco->id; ?>" <?php echo $selected; ?>><?php echo $banco->nombre; ?></option>
            <?php }
            } ?>

        </select>
</div>