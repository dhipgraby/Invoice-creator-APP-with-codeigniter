<div align="center">
    <label for="numero_factura">ID Factura</label>
    <input type="number" class="form-control" style="max-width:300px" id="numero_factura">
    <br>
    <div class="btn-group">

        <button class="btn btn-light" onclick="buscar('get_detalles')"><i class="fas fa-search"></i> Detalles</button>
        <button class="btn btn-light ml-3" onclick="buscar('get_partidas')"> <i class="fas fa-search"></i> Partidas</button>

    </div>
    <br>
    <h3 class="mt-4"><i class="fas fa-globe-africa"></i> Resultados</h3>

    <br>
    <table class="table" id="res_tab">

    </table>
</div>

<script>
    function buscar(name) {
        var id = $('#numero_factura').val();
        var table = $('#res_tab');
        if (id < 1) {
            var msg = alert_msg('Escriba un id de factura', 'warning');
            $('#resultados').html(msg);
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>documentos/ver/" + name + "/" + id,
            data: {},
            success: function(datos) {
                var array = JSON.parse(datos);                
                if (name == 'get_detalles') {
                  table.html('<tr><td>ID</td><td>ID Producto</td><td>ID Partida</td><td>Cantidad</td><td>P-Venta</td></tr>');
                  for(var i = 0; i < array.length;i++){
                    table.append('<tr><td>'+array[i].id_detalle+'</td><td>'+array[i].id_producto+'</td></td><td>'+array[i].id_partida+'</td><td>'+array[i].cantidad+'</td><td>'+array[i].precio_venta+'</td></tr>');
                  }
                }
                if (name == 'get_partidas') {
                    table.html('<tr><td>ID</td><td>Nombre</td><td>Old ID</td></tr>');
                    for(var i = 0; i < array.length;i++){
                    table.append('<tr><td>'+array[i].id_partida+'</td><td>'+array[i].nombre_partida+'</td><td>'+array[i].old_id+'</td></tr>');
                  }
                }

                var msg = alert_msg('Busqueda finalizada', 'success');
                $("#resultados").html(msg);
                disable_alert();
            }

        });
    }
</script>