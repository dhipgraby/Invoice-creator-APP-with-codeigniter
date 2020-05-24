	<div class="modal fade" id="cambioContraseña" tabindex="-1" role="dialog" aria-labelledby="cambioContraseña">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			
			<h4 class="modal-title"><i class="fas fa-key"></i> Cambiar contraseña</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
		  <div class="modal-body ">
               
          <div class="form-group">
				<label for="password" class="control-label">Contraseña actual</label>
				<div>
				  <input type="password" class="form-control" id="password" name="password" required>
				</div>
              </div>
              <hr>
              <div class="form-group">
				<label for="new_password" class="control-label">Nueva contraseña</label>
				<div>
				  <input type="password" class="form-control" id="new_password" name="new_password" required>
				</div>
              </div>
              
              <div class="form-group">
				<label for="password_confirm" class="control-label">Confirmar contraseña</label>
				<div>
				  <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
				</div>
			  </div>
			  
	  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button class="btn btn-primary" id="change_password">Guardar</button>
		  </div>
		
		</div>
	  </div>
	</div>

