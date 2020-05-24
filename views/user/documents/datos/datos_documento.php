<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">


	<section class="card" style="height:92%">
		<div class="card-header d-flex">
			<div class="row minw-100">
				<div class="col-md-4">
					<h4 class="card-header-title"><i class="fas fa-file-alt"></i> Datos de <?php echo $documento; ?></h4>

				</div>
				<?php if ($documento == 'abono') { ?>
					<div class="col-md-2 ta-r">
						<h4 class="card-header-title t-inline"> N° de factura:</h4>

					</div>
					<div class="col-md-5">
						<input type="text" name="n_original" placeholder="numero de factura original" class="form-control input-lg" id="n_original" value="<?php if (!empty($current_doc)) {
																																								echo $current_doc->n_original;
																																							} ?>">
					</div>
				<?php } ?>
			</div>
		</div>
		<br>
		<div class="p-2 m-3">
			<div class="form-group ">

				<div class="row">
				<label class="col-md-4 control-label pt-2"><i class="fas fa-user-tie"></i> Vendedor</label>
				<div class="col-md-4">
					
			       <input type="text" id="id_vendedor" name="id_vendedor" class="form-control input-sm" value="<?php echo (empty($info->id_vendedor)) ? $user->firstname : $info->id_vendedor; ?>" readonly>
					</div>
				</div>
			
				<div class="row mt-2">
			
					<div class="col-md-4 mt-3">
					<label for="tel2" class="control-label"><i class="far fa-calendar-alt"></i> Fecha <?php echo $documento; ?></label>
						<input type="text" class="form-control datetimepicker-input" id="fecha" name="fecha" data-toggle="datetimepicker" data-target="#fecha">
					</div>
					<div class="col-md-4 mt-3">
					<label for="mydatepicker" class="control-label"><i class="far fa-calendar-alt"></i> Fecha Vencimiento</label>
					<input type="text" class="form-control datetimepicker-input" id="fecha_vencimiento" name="fecha_vencimiento" data-toggle="datetimepicker" data-target="#fecha_vencimiento">
					</div>
				</div>
	
				<!-- PAYMENT BOX AND MEHODS -->
				<?php $this->load->view('user/documents/payment_box') ?>
				<!-- ------ -->
			</div>
		</div>
	</section>

</div>