
<?php $this->data['function'] = 'eliminar('.$detail['id_detalle'].','.$detail['id_producto'].')'; ?>

 <tr>
  <td class="minw-60 ta-l" valign="top"><?php echo $detail['nombre_producto'];  ?></td>
  <td class="minw-10 ta-c" valign="top"><?php echo $negative.number_format($detail['cantidad'],2,",",".").' <b>'.$detail['tipo'].'</b>'; ?></td>
  <td class="minw-10 ta-r" valign="top"><?php echo $detail['precio_venta_f'].' '.$simbolo_moneda; ?></td>
  <td class="minw-20 ta-r" valign="top"><?php echo $negative.$detail['precio_total_f'].' '.$simbolo_moneda; ?></td>
  <td  class="minw-10 ta-c black"><i onclick='editar_producto(<?php echo $detail["id_producto"] ?>)' class='fas fa-edit pointer blue'></i></td>   
  <td  class="minw-10 ta-c black"><i 
  tabindex="0"  data-toggle="tooltip"  data-trigger="focus"
   data-placement="left"
   data-html="true" 
   title="<?php $this->load->view('user/components/delete_tooltip',$this->data) ?>"
   class='fas fa-trash-alt blue pointer'></i></td>
  </td>
</tr>
