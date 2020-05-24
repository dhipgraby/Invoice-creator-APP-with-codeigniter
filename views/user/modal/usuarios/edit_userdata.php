
			<div class="form-group">
				<label for="edit_firstname" class="col-sm-12 control-label"> Nombre completo</label>
				<div class="col-sm-12">
				  <input type="text" class="form-control" id="edit_firstname" name="edit_firstname" value="<?php echo $user_edit->firstname ?>" placeholder="Nombre" required>				
				  <input type="text" class="form-control hidden" id="user_id" value="<?php echo $user_edit->user_id ?>">	
				</div>
			  </div>

            <div class="form-group">
				<label for="edit_user_email" class="col-sm-12 control-label"> Email</label>
				<div class="col-sm-12">
				  <input type="text" class="form-control" id="edit_user_email" name="edit_user_email" value="<?php echo $user_edit->email ?>" placeholder="Email" required>
			</div>
       		 	 