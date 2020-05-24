<script src="https://js.stripe.com/v3/"></script>
<script src="<?php echo base_url(); ?>js/stripe_user.js" defer></script>

<h1><i class="fas fa-sliders-h"></i> Subscripción</h1>
<br>
<div class="col-sm-12" align="left">
    <div class="pills-regular pl-2 mb-1">
        <ul class="nav nav-pills card-header-pills" id="myTab2" role="tablist">
            <li class="nav-item hidden">
                <button class="btn btn- bg-blue" id="card-pills-2" data-toggle="tab" href="#card-pill-2" role="tab" aria-controls="card-2" aria-selected="false">
                    <i class="fas fa-chevron-left"></i> Ajustes</button>

            </li>
            <li class="nav-item hidden">
                <a class="nav-link" id="card-pills-1" data-toggle="tab" href="#card-pill-1" role="tab" aria-controls="card-1" aria-selected="false">
                    <i class="far fa-bookmark"></i> Planes</a>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="myTabContent2">
        <div class="tab-pane fade <?php if ($status == 'canceled') {
                                        echo 'active show';
                                    } ?>" id="card-pill-1" role="tabpanel" aria-labelledby="card-tab-1">
            <?php $this->load->view('subscription/planes') ?>
        </div>
        <div class="tab-pane fade <?php if ($status != 'canceled') {
                                        echo 'active show';
                                    } ?>" id="card-pill-2" role="tabpanel" aria-labelledby="card-tab-2">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="modal-header">
                            <h4 class="modal-title">Datos de subscripción</h4>
                        </div>
                        <div class="modal-body">
                            <table>
                                <tr>
                                    <td>
                                        <p>Plan actual: <?php echo $plan_name; ?> (Creación <?php echo date('Y/m/d', $comienzo); ?>)</p>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <p>Proximo pago: <?php echo date('Y/m/d', $proximo_pago); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Estatus: <?php echo ($status == 'canceled') ? 'Cancelado' : 'Activo'; ?></p>
                                    </td>
                                </tr>

                            </table>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <div class="btn-group show-block">
                                <button class="btn btn- bg-blue pull-left m-2" onclick="$('#card-pills-1').click()"><i class="fas fa-sync-alt"></i> Cambiar de plan</button>
                                <button class="btn btn-danger pull-left m-2" id="cancel_plan" tabindex="0" data-toggle="tooltip" data-trigger="focus" data-placement="bottom" data-html="true" title="<div>
<b>Si cancela su subscripción solo podra renovarla en un plazo máximo de 15 dias. Efectuando otro pago o una nueva contractación</b><br><button onclick='cancel_subscription()' class='btn btn-danger btn-sm tooltip-btn mt-1 tsp-1'><b>Confirmar cancelación</b></button>
</div>"><i class="fas fa-exclamation-triangle"></i> Cancelar subscripción</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col">
                    <div class="card"><?php $this->load->view('subscription/pago') ?></div>
                </div>
            </div>
            <br>
            <div id="cancel_res"></div>
        </div>

    </div>

</div>