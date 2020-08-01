<div class="row">
<div class="col-4 mb-3">
	<label class="card-title font-12">Other Benefit (%) (P20,000.00)</label>
	<input type="text" class="form-control form-control-sm font-12 rounded-0" id="other_benefit" name="other_benefit" value="" readonly="">
</div>
<div class="col-12">
	<table class="table font-12">
		<tr>
			<td colspan="2"><label class="card-title font-12">Sickness</label></td>
			<td></td>
			<td></td>
			<td></td>
			<td><input type="text" class="form-control form-control-sm font-12 rounded-0 text-right" id="sickness" name="sickness" readonly="" value=""></td>
		</tr>
		<tr>
			<td colspan="2"><label class="card-title font-12">Death of Immediate Family</label></td>
			<td></td>
			<td></td>
			<td></td>
			<td><input type="text" class="form-control form-control-sm font-12 rounded-0 text-right" id="doif" name="doif" readonly="" value=""></td>
		</tr>
		<tr>
			<td colspan="2"><label class="card-title font-12">Accident</label></td>
			<td></td>
			<td></td>
			<td></td>
			<td><input type="text" class="form-control form-control-sm font-12 rounded-0 text-right" id="accident" name="accident" readonly="" value=""></td>
		</tr>
		<tr>
			<td colspan="2"><label class="card-title font-12">Calamity/Fire</label></td>
			<td></td>
			<td></td>
			<td></td>
			<td><input type="text" class="form-control form-control-sm font-12 rounded-0 text-right" id="calamity" name="calamity" readonly="" value=""></td>
		</tr>
		<?php foreach($prevClaimedBenefit as $row): ?>
			<tr>
				<td colspan="2"><label class="card-title font-12">LESS:</label></td>
				<td colspan="3" class="font-12 text-right"><?php echo $row->type_of_benefit; ?></td>
				<td class="text-right font-weight-bold less-prev-benefit"><?php echo number_format($row->total_claim, 2); ?></td>
			</tr>
		<?php endforeach; ?>
			<tr>
				<td colspan="2"><label class="card-title font-12"></label></td>
				<td colspan="3" class="font-12 text-right font-weight-bold">TOTAL BENEFITS:</td>
				<td class="text-right font-weight-bold total-other-benefit"></td>
			</tr>
	</table>
</div>
</div>