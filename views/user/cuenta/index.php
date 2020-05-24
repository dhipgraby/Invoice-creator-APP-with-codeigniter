
<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
	<h1><i class="fas fa-fw fa-building" aria-hidden="true"></i> Cuenta</h1>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" align="right">
<?php if($config_access[0] == 2){  ?>
<button type="button" class="btn btn-primary" id="guardar"><i class="fas fa-sync-alt"></i> Actualizar datos</button>
<?php } ?>
</div>

</div>

 
<br>

<div class="row">
<div class="col-sm-3" align="center">

		<div class="card p-4">
	
		<div align="left">
	    	<h4 class="light-c"><i class="fas fa-image"></i> LOGO</h4>
     	</div>
		<img id="current_logo" src="<?php echo $logo_url; ?>" style="width:180px;">  
	

		</div>

		<?php if($config_access[0] == 2){  ?>
		<div class="card mt-3  p-3" align="center">

     				<form method="post" id="upload_form" enctype="multipart/form-data">  
					 <label for="image_file" class="btn">Pulse añadir para subir una imagen</label>
			         
					 <div class="btn-group">
					 <button class="btn btn-info" type="button" onclick="document.getElementById('image_file').click()"><i class="fas fa-file-upload"></i> Añadir imagen </button>
					<?php echo "<input class='hidden' type='file' name='userfile' size='20' id='image_file' />"; ?>
					
					<button type="submit" class="btn btn-primary ml-3" id="upload">Subir</button>

					 </div>
					 </form>
					<br>				
			</div>
		<?php } ?>
</div>	
<!-- END COL 4 -->

<div class="col-sm-9" align="left">
 <div class="pills-regular pl-2 mb-1">
	<ul class="nav nav-pills card-header-pills" id="myTab2" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="card-pills-1" data-toggle="tab" href="#card-pill-1" role="tab" aria-controls="card-1" aria-selected="false">
			<i class="fas fa-city"></i> Datos de facturación</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="card-pills-2" data-toggle="tab" href="#card-pill-2" role="tab" aria-controls="card-2" aria-selected="false">
			<i class="fas fa-tasks"></i> Configuración</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="card-pills-3" data-toggle="tab" href="#card-pill-3" role="tab" aria-controls="card-2" aria-selected="false">
			<i class="far fa-credit-card"></i> Formas de pago</a>
		</li>
		
	</ul>
 </div>
	<div class="card p-4">   
												
			<div class="card-body">
				<div class="tab-content" id="myTabContent2">
					<div class="tab-pane fade active show" id="card-pill-1" role="tabpanel" aria-labelledby="card-tab-1">
					
					<?php $this->load->view('user/cuenta/datos_facturacion') ?>
					
				    </div>
				 	<div class="tab-pane fade " id="card-pill-2" role="tabpanel" aria-labelledby="card-tab-2">					
					
					<?php $this->load->view('user/cuenta/configuracion') ?>
	
					</div>	
					<div class="tab-pane fade" id="card-pill-3" role="tabpanel" aria-labelledby="card-tab-3">					
								
					<?php $this->load->view('user/cuenta/pago/formas_de_pago') ?>

					</div>			
				</div>
			</div>
		</div>


</div>
</div>
<!-- END ROW -->		

