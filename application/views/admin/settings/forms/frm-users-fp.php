<form id="frm-users-settings">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    <label for="password" class="font-12">NEW PASSWORD</label>
		    <input type="password" class="form-control form-control-sm font-12" id="password" name="password" value="">
		    <div class="password err-msg"></div>
		    <label for="confirm_password" class="font-12">CONFIRM NEW PASSWORD</label>
		    <input type="password" class="form-control form-control-sm font-12" id="confirm_password" name="confirm_password" value="">
		    <div class="confirm_password err-msg"></div>
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<input type="hidden" name="has_update" value="<?php echo $has_update ?? ''; ?>">
			<button type="submit" class="btn btn-sm btn-default float-right font-12"><i class="fas fa-save"></i> Save</button>
		</div>
		
	</div>
</form>