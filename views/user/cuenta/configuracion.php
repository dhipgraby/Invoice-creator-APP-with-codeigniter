<h3><i class="fas fa-tasks"></i> Configuracion de documentos</h3>

<p> Habilite y deshabilite las opciones que desea que se muestren en la creación y vista de los documentos</p>


<div class="row">
        <div class="col-sm-6">
                <h3 class="light-c"><i class="fas fa-info-circle"></i> Opciones de documento</h3>

                <table class="table table-responsive">
                        <tr>
                                <td>
                                        <?php if ($acc_config->proyecto == 1) {
                                                $checked =  'checked';
                                                $color = 't-purple';
                                        } else {
                                                $color = '';
                                                $checked = '';
                                        } ?>
                                        <div class="switch-button switch-button-yesno">
                                                <input type="checkbox" id="switch1" name="proyecto" onclick="change_option(this.name)" <?php echo $checked; ?>>
                                                <span><label for="switch1"></label></span>
                                        </div>
                                </td>
                                <td class="<?php echo $color; ?>" name="proyecto">
                                        <p class="ml-3">Proyecto</p>
                                </td>

                                <?php if ($acc_config->proyecto == 1) {
                                        $display = 'show-block';
                                } else {
                                        $display = 'hidden';
                                } ?>

                                <td>
                                        <?php if ($acc_config->direccion == 1) {
                                                $checked =  'checked';
                                                $color = 't-purple';
                                        } else {
                                                $color = '';
                                                $checked = '';
                                        } ?>
                                        <div name="input_direccion" class="switch-button switch-button-yesno ml-3 <?php echo $display; ?>">
                                                <input type="checkbox" id="switch2" name="direccion" onclick="change_option(this.name)" <?php echo $checked; ?>>
                                                <span><label for="switch2"></label></span>
                                        </div>
                                </td>

                                <td name="direccion" class="<?php echo $color; ?>">
                                        <p name="input_direccion" class="ml-3 <?php echo $display; ?>">Dirección del proyecto</p>
                                </td>

                        </tr>
                        <tr>
                                <td>
                                        <?php if ($acc_config->notas == 1) {
                                                $checked =  'checked';
                                                $color = 't-purple';
                                        } else {
                                                $color = '';
                                                $checked = '';
                                        } ?>
                                        <div class="switch-button switch-button-yesno">
                                                <input type="checkbox" id="switch3" name="notas" onclick="change_option(this.name)" <?php echo $checked; ?>>
                                                <span><label for="switch3"></label></span>
                                        </div>
                                </td>

                                <td name="notas" class="<?php echo $color; ?>">
                                        <p class="ml-3">Notas</p>
                                </td>

                        </tr>

                </table>

        </div>

        <div class="col-sm-6">
                <h3 class="light-c"><i class="fas fa-cubes"></i> Productos</h3>

                <table class="table">
                        <tr>
                                <td>
                                        <?php if ($acc_config->partidas == 1) {
                                                $checked =  'checked';
                                                $color = 't-purple';
                                        } else {
                                                $color = '';
                                                $checked = '';
                                        } ?>
                                        <div class="switch-button switch-button-yesno">
                                                <input type="checkbox" id="switch4" name="partidas" onclick="change_option(this.name);check_product('partidas','sin_partida');" <?php echo $checked ?>>
                                                <span><label for="switch4"></label></span>
                                        </div>
                                </td>
                                <td name="partidas" class="<?php echo $color; ?>">
                                        <p class="ml-3">Partidas</p>
                                </td>

                        </tr>

                        <tr>
                                <td>
                                        <?php if ($acc_config->sin_partida == 1) {
                                                $checked =  'checked';
                                                $color = 't-purple';
                                        } else {
                                                $color = '';
                                                $checked = '';
                                        } ?>
                                        <div class="switch-button switch-button-yesno">
                                                <input type="checkbox" id="switch5" name="sin_partida" onclick="change_option(this.name);check_product('sin_partida','partidas');" <?php echo $checked ?>>
                                                <span><label for="switch5"></label></span>
                                        </div>
                                </td>
                                <td name="sin_partida" class="<?php echo $color; ?>">
                                        <p class="ml-3 <?php echo $color; ?>">Productos sin partidas</p>
                                </td>

                        </tr>

                </table>
        </div>
</div>
<br>
<?php $this->load->view('user/cuenta/product_unit'); ?>
<div>
        <h3 class="light-c mt-3"><i class="fas fa-align-justify"></i> Textos</h3> <br>

        <?php $this->load->view('user/modal/cuenta/text_modal'); ?>

        <table class="table-responsive">
                <tr>

                        <td>
                                <?php if ($acc_config->lopd == 1) {
                                        $checked = 'checked';
                                        $color = 't-purple';
                                        $active = '';
                                        $type = 'primary';
                                } else {
                                        $checked = '';
                                        $color = '';
                                        $active = 'disabled';
                                        $type = 'default';
                                } ?>
                                <div class="switch-button switch-button-yesno">
                                        <input type="checkbox" id="switch6" name="lopd" onclick="change_option(this.name);check_text(this.name);" <?php echo $checked; ?>>
                                        <span><label for="switch6"></label></span>
                                </div>
                        </td>
                        <td name="lopd" class="p-3 <?php echo $color; ?>">
                                <p class="mb-0 ">LOPD (Ley organica de proteccion de datos)</p>
                                <small class="ml-2"> El texto LOPD saldra al final de todos los documentos</small>
                        </td>
                        <td><?php echo new_button('Editar texto', 'lopd', $type, 'data-toggle="modal" data-target="#text_modal" onclick="text_info(this.id)" ' . $active); ?></td>
                </tr>

                <tr>

                        <td>
                                <?php if ($acc_config->c_contratacion == 1) {
                                        $checked = 'checked';
                                        $color = 't-purple';
                                        $active = '';
                                        $type = 'primary';
                                } else {
                                        $checked = '';
                                        $color = '';
                                        $active = 'disabled';
                                        $type = 'default';
                                } ?>
                                <div class="switch-button switch-button-yesno">
                                        <input type="checkbox" id="switch7" name="c_contratacion" onclick="change_option(this.name);check_text(this.name);" <?php echo $checked; ?>>
                                        <span><label for="switch7"></label></span>
                                </div>
                        </td>
                        <td name="c_contratacion" class="p-3 <?php echo $color; ?>">
                                <p class="mb-0 ">Condiciones de contratación</p>
                                <small class="ml-2"> El texto Condiciones de contratación saldra al final de los documentos tipo presupuesto</small>
                        </td>
                        <td><?php echo new_button('Editar texto', 'c_contratacion', $type, 'data-toggle="modal" data-target="#text_modal" onclick="text_info(this.id)" ' . $active); ?></td>

                </tr>
                <tr>

                        <td>
                                <?php if ($acc_config->c_venta == 1) {
                                        $checked = 'checked';
                                        $color = 't-purple';
                                        $active = '';
                                        $type = 'primary';
                                } else {
                                        $checked = '';
                                        $color = '';
                                        $active = 'disabled';
                                        $type = 'default';
                                } ?>
                                <div class="switch-button switch-button-yesno">
                                        <input type="checkbox" id="switch8" name="c_venta" onclick="change_option(this.name);check_text(this.name);" <?php echo $checked; ?>>
                                        <span><label for="switch8"></label></span>
                                </div>
                        </td>
                        <td name="c_venta" class="p-3 <?php echo $color; ?>">
                                <p class="mb-0 ">Condiciones de Ventas</p>
                                <small class="ml-2"> El texto Condiciones de venta saldra al final de los documentos tipo facturas, abonos y proformas</small>
                        </td>
                        <td><?php echo new_button('Editar texto', 'c_venta', $type, 'data-toggle="modal" data-target="#text_modal" onclick="text_info(this.id)" ' . $active); ?></td>
                </tr>

        </table>
</div>

<?php $this->load->view('user/js/configuracion'); ?>