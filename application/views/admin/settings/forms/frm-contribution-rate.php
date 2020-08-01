<form id="frm-contribution-rate">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		    <label for="rate" class="font-12">CONTRIBUTION RATE</label>
		    <input type="text" class="form-control form-control-sm font-12 isNum" id="rate" name="rate" value="<?php echo !empty($cr) ? $cr->rate : ''; ?>" required>
		  </div>
		  <div class="form-group">
		    <label for="cash_gift" class="font-12">CASH GIFT RATE</label>
		    <input type="text" class="form-control form-control-sm font-12 isNum" id="cash_gift" name="cash_gift" value="<?php echo !empty($cr) ? $cr->cash_gift : ''; ?>" required>
		  </div>
		</div>
		<div class="col-12">
			<input type="hidden" name="has_update" value="<?php echo !empty($cr) ? $cr->contribution_rate_id : ''; ?>">
			<button type="submit" class="btn btn-sm btn-default float-right font-12"><i class="fas fa-save"></i> Update</button>
		</div>
		
	</div>
</form>	