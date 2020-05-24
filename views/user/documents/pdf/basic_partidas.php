
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
 
?>
<div style="page-break-inside: avoid;">
<p class="mb-1" style="text-decoration:underline"><b><?php echo strtoupper($partida->nombre_partida); ?></b></p>

<table style="width: 100%;" cellspacing="0">

       <tr>
        <td class="ta-l bb-1" style="width:60%;"><p><b>CONCEPTO</b></p></td>
        <td class="ta-r bb-1" style="width:13%"><p><b>CANTIDAD</b></p></td>
        <td class="ta-r bb-1" style="width:13%; white-space: nowrap;"><p><b>PRECIO UND</b></p></td>
        <td class="ta-r bb-1" style="width:13%;"><p><b>TOTAL</b></p></td>
        </tr>  
      
<?php 

if(count($detalles)){
    foreach($detalles as $detalle)
    {
        $detail = product_formating($detalle);
        if($partida->id_partida == $detail['id_to_append']){            
            $this->data['detail'] = $detail;
            $this->load->view('user/documents/pdf/basic_detalles',$this->data);    
       } 
    }
}
?>
      </table>
      <br>
    </div>

<?php }
    }  ?>
<?php if($sin_partida == TRUE){   ?>
<table style="width: 100%;" cellspacing="0">

       <tr>
        <td class="ta-l bb-1" style="width:60%;"><p><b>CONCEPTO</b></p></td>
        <td class="ta-r bb-1" style="width:13%"><p><b>CANTIDAD</b></p></td>
        <td class="ta-r bb-1" style="width:13%; white-space: nowrap;"><p><b>PRECIO UND</b></p></td>
        <td class="ta-r bb-1" style="width:13%;"><p><b>TOTAL</b></p></td>
        </tr>  
      
<?php 

if(count($detalles)){
    foreach($detalles as $detalle)
    {
        if($detalle['id_partida'] == 0){            
            $detail = product_formating($detalle);
            $this->data['detail'] = $detail;
            $this->load->view('user/documents/pdf/basic_detalles',$this->data);    
       } 
    }
}
?>
      </table>
      <br>
<?php } ?>
<?php 
	$impuesto = 21;

    switch($factura->iva){
        case 1:
            $impuesto = 21;
            break;
        case 2:
            $impuesto = 10;
            break;
        case 0:
            $impuesto = 0;
            break;
    }
$subtotal=number_format($subtotal,2,'.','');
$total_iva=number_format($total_iva,2,'.','');

?>
</div>
<div class="grey-bg ta-r pl-3 pr-3 pt-1 pb-1 mw-100" style="page-break-inside: avoid;">

<table style="width:100%;padding-left: 70%;" class="ta-r">
	
    <tr>
        <td><p style="margin:0px;">SUBTOTAL:</p></td>
        <td><p style="margin:0px;"><?php echo $negative.number_format($subtotal,2,",","."); ?> €</p></td>
    </tr>
    <tr>
        <td><p style="margin:0px;"><?php echo $impuesto; ?>% IVA: </p></td>
        <td><p style="margin:0px;"><?php echo $negative.number_format($total_iva,2,",","."); ?> €</p></td>
    </tr>
    <tr>
        <td><p style="margin-top:0px;">TOTAL:</p></td>
        <td><p style="margin-top:0px;"><?php echo $negative.number_format($total_factura,2,",","."); ?> €</p></td>
    </tr>
    
    
        </table>
</div>