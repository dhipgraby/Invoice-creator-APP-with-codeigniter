	
<table cellspacing="0" style="width: 100%; justify-content:center;" class="mb-2">
        <tr>
        <td style="width: 60%;">
            <div style="width:auto;" class="ta-l" align="center">
               
            <h4 class="mb-1"><b ><?php echo ucwords($perfil->nombre_empresa); ?></b></h4>
            
                <p style="font-size: 12px;margin:0px">
                <?php echo $perfil->direccion; ?><br>
                <?php echo $perfil->codigo_postal; ?> - <?php echo $perfil->poblacion; ?><br>
                Tel. <?php echo $perfil->telefono; ?>  -  CIF: <?php echo $perfil->cif; ?><br>
                <?php echo $perfil->email; ?>
              
                </p>
           
            </td>  
           <td style="width: 40%;" class="ta-c" valign="top"> 
           
           <!-- LOGO -->
             <img src="images/<?php echo $perfil->logo_url; ?>" class="logo mt-1" ><br>
             
                
                </td>

             
        </tr>
    </table>