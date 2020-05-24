<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 co-12" style="height:90%">
		<section class="card" style="height:90%">
		<div class="card-header d-flex">
			<div class="row">
				<div class="col-md-4 m-2">
					<h4 class="card-header-title" for="info_cliente"><i class="fas fa-user-tag"></i> Buscar Cliente:</h4>
				</div>
				<div class="col-md-4 ui-widget m-2">
					<input type="text" placeholder="introduzca nombre cliente" class="form-control input-lg" id="info_cliente" value="<?php echo $info->nombre_cliente; ?>">
					<input name="id_cliente" id="id_cliente" value="<?php echo $info->id_cliente; ?>" type='hidden'>	
				</div>
				<div class="col-md-2 m-2" align="right">
				<?php if($pages_access[2] == 2){ ?>
					<button type="button" data-toggle="modal" data-target="#nuevoCliente" class="btn btn-primary btn-sm"><i class="fas fa-user-plus"></i> Nuevo Cliente</button>
				<?php } else { echo new_button('Datos cliente','','default btn-sm','onclick="return false;"');  } ?>
				</div>
			</div>

		</div>

		<div class="card-body p-4 table-responsive">
			<table>

				<tr>
					<td style="width: 150px;"><label class="control-label">Nombre Fiscal:</label> </td>
					<td><label id="nombre_cliente2" class="control-label text-capitalize black"><?php echo $info->nombre_cliente; ?></label></td>
				</tr>

				<tr>
					<td><label class="control-label">Cif:</label></td>
					<td><label id="cif2" class="control-label text-capitalize black"><?php echo $info->cif; ?></label></td>
				</tr>

				<tr>
					<td><label class="control-label">Dirección:</label></td>
					<td><label id="direccion_cliente2" class="control-label text-capitalize black"><?php echo $info->direccion_cliente; ?></label></td>
				</tr>

				<tr>
					<td><label class="control-label">CP:</label></td>
					<td><label id="cp_cliente2" class="control-label black"><?php echo $info->cp_cliente; ?></label></td>
				</tr>

				<tr>
					<td><label class="control-label">Poblacion:</label></td>
					<td><label id="poblacion_cliente2" class="control-label text-capitalize black"><?php echo $info->poblacion_cliente; ?></label></td>
				</tr>

				<tr>
					<td><label class="control-label">Provincia:</label></td>
					<td><label id="provincia_cliente2" class="control-label text-capitalize black"><?php echo $info->provincia_cliente; ?></label></td>
				</tr>

				<tr>
					<td><label class="control-label">Telefono: </label></td>
					<td><label id="tel2" class="control-label black"><?php echo $info->telefono_cliente; ?></label></td>
				</tr>

				<tr>
					<td><label class="control-label">Email:</></td>
					<td><label id="mail2" class="control-label black"><?php echo $info->email_cliente; ?></label></td>
				</tr>

			</table>
        </div>
        </section>
    </div>