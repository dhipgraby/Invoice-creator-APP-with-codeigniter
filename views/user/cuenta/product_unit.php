
<h3 class="light-c mt-3"><i class="fas fa-boxes"></i> Unidades de productos</h3>
<table class="table table-responsive" id="units">
        <tbody>
                <tr>
                        <td>
                                <div class="switch-button switch-button-yesno">
                                        <input onclick="set_products()" type="checkbox" id="unit1" <?php if($product_config[0] != 2){ echo 'checked="true"'; } ?> autocomplete="off">
                                        <span><label for="unit1"></label></span>
                                </div>
                        </td>
                        <td class="t-purple">
                                <p class="ml-3">Unidades (ud)
                                <label class="custom-control custom-radio custom-control-inline pointer ml-2">
                                        <input onclick="set_products()" type="radio" class="custom-control-input" <?php if($product_config[0] == 3){ echo 'checked="true"'; } ?> name="unit_predet" id="radio1" autocomplete="off">
                                        <span class="custom-control-label"><small>PREDET.</small></span>
                                </p>
                        </td>


                        <td>
                                <div class="switch-button switch-button-yesno show-block">
                                        <input onclick="set_products()" type="checkbox" id="unit2" <?php if($product_config[1] != 2){ echo 'checked="true"'; } ?> autocomplete="off">
                                        <span><label for="unit2"></label></span>
                                </div>
                        </td>

                        <td>
                                <p class="ml-3 show-block">Metros cuadrados (m2)
                                <label class="custom-control custom-radio custom-control-inline pointer ml-2">
                                        <input onclick="set_products()" type="radio" class="custom-control-input" <?php if($product_config[1] == 3){ echo 'checked="true"'; } ?> name="unit_predet" id="radio2" autocomplete="off">
                                        <span class="custom-control-label"><small>PREDET.</small></span>
                                </p>
                        </td>

                </tr>
                <tr>
                        <td>
                                <div class="switch-button switch-button-yesno">
                                        <input onclick="set_products()" type="checkbox" id="unit3" <?php if($product_config[2] != 2){ echo 'checked="true"'; } ?> autocomplete="off">
                                        <span><label for="unit3"></label></span>
                                </div>
                        </td>

                        <td class="t-purple">
                                <p class="ml-3">Horas (h)
                                        <label class="custom-control custom-radio custom-control-inline pointer ml-2">
                                                <input onclick="set_products()" type="radio" class="custom-control-input" <?php if($product_config[2] == 3){ echo 'checked="true"'; } ?> name="unit_predet" id="radio3" autocomplete="off">
                                                <span class="custom-control-label"><small>PREDET.</small></span>
                                        </label>
                                </p>
                        </td>
                        <td>
                                <div class="switch-button switch-button-yesno">
                                        <input onclick="set_products()" type="checkbox" id="unit4" <?php if($product_config[3] != 2){ echo 'checked="true"'; } ?> autocomplete="off">
                                        <span><label for="unit4"></label></span>
                                </div>
                        </td>

                        <td class="t-purple">
                                <p class="ml-3">Mililitros (ml)
                                        <label class="custom-control custom-radio custom-control-inline pointer ml-2">
                                                <input onclick="set_products()" type="radio" class="custom-control-input" <?php if($product_config[3] == 3){ echo 'checked="true"'; } ?> name="unit_predet" id="radio4" autocomplete="off">
                                                <span class="custom-control-label"><small>PREDET.</small></span>
                                </p>
                        </td>

                </tr>

        </tbody>
</table>
