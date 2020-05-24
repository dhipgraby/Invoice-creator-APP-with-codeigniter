<div class="card p-4 col-sm-12">
<?php 

 if(count($partidas)){

    foreach($partidas as $partida){      
       
?>
<div name="partida_abono" value="<?php echo $partida->id_partida;  ?>">
	<div class="bg-primary">
		<div class="row">

			<div class="col-sm-6">
        <h5 class="text-white title-partida pl-4  mt-3"><?php echo $partida->nombre_partida; ?></h5>
        
      </div>
			<div class="col-sm-6 p-2 ">
            						
			</div>

		</div>
    </div>	
    
    <table class="table table-responsive p-2">
        
    <tr style="width:100%">
            <td class="minw-60 ta-l black"> CONCEPTO</td>
            <td class="minw-10 ta-c black">CANT.</td>
            <td class="minw-10 ta-r black" style="white-space: nowrap;">PRECIO UNIT.</td>
            <td class="minw-10 ta-r black" >PRECIO TOTAL</td>
         
        </tr>
<?php

if(count($detalles)){

foreach($detalles as $detalle)
{

$detail = product_formating($detalle);

$sin_partida = ($detail['id_to_append'] == 0) ? TRUE : 0;
if($partida->id_partida == $detail['id_to_append']){    

    $this->data['detail'] = $detail;
    $this->load->view('user/documents/abonos/datos_detalles',$this->data);
       }        
     } //end foreach detalles
   }     ?>
    </table>
    
 <?php
} //end foreach partidas
} ?>


<br>
<?php
if($acc_config->sin_partida == 1) {  ?> 
        <table class="table table-responsive p-2">
        
        <tr style="width:100%">
            <td class="minw-60 ta-l black"> CONCEPTO</td>
            <td class="minw-10 ta-c black">CANT.</td>
            <td class="minw-10 ta-r black" >PRECIO UNIT.</td>
            <td class="minw-10 ta-r black" >PRECIO TOTAL</td>
   
        </tr>
     
   <?php foreach($detalles as $detalle)
    {
      
$detail = product_formating($detalle);    
    if($detalle['id_partida'] == 0){
           
    $this->data['detail'] = $detail;
    $this->load->view('user/documents/abonos/datos_detalles',$this->data);     
        
      }
    } ?>
   </table>

<br>
<?php } ?>
</div>
  </div>
