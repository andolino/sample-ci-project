<div class="card rounded-0">
	<div class="card-body row">
		
		<div class="col-4">
			<label class="card-title font-12">Official Station</label>
			<p class="card-text font-12"><?php echo strtoupper($data[0]->office_name); ?></p>
		</div>
		<div class="col-4">
			<label class="card-title font-12">Member of Effectivity</label>
			<p class="card-text font-12 p-member-eff"><?php echo date('Y-m-d', strtotime($data[0]->date_of_effectivity)); ?></p>
		</div>
		<div class="col-4">
			<label class="card-title font-12">Claim Date</label>
			<input type="date" class="form-control form-control-sm font-12 rounded-0" id="claim_date" name="claim_date" value="<?php echo !empty($claimedData) ? $claimedData->claim_date : ''; ?>">
		</div>
		<div class="col-4 mt-3">
			<label class="card-title font-12">Other Benefit (%)</label>
			<input type="text" class="form-control form-control-sm font-12 rounded-0" id="other_benefit" name="other_benefit" value="" readonly="">
		</div>
		<div class="col-4 mt-3">
			<label class="card-title font-12">Amount to Claim</label>
			<input type="text" class="form-control form-control-sm font-12 rounded-0" id="amnt_claim" name="amnt_claim" value="<?php echo number_format($benefitType->min_amnt, 2); ?>">
			<input type="hidden" class="form-control form-control-sm font-12 rounded-0" id="org_amnt_claim" name="org_amnt_claim" value="<?php echo number_format($benefitType->min_amnt, 2); ?>">
		</div>
		<div class="line mt-3 mb-3 pt-0 pb-0"></div>
		

		<div class="col-4 offset-8">
			<button type="submit" class="btn btn-default btn-sm rounded-0 border float-right font-12"><i class="fas fa-save"></i> Claim</button>
		</div>
	</div>
</div>
<input type="hidden" id="has_update" name="has_update" value="<?php echo !empty($claimedData) ? $claimedData->claimed_benefit_id : ''; ?>">
