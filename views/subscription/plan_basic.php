<div name="month_plan" class="p-5">
        <div class="card light-b-shadow black-border">
        
            <div class="card-header ta-c top-black p-5">
                <h2 class="c-white m-0">Basic</h2>
            </div>
            <div class="card-header ta-c mid-price p-4">
                <h2 class="black pt-2">€ 9,90 al mes</h2>
            </div>

            <div class="card-body ta-c">

                <ul class="list-group"></ul>

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> 1 Usuario</h4>
                    </li>

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> Facturas</h4>
                    </li>

                </ul>
            </div>
            <div class="card-footer ta-c none-border bg-white">
                <?php if ($plan_name == 'Slapp Basic') {
                ?>
                    <button class="btn btn- purchase grow purchase-btn font-18 mb-3" <?php echo ($status == 'canceled') ? 'name="get-plan" id="SLIV_001"' : ''; ?>><?php echo ($status == 'canceled') ? 'Renovar' : 'Activo'; ?></button>
                <?php
                } else {  ?>
                    <button name="get-plan" id="SLIV_001" class="btn btn- purchase grow purchase-btn font-18 mb-3">Contratar</button>
                <?php  } ?>
            </div>

        </div>
    </div>
    <div name="year_plan" class="p-5 hidden">
        <div class="card light-b-shadow black-border">
        <span class="ribbon4">10% DTO.</span>
            <div class="card-header ta-c top-black p-5">
                <h2 class="c-white m-0">Basic</h2>
            </div>
            <div class="card-header ta-c mid-price p-4">
              <h2 class="black pt-2"><small style="font-size:14px; text-decoration: line-through;"> € 9,90</small> € 8,91 al mes</h2>
            </div>

            <div class="card-body ta-c">

                <ul class="list-group">

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> 1 Usuario</h4>
                    </li>

                    <li class="list-group-item none-border p-2">
                        <h4 class="black m-0"><i class="fas fa-check blue"></i> Facturas</h4>
                    </li>

                </ul>
            </div>
            <div class="card-footer ta-c none-border bg-white">
                <?php if ($plan_name == 'Slapp Basic anual') {
                ?>
                    <button class="btn btn- purchase grow purchase-btn font-18 mb-3" <?php echo ($status == 'canceled') ? 'name="get-plan" id="SLIV_004"' : ''; ?>><?php echo ($status == 'canceled') ? 'Renovar' : 'Activo'; ?></button>
                <?php
                } else {  ?>
                    <button name="get-plan" id="SLIV_004" class="btn btn- purchase grow purchase-btn font-18 mb-3">Contratar</button>
                <?php  } ?>
            </div>

        </div>
    </div>