<?php
if (!empty($paypals)) {
    if ($payment_config->paypal == 1) {
        $disabled =  '';        
    } else {        
        $disabled =  'disabled';
    } 
?>

    <table class="table">
        <tr>
            <td><b class="black">Cuenta <span class="light-c">(email)</span></b></td>    
        </tr>
        <?php
        foreach ($paypals as $paypal) { ?>

            <tr>
                <td>
                    <?php
                    $checked = '';
                    $span = '';
                    if ($paypal->current == 1) {
                        $span = '<span class="badge badge-light ml-3 black">PREDET.</span>';
                        $checked = 'checked';
                    } ?>
                    <p>
                    <label class="custom-control custom-radio custom-control-inline pointer">
                            <input type="radio" name="btn_paypal" onclick="set_current(<?php echo $paypal->id ?>,'paypal')" class="custom-control-input" <?php echo $checked; ?> <?php echo $disabled; ?>>
                    <span class="custom-control-label" id="email<?php echo $paypal->id; ?>"><?php echo $paypal->email; ?></span>
                    </label>
                    
                    <?php echo $span; ?>
                </p>
                    
                </td>

                <td>



                    <div class="btn-group">
                     
                        <button class="btn btn-default" name="btn_paypal" onclick="edit_paypal(<?php echo $paypal->id ?>)" <?php echo $disabled ?>><i class="fas fa-edit"></i></button>
                        <?php $this->data['function'] = 'eliminar_paypal(' . $paypal->id . ')'; ?>
                        <button name="btn_paypal" class="btn btn-default btn-sm ml-2" tabindex="0" data-toggle="tooltip" data-trigger="focus" data-placement="right" data-html="true" title="<?php $this->load->view('user/components/delete_tooltip', $this->data); ?>" <?php echo $disabled ?>>
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
        })
    </script>
<?php   } ?>