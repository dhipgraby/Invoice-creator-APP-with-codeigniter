<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
		<h1><i class="fas fa-user-shield"></i> Perfil de usuario</h1>
	</div>

	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" align="right">

	</div>

</div>
<br>

<?php $this->load->view('user/modal/perfil/password'); ?>

<div class="row">

	<div class="col-sm-6" align="left">
		<div class="card">

			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-user-edit"></i> Datos de usuario</h4>

			</div>

			<div class="modal-body ">

				<form onsubmit="return false;" class="form-horizontal" id="datos_usuario" name="datos_usuario">
					<div class="form-group">
						<label for="firstname" class="control-label">Nombre</label>
						<div>
							<input value="<?php echo $user->firstname; ?>" type="text" class="form-control" id="firstname" name="firstname" required>
						</div>
					</div>

					<div class="form-group">
						<label for="email" class="control-label">Email</label>
						<div>
							<input value="<?php echo $user->email; ?>" type="text" class="form-control" id="email" name="email" required>
						</div>
					</div>
	

			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" data-toggle="modal" data-target="#passConfirm"><i class="fas fa-sync-alt"></i> Actualizar datos</button>
			</div>
			</form>
		</div>
	</div>

	<div class="col-sm-6">
		<div class="card">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-key"></i> Cambiar contraseña</h4>
			</div>
			<div class="modal-body ">
			<form onsubmit="return false;">
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
				<button type="submit" class="btn btn-primary" id="change_password"><i class="fas fa-save"></i> Guardar</button>
			</div>
			</form>
		</div>
	</div>

</div>