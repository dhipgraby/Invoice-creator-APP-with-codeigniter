
	<!-- Modal -->
	<div class="modal fade" id="contactoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
		
            <h4 class="modal-title"><i class="fas fa-users"></i> Persona de contacto</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            
		  </div>
		  <div class="modal-body">
          <div id="res_contacto"></div>
          <form id="p_contacto" onsubmit="return false;">
          <div class="form-group">
				<label for="nombre" class="col-sm-12 control-label"> Nombre</label>
				<div class="col-sm-12">
                  <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Nombre de contacto" >				
                  <input type="text" class="form-control hidden" id="id_contacto" >				
				</div>
            </div>

			<div class="form-group">
				<label for="cargo" class="col-sm-12 control-label"> Cargo</label>
				<div class="col-sm-12">
				  <input type="text" class="form-control" id="cargo" name="cargo" value="" placeholder="Cargo">				
				</div>
			  </div>

           <div class="form-group">
				<label for="telefono" class="col-sm-12 control-label"> Telefono</label>
				<div class="col-sm-12">
				  <input type="text" class="form-control" id="telefono" name="telefono" value="" placeholder="telefono">
			</div>
            </div>
         
            <div class="form-group">
				<label for="email" class="col-sm-12 control-label"> Email</label>
				<div class="col-sm-12">
				  <input type="text" class="form-control" id="email" name="email" value="" placeholder="Email">
			</div>
            </div>

		</div>
        <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_contacto">Guardar</button>
		  </div>
          </form>
	  </div>
	</div>
	</div>


