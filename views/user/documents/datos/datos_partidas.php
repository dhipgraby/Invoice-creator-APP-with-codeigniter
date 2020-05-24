<?php if ($acc_config->partidas == 1) {  ?>
	<div align="right">
		<div class="btn-group">

			<button type="button" class="btn btn-info mr-2" onclick="clean_partidas()" data-toggle="modal" data-target="#nuevaPartida">
				<i class="fas fa-file-medical"></i> Nueva partida
			</button>
			<button type="button" style="padding-left:10px;padding-right:10px;" class="btn btn-info " data-toggle="modal" data-target="#order">
				<i class="fas fa-sort-amount-down-alt"></i> Ordenar partidas
			</button>
		</div>
	</div>
	<br>
<?php } ?>


<div id="partidas_div">
	<?php $this->load->view('user/documents/partidas'); ?>
</div>

<?php if ($acc_config->notas == 1) {  ?>
	<br>
	<div class='col-md-12'>
		<div class="form-group">

			<label for="notas" class="col-sm-3 control-label">

				<h4><span class="badge badge-info" style="background-color:#3498DB;color:#ffffff;font-weight:400">Notas</span></h4>

			</label>


			<div class="col-sm-8">
				<textarea  id="notas" name="notas">
   <?php echo $info->notas; ?>
   </textarea>
			
			
<br>
<button id="guardar_notas" class="btn btn- bg-blue">Guardar notas</button>

			</div>

		</div>
	</div>
<?php } ?>