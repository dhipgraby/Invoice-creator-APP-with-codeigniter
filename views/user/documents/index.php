<?php $this->load->view('user/modal/documentos/pdf_modal') ?>

<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
		<h1><i class="fas fa-file-alt"></i> <?php echo ucfirst($plural_docname); ?></h1>
	</div>

	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
		<?php

		if ($pages_access[0] == 2) {
			echo new_button('<i class="fas fa-folder-plus"></i> Crear ' . $documento, 'new', ' bg-primary float-right ', 'onclick=go_to("crear/' . $documento . '")');
		} else {
			if ($documento == 'presupuesto' && $pages_access[1] == 2) {
				echo new_button('<i class="fas fa-folder-plus"></i> Crear ' . $documento, 'new', ' bg-primary float-right ', 'onclick=go_to("crear/' . $documento . '")');
			}
		}

		?>


	</div>

</div>

<br>



<div class="card p-4">

	<h4 class="blue"><i class="fas fa-search"></i> Buscar <?php echo $documento ?></h4>
	<div class="form-group row ta-r">
		<label for="filter" class="col-md-2 control-label mt-2"><i class="fas fa-user-tag"></i> Cliente o # de <?php echo $documento;  ?></label>
		<div class="col-md-3 m-2">
			<input type="text" class="form-control" id="filter" placeholder="Nombre del cliente o # de <?php echo $documento;  ?>">

			<input type="text" id="filter2" value="" class="hidden">
			<br>
			<label class="pull-left control-label"><i class="fas fa-calendar-alt"></i> Ejercicio fiscal </label>
			<select id="fecha" class="form-control input-sm">

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

		<label for="q" class="col-md-2 control-label mt-2"><i class="fas fa-check-double"></i> Estado de <?php echo $documento;  ?></label>
		<div class="col-md-3 m-2">
			<select class="form-control input-sm" id="estado" name="estado">
				<?php $estado_pagado =  ($documento == 'proforma' || $documento == 'factura') ? 'Pagada' : 'Aprobado';
				if ($documento == 'abono') {
					$estado_pagado = 'Abonado';
				} ?>
				<option value="0" selected>Todas</option>
				<option value="2"><?php echo $estado_pagado; ?></option>
				<option value="1">Pendiente</option>
			</select>
			<input type="text" id="estado2" value="0" class="hidden">

		</div>

		<div class="col-md-2 ta-l m-2">
			<button type="button" class="btn btn-primary" id="search" onclick='buscar(0,1,"#filter","#estado");'>
				<i class="fas fa-search" aria-hidden="true"></i> Buscar</button>

		</div>
	</div>


</div>

<div class="alert-box" id="results"> </div>

<div class="card">
	<div id="pagination">

	</div>

	<div class="table-responsive p-4" id="result_table">

		<?php $this->load->view('user/documents/main_table') ?>
	</div>
</div>