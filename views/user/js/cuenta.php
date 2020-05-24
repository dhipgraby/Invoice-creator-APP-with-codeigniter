<script>
     var datos = <?php echo (!isset($perfil)) ? '0' : $perfil; ?>;

     $("#guardar").click(function() {

          guardar();

     });

     function guardar() {

          var parametros = $('#datos_empresa').serialize();

          $.ajax({
               type: "POST",
               url: "<?php echo base_url() ?>cuenta/guardar",
               data: parametros,
               success: function(data) {
                    $("#resultados").html(data);
                    disable_alert();
               }
          });
     }

     $('#upload_form').on('submit', function(e) {
          e.preventDefault();
          if ($('#image_file').val() == '') {
               alert("Seleccione una imagen");
          } else {

               $.ajax({
                    url: "<?php echo base_url(); ?>cuenta/do_upload",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                         var array = JSON.parse(data);

                         switch (array.result) {
                              case 'success':
                                   $("#resultados").html(array.msg);
                                   $('#current_logo').attr('src', array.img);
                                   break;
                              case 'error':
                                   $('#resultados').html(array.msg);                                   
                                   break;
                         }
                         disable_alert();
                    }
               });
          }
     });


     fill_info(datos);

     function fill_info(datos) {

          var datosArr = Object.entries(datos);
          for (var i = 0; i < datosArr.length; i++) {

               $('#' + datosArr[i][0]).val(datosArr[i][1]);

          }
     }
</script>