<form id="frm-departments-settings">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    <label for="region" class="font-12">REGION</label>
		    <input type="text" class="form-control form-control-sm font-12" id="region" name="region" value="<?php echo !empty($data) ? $data->region : ''; ?>" required>
		    <div class="region err-msg"></div>
		    <label for="short" class="font-12">SHORT</label>
		    <input type="text" class="form-control form-control-sm font-12" id="short" name="short" value="<?php echo !empty($data) ? $data->short : ''; ?>" required>
		    <label for="cash_gift_rate" class="font-12">CASH GIFT RATE</label>
		    <input type="text" class="form-control form-control-sm font-12 isNum" id="cash_gift_rate" name="cash_gift_rate" value="<?php echo !empty($data) ? $data->cash_gift_rate : ''; ?>" required>
		    <label for="contribution_rate" class="font-12">CONTRIBUTION RATE</label>
		    <input type="text" class="form-control form-control-sm font-12 isNum" id="contribution_rate" name="contribution_rate" value="<?php echo !empty($data) ? $data->contribution_rate : ''; ?>" required>
		    <div class="short err-msg"></div>
		    <label for="place" class="font-12">PLACE</label>
		    <select class="custom-select custom-select-sm mb-2 font-12" id="place" name="place">
				  <option value="" hidden>--</option>
					<option value="CENTRAL OFFICE" <?php echo !empty($data) ? ($data->place == 'CENTRAL OFFICE' ? 'selected' : '') : ''; ?>>CENTRAL OFFICE</option>
					<option value="REGION OFFICE" <?php echo !empty($data) ? ($data->place == 'REGION OFFICE' ? 'selected' : '') : ''; ?>>REGION OFFICE</option>
				</select>
		    <!-- <label for="office_name" class="font-12">OFFICE NAME</label>
		    <input type="text" class="form-control form-control-sm font-12" id="office_name" name="office_name" value="<?php //echo !empty($data) ? $data->office_name : ''; ?>" required> -->
		    <div class="office_name err-msg"></div>
		    <input type="hidden" class="" name="entry_date" value="<?php echo date('Y-m-d'); ?>">
		    <input type="hidden" class="" name="original_val" value="<?php echo !empty($data) ? $data->region : ''; ?>">
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<input type="hidden" name="has_update" value="<?php echo $has_update ?? ''; ?>">
			<button type="submit" class="btn btn-sm btn-default float-right font-12"><i class="fas fa-save"></i> Save</button>
		</div>
		
	</div>
</form>	