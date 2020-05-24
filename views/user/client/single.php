<?php $this->load->view('user/modal/documentos/pdf_modal');

if ($pages_access[2] == 2) {
    $this->load->view('user/modal/clientes/contacto_modal');

    $this->load->view('user/modal/clientes/registro_clientes');
}
?>

<h1><i class="fas fa-user-tag" aria-hidden="true"></i> Información de cliente</h1>
<br>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-header-title"><i class="fas fa-file-alt"></i> Datos Fiscales</h4>
                <div class="toolbar ml-auto">
                    <?php if ($pages_access[2] == 2) {  ?>
                        <button data-toggle="modal" data-target="#nuevoCliente" class="btn btn-primary btn-sm "><i class="fas fa-edit" aria-hidden="true"></i> Editar</button>
                    <?php } ?>

                </div>

            </div>
            <div class="card-body">
                <table class="table-responsive">

                    <tr>
                        <td style="width:150px;"><b>Nombre Fiscal:</b> </td>
                        <td id="nombre_cliente2"></td>
                    </tr>



                    <tr>
                        <td><b>Cif:</b></td>
                        <td id="cif2"></td>
                    </tr>

                    <tr>
                        <td><b>Dirección:</b></td>
                        <td id="direccion_cliente2"></td>
                    </tr>

                    <tr>
                        <td><b>CP:</b></td>
                        <td id="cp_cliente2"></td>
                    </tr>

                    <tr>
                        <td><b>Poblacion:</b></td>
                        <td id="poblacion_cliente2"></td>
                    </tr>

                    <tr>
                        <td><b>Provincia:</b></td>
                        <td id="provincia_cliente2"></td>
                    </tr>

                    <tr>
                        <td><b>Telefono: </b></td>
                        <td id="telefono_cliente2"></td>
                    </tr>


                    <tr>
                        <td><b>Email:</b></td>
                        <td id="email_cliente2"></td>
                    </tr>


                </table>
            </div>
        </div>
    </div>


    <!-- ============================================================== -->
    <!-- shortable list  -->
    <!-- ============================================================== -->
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 co-12">
        <section class="card">
            <div class="card-header d-flex">
                <h4 class="card-header-title"><i class="fas fa-users"></i> Personas de Contacto</h4>
                <div class="ml-auto">
                    <?php if ($pages_access[2] == 2) {  ?>
                        <button type="button" class="btn btn-primary btn-sm" onclick="clean_contact()" data-toggle="modal" data-target="#contactoCliente">
                            <i class="fas fa-user-plus"></i> Agregar
                        </button>
                    <?php } ?>

                </div>

            </div>

            <div class="p-2" id="contactos">

                <?php $this->load->view('user/client/contactos'); ?>

            </div>

            <div id="pagination_c"></div>

        </section>
    </div>

</div>

<div align="left">



    <div class="col-md-12" align="center">
        <div class="btn-group mb-2 mt-2 show-block" style="display:table;">

            <?php if ($pages_access[0] == 1 || $pages_access[0] == 2) {  ?>
                <button type="button" name="search_btn" value="factura" class="btn btn-dark m-2" onclick="load_doc(0,1,'factura');document.getElementById('estado_pagado').innerHTML = 'Pagada'"><i class="fas fa-search"></i> Facturas</button>
                <button type="button" name="search_btn" value="proforma" class="btn btn-dark m-2" onclick="load_doc(0,1,'proforma');document.getElementById('estado_pagado').innerHTML = 'Pagada'"><i class="fas fa-search"></i> Proformas</button>
                <button type="button" name="search_btn" value="abono" class="btn btn-dark m-2" onclick="load_doc(0,1,'abono');document.getElementById('estado_pagado').innerHTML = 'Abonado'"><i class="fas fa-search"></i> Abonos</button>

            <?php } ?>
            <?php
            if($user->plan_id != 'SLIV_001' && $user->plan_id != 'SLIV_004'){ 
            if ($pages_access[1] == 1 || $pages_access[1] == 2) {  ?>

                <button type="button" name="search_btn" value="presupuesto" class="btn btn-dark m-2" onclick="load_doc(0,1,'presupuesto');document.getElementById('estado_pagado').innerHTML = 'Aprobado'"><i class="fas fa-search"></i> Presupuesto</button>
            <?php } } ?>
        </div>

    </div>
</div>
<div class="row mb-3 mt-2" align="left">
    <div class="col-sm-3 mt-2">
        <input type="text" class="form-control hidden" onclick="load_doc(0,1,this.value)" value="" id="docname" readonly>
        <label class="control-label"><i class="fas fa-check-double"></i> Estado </label>
        <select class="form-control" onchange="document.getElementById('docname').click();" id="estado" name="estado">
            <option value="0" selected>Todas</option>
            <option value="2" id="estado_pagado">Pagada</option>
            <option value="1">Pendiente</option>
        </select>
    </div>

    <div class="col-md-3 mt-2">
    <label class="control-label"><i class="fas fa-calendar-alt"></i> Ejercicio fiscal </label>
        <select id="fecha" class="form-control" onchange="document.getElementById('docname').click();">

            <?php if (isset($años_fiscales) && !empty($años_fiscales)) {
                $año_actual = date('Y');
                if (date_format(date_create($años_fiscales[0]->fecha_factura), 'Y') != $año_actual) {  ?>
                    <option value="<?php echo date('Y'); ?>" selected><?php echo date('Y'); ?></option>
                <?php  }
                for ($i = 0; $i < count($años_fiscales); $i++) {

                    $año_fiscal = date_format(date_create($años_fiscales[$i]->fecha_factura), 'Y'); ?>

                    <option value="<?php echo $año_fiscal; ?>"><?php echo $año_fiscal; ?></option>
                <?php }
            } else { ?>
                <option value="<?php echo date('Y'); ?>" selected><?php echo date('Y'); ?></option>
            <?php } ?>

        </select>
    </div>
</div>
<div class="card pt-4">
<div class="col-sm-12" id="pagination" align="right"></div>
    <div class="table-responsive p-4" id="result_table"></div>
</div>