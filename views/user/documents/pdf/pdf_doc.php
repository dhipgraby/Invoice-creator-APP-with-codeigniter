<?php $this->load->view('user/documents/pdf/style.php') ?>



    <table cellspacing="0" style="width: 100%; justify-content:center;">
        <tr>
            <td style="width: 40%;text-align:center">

                <!-- LOGO -->
                <img src="images/<?php echo $perfil->logo_url; ?>" class="logo"><br>

                <h4 class="green-text"><?php echo $perfil->nombre_empresa; ?></h4>
                <p style="font-size: 12px;"><b>
                        <?php echo $perfil->direccion; ?><br>
                        <?php echo $perfil->codigo_postal; ?> - <?php echo $perfil->poblacion; ?><br>
                        Tel. <?php echo $perfil->telefono; ?> - CIF: <?php echo $perfil->cif; ?><br>

                        <?php
                        if ($licencia == 244754) {
                            if ($documento == 'presupuesto') {

                                echo 'revestimientosislatec@gmail.com';
                            } else {
                                echo 'direccion@islatecsl.com';
                            }
                        } else {
                            echo $perfil->email;
                        }
                        ?>
                    </b>
                </p>

            </td>

            <td style="width: 60%;">
                <div class="green-bg" align="center">
                    <h3 style="margin:0"><?php echo strtoupper($documento); ?> N° <?php echo $factura->numero_factura . ' / ' . substr(date('Y', strtotime($factura->fecha_factura)), 2, 4); ?></h3>
                </div>


                <p class="green-text" style="font-weight: bold; margin-bottom:10px;">Fecha: <b style="color:#000000;">
                        <?php echo date('d/m/Y', strtotime($factura->fecha_factura)) ?></b> <span style="margin-left:40px;">

                        Atendido por: <b style="color:#000000;">

                            <?php echo $user->firstname; ?>

                        </b></span></p>

                <div class="green-bg">

                    <table style="width:80%">




                        <tr>
                            <td valign="top" style="width:33%">
                                <p style="margin:0px;">Nombre Fiscal:</p>
                            </td>
                            <td>
                                <p style="margin:0px;"><?php echo  $cliente->nombre_cliente ?></p>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <p style="margin:0px;">NIF/CIF:</p>
                            </td>
                            <td>
                                <p style="margin:0px;"><?php echo  $cliente->cif ?></p>
                            </td>
                        </tr>


                        <tr>
                            <td valign="top">
                                <p style="margin:0px;">Dirección:</p>
                            </td>
                            <td>
                                <p style="margin:0px;"><?php echo  $cliente->direccion_cliente . '<br>' . $cliente->cp_cliente . ' - ' . $cliente->poblacion_cliente; ?></p>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <p style="margin:0px;">Tel.: </p>
                            </td>
                            <td>
                                <p style="margin:0px;"><?php echo  $cliente->telefono_cliente ?></p>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <p style="margin:0px;"> Email:</p>
                            </td>
                            <td>
                                <p style="margin:0px;"><?php echo  $cliente->email_cliente ?></p>
                            </td>
                        </tr>



                    </table>

                </div>
            </td>
        </tr>
    </table>
   


    <br>
    <?php if (!empty($factura->proyecto) || !empty($factura->direccion_proyecto)) {  ?>
        <table style="width: 100%;" cellspacing="0" class="table-center">
            <tr>
                <td style="width: 100%;" class="green-bg"><p style="margin:0">PROYECTO</p></td>
            </tr>

            <tr style="width: 100%;">
                <td style="width: 100%;padding:10px;" class="grey-bg">

                    <p class="green-text" style="margin-top:0px;"><b><?php echo strtoupper($factura->proyecto); ?></b></p>

                </td>
            </tr>

            <tr style="width: 100%;">
                <td style="width: 100%;padding:10px;" class="grey-bg green-top-border">

                    <p style="margin-top:0px;"><b><?php echo $factura->direccion_proyecto; ?></b></p>

                </td>
            </tr>

        </table>
    <?php } ?>
    <br>

    <?php $this->load->view('user/documents/pdf/pdf_partidas') ?>

    <br>
    <hr>


    <?php if ($acc_config->notas == 1 && !empty($factura->notas)) {  ?>
        <div class="pl-3 pr-3 ta-l" style="page-break-before: avoid;">
            
                <div class="green-bg">
                    <p class="c-white" style="margin:0px;page-break-before: avoid;">Notas</p>
                </div>
                <div class="grey-bg p-3" style="page-break-before: avoid;">            
                <?php echo $factura->notas ?>
                </div>
       
        </div>
    <?php } ?>


    <?php if ($acc_config->lopd == 1  && !empty($acc_config->text_lopd)) {  ?>
        <div class="pl-3 pr-3" style="page-break-before: always; height:auto;">
            <?php echo $acc_config->text_lopd; ?>
        </div>
    <?php  } ?>


    <?php if ($acc_config->c_contratacion == 1  && !empty($acc_config->text_contratacion)) {  ?>
        <?php if ($documento == 'presupuesto') { ?>

            <div class="pl-3 pr-3" style="page-break-before: always; height:auto;">
                <?php echo $acc_config->text_contratacion; ?>
            </div>

    <?php }
    } ?>

    <?php if ($acc_config->c_venta == 1  && !empty($acc_config->text_ventas)) {  ?>
        <?php if ($documento == 'factura' || $documento == 'abono' || $documento == 'proforma') { ?>

            <div class="pl-3 pr-3" style="page-break-before: always; height:auto;">
                <?php echo $acc_config->text_ventas; ?>
            </div>

    <?php }
    } ?>