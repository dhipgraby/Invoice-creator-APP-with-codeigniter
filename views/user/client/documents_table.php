
<label class="control-label mb-3">Número de <?php echo $documento.'s: '.$total_docs;?>  </label>
<table class="table">
	<tr class="blue-little-box opacity-9">
		<th class="minw-10">N° <?php if ($documento == 'abono') {
									echo ' - N° factura';
								} ?></th>
		<th class="minw-10"><i class="far fa-calendar-alt"></i> Fecha</th>
		<th class="minw-30"><i class="fas fa-user-tag"></i> Cliente</th>
		<th class="minw-15"><i class="fas fa-user-tie"></i> Vendedor</th>
		<th class="minw-10"><i class="fas fa-check-double"></i> Estado</th>
		<th class='text-right minw-15'><i class="fas fa-calculator"></i> Total</th>
		<th class='ta-c minw-10'><i class="fas fa-sliders-h"></i> Acciones</th>
	</tr>


	<?php

	$estado_pagado = ($documento == 'proforma' || $documento == 'factura') ? 'Pagada' : 'Aprobado';
	if ($documento == 'abono') {
		$estado_pagado = 'Abonado';
	}
	foreach ($docs as $document) {
		if (!empty($document['numero_factura'])) {
			$fecha = date("d/m/Y", strtotime($document['fecha_factura']));

	?>
			<tr>
				<th class="minw-10"><?php echo $document['numero_factura']; ?>
					<?php if ($documento == 'abono') {
						echo ' - ' . $document['n_original'];
					} ?>
				</th>

				<th class="minw-10"><?php echo $fecha; ?></th>
				<th class="minw-30"><?php echo $document['nombre_cliente']; ?></th>
				<th class="minw-15"><?php echo $document['id_vendedor']; ?></th>
				<th class="minw-10"><?php echo ($document['estado_factura'] == 2) ? $estado_pagado : 'Pendiente'; ?></th>
				<th class="ta-r minw-15"><?php echo $negative . number_format($document['total_venta'], 2, ",", "."); ?> <?php echo $simbolo_moneda; ?></th>
				<th class="ta-c minw-10">
					<div class="btn-group">
						<?php
						$url = "'editar/" . $documento . "/" . $document['id_factura'] . "' ";
						$pdf_url = "'pdf/" . $document['id_factura'] . "' ";
						$pdf_download_url = "'pdf/download/" . $document['id_factura'] . "' ";
						$go_edit = 'onclick="go_to(' . $url . ')"';
						$go_pdf = 'onclick="go_to(' . $pdf_url . ')"';
						$download_pdf = 'onclick="go_to(' . $pdf_download_url . ')"';
						$open_pdf = 'onclick="open_pdf(' . $document['id_factura'] . ')"';

						echo new_button('<i class="fas fa-file-pdf"></i> <small>PDF</small>', '', 'info btn-sm pdf-web mr-2', $open_pdf . ' data-toggle="modal" data-target="#pdf_modal"') ?>
						<?php echo new_button('<i class="fas fa-file-download"></i> <small>PDF</small>', '', 'info btn-sm pdf-mobile mr-2', $download_pdf);

						if ($pages_access[0] == 2) {
							echo new_button('<i class="fas fa-edit"></i>', $document['numero_factura'], 'primary', $go_edit);
							$this->data['function'] = 'vaciar_doc(' . $document['id_factura'] . ')';
						?>
							<button tabindex="0" data-toggle="tooltip" data-trigger="focus" data-placement="right" data-html="true" title="<?php $this->load->view('user/components/vaciar_tooltip', $this->data) ?>" class="btn btn-warning ml-2">
								<i class="fas fa-exclamation-triangle"></i> Vaciar
							</button>
						<?php } else {
							if ($documento == 'presupuesto' && $pages_access[1] == 2) {
								echo new_button('<i class="fas fa-edit"></i>', $document['numero_factura'], 'primary', $go_edit);
							}
						}  ?>


					</div>
				</th>
			</tr>
	<?php
		}
	}

	?>

	<?php if (isset($script)) {
		echo $script;
	} ?>
</table>