<form id="frm-subsidiary-settings">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    <label for="code" class="font-12">ACCOUNT CODE</label>
		    <select class="custom-select custom-select-sm mb-2 font-12" id="code" name="code">
				  <option value="" hidden>--</option>
				  <?php foreach ($mainAccnt as $row): ?>
				  	<option value="<?php echo $row->code; ?>" <?php echo !empty($data) ? ($row->code == $data->code ? 'selected' : '') : ''; ?>><?php echo $row->code . ' - ' . $row->main_desc; ?></option>
				  <?php endforeach; ?>
				</select>
		    <div class="signatory_name err-msg"></div>
		    <label for="employee_id" class="font-12">ID NO</label>
		    <select class="custom-select custom-select-sm mb-2 font-12" id="employee_id" name="employee_id" required>
				  <option value="" hidden>--</option>
				  <?php foreach ($membersData as $row): ?>
				  	<option value="<?php echo $row->id_no; ?>" <?php echo !empty($data) ? ($row->id_no == $data->employee_id ? 'selected' : '') : ''; ?>><?php echo $row->id_no . ' - ' . strtoupper($row->last_name . ', ' . $row->first_name); ?></option>
				  <?php endforeach; ?>
				</select>
		    <label for="name" class="font-12">NAME</label>
		    <input type="text" class="form-control form-control-sm font-12" id="name" name="name" value="<?php echo !empty($data) ? $data->name : ''; ?>" required>
		    <label for="name" class="font-12">SUB CODE</label>
		    <input type="text" class="form-control form-control-sm font-12" id="sub_code" name="sub_code" value="<?php echo !empty($data) ? $data->sub_code : ''; ?>" required>
		    <div class="designation err-msg"></div>
		    <input type="hidden" class="" name="entry_date" value="<?php echo date('Y-m-d'); ?>">
		    <input type="hidden" class="" name="original_val" value="<?php echo !empty($data) ? $data->sub_code : ''; ?>">
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<input type="hidden" name="has_update" value="<?php echo $has_update ?? ''; ?>">
			<button type="submit" class="btn btn-sm btn-default float-right font-12"><i class="fas fa-save"></i> Save</button>
		</div>
		
	</div>
</form>