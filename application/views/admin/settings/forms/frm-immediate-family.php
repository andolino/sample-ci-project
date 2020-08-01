<form id="frm-immediate-family-settings">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    <label for="name" class="font-12">NAME</label>
		    <input type="text" class="form-control form-control-sm font-12" id="name" name="name" value="<?php echo !empty($data) ? $data->name : ''; ?>" required>
		    <div class="name err-msg"></div>
		    <label for="relationship_type_id" class="font-12">RELATIONSHIP TYPE</label>
		    <select class="custom-select custom-select-sm mb-2 font-12" id="relationship_type_id" name="relationship_type_id">
				  <option value="" hidden>--</option>
				  <?php foreach ($rtype as $row): ?>
				  	<option value="<?php echo $row->relationship_type_id; ?>" <?php echo !empty($data) ? ($row->relationship_type_id == $data->relationship_type_id ? 'selected' : '') : ''; ?>><?php echo $row->rel_type; ?></option>
				  <?php endforeach; ?>
				</select>
		    <!-- <label for="office_name" class="font-12">OFFICE NAME</label>
		    <input type="text" class="form-control form-control-sm font-12" id="office_name" name="office_name" value="<?php //echo !empty($data) ? $data->office_name : ''; ?>" required> -->
		    <div class="office_name err-msg"></div>	
		    <input type="hidden" class="" name="entry_date" value="<?php echo date('Y-m-d'); ?>">
		    <input type="hidden" class="" name="members_id" value="<?php echo !empty($data) ? $data->members_id : $members_id; ?>">
		    <input type="hidden" class="" name="original_val" value="<?php echo !empty($data) ? $data->name : ''; ?>">
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<input type="hidden" name="has_update" value="<?php echo !empty($data) ? $data->immediate_family_id : ''; ?>">
			<button type="submit" class="btn btn-sm btn-default float-right font-12"><i class="fas fa-save"></i> Save</button>
		</div>
		
	</div>
</form>	