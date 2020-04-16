<form id="frm-sub-acct">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    <label for="class_code" class="font-12">SELECT ACCOUNT</label>
				<select class="custom-select custom-select-sm" id="class_code" name="class_code">
				  <option selected hidden>--</option>
				  <?php foreach ($acctClass as $row): ?>
				  	<option value="<?php echo $row->class_code; ?>"><?php echo $row->class_desc; ?></option>
				  <?php endforeach; ?>
				</select>
		    <label for="sub-name" class="font-12">SUB NAME</label>
		    <input type="text" class="form-control form-control-sm" id="sub-name" name="sub-name" required>
		    <input type="hidden" class="" name="acctType" value="account_groups">
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<button type="submit" class="btn btn-sm btn-default float-right"><i class="fas fa-save"></i> Save</button>
		</div>
		
	</div>
</form>