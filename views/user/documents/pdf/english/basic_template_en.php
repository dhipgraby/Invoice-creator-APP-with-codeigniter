<?php $this->load->view('user/documents/pdf/basic_style.php') ?>


<div class="grey-bg ta-r">
	<h1 style="font-size: 30px;" class="pr-4 p-2">INVOICE</h1>
</div>

<div class="pl-3 pr-3 mb-2">

	<?php $this->load->view('user/documents/pdf/english/basic_empresa') ?>
	<?php $this->load->view('user/documents/pdf/english/basic_cliente') ?>


	<br>

	<?php if ($acc_config->proyecto == 1 || $acc_config->direccion == 1) {  ?>
		<?php if (!empty($factura->proyecto) || !empty($factura->direccion_proyecto)) {  ?>

			<p class="ta-l">
				<?php if ($acc_config->proyecto == 1 &&  !empty($factura->proyecto)) {  ?>
					<b>Nombre de proyecto:</b> <?php echo strtoupper($factura->proyecto); ?>
					<br>
				<?php } ?>
				<?php if ($acc_config->direccion == 1 &&  !empty($factura->direccion_proyecto)) {  ?>
					<b>Dirección de Proyecto:</b> <?php echo $factura->direccion_proyecto; ?>
				<?php } ?>
			</p>

	<?php }
	} ?>

	<br>


	<?php $this->load->view('user/documents/pdf/english/basic_partidas') ?>

	<br>

	<hr>
	<?php

	$pago = $factura->condiciones;
	switch ($pago) {

		case 1:
			$pago = 'Cash';
			break;
		case 2:
			$pago = 'Card';
			break;
		case 3:
			$pago = 'Banc transfer';
			break;
		case 4:
			$pago = 'Paypal';
			break;
	}

	?>
	<div class="pl-3 pr-3 mb-2 mt-2">

		<table>
			<tr>
				<td>
					<p><b>Payment method:</b></p>
				</td>
				<td>
					<p><?php echo $pago; ?></p>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<p>
						<?php if ($factura->condiciones == 3) {
							foreach ($payment_method['bancos'] as $banco) {

								if ($banco->id == $factura->id_payment) {
									echo $banco->nombre . ' ' . $banco->cuenta;
								}
							}
						}

						if ($factura->condiciones == 4) {
							foreach ($payment_method['paypals'] as $paypal) {

								if ($paypal->id == $factura->id_payment) {
									echo $paypal->email;
								}
							}
						}
						?>
					</p>
				</td>
			</tr>
		</table>

	</div>



	<?php if ($acc_config->notas == 1 && !empty($factura->notas)) {  ?>
		<div class="pl-3 pr-3 ta-l" style="page-break-inside: avoid; height:auto;">
			<p>
				<b>Notes</b><br>
				<?php echo $factura->notas ?></p>

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