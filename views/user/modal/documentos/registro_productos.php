
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
		  <h4 class="modal-title"><i class="fas fa-file-signature"></i> <span id="product_text">Agregar</span> Producto  </h4>
			<button type="button" class="close c-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			
		  </div>
		  <div class="modal-body" id="product_form">
		<div id="res_product"></div>
		  <form onsubmit="return false;" class="form-horizontal" id="form_producto" name="guardar_producto">
			
			<?php $this->load->view('user/modal/documentos/product_form'); ?>

			
			<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_producto">Guardar datos</button>
			<button type="submit" class="btn btn-primary hidden" id="editar_producto">Guardar datos</button>
			</form>  
		</div>

		
		</div>
	  </div>
	</div>
