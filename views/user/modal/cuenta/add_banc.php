
	<div class="modal fade" id="bancos_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content ">
		  <div class="modal-header">
			
			<h4 class="modal-title" id="text_banco"><i class="fas fa-university" aria-hidden="true"></i> Añadir nuevo banco </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
		  <div class="modal-body ">
          
		<div id="banc_res"></div>	  
         <form id="form_banco" onsubmit="return false">
            <div class="row">

            <div class="col-sm-6">
            <label for="banco" class="black"> Nombre Entidad</label>
            <input type="text" class="form-control" name="banco" id="nombre_banco">            
            <input type="text" class="form-control hidden" val="0" name="id_banco" id="id_banco">
            </div>
         
            <div class="col-sm-6">
            <label for="bic"> <b>BIC / SWIFT</b></label>
            <input type="text" class="form-control" name="bic" id="bic">
            </div>

            </div>
            <label class="mt-2 black" for="cuenta"> Numero de cuenta</label>
            <input type="text" class="form-control input-sm" name="cuenta" id="cuenta">
          </div>

  
		
          <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <?php echo new_button('<i class="fas fa-check"></i> Confirmar','guardar_banco','primary'); ?>
            </form>
		  </div>
		
		</div>
	  </div>
	</div>

