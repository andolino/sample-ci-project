<pre>
	<?php //print_r($claimedData); ?>
</pre>
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
			<label class="card-title font-12">Accum.  Member's  Contributions</label>
			<input type="text" class="form-control form-control-sm font-12 rounded-0 isNum text-right" id="accum_mem_cont" name="accum_mem_cont" value="<?php echo !empty($accumContribution) ? $accumContribution->total : 0; ?>" readonly="">
		</div>
		<div class="col-4 mt-3">
			<label class="card-title font-12">Retirement CPFI's Share (%)</label>
			<input type="text" class="form-control form-control-sm font-12 rounded-0" id="share" name="share" readonly>
		</div>
		<div class="col-4 mt-3">
			<label class="card-title font-12">Total Share Contribution</label>
			<input type="text" class="form-control form-control-sm font-12 rounded-0 text-right" id="total_contrib" name="total_contrib" value="" readonly="">
		</div>
		<div class="col-4 mt-3">
			<div class="form-row align-items-center">
		    <div class="col-auto my-1">
		      <div class="custom-control custom-checkbox mr-sm-2">
		        <input type="checkbox" class="custom-control-input custom-control-sm" id="lbToLRI" disabled>
		        <label class="custom-control-label font-12" for="lbToLRI">Loan Balance to LRI</label>
		      </div>
		    </div>
		  </div>
		</div>
		<div class="col-4 mt-3">
			<div class="form-row align-items-center">
		    <div class="col-auto my-1">
		      <div class="custom-control custom-checkbox mr-sm-2">
		        <input type="checkbox" class="custom-control-input custom-control-sm" id="hideOthBen" value="<?php echo $data[0]->members_id; ?>" disabled>
		        <label class="custom-control-label font-12" for="hideOthBen">Hide Other Benefit</label>
		      </div>
		    </div>
		  </div>
		</div>
		<div class="col-12"></div>
		<div class="col-12 mt-2 mb-3 pr-0 pl-0" id="other-benefit-tbl-frm">
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
			
		</div>

		<table class="table font-12">
			<?php $ctr = 0; ?>
			<?php $totalLoanBalance = 0; ?>
			<?php foreach ($balance as $row): ?>
				<tr style="font-weight: 600;">
					<td style="width: 10%;"><?php echo $ctr==0?'Less:':''; ?></td>
					<td colspan="3"><?php echo strtoupper($row->loan_type_name).' '.$row->ref_no.' from '.$row->col_period_start.' - '.$row->col_period_end . ' @ ' . number_format($row->mo_amortization, 2); ?></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>Principal:</td>
					<td class="text-right"><?php echo number_format($row->mo_principal, 2); ?></td>
					<td></td>
					<td class="text-right"><?php echo number_format($row->tot_principal, 2); ?></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>Interest:</td>
					<td class="text-right"><?php echo number_format($row->interest_per_mo, 2); ?></td>
					<td></td>
					<td class="text-right"><?php echo number_format($row->tot_monthly_interest, 2); ?></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>TOTAL:</td>
					<td></td>
					<td></td>
					<td class="text-right"><?php echo number_format($row->tot_mo_amortization, 2); ?></td>
					<td></td>
				</tr>
				<tr class="tr-heading">
					<td></td>
					<td colspan="2">LESS: Payment from <?php echo $row->first_date_of_paid . ' to ' . $row->last_date_of_paid; ?></td>
					<td></td>
					<td class="text-right"><?php echo number_format(floatval(str_replace(',', '', $row->tot_amount_paid)) + floatval(str_replace(',', '', $row->tot_interest_paid)), 2); ?></td>
					<td class="text-right"><?php echo number_format(floatval(str_replace(',', '', $row->tot_mo_amortization)) - (floatval(str_replace(',', '', $row->tot_amount_paid)) + floatval(str_replace(',', '', $row->tot_interest_paid))), 2); ?></td>
				</tr>
				<tr>
					<td colspan="6" style="border-top: 1px solid #000;padding: 0;"></td>
				</tr>
				<?php $totalLoanBalance+=floatval(str_replace(',', '', $row->tot_mo_amortization)) - (floatval(str_replace(',', '', $row->tot_amount_paid)) + floatval(str_replace(',', '', $row->tot_interest_paid))); ?>
			<?php $ctr++; ?>
			<?php endforeach ?>
			<tr class="tfoot-total">
				<td style="text-align: right;" colspan="5">TOTAL LOAN BALANCE: </td>
				<td style="text-align: right;" class=""><?php echo number_format($totalLoanBalance, 2); ?></td>
			</tr>
			<tr class="tfoot-total">
				<td style="text-align: right;" colspan="5">GRAND TOTAL: </td>
				<td style="text-align: right;" class="total-loan"> </td>
			</tr>
		</table>

				
		<div class="col-4 offset-8">
			<button type="submit" class="btn btn-default btn-sm rounded-0 border float-right font-12"><i class="fas fa-save"></i> Claim</button>
		</div>
	</div>
</div>
<input type="hidden" name="lri_from_loan_balance" value="<?php echo !empty($claimedData) ? $claimedData->lri_from_loan_balance : ''; ?>">
<input type="hidden" name="oth_benefit" value="<?php echo !empty($claimedData) ? $claimedData->other_benefit : ''; ?>">
<input type="hidden" id="has_update" name="has_update" value="<?php echo !empty($claimedData) ? $claimedData->claimed_benefit_id : ''; ?>">
