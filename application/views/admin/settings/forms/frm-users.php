<form id="frm-users-settings">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    <label for="screen_name" class="font-12">SCREEN NAME</label>
		    <input type="text" class="form-control form-control-sm font-12" id="screen_name" name="screen_name" value="<?php echo !empty($data) ? $data->screen_name : ''; ?>" value="">
		    <div class="screen_name err-msg"></div>
		    <label for="last_name" class="font-12">LAST NAME</label>
		    <input type="text" class="form-control form-control-sm font-12" id="last_name" name="last_name" value="<?php echo !empty($data) ? $data->last_name : ''; ?>" value="">
		    <div class="last_name err-msg"></div>
		    <label for="first_name" class="font-12">FIRST NAME</label>
		    <input type="text" class="form-control form-control-sm font-12" id="first_name" name="first_name" value="<?php echo !empty($data) ? $data->first_name : ''; ?>" value="">
		    <div class="first_name err-msg"></div>
		    <label for="middle_name" class="font-12">MIDDLE NAME</label>
		    <input type="text" class="form-control form-control-sm font-12" id="middle_name" name="middle_name" value="<?php echo !empty($data) ? $data->middle_name : ''; ?>" value="">
		    <div class="middle_name err-msg"></div>
		    <label for="email" class="font-12">EMAIL</label>
		    <input type="text" class="form-control form-control-sm font-12" id="email" name="email" value="<?php echo !empty($data) ? $data->email : ''; ?>" value="">
		    <div class="email err-msg"></div>
		    <label for="username" class="font-12">USERNAME</label>
		    <input type="text" class="form-control form-control-sm font-12" id="username" name="username" value="<?php echo !empty($data) ? $data->username : ''; ?>" value="">
		    <div class="username err-msg"></div>
		    <?php if (!empty($has_update)): ?>
		    	<input type="hidden" class="form-control form-control-sm font-12" id="original_email" name="original_email" value="<?php echo !empty($data) ? $data->email : ''; ?>" value="">
		    	<input type="hidden" class="form-control form-control-sm font-12" id="original_username" name="original_username" value="<?php echo !empty($data) ? $data->username : ''; ?>" value="">
		    <?php else: ?>
		    	<label for="password" class="font-12">PASSWORD</label>
			    <input type="password" class="form-control form-control-sm font-12" id="password" name="password" value="">
			    <div class="password err-msg"></div>
			    <label for="confirm_password" class="font-12">CONFIRM PASSWORD</label>
			    <input type="password" class="form-control form-control-sm font-12" id="confirm_password" name="confirm_password" value="">
		    <?php endif; ?>
		    <div class="confirm_password err-msg"></div>
		    <label for="level" class="font-12">LEVEL</label>
				<select class="custom-select custom-select-sm mb-2 font-12" id="level" name="level">
				  <option value="" selected hidden>--</option>
				  <option value="0" <?php echo !empty($data) ? ($data->level == 0 ? 'selected' : '' ) : ''; ?>>Administrator</option>
				  <option value="1" <?php echo !empty($data) ? ($data->level == 1 ? 'selected' : '' ) : ''; ?>>User - Loans</option>
				  <option value="2" <?php echo !empty($data) ? ($data->level == 2 ? 'selected' : '' ) : ''; ?>>User - Collections</option>
				  <option value="3" <?php echo !empty($data) ? ($data->level == 3 ? 'selected' : '' ) : ''; ?>>User - Benefits</option>
				  <option value="4" <?php echo !empty($data) ? ($data->level == 4 ? 'selected' : '' ) : ''; ?>>Guest</option>
				</select>
				<div class="level err-msg"></div>
		    <label for="designation" class="font-12">DESIGNATION</label>
		    <input type="text" class="form-control form-control-sm font-12" id="designation" name="designation" value="<?php echo !empty($data) ? $data->designation : ''; ?>">
				<div class="designation err-msg"></div>
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<input type="hidden" name="has_update" value="<?php echo $has_update ?? ''; ?>">
			<button type="submit" class="btn btn-sm btn-default float-right font-12"><i class="fas fa-save"></i> Save</button>
		</div>
		
	</div>
</form>