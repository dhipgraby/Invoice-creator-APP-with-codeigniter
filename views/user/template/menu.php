<!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler mt-1" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                     
                            <li class="nav-divider">
                            MENU      
                            </li>
                     <?php if($sub_canceled != TRUE){   ?>
                            <li class="nav-item pl-2">
                                <a class="nav-link <?php if($c_url == 'dashboard'){ echo 'active'; } ?>" href="<?php echo base_url('dashboard') ?>" ><i class="fa fa-fw fa-table"></i>Dashboard <span class="badge badge-success">6</span></a>                                
                            </li>
                            <?php if($pages_access[0] != 3){ ?> 
                            <li class="nav-item pl-2">
                                <a class="nav-link <?php if($c_url == 'facturas'){ echo 'active'; } ?>" href="<?php echo base_url('facturas') ?>" ><i class="fa fa-fw fa-file"></i>Facturas</a>                            
                            </li>
                            <?php  } ?>
                            <?php if($pages_access[0] != 3){ ?> 
                            <li class="nav-item pl-2">
                                <a class="nav-link <?php if($c_url == 'abonos'){ echo 'active'; } ?>" href="<?php echo base_url('abonos') ?>" ><i class="fa fa-fw fa-file"></i>Abonos</a>                            
                            </li>
                            <?php  } ?>
                            <?php if($pages_access[0] != 3){ ?> 
                            <li class="nav-item pl-2">
                                <a class="nav-link <?php if($c_url == 'proformas'){ echo 'active'; } ?>" href="<?php echo base_url('proformas') ?>" ><i class="fas fa-fw fa-file"></i>Proformas</a>                      
                            </li>
                            <?php  } ?>
                            <?php
                            if($user->plan_id != 'SLIV_001' && $user->plan_id != 'SLIV_004'){ 
                            if($pages_access[1] != 3){ ?> 
                            <li class="nav-item pl-2 ">
                                <a class="nav-link <?php if($c_url == 'presupuestos'){ echo 'active'; } ?>" href="<?php echo base_url('presupuestos') ?>" ><i class="fas fa-fw fa-file"></i>Presupuestos</a>                                
                            </li>
                            <?php  } } ?>
                            <?php if($pages_access[2] != 3){ ?> 
                            <li class="nav-item pl-2">
                                <a class="nav-link <?php if($c_url == 'clientes'){ echo 'active'; } ?>" href="<?php echo base_url('clientes') ?>" ><i class="fas fa-user-tag" aria-hidden="true"></i>Clientes</a>                            
                            </li>
                            <?php  } ?>
                            <?php if($config_access[0] != 3 && $config_access[1] != 3){ ?> 
                            <li class="nav-divider">
                            <i class="fas fa-cogs"></i> Configuración
                            </li>
                            <?php  } ?>
                            <?php if($config_access[0] != 3){ ?>  
                            <li class="nav-item pl-2">
                                <a class="nav-link <?php if($c_url == 'configuracion'){ echo 'active'; } ?>" href="<?php echo base_url('cuenta') ?>" ><i class="fas fa-wrench"></i> Ajustes </a>                                
                            </li>
                            <?php  } ?> 
                            <?php
                            if($user->plan_id != 'SLIV_001' && $user->plan_id != 'SLIV_004'){ 
                            if($config_access[1] != 3){ ?>                   
                            <li class="nav-item pl-2">
                                <a class="nav-link <?php if($c_url == 'usuarios'){ echo 'active'; } ?>" href="<?php echo base_url('usuarios') ?>" ><i class="fas fa-users"></i>Usuarios </a>                                
                            </li>
                           <?php }  } ?>
                        
                            <?php } ?>
                            <?php if($config_access[2] != 3){ ?>     
                            <li class="nav-item pl-2">
                                <a class="nav-link <?php if($c_url == 'subscription'){ echo 'active'; } ?>" href="<?php echo base_url('subscription') ?>" ><i class="far fa-id-card"></i> Subscripción </a>                                
                            </li>
                            <?php  } ?>
                            <li class="nav-item p-5 ml-3">
                                <button class="btn btn-primary tsp-1" onclick="open_slapp('soporte')"><i class="fas fa-headset"></i> Soporte</button>
                            </li>
                     
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
