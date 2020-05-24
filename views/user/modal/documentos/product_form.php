	  
			  <div class="form-group">
				<label for="nombre_producto" class="col-sm-12 control-label">Nombre</label>
				<div class="col-sm-12">
					<textarea class="form-control" id="nombre_producto" name="nombre_producto" placeholder="Nombre del producto" required maxlength="255" ></textarea>
					<input type="text" class="hidden" id="id_partida" name="id_partida" value="">
					<input type="text" class="hidden" id="id_producto" name="id_producto" value="">
					<input type="text" class="hidden" id="codigo_producto" name="codigo_producto" value="">
				</div>
			  </div>
			 
			  <div class="form-group">
				<label for="cantidad" class="col-sm-12 control-label">Cantidad</label>
				<div class="col-sm-12">
				  <input type="text" class="form-control" id="cantidad" name="cantidad" title="Ingresa sólo números con 0 ó 2 decimales">
				</div>
			  </div>
			 
			  <?php $product_config = str_split($acc_config->unidades); ?>
			  <div class="form-group">
				<label for="tipo" class="col-sm-12 control-label">Unidad</label>
				<div class="col-sm-12">
				<select class="form-control input-sm" id="tipo" name="tipo">
				<?php if($product_config[0] != 2) {  ?>
			  <option value="ud" <?php if($product_config[0] == 3){ echo 'selected';  } ?>>ud.</option>
				<?php }  ?>
				<?php if($product_config[1] != 2) {  ?>
			  <option value="m2" <?php if($product_config[1] == 3){ echo 'selected';  } ?>>m2.</option>
				<?php }  ?>
				<?php if($product_config[2] != 2) {  ?>
			  <option value="h" <?php if($product_config[2] == 3){ echo 'selected';  } ?>>h.</option>
				<?php }  ?>
				<?php if($product_config[3] != 2) {  ?>
			  <option value="ml" <?php if($product_config[3] == 3){ echo 'selected';  } ?>>ml.</option>
				<?php }  ?>			  
			  
			  </select>
				
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="precio_producto" class="col-sm-12 control-label" >Precio producto</label>
				<div class="col-sm-12">
				  <input type="text"  value="0.00"  class="form-control" id="precio_producto" name="precio_producto"  title="Ingresa sólo números con 0 ó 2 decimales" >
				</div>
			  </div>

			 			
		  </div>

		  <script>
	
          
		  var single_detail = <?php echo (!isset($single_detail)) ? '0' : $single_detail; ?>;
    	  
		  if(single_detail != 0){

			fill_products_form(single_detail);
		  }

		  </script>