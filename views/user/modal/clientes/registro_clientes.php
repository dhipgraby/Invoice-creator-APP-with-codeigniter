
	<!-- Modal -->
	<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog  modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">

		  <h4 class="modal-title"><i class="fas fa-user-tag" aria-hidden="true"></i> <?php echo (!empty($cliente)) ? 'Editar': 'Nuevo'; ?> cliente</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

		  </div>
		  <div class="modal-body" align="left">

		  <div id="res_clientes" class="mt-2"></div>	
		  <?php echo (!empty($cliente)) ? ' ': '<small>Rellene todos los datos para agregar un nuevo cliente</small> <br>'; ?>	
         
<form class="form-horizontal" id="datos_cliente" name="datos_cliente" onsubmit="return false;">
	
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
              
             	
	
		         
       <?php if(isset($r_script)){  echo $r_script; } ?>

		</div>
		<div class="modal-footer" align="right">
		<button type="submit" class="btn btn-primary" id="guardar_cliente_modal"><i class="fas fa-save"></i> Guardar datos</button>
		</form>
		</div>
	  </div>
	</div>
	</div>

	
