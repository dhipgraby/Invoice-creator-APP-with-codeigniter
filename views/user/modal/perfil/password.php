<div class="modal fade" id="passConfirm" tabindex="-1" role="dialog" aria-labelledby="cambioContraseña">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			
			<h4 class="modal-title"><i class="fas fa-key"></i> Confirmación de seguridad</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
		  <div class="modal-body">
              <p>Introduzca su contraseña de usuario para realizar los cambios</p> 
			  <form onsubmit="return false">			  
             <div class="form-group">
				<label for="password" class="control-label">Contraseña actual</label>
				<div>
				  <input type="password" class="form-control" id="password_validation" name="password_validation" required>
				</div>
              </div>
      
			  
	  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar">Guardar</button>
		  </div>
		  </form>		
		</div>
	  </div>
	</div>

