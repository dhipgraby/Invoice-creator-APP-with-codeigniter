
<table style="width:100%">
<tr>
<td class="mw-60">
         
<h4 class="mb-0 mt-0"><b>CLIENT</b></h4>

<p style="border-top:solid 1px #000; padding-top:10px">
     <?php echo  $cliente->cif ?>
<br>
     <?php echo  $cliente->nombre_cliente ?>
<br>
     <?php echo  $cliente->direccion_cliente.'<br>'.$cliente->cp_cliente.' - '.$cliente->poblacion_cliente; ?>
<br>
     Phone. <?php echo  $cliente->telefono_cliente ?>
<br>
     <?php echo  $cliente->email_cliente ?>
     </p>           

</td>

<td class="mw-40 " >    
<br>
    <table class="mb-1 mw-100">
     
<td class="ta-r">
        <p>

        <b>Invoice N°:</b><br>
        <?php if($documento =='abono'){ echo '<b>Corrige factura N°:</b><br>';  } ?>
        <b>Date:</b><br>
        <b>Expiration date:</b><br>
        <b>Attended by:</b>  

        </p>
</p>
        
        <td class="ta-r">
          <p>
         <?php echo $factura->numero_factura.' / '.substr(date('Y',strtotime($factura->fecha_factura)),2,4); ?><br>
         <?php if($documento =='abono'){ echo $factura_original.' / '.substr(date('Y',strtotime($factura->fecha_factura)),2,4).'<br>';  } ?>
         <?php echo date('d/m/Y',strtotime($factura->fecha_factura)) ?><br>
         <?php echo date('d/m/Y',strtotime($factura->vencimiento)) ?><br>
         <?php echo $user->firstname; ?>
         </p>
         </td>
  
    </table>  

</td>

</tr>


</table> 

