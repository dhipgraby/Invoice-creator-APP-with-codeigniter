<div class="modal fade" id="editarUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-edit" aria-hidden="true"></i> Editar usuario</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			</div>
			<div class="modal-body">
				<div id="edit_res_user"></div>
				<!-- CARGA DE NOMBRE E EMAIL -->
				<form onsubmit="return false">
					<div id="edit_userdata"></div>
					<!-- -->
					<br>
					<div align="right">
						<button type="submit" class="btn btn-primary" id="update_user">Actualizar datos</button>
					</div>
				</form>
				<br>
				<h4><i class="fas fa-key"></i> Cambiar contraseña</h4>
				<div id="edit_pass_user"></div>
				<form onsubmit="return false">
					<div class="form-group">
						<label for="new_password" class="col-sm-12 control-label"> Nueva contraseña</label>
						<div class="col-sm-12">
							<input type="password" class="form-control" id="new_password" name="new_password" placeholder="contraseña" required>
						</div>
					</div>

					<div class="form-group">
						<label for="new_password_confirm" class="col-sm-12 control-label"> Repetir contraseña</label>
						<div class="col-sm-12">
							<input type="password" class="form-control" id="new_password_confirm" name="new_password_confirm" placeholder="confirmar contraseña" required>
						</div>
					</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" id="update_pass"><i class="fas fa-key"></i> Guardar nueva contraseña</button>
			</div>
			</form>

		</div>
	</div>
</div>