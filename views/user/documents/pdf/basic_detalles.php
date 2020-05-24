<tr>
     <td class="ta-l mt-1" style="width:60%" valign="top"><p class="mt-1 mb-0"><?php echo $detail['nombre_producto'];  ?></p></td>
     <td class="ta-r mt-1 mr-2" style="width:13%;" valign="top"><p class="mt-1 mb-0"><?php echo $negative.number_format($detail['cantidad'],2,",",".").' '.$tipo; ?></p></td>
     <td class="ta-r mt-1 mr-2" style="width:13%;" valign="top"><p class="mt-1 mb-0"><?php echo $detail['precio_venta_f'].' '.$simbolo_moneda; ?></p></td>
     <td class="ta-r mt-1 mr-2" style="width:13%;" valign="top"><p class="mt-1 mb-0"><?php echo $negative.$detail['precio_total_f'].' '.$simbolo_moneda; ?></p></td>
     </tr>