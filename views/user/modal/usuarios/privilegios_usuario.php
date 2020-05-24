
	<div class="modal fade" id="privilegios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
		  <h4 class="modal-title"><i class="fas fa-layer-group" aria-hidden="true"></i> Privilegios de usuario </h4>

			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

		  </div>
		  <div class="modal-body">
			
      <input type="text" class="form-control hidden" id="user_priv_id">
       
            <h4 class="light-c"><i class="far fa-copy"></i> Paginas</h4>
          <?php $this->load->view('user/usuarios/pages_option') ?>
           <br>
           <h4 class="light-c"><i class="fas fa-cogs"></i> Configuracion</h4>
           <?php $this->load->view('user/usuarios/config_option') ?>
		  </div>
		  <div class="modal-footer">
			  
			<div id="res_priv"></div>
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		  </div>
	
		</div>
	  </div>
	</div>
