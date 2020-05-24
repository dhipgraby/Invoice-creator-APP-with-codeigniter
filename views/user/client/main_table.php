<table class="table table-responsive">
				<tr  class="blue-little-box opacity-9">
					
					<th class="minw-30"><i class="far fa-calendar-alt"></i> Nombre</th>
					<th class="minw-10"><i class="fas fa-phone" aria-hidden="true"></i> Telefono</th>
					<th class="minw-10"><i class="fas fa-envelope" aria-hidden="true"></i> Email</th>
					<th class="minw-30"><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Dirrección</th>
					<th class='ta-c minw-10'><i class="far fa-calendar-alt" aria-hidden="true"></i></th>
                    <th class='ta-c minw-10'><i class="fas fa-sliders-h"></i> Acciones</th>
                </tr>
          

                                    <?php 
									
										
										foreach($clientes as $client){
									    $date = date_create($client['date_added']);
										$fecha= date_format($date,'d-m-y');

										if(!empty($client['id_cliente'])){ 
									
									?>  <tr>

                                      <th class="minw-30"><?php echo $client['nombre_cliente']; ?></th> 
                                      
                                      <th class="minw-10"><?php echo $client['telefono_cliente']; ?></th> 
                                      
                                      <th class="minw-10"><?php echo $client['email_cliente']; ?></th> 
                                      
                                      <th class="minw-30"><?php echo $client['direccion_cliente']; ?></th> 
                                      
                                      <th class="minw-10 ta-c"><?php echo $fecha; ?></th>
                                     
									  <th class="ta-c minw-10">
									  
									  <div class="btn-group">
									      
											<?php
											 $url = "'clientes/editar/".$client['id_cliente']."'";
											 $perfil_url = "'clientes/ver/".$client['id_cliente']."'";											 
											 $go_perfil = 'onclick="go_to('.$perfil_url.')"';
								
											 echo new_button('<i class="fas fa-eye"></i>','','primary',$go_perfil);
											 if($pages_access[2] == 2){ 
												$this->data['function'] = 'eliminar_cliente('.$client['id_cliente'].')';
												 ?>
												 <button class="btn btn-warning ml-2"
												tabindex="0"
												data-toggle="tooltip"
												data-trigger="focus"
												data-placement="right"
												data-html="true" title="<?php $this->load->view('user/components/delete_tooltip', $this->data) ?>">
												<i class="fas fa-trash-alt"></i></button>										
											<?php } ?>									       
									      </div></th>
									  </tr>
									<?php 
										}
									}

                                ?>
               
<?php if(isset($script)){ echo $script; } ?>
            </table>