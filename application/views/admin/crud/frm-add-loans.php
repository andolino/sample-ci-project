<form id="frm-add-loans">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    <label for="loan_code" class="font-12">LOAN CODE</label>
				<select class="custom-select custom-select-sm mb-2" id="loan_code" name="loan_code" required>
				  <option value="" selected hidden>--</option>
					<?php foreach ($loanCode as $row): ?>
						<option value="<?php echo $row->loan_code_id; ?>" <?php echo !empty($loanSettingsData) && $loanSettingsData->loan_code_id == $row->loan_code_id ? 'selected' : ''; ?>><?php echo $row->loan_code; ?></option>
					<?php endforeach; ?>
				</select>
		    <label for="no_month" class="font-12">NUMBER OF MONTH</label>
		    <input type="number" class="form-control form-control-sm" id="no_month" name="no_month" value="<?php echo !empty($loanSettingsData) ? $loanSettingsData->number_of_month : ''; ?>" required>
		    <label for="int_per_annum" class="font-12">INTEREST PER ANNUM</label>
		    <input type="text" class="form-control form-control-sm isNum" id="int_per_annum" name="int_per_annum" value="<?php echo !empty($loanSettingsData) ? number_format($loanSettingsData->int_per_annum, 2) : ''; ?>" required>
		    <label for="lri" class="font-12">LRI(%)</label>
		    <input type="text" class="form-control form-control-sm isNum" id="lri" name="lri" value="<?php echo !empty($loanSettingsData) ? number_format($loanSettingsData->lri, 2) : ''; ?>" required>
		    <label for="svc" class="font-12">SVC</label>
		    <input type="text" class="form-control form-control-sm isNum" id="svc" name="svc" value="<?php echo !empty($loanSettingsData) ? number_format($loanSettingsData->svc, 2) : ''; ?>" required>
		    <label for="repayment_period" class="font-12">REPAYMENT PERIOD</label>
		    <input type="text" class="form-control form-control-sm isNum" id="repayment_period" name="repayment_period" value="<?php echo !empty($loanSettingsData) ? number_format($loanSettingsData->repymnt_period, 2) : ''; ?>" required>
		    <label for="monthly_interest" class="font-12">MONTHLY INTEREST(%)</label>
		    <input type="text" class="form-control form-control-sm isNum" id="monthly_interest" name="monthly_interest" value="<?php echo !empty($loanSettingsData) ? number_format($loanSettingsData->monthly_interest, 2) : ''; ?>" required>

		    <input type="hidden" name="loan_settings_id" value="<?php echo !empty($loanSettingsData) ? number_format($loanSettingsData->loan_settings_id, 2) : ''; ?>">
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<button type="submit" class="btn btn-sm btn-default float-right"><i class="fas fa-save"></i> Save</button>
		</div>
		
	</div>
</form>