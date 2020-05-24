<div class="card p-4 col-sm-12">
<?php

$sin_partida = FALSE;
if(count($detalles)){

foreach($detalles as $detalle)
{

  if($detalle['id_partida'] == 0){
    $sin_partida = TRUE;
  }
  
 }
}

 if(count($partidas)){

    foreach($partidas as $partida){      
    $this->data['function'] = 'eliminar_partida('.$partida->id_partida.')';
    
?>
	<div class=" bg-primary">
		<div class="row">

			<div class="col-sm-6">
                <h5 class="text-white title-partida pl-4  mt-3"><span id="partida_<?php echo $partida->id_partida; ?>"><?php echo $partida->nombre_partida; ?></span>
                    <i class="fas fa-edit ml-2" onclick="editar_partida(<?php echo $partida->id_partida; ?>,'<?php echo $partida->nombre_partida; ?>')"></i>
                    <i tabindex="0"  data-toggle="tooltip"  data-trigger="focus"
                       data-placement="right"
                       data-html="true" 
                       title="<?php $this->load->view('user/components/delete_tooltip',$this->data) ?>"
                       class='fas fa-trash-alt ml-2'></i>
                </h5>
			</div>
			<div class="col-sm-6 p-2 " align="right">
            	<button type="button" class="btn btn-primary-light mr-3" onclick="clean_productos(<?php echo $partida->id_partida;?>)" data-toggle="modal" data-target="#nuevoProducto" value="<?php echo $partida->id_partida; ?>">
				<i class="fas fa-file-signature"></i> Agregar producto
				</button>					
			</div>

		</div>
    </div>	
    <table class="table table-responsive p-2">
        
    <tr style="width:100%">
            <td class="minw-60 ta-l black"> CONCEPTO</td>
            <td class="minw-10 ta-c black">CANT.</td>
            <td class="minw-10 ta-r black" >PRECIO UNIT.</td>
            <td class="minw-10 ta-r black" >PRECIO TOTAL</td>
            <td class="minw-10 "></td>
            <td class="minw-10"></td>
        </tr>
<?php

if(count($detalles)){

foreach($detalles as $detalle)
{

$detail = product_formating($detalle);

if($partida->id_partida == $detail['id_to_append']){    

    $this->data['detail'] = $detail;
    $this->load->view('user/documents/datos/datos_detalles',$this->data);
       }        
     } //end foreach detalles
   }     ?>
    </table>
 <?php
} //end foreach partidas
} ?>

<?php if($sin_partida == TRUE){   ?>
<br> 
        <table class="table table-responsive p-2">
        
        <tr style="width:100%">
            <td class="minw-60 ta-l black"> CONCEPTO</td>
            <td class="minw-10 ta-c black">CANT.</td>
            <td class="minw-10 ta-r black" >PRECIO UNIT.</td>
            <td class="minw-10 ta-r black" >PRECIO TOTAL</td>
            <td class="minw-10 "></td>
            <td class="minw-10"></td>
        </tr>
     
   <?php foreach($detalles as $detalle)
    {

$detail = product_formating($detalle);    
    if($detalle['id_partida'] == 0){
           
    $this->data['detail'] = $detail;
    $this->load->view('user/documents/datos/datos_detalles',$this->data);     
        
      }
    } ?>
   </table>

  <?php }  ?>

<!-- DATOS TOTALES  -->
<?php 
$subtotal=number_format($subtotal,2,'.','');
$total_iva=number_format($total_iva,2,'.','');

?>
<br>
<div class="col-md-12">
<?php if($acc_config->sin_partida == 1){  ?>
			<button type="button" class="btn btn-primary pull-right mt-4" style="margin-right:10px;margin-bottom:10px;" onclick="clean_productos(0)" data-toggle="modal" data-target="#nuevoProducto" value="0" onclick="document.getElementById('id_partida').innerHTML=this.value">
			<i class="fas fa-file-signature" aria-hidden="true"></i> Agregar producto simple
		    </button>
        <?php } ?>   
						<table class="table black ">
							<tr>
								<td class='text-right' colspan="4">SUBTOTAL </td>
								<td class='text-right' ><?php if(isset($negative)){ echo $negative; } ?><span id="subtotal">  <?php echo number_format($subtotal,2,",",".");?></span> <?php echo $simbolo_moneda;?></td>
							
							</tr>
							<tr>
								<td class='text-right' colspan="4">IVA (<select onchange="set_iva()" style="border-radius:5px;" id="iva" name="iva">
																
								<option value="1" <?php echo ($iva ==1) ? 'selected': ''; ?>>21%</option>
                <option value="2" <?php echo ($iva ==2) ? 'selected': ''; ?>>10%</option>
								<option value="0" <?php echo ($iva ==0) ? 'selected': ''; ?>>0%</option>
																		
															</select>)</td>
								<td class='text-right' ><?php if(isset($negative)){ echo $negative; } ?><span id="iva_res"><?php echo number_format($total_iva,2,",",".");?></span> <?php echo $simbolo_moneda; ?></td>
						
							</tr>
							<tr>
								<td class='text-right' colspan="4">TOTAL </td>
                <td class='text-right' ><?php if(isset($negative)){ echo $negative; } ?><span id="total"><?php echo number_format($total_factura,2,",",".");?>  </span><?php echo $simbolo_moneda; ?>
                 <input name="total_factura" id="total_factura" value="<?php echo $total_factura; ?>" class='hidden'>	</td>
							
							</tr>

						</table>	
	</div>
  </div>

    <script>
    
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
})

</script>