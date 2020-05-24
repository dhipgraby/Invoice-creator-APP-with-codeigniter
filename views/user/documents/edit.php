
<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
		<h1><i class="fas fa-folder-plus"></i> Editar <?php echo $documento; ?> N° <span id="numero_factura"><?php echo $numero_factura ?></span></h1>
	</div>

	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" align="right">

		<div class="btn-group show-block">
		
			<?php echo new_button(
				'<i class="fas fa-file-pdf"></i> PDF',
				'',
				'info pdf-web m-2',
				'onclick="open_pdf(' . $id_factura . ')" data-toggle="modal" data-target="#pdf_modal"'
			);
			$pdf_download_url = "'pdf/download/" . $id_factura  . "' ";
			$download_pdf = 'onclick="go_to(' . $pdf_download_url . ')"';
			echo new_button('<i class="fas fa-file-download"></i> PDF', '', 'info pdf-mobile mr-2', $download_pdf); ?>

			<button type="button" id="actualizar_datos" class="btn btn-primary m-2">
				<i class="fas fa-sync"></i> Actualizar datos
			</button>

			<?php if ($documento == 'factura') {
			?>

				<button type="button" id="abono_form" data-target="#abono_modal" data-toggle="modal" class="btn btn-primary m-2">
					<i class="fas fa-file-signature"></i> Abonar
				</button>

			<?php } ?>

			<?php if ($documento == 'presupuesto') { ?>
				<button type="button" class="btn btn-primary m-2" id="abono_form" data-target="#abono_modal" data-toggle="modal">
					<i class="fas fa-file-import"></i> Facturar
				</button>
			<?php }
			$this->data['function'] = 'vaciar_doc_edit('.$id_factura.')'; ?>
			<button class="btn btn-warning m-2"
			tabindex="0"
			data-toggle="tooltip"
			data-trigger="focus"
			data-placement="right"
			data-html="true" title="<?php $this->load->view('user/components/vaciar_tooltip', $this->data) ?>"><i class="fas fa-exclamation-triangle"></i> Vaciar</button>
		</div>
	</div>

</div>
<br>
<?php
$this->load->view('user/modal/documentos/abono_modal');
$this->load->view('user/modal/documentos/registro_partidas');
$this->load->view('user/modal/documentos/registro_productos');
$this->load->view('user/modal/documentos/order_partidas');
$this->load->view('user/modal/documentos/pdf_modal');
if ($pages_access[2] == 2) {
	$this->load->view('user/modal/clientes/registro_clientes');
}
?>

<form class="form-horizontal ta-l" role="form" id="datos_factura">
	<input name="id_factura" id="id_factura" value="<?php echo $id_doc; ?>" type='hidden'>

	<div class="row">

		<?php $this->load->view('user/documents/datos/datos_documento') ?>

		<?php $this->load->view('user/documents/datos/datos_cliente') ?>

	</div>
	<?php if ($acc_config->proyecto == 1 || $acc_config->direccion == 1) {  ?>
		<div class="card p-4">

			<div class="col-md-12">
				<div class="form-group row">
					<?php if ($acc_config->proyecto == 1) {  ?>
						<label for="proyecto" class="col-md-1 control-label mt-2">Proyecto</label>

						<div class="col-md-5">
							<input type="text" class="form-control input-sm" name="proyecto" id="proyecto" value="<?php echo $info->proyecto; ?>">
						</div>
					<?php } ?>
					<?php if ($acc_config->direccion == 1) {  ?>
						<label for="direccion_proyecto" class="col-md-1 control-label mt-2"><i class="fas fa-map-marker-alt"></i> Dirección</label>

						<div class="col-md-5">
							<input type="text" class="form-control input-sm" id="direccion_proyecto" name="direccion" value="<?php echo $info->direccion_proyecto; ?>">
						</div>
					<?php } ?>
				</div>
			</div>

		</div>
	<?php } ?>
</form>

<?php $this->load->view('user/documents/datos/datos_partidas'); ?>