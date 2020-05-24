<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
		<h1><i class="fas fa-users"></i> Usuarios</h1>
	</div>

</div>

<div class="row">
<?php if ($config_access[1] == 2) { ?>	
<div class="col-sm-4">
		<?php
		
		$this->load->view('user/modal/usuarios/add_user'); ?>
		<?php $this->load->view('user/usuarios/registro_usuario');  ?>
	</div>
	<?php  } ?>
	<div class="col-sm-8" id="user_table">
		<?php $this->load->view('user/usuarios/user_table') ?>
	</div>
</div>

<!-- MODALS -->
<?php if ($config_access[1] == 2) {
	$this->load->view('user/modal/usuarios/privilegios_usuario');
} ?>
<?php if ($config_access[1] == 2) {
	$this->load->view('user/modal/usuarios/editar_usuario');
} ?>