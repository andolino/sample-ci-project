<form id="frm-benefit-type-settings">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    <label for="type_of_benefit" class="font-12">BENEFIT TYPE</label>
		    <input type="text" class="form-control form-control-sm font-12" id="type_of_benefit" name="type_of_benefit" value="<?php echo !empty($data) ? $data->type_of_benefit : ''; ?>" required>
		    <div class="type_of_benefit err-msg"></div>
		    <label for="min_amnt" class="font-12 pt-2">MINIMUM AMOUNT</label>
		    <input type="text" class="form-control form-control-sm font-12" id="min_amnt" name="min_amnt" value="<?php echo !empty($data) ? $data->min_amnt : ''; ?>" required>
		    <div class="min_amnt err-msg"></div>
		    <label for="min_amnt" class="font-12 pt-2">MULTI CLAIM</label>
		    
		    <div class="custom-control custom-radio">
					  <input type="radio" id="ra1" name="multi_claim" value="1" class="custom-control-input" <?php echo !empty($data) ? ($data->multi_claim == 1 ? 'checked' : '') : ''; ?>>
					  <label class="custom-control-label font-12" for="ra1">Yes</label>
					</div>
					<div class="custom-control custom-radio">
					  <input type="radio" id="ra2" name="multi_claim" value="0" class="custom-control-input" <?php echo !empty($data) ? ($data->multi_claim == 0 ? 'checked' : '') : ''; ?>>
					  <label class="custom-control-label font-12" for="ra2">No</label>
					</div>

		    <div class="min_amnt err-msg"></div>
		    <input type="hidden" class="" name="entry_date" value="<?php echo date('Y-m-d'); ?>">
		    <input type="hidden" class="" name="original_val" value="<?php echo !empty($data) ? $data->type_of_benefit : ''; ?>">
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<input type="hidden" name="has_update" value="<?php echo $has_update ?? ''; ?>">
			<button type="submit" class="btn btn-sm btn-default float-right font-12"><i class="fas fa-save"></i> Save</button>
		</div>
		
	</div>
</form>