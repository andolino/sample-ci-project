<form id="frm-loan-types">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    
		    <label for="loan_code" class="font-12">LOAN CODE</label>
		    <input type="text" class="form-control form-control-sm font-12" id="loan_code" name="loan_code" value="<?php echo !empty($data) ? $data->loan_code : ''; ?>" required>
		    <div class="office_code err-msg"></div>

		    <label for="loan_type_name" class="font-12">LOAN TYPE</label>
		    <input type="text" class="form-control form-control-sm font-12" id="loan_type_name" name="loan_type_name" value="<?php echo !empty($data) ? $data->loan_type_name : ''; ?>" required>
		    <div class="loan_type_name err-msg"></div>
		    <input type="hidden" class="" name="entry_date" value="<?php echo date('Y-m-d'); ?>">
		    <input type="hidden" class="" name="original_val" value="<?php echo !empty($data) ? $data->loan_code : ''; ?>">
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<input type="hidden" name="has_update" value="<?php echo $has_update ?? ''; ?>">
			<button type="submit" class="btn btn-sm btn-default float-right font-12"><i class="fas fa-save"></i> Save</button>
		</div>
		
	</div>
</form>