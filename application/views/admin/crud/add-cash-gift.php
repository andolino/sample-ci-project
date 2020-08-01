<form id="frm-cash-gift">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
				<label for="select_members_cash_gift" class="font-12 mt-2">MEMBER</label>
				<select class="custom-select custom-select-sm" id="select_members_cash_gift" name="members_id" required>
				  <option value="" selected hidden>--</option>
					<?php foreach ($membersData as $row): ?>
						<option value="<?php echo $row->members_id; ?>" <?php echo !empty($data) && $data->members_id == $row->members_id ? 'selected' : ''; ?>><?php echo strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name); ?></option>
					<?php endforeach; ?>
				</select>
		    <label for="amount" class="font-12 mt-2">AMOUNT</label>
		    <input type="text" class="form-control form-csontrol-sm font-12 isNum" id="amount" name="amount" value="<?php echo !empty($data) ? number_format($data->amount, 2) : ''; ?>" required>
		    
		    <label for="date_applied" class="font-12 mt-2">DATE APPLIED</label>
		    <input type="text" class="form-control form-csontrol-sm font-12" id="date_applied" name="date_applied" value="<?php echo !empty($data) ? date('m/d/Y', strtotime($data->date_applied)) : ''; ?>" required>
		    
		    <label for="remarks" class="font-12 mt-2">REMARKS</label>
		    <input type="text" class="form-control form-control-sm font-12" id="remarks" name="remarks" value="<?php echo !empty($data) ? $data->remarks : ''; ?>">
		    <input type="hidden" name="has_update" value="<?php echo !empty($data) ? number_format($data->members_id, 2) : ''; ?>">
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<button type="submit" class="btn btn-sm btn-default float-right"><i class="fas fa-save"></i> Save</button>
		</div>
		
	</div>
</form>