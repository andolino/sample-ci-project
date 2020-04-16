<form id="frm-sub-acct">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    <label for="group_code" class="font-12">SELECT ACCOUNT</label>
				<select class="custom-select custom-select-sm mb-2" id="group_code" name="group_code" required>
				  <?php foreach ($acctGroups as $row): ?>
				  	<option value="<?php echo $row->group_code; ?>"><?php echo $row->group_desc; ?></option>
				  <?php endforeach; ?>
				</select>
		    <label for="normal_bal" class="font-12">NORMAL BALANCE</label>
				<select class="custom-select custom-select-sm mb-2" id="normal_bal" name="normal_bal" required>
				  <option value="Dr">Debit</option>
				  <option value="Cr">Credit</option>
				</select>
		    <label for="main-name" class="font-12">MAIN NAME</label>
		    <input type="text" class="form-control form-control-sm mb-2" id="main-name" name="main-name" required>
		    <label for="code" class="font-12">CODE</label>
		    <input type="text" class="form-control form-control-sm mb-2" id="code" name="code" required>
		    <input type="hidden" class="" name="acctType" value="account_main">
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<button type="submit" class="btn btn-sm btn-default float-right"><i class="fas fa-save"></i> Save</button>
		</div>
		
	</div>
</form>