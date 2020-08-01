<form id="frm-office-settings">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    <label for="office_code" class="font-12">OFFICE CODE</label>
		    <input type="text" class="form-control form-control-sm font-12" id="office_code" name="office_code" value="<?php echo !empty($data) ? $data->office_code : ''; ?>" required>
		    <div class="office_code err-msg"></div>
		    <label for="office_name" class="font-12">OFFICE NAME</label>
		    <input type="text" class="form-control form-control-sm font-12" id="office_name" name="office_name" value="<?php echo !empty($data) ? $data->office_name : ''; ?>" required>
		    <div class="office_name err-msg"></div>
		    <label for="departments_id" class="font-12">DEPARTMENTS</label>
		    <select class="custom-select custom-select-sm mb-2 font-12" id="departments_id" name="departments_id">
				  <option value="" hidden>--</option>
					<?php foreach ($dataDepartments as $row): ?>
						<option value="<?php echo $row->departments_id; ?>" <?php echo !empty($data) ? ($data->departments_id == $row->departments_id ? 'selected' : '') : ''; ?>><?php echo $row->region; ?></option>
					<?php endforeach; ?>
				</select>
		    <div class="departments_id err-msg"></div>
		    <input type="hidden" class="" name="entry_date" value="<?php echo date('Y-m-d'); ?>">
		    <input type="hidden" class="" name="original_val" value="<?php echo !empty($data) ? $data->office_code : ''; ?>">
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<input type="hidden" name="has_update" value="<?php echo $has_update ?? ''; ?>">
			<button type="submit" class="btn btn-sm btn-default float-right font-12"><i class="fas fa-save"></i> Save</button>
		</div>
		
	</div>
</form>