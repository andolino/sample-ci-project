<form>
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    <label for="date_applied" class="font-12 mt-2">DATE APPLIED</label>
		    <input type="text" class="form-control form-csontrol-sm font-12" id="date_applied" name="date_applied" value="" required>
		    <label for="remarks" class="font-12 mt-2">REMARKS</label>
		    <input type="text" class="form-control form-control-sm font-12" id="remarks" name="remarks" value="">
				<label for="date_applied" class="font-12 mt-2">REGION</label>
				<select class="custom-select custom-select-sm" id="select_region_cash_gift" name="departments_id" required>
				  <option value="" selected hidden>--</option>
					<?php foreach ($officeManagement as $row): ?>
						<option value="<?php echo $row->departments_id; ?>"><?php echo strtoupper($row->region); ?></option>
					<?php endforeach; ?>
				</select>
		  </div>
		</div>
		
	</div>
</form>