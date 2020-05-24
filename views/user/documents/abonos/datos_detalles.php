<tr class="bg-light pointer product-select" onclick="document.getElementById('<?php echo $detail['id_detalle'];  ?>').click();">
  <td class="ta-l form-inline" valign="top">

    <?php if ($detail['abonado'] != TRUE) {   ?>
      <label class="custom-control custom-checkbox">
        <input class="custom-control-input ml-2" type="checkbox" id="<?php echo $detail['id_detalle'];  ?>" checked>
        <span class="custom-control-label"></span>
      </label>


    <?php } else {
      $tipo = ($documento == 'presupuesto') ? 'Facturado' : 'Abonado';
      echo '<span class="badge badge-primary"><small><i class="fas fa-check"></i> ' . $tipo . '</small></span>';
    } ?>
    <p class="ml-4"> <?php echo $detail['nombre_producto'];  ?></p>
  </td>

  <td class="minw-10 ta-c" style="white-space: nowrap;" valign="top"><?php echo number_format($detail['cantidad'], 2, ",", ".") . ' <b>' . $detail['tipo'] . '</b>'; ?></td>
  <td class="minw-10 ta-r" valign="top"><?php echo $detail['precio_venta_f'] . ' ' . $simbolo_moneda; ?></td>
  <td class="minw-20 ta-r" valign="top"><?php echo $detail['precio_total_f'] . ' ' . $simbolo_moneda; ?></td>

  </td>
</tr>