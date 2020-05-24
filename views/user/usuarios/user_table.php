
<div class="card" role="document">

        <div class="modal-header">
            <h4 class="modal-title">Gestión de usuarios</h4>

        </div>
      
        <div class="modal-body table-responsive">
            <table class="table u-table">
            <tr>   
            <td><i class="fas fa-id-card"></i> Email</td>
                <?php if ($config_access[1] == 2) { ?>
                <td class="ta-l"><i class="fas fa-unlock"></i> Estatus</td>
             
                    <td class="ta-r"><i class="fas fa-layer-group"></i> Privilegios</td>
                    <td class="ta-r"><i class="fas fa-sliders-h" aria-hidden="true"></i> Opciones</td>
                <?php } ?>
                </tr>
             
                <?php if (count($users)) {
             
                    foreach ($users as $key) {
                        echo '<tr>';
                        switch ($key->status) {
                            case 1:
                                $status = '<span class="badge badge-success" id="status-'.$key->id.'">Activo</span>
                                 <div class="switch-button switch-button-yesno">
                                <input type="checkbox"  id="check-'.$key->id.'" checked autocomplete="off">
                                <span><label onclick="change_option('.$key->id.')"></label></span></div>';
                                break;
                            case 2:
                                $status = '<span class="badge badge-info">Proceso de validación</span>';
                                break;
                            case 3:
                                $status = '<span class="badge badge-warning" id="status-'.$key->id.'">Inactivo</span>
                                 <div class="switch-button switch-button-yesno">
                                <input type="checkbox" id="check-'.$key->id.'"  autocomplete="off">
                                <span><label onclick="change_option('.$key->id.')"></label></span></div>';
                                break;
                        }
                        echo '<td>' . $key->email . '</td>';
                        if ($config_access[1] == 2) {
                        echo '<td class="ta-l">'. $status .'</td>';
                         ?>
                            <td class="ta-r">
                                <button class="btn btn-primary btn-sm ml-2" onclick="set_pages_priv('<?php echo $key->user_id ?>','<?php echo $key->pages_priv; ?>');set_config_priv('<?php echo $key->config_priv; ?>');" data-toggle="modal" data-target="#privilegios">
                                    <i class="fas fa-align-left"></i> Asignar
                                </button>
                            </td>
                            <td class="blue pointer ta-r">
                                <?php if($key->status != 2) {  ?><i onclick="fill_user('<?php echo $key->user_id ?>')" data-toggle="modal" data-target="#editarUsuario" class="fas fa-edit"></i><?php } ?>
                                <?php $this->data['function'] = 'delete_user(' . $key->id . ')'; ?>
                                <i tabindex="0" id="<?php echo $key->id ?>" data-user-id="<?php echo $key->user_id ?>" data-toggle="tooltip" data-trigger="focus" data-placement="left" data-html="true" title="<?php $this->load->view('user/components/delete_tooltip', $this->data) ?>" class="fas fa-trash-alt ml-2"></i>
                             </td>
                           
                <?php
                        }
                        echo '</tr>';  }
                   } ?>
         
            </table>
        </div>

    </div>
</div>