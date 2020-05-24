
	<div class="modal fade" id="nuevaPartida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
		  <h4 class="modal-title"><i class="fas fa-file-medical"></i> <span id="partidas_text">Agregar</span> Partida</h4>

			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

		  </div>
		  <div class="modal-body">
		  <div id="res_partidas"></div>	
		  <form onsubmit="return false" class="form-horizontal" name="guardar_partida">				
			<div class="form-group">
				<label for="partida" class="col-sm-12 control-label">Nombre Partida</label>
				<div class="col-sm-12">
				  <input type="text" class="form-control" id="partida" name="partida" placeholder="Nombre partida">
				  <input type="text" class="form-control hidden" id="edit_id_partida" name="edit_id_partida">
				</div>
			  </div> 
						
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_partida">Guardar</button>
			<button type="button" class="btn btn-primary hidden" id="editar_partida">Guardar</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
