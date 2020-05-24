
	<div class="modal fade" id="paypal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content ">
		  <div class="modal-header">
			
			<h4 class="modal-title"><i class="fab fa-paypal" aria-hidden="true"></i> <span id="text_paypal">Añadir</span> cuenta Paypal</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
		  <div class="modal-body">
			  <form onsubmit="return false;">
		    <div  id="paypal_res"></div>	  
            <label for="nombre"> Paypal email</label>
            <input type="text" class="form-control" name="paypal_email" id="paypal_email">
			<input type="text" class="form-control hidden" value="0" id="id_paypal">            
          </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<?php echo new_button('<i class="fas fa-check"></i> Confirmar','guardar_paypal','primary'); ?>
			</form>
		  </div>
		
		</div>
	  </div>
	</div>

