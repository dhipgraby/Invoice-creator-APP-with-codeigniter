<style>
.table td{
    border-top:none;
}

</style>
<table class="table table-responsive">

      <?php if(count($contactos)){
          foreach($contactos as $contacto){
              if(!empty($contacto->id)){ 
                  $c_id =$contacto->id;
              ?>
                     
                    <tr>
                        <td id="nombre<?php echo $c_id ?>"><?php echo $contacto->nombre; ?></td>
                        <td id="cargo<?php echo $c_id ?>"><?php echo $contacto->cargo; ?></td>               
                        <td id="telefono<?php echo $c_id ?>"><?php echo $contacto->telefono; ?></td>
                        <td id="email<?php echo $c_id ?>"><?php echo $contacto->email; ?></td>
                        <td>
                           <?php if($pages_access[2] == 2){  ?>
                            <div class="btn-group ml-auto">
     <button class="btn btn-sm btn-light" onclick="fill_contact_form(<?php echo $c_id ?>)" data-toggle="modal" data-target="#contactoCliente">Edit</button>
                              
                              <?php	$this->data['function'] = 'eliminar_contacto('.$c_id.')'; ?>
                              
                                <button class="btn btn-sm btn-light"
                                tabindex="0"
                                data-toggle="tooltip"
                                data-trigger="focus"
                                data-placement="right"
                                data-html="true" title="<?php $this->load->view('user/components/delete_tooltip', $this->data) ?>">
                                <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        <?php } ?>
                        </td>                   
                    </tr>
    <?php
           }
          }
         }
    ?>
    </table>

  <?php if(isset($contact_script)){ echo $contact_script; } ?>
