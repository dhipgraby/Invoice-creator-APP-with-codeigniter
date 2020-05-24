<div class="col-sm-12">

<?php if(isset($message)){ echo $message; } ?>

    <h1 class="text-center blue"> Bienvenido </h1>

    <h3 class="text-center blue">
        <i class='glyphicon glyphicon-stats'></i> Estadisticas
    </h3>

    <div class="row">        
        <!-- end of 1st -->
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="card border-3 border-top border-top-primary">
                <div class="card-body text-center">
                    <h5 class="text-muted "><span class="icon-circle-small icon-box-s text-success bg-success-light"><i class="fa fa-fw fa-file-alt"></i></span> FACTURAS</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1"><?php echo $docs['total_facturas'] ?></h1>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="card border-3 border-top border-top-primary">
                <div class="card-body text-center">
                    <h5 class="text-muted"><span class="icon-circle-small icon-box-s text-success bg-success-light"><i class="fa fa-fw fa-file-alt"></i></span> PROFORMAS</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1"><?php echo $docs['total_proformas'] ?></h1>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="card border-3 border-top border-top-primary">
                <div class="card-body text-center">
                    <h5 class="text-muted"><span class="icon-circle-small icon-box-s text-success bg-success-light"><i class="fa fa-fw fa-file-alt"></i></span> PRESUPUESTOS</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1"><?php echo $docs['total_presupuestos'] ?></h1>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="card border-3 border-top border-top-primary">
                <div class="card-body text-center">
                    <h5 class="text-muted"><span class="icon-circle-small icon-box-s text-success bg-success-light"><i class="fa fa-fw fa-user"></i></span> CLIENTES</h5>
                    <div class="metric-value d-inline-block ¡">
                        <h1 class="mb-1 "><?php echo $docs['total_clientes'] ?></h1>
                    </div>


                </div>
            </div>
        </div>

    </div>

</div>