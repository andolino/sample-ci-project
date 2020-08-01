<form id="frm-signatory-settings">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    <label for="signatory_name" class="font-12">SIGNATORY</label>
		    <input type="text" class="form-control form-control-sm font-12" id="signatory_name" name="signatory_name" value="<?php echo !empty($data) ? $data->signatory_name : ''; ?>" required>
		    <div class="signatory_name err-msg"></div>
		    <label for="designation" class="font-12">DESIGNATION</label>
		    <input type="text" class="form-control form-control-sm font-12" id="designation" name="designation" value="<?php echo !empty($data) ? $data->designation : ''; ?>" required>
		    <div class="designation err-msg"></div>
		    <input type="hidden" class="" name="entry_date" value="<?php echo date('Y-m-d'); ?>">
		    <input type="hidden" class="" name="original_val" value="<?php echo !empty($data) ? $data->signatory_name : ''; ?>">
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<input type="hidden" name="has_update" value="<?php echo $has_update ?? ''; ?>">
			<button type="submit" class="btn btn-sm btn-default float-right font-12"><i class="fas fa-save"></i> Save</button>
		</div>
		
	</div>
</form>