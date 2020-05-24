<?php if (count($partidas)) {

	foreach ($partidas as $partida) {

?>
		<div style="page-break-inside: avoid;">
			<table style="width: 100%;" cellspacing="0">
				<tr>
					<td style="width: 100%;padding:5px;padding-left:20px;" class="green-bg">
						<p style="margin-top:0px;"><?php echo strtoupper($partida->nombre_partida); ?></p>
					</td>
				</tr>
				<tr style="width: 100%;">
					<td style="width: 100%;padding-top:0;" class="grey-bg">

						<table style="width:100%;padding-left:20px;">
							<tr>
								<td class="ta-l" style="width:60%">
									<p class="m0 green-text"><b>CONCEPTO</b></p>
								</td>
								<td class="ta-r" style="width:13%">
									<p class="m0 green-text"><b>CANTIDAD</b></p>
								</td>
								<td class="ta-r" style="width:13%">
									<p class="m0 green-text"><b>PRECIO UND</b></p>
								</td>
								<td class="ta-r p-2" style="width:13%; padding-left:16px;">
									<p class="m0 green-text"><b>TOTAL</b></p>
								</td>
							</tr>
						</table>


					</td>

				</tr>
				<?php

				$sumador_total = 0;
				if (count($detalles)) {

					rsort($detalles);
					foreach ($detalles as $detalle) {
						$detalle_json = json_encode($detalle);
						$id_to_append = $detalle['id_partida'];
						$id_detalle = $detalle["id_detalle"];
						$codigo_producto = $detalle['codigo_producto'];
						$cantidad = $detalle['cantidad'];
						$nombre_producto = json_encode(htmlentities($detalle['nombre_producto']), JSON_UNESCAPED_UNICODE);
						$tipo = $detalle['tipo'];


						$precio_venta = $detalle['precio_venta'];
						$precio_venta_f = number_format($precio_venta, 2, ",", "."); //Formateo variables
						$precio_total = $precio_venta * $cantidad;
						$precio_total_f = number_format($precio_total, 2, ",", "."); //Precio total formateado
						$sumador_total += $precio_total; //Sumador
						$nombre_producto = str_replace("\\", '"', $nombre_producto);
						$nombre_producto =  str_replace(array('"r"n', '\r'), "<br>", $nombre_producto);
						$nombre_producto =  str_replace('"', '', $nombre_producto);

						if ($partida->id_partida == $id_to_append) {
				?>

							<table style="width:100%;padding-left:20px;" class="grey-bg green-top-border">
								<tr>
									<td class="ta-l" style="width:60%" valign="top">
										<p><?php echo $nombre_producto;  ?></p>
									</td>
									<td class="ta-r mr-2" style="width:13%;" valign="top">
										<p><?php echo $negative .number_format($detalle['cantidad'], 2, ",", ".") . ' <b>' . $tipo . '</b>'; ?></p>
									</td>
									<td class="ta-r mr-2" style="width:13%;" valign="top">
										<p><?php echo $negative .$precio_venta_f . ' ' . $simbolo_moneda; ?></p>
									</td>
									<td class="ta-r mr-2" style="width:13%;" valign="top">
										<p><?php echo $negative .$precio_total_f . ' ' . $simbolo_moneda; ?></p>
									</td>
								</tr>
							</table>
				<?php  }
					}
				}

				$impuesto = 21;

				switch($factura->iva){
					case 1:
						$impuesto = 21;
						break;
					case 2:
						$impuesto = 10;
						break;
					case 0:
						$impuesto = 0;
						break;
				}

				$subtotal = number_format($sumador_total, 2, '.', '');
				$total_iva = ($subtotal * $impuesto) / 100;
				$total_iva = number_format($total_iva, 2, '.', '');
				$total_factura = $subtotal + $total_iva;

				?>


			</table>
			<br>
		</div>
<?php

	}
}

$pago = $factura->condiciones;
switch ($pago) {

	case 1:
		$pago = 'Efectivo';
		break;
	case 2:
		$pago = 'Tarjeta';
		break;
	case 3:
		$pago = 'Transferencia bancaria';
		break;
	case 4:
		$pago = 'Paypal';
		break;
}

?>
<br>
<table style="width: 100%;" cellspacing="0">
	<tr>
		<td style="width:55%; padding:5px;text-align:center" class="grey-bg">

			<p class="m0 green-text">Metodo de pago: <?php echo $pago; ?>
				<br>
				<b style="color:#000000">
				<?php if ($factura->condiciones == 3) {
							foreach ($payment_method['bancos'] as $banco) {

								if ($banco->id == $factura->id_payment) {
									echo $banco->nombre . ' - ' . $banco->cuenta;
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
			</b>
			</p>
		</td>

		<td style="width:45%; padding-right:40px; padding-left:30px;" class="green-bg">
			<table style="width:100%" class="ta-r">

				<tr>
					<td>
						<p style="margin:0px;margin-top:10px">SUBTOTAL:</p>
					</td>
					<td>
						<p style="margin:0px;margin-top:10px"><?php echo $negative . number_format($subtotal, 2, ",", "."); ?> €</p>
					</td>
				</tr>
				<tr>
					<td>
						
						<p style="margin:0px;"><?php echo $impuesto; ?>% IVA: </p>
					</td>
					<td>
						<p style="margin:0px;"><?php echo $negative . number_format($total_iva, 2, ",", "."); ?> €</p>
					</td>
				</tr>
				<tr>
					<td>
						<h4 style="margin-top:0px;">TOTAL:</h4>
					</td>
					<td>
						<h4 style="margin-top:0px;"><?php echo $negative . number_format($total_factura, 2, ",", "."); ?> €</h4>
					</td>
				</tr>


			</table>


		</td>

	</tr>

</table>