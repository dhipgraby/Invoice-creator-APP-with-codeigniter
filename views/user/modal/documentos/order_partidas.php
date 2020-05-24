
	<div class="modal fade" id="order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			
			<h4 class="modal-title"> Ordernar partidas</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
		  <div class="modal-body " id="partidas_res">
               
<?php $this->load->view('user/modal/documentos/partidas'); ?>				  
	  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_orden">Guardar orden</button>
		  </div>
		
		</div>
	  </div>
	</div>

