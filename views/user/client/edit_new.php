<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
	<h1><i class="fas fa-user-tag" aria-hidden="true"></i> Nuevo cliente</h1>
<small>Rellene todos los datos para agregar un nuevo cliente</small>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" align="right">
<button type="button" class="btn btn-primary" id="guardar_cliente"><i class="fas fa-save"></i> Guardar datos</button>
</div>

</div>

<br>

<div class="card p-4">
<form class="form-horizontal" id="datos_cliente" name="datos_cliente">
	
			  <div class="form-group">
				<label for="nombre" class="control-label">Nombre Fiscal</label>
				<div>
				  <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" >
				</div>
			  </div>
              
              <div class="form-group">
				<label for="cif" class=" control-label">Cif</label>
				<div>
				  <input type="text" class="form-control" id="cif" name="cif">
				</div>
			  </div>
		
			  <div class="form-group">
				<label for="direccion" class=" control-label">Dirección</label>
				<div>
			    <input type="text" class="form-control" id="direccion_cliente" name="direccion_cliente">
				</div>
			  </div>
			  <div class="form-group">
		  <div class="row">
		  <div class="col-sm-2">
		  <label for="cp" class=" control-label">Código Postal</label>
				<div>
				  <input type="text" class="form-control" id="cp_cliente" name="cp_cliente">
				</div>
				</div>
				<div class="col-sm-5">
				<label for="poblacion" class=" control-label">Población</label>
				<div>
				  <input type="text" class="form-control" id="poblacion_cliente" name="poblacion_cliente">
				</div>
				</div>					
				<div class="col-sm-5">
				<label for="provincia" class=" control-label">Provincia</label>
				<div>
				  <input type="text" class="form-control" id="provincia_cliente" name="provincia_cliente">
				</div>
	     	   </div>						
			</div>
		  </div>
		  <div class="form-group">
		  <div class="row">
				<div class="col-sm-4">
				<label for="telefono_cliente" class=" control-label">Teléfono</label>
				<div>
				  <input type="text" class="form-control" id="telefono_cliente" name="telefono_cliente" >
				</div>
				</div>
				<div class="col-sm-8">
				<label for="email" class=" control-label">Email</label>
				<div>
					<input type="email" class="form-control" id="email_cliente" name="email_cliente">				  
				</div>
				</div>					
			  </div>
		  </div>
              
             	
		  </form>
		  </div>
          <br>
          
       <?php if(isset($r_script)){  echo $r_script; } ?>