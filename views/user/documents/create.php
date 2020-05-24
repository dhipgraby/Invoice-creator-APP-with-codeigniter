<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
		<h1><i class="fas fa-folder-plus"></i> Crear <?php echo $documento; ?></h1>
	</div>

	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" align="left">

	</div>

</div>

<br>
<?php
$this->load->view('user/modal/documentos/pdf_modal');
if ($pages_access[2] == 2) {
	$this->load->view('user/modal/clientes/registro_clientes');
}

?>
<!-- ============================================================== -->

<form onsubmit="return false;" class="form-horizontal ta-l" role="form" id="datos_factura">

	<div class="row">
		<!-- Card Datos Factura  -->
		<!-- ============================================================== -->
		<?php $this->load->view('user/documents/datos/datos_documento') ?>

		<!-- ============================================================== -->
		<!-- Card Datos Cliente  -->
		<!-- ============================================================== -->

		<?php $this->load->view('user/documents/datos/datos_cliente') ?>

	</div>

	<?php if ($acc_config->proyecto == 1 || $acc_config->direccion == 1) {  ?>
		<div class="card p-4">

			<div class="col-md-12">
				<div class="form-group row">

					<?php if ($acc_config->proyecto == 1) {  ?>
						<label for="proyecto" class="col-md-1 mt-2 control-label">Proyecto</label>

						<div class="col-md-5">
							<input type="text" class="form-control input-sm" name="proyecto" id="proyecto" value="">
						</div>
					<?php } ?>
					<?php if ($acc_config->direccion == 1) {  ?>
						<label for="direccion_proyecto" class="col-md-1 mt-2 control-label"><i class="fas fa-map-marker-alt"></i> Dirección</label>

						<div class="col-md-5">
							<input type="text" class="form-control input-sm" id="direccion_proyecto" name="direccion" value="">
						</div>
					<?php } ?>

				</div>
			</div>

		</div>
	<?php } ?>

	<div align="right">

		<button type="button" id="send_form" class="btn btn-primary ">
			<i class="fas fa-save"></i> Crear <?php echo $documento; ?>
		</button>


	</div>

	<div class="card p-4 <?php echo ($init_num == FALSE) ? 'hidden' : ''; ?>" style="width: 18rem;">

		<label for="init_num" class="control blue-little-box">Numero inicial de <?php echo $documento; ?></label>

		<div style="margin-top:15px;">

			<input class="form-control input-sm" id="init_num" type="number" value="1" required>

		</div>


	</div>
</form>