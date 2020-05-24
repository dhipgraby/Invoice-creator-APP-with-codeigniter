<script>

$("#actualizar").click(function() {
				  
				  var parametros = $('#datos_usuario').serialize();
				  var password= $('#password_validation').val();
				  parametros += '&password='+password;
				 
				  $.ajax({
							 type: "POST",
							 url: "<?php echo base_url() ?>perfil/editar",
							 data: parametros,					 
							 success: function(datos){						 
								 $("#resultados").html(datos);								 
								 $('#passConfirm').modal('hide');
								 disable_alert();							
						   }
					 });					 
				 });

$("#change_password").click(function() {
				  
	var password = $('#password').val();			 
	var new_password = $('#new_password').val();			 
	var password_confirm = $('#password_confirm').val();			 
   
				  $.ajax({
							 type: "POST",
							 url: "<?php echo base_url() ?>perfil/change_password",
							 data: { password,new_password,password_confirm },					 
							 success: function(datos){
						         $("#resultados").html(datos);
								 disable_alert();								
						   }
					 });					 
				 });
</script>