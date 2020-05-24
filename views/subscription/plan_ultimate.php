<div name="month_plan" class="p-4">
        <div class="card light-b-shadow blue-border no-overflow">
            <div class="recomended ta-c">
                <h4 class="c-white m-0">RECOMENDADO</h4>
            </div>
            <div class="card-header ta-c top-blue p-5">
                <h2 class="c-white m-0">Professional</h2>
            </div>
            <div class="card-header ta-c mid-price p-4">
                <h2 class="black pt-2">€ 24,90 al mes</h2>
            </div>

            <div class="card-body ta-l pl-5">

                <ul class="llist-group pl-5 ml-3">

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> 3 Usuario</h4>
                    </li>

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> Facturas</h4>
                    </li>

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> Presupuestos</h4>
                    </li>

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> Plantilla PDF personalizada</h4>
                    </li>

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> Soporte 24/7</h4>
                    </li>

                </ul>
            </div>
            <div class="card-footer ta-c none-border bg-white">
                <?php if ($plan_name == 'Slapp Professional') {
                ?>
                    <button class="btn btn- purchase grow purchase-blue font-18 mb-3" <?php echo ($status == 'canceled') ? 'name="get-plan" id="SLIV_003"' : ''; ?>><?php echo ($status == 'canceled') ? 'Renovar' : 'Activo'; ?></button>
                <?php
                } else {  ?>
                    <button name="get-plan" id="SLIV_003" class="btn btn- purchase grow purchase-blue font-18 mb-3">Contratar</button>
                <?php  } ?>
            </div>

        </div>
    </div>
    <div name="year_plan" class="p-4 hidden">
        <div class="card light-b-shadow blue-border no-overflow">
            <div class="recomended ta-c">
                <h4 class="c-white m-0">15% Descuento</h4>
            </div>
            
            <div class="card-header ta-c top-blue p-5">
                <h2 class="c-white m-0">Professional</h2>
            </div>
            <div class="card-header ta-c mid-price p-4">
            <h2 class="black pt-2"><small style="font-size:14px; text-decoration: line-through;"> € 24,90</small> € 21,17 al mes</h2>
            </div>

            <div class="card-body ta-l pl-5">

                <ul class="llist-group pl-5 ml-3">

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> 3 Usuario</h4>
                    </li>

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> Facturas</h4>
                    </li>

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> Presupuestos</h4>
                    </li>

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> Plantilla PDF personalizada</h4>
                    </li>

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> Soporte 24/7</h4>
                    </li>

                </ul>
            </div>
            <div class="card-footer ta-c none-border bg-white">
                <?php if ($plan_name == 'Slapp Professional anual') {
                ?>
                    <button class="btn btn- purchase grow purchase-blue font-18 mb-3" <?php echo ($status == 'canceled') ? 'name="get-plan" id="SLIV_006"' : ''; ?>><?php echo ($status == 'canceled') ? 'Renovar' : 'Activo'; ?></button>
                <?php
                } else {  ?>
                    <button name="get-plan" id="SLIV_006" class="btn btn- purchase grow purchase-blue font-18 mb-3">Contratar</button>
                <?php  } ?>
            </div>

        </div>
    </div>