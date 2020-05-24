
	<!-- Modal -->
	<div class="modal fade" id="abono_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog  modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
<?php $new_doc = ($documento == 'presupuesto') ? 'Factura' : 'Abono';
      $accion =  ($documento == 'presupuesto') ? 'facturar' : 'abonar';
	  $doc_text = ($documento == 'presupuesto') ? '(crear factura de este presupuesto)' : '(Factura rectificativa)';  
	   ?>
		  <h4 class="modal-title"><i class="fas fa-file-signature" aria-hidden="true"></i> Crear <?php echo $new_doc; ?> <small><?php echo $doc_text; ?></small></h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

		  </div>
		  <div class="modal-body" align="left">

		  <div id="res_abonos" class="mt-2"></div>	
		 <p>Los productos seleccionados, seran los que se van a <?php echo $accion; ?>.</p> 
       
        <div id="productos_abono"></div> 
      

		</div>
		<div class="modal-footer" align="right">
        <button type="button" class="btn btn-primary mt-1 mb-1" id="abonar"><i class="fas fa-save"></i> Crear <?php echo $new_doc ?></button>
		</div>
	  </div>
     </div>
	</div>

	
