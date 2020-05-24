<table class="table">
        <tr>
                <td>
                        <?php if ($payment_config->efectivo == 1) {
                                $checked =  'checked';
                                $disabled =  '';
                                $color = 't-purple';
                        } else {
                                $color = 'light-c';
                                $disabled =  'disabled';
                                $checked = '';
                        } ?>
                        <div name="switch-button" class="switch-button switch-button-yesno">
                                <input type="checkbox" id="switch11" name="efectivo" onclick="swicht_payment(this.name,'current1',this.id);" <?php echo $checked; ?>>
                                <span><label for="switch11"></label></span>
                        </div>
                </td>
                <td>
                        <p class="ml-3 <?php echo $color; ?>" name="efectivo"><i class="fas fa-wallet"></i> Efectivo </p>

                </td>
                <td>
                <?php $check = '';  if($payment_config->current == 1){ $check = 'checked'; } ?>
                                <label class="custom-control custom-radio custom-control-inline pointer">
                                        <input id="current1" onclick="current_option(1)" type="radio" name="btn_current" class="custom-control-input" <?php echo $check; ?> <?php echo $disabled ?>>
                                        <span class="custom-control-label"><small>PREDET.</small></span>
                                </label>
                                
                </td>
        </tr>
        <tr>
                <td>
                        <?php if ($payment_config->tarjeta == 1) {
                                $checked =  'checked';
                                $color = 't-purple';
                                $disabled = '';
                        } else {
                                $color = 'light-c';
                                $checked = '';
                                $disabled = 'disabled';
                        } ?>
                        <div name="switch-button" class="switch-button switch-button-yesno">
                                <input type="checkbox" id="switch33" name="tarjeta" onclick="swicht_payment(this.name,'current2',this.id);" <?php echo $checked; ?>>
                                <span><label for="switch33"></label></span>
                        </div>
                </td>

                <td>
                        <p class="ml-3 <?php echo $color; ?>" name="tarjeta"><i class="far fa-credit-card"></i> Tarjeta</p>
                </td>
                <td>

                <?php $check = '';  if($payment_config->current == 2){ $check = 'checked'; } ?>
                        <label class="custom-control custom-radio custom-control-inline pointer">
                                        <input id="current2" onclick="current_option(2)"  type="radio" name="btn_current" class="custom-control-input" <?php echo $check; ?> <?php echo $disabled ?>>
                                        <span class="custom-control-label"><small>PREDET.</small></span>
                                </label>
                        
                </td>

        </tr>

</table>