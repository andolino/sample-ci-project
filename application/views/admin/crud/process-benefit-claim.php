<div class="cont-process-benefit-claim-by-member row none w-100">
	<div class="col-8">
		<a href="javascript:void(0);" class="float-right pr-2 pb-2" id="loadPage" data-link="show-claim-benefit" data-badge-head="BENEFIT CLAIM"
   								data-cls="cont-benefit-claims" data-placement="top" data-toggle="tooltip" title="Back to List"><i class="fas fa-times"></i></a>
	</div>
	<div class="col-12"></div>	
	<div class="col-8">
		<form id="frm-claim-beneft">
			<div class="row">
					<!-- heading -->
					<div class="col-6">
						<?php if($data[0]->retired_date !== null): ?>
						<a class="btn btn-md btn-default font-12 rounded-0 border" onclick="exportF(this)"><i class="fas fa-table"></i> Print</a>
						<select class="custom-select custom-select-sm rounded-0 mt-2 d-none" id="benefit_type" data-type="edit" name="benefit_type">
						  <option selected hidden value="">-SELECT-</option>
						  <?php foreach ($benefit_type as $row): ?>
						  	<option value="<?php echo $row->benefit_type_id; ?>" data-m-id="<?php echo $data[0]->members_id; ?>"><?php echo $row->type_of_benefit; ?></option>
						  <?php endforeach; ?>
						</select>
						<?php else: ?>
						<label for="benefit_type" class="font-12">Benefit Type</label>
						<select class="custom-select custom-select-sm rounded-0" id="benefit_type" name="benefit_type">
						  <option selected hidden value="">-SELECT-</option>
						  <?php foreach ($benefit_type as $row): ?>
						  	<option value="<?php echo $row->benefit_type_id; ?>" data-m-id="<?php echo $data[0]->members_id; ?>"><?php echo $row->type_of_benefit; ?></option>
						  <?php endforeach; ?>
						</select>
						<?php endif; ?>
						
					</div>
					<!-- end -->
					<div class="col-12 mt-3 bfit-frm">
						<table class="table table-sm font-12" id="tbl-benefit-list-by-member" data-member-id="<?php echo $data[0]->members_id; ?>">
							<thead>
								<tr>
									<th class="">BENEFIT TYPE</th>
									<th class="">NAME</th>
									<th class="">AMOUNT CLAIM</th>
									<th class="">DATE CLAIM</th>
									<th>ACTION</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>

						
					</div>

			</div>	
			<div class="line mt-3 mb-3 pt-0 pb-0"></div>
			
		</form>

	</div>
	
</div>


<div class="col-8 pl-0 pr-0 d-none">
	<table id="table-to-excel" border="1" class="font-12" cellpadding="4" width="60%">
		<tr>
			<td><img src="<?php echo base_url('assets/image/misc/logo.png')?>" alt="" width="76"></td>
			<td colspan="5">
				<span>Census Provident Fund, Inc.</span><br>
				<span>5/F, TAM Bldg., PSA Complex, East Ave., Diliman, Quezon City</span><br>
				<span>Tel No. (02) 8666-2401</span><br>
				<span>Email: Provident.Fund@psa.gov.ph</span>
			</td>

		</tr>
		<tr>
			<td colspan="6">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="6"><center><strong>COMPUTATION OF BENEFIT CLAIMS DUE</strong></center></td>
		</tr>
		<tr>
			<td>NAME OF A MEMBER</td>
			<td colspan="2"><?php echo strtoupper($data[0]->last_name . ', ' . $data[0]->first_name . ' ' . $data[0]->middle_name); ?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Official Station</td>
			<td colspan="2"><?php echo strtoupper($data[0]->office_name); ?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Effectivity of a Membership</td>
			<td><?php echo date('F j, Y', strtotime($data[0]->date_of_effectivity)); ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Effectivity of a <?php echo ucwords($data[0]->type_of_benefit); ?></td>
			<td><?php echo date('F j, Y', strtotime($data[0]->retired_date)); ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2">Accum.  Member's  Contributions  (MC)  as  of	<?php echo date('F j, Y', strtotime($data[0]->retired_date)); ?></td>
			<td></td>
			<td class="text-right"><?php echo !empty($claimBenefit) ? number_format($claimBenefit[0]->accum_contrib, 2) : ''; ?></td>
			<td></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2">CPFI's Share (<?php echo !empty($claimBenefit) ? $claimBenefit[0]->share : ''; ?>% of MC)</td>
			<td></td>
			<td class="text-right"><?php echo !empty($claimBenefit) ? number_format($claimBenefit[0]->accum_contrib, 2) : ''; ?></td>
			<td class="text-right"><?php echo !empty($claimBenefit) ? number_format($claimBenefit[0]->accum_contrib + $claimBenefit[0]->accum_contrib, 2) : ''; ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2">Other Benefits (<?php echo !empty($claimBenefit) ? $claimBenefit[0]->other_benefit : ''; ?>% of the P20,000.00)</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Sickness</td>
			<td></td>
			<td></td>
			<td class="text-right"><?php echo !empty($claimBenefit) ? number_format($claimBenefit[0]->clmd_sickness, 2) : ''; ?></td>
		</tr>
		<?php foreach ($claimBenefit as $row): ?>
			<?php if ($row->clmd_sickness>0 && $row->claim_all == 0): ?>
			<tr>
				<td>LESS</td>
				<td>CLAIMED DATE</td>
				<td><?php echo date('F,Y', strtotime($row->claim_date)); ?></td>
				<td></td>
				<td></td>
				<td class="text-right"><?php echo number_format($row->clmd_sickness, 2); ?></td>
			</tr>
			<?php endif; ?>
		<?php endforeach; ?>
		<tr>
			<td></td>
			<td></td>
			<td>Death of immediate family</td>
			<td></td>
			<td></td>
			<td class="text-right"><?php echo !empty($claimBenefit) ? number_format($claimBenefit[0]->clmd_dif, 2) : ''; ?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Accident</td>
			<td></td>
			<td></td>
			<td class="text-right"><?php echo !empty($claimBenefit) ? number_format($claimBenefit[0]->clmd_accident, 2) : ''; ?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Calamity/Fire</td>
			<td></td>
			<td></td>
			<td class="text-right"><?php echo !empty($claimBenefit) ? number_format($claimBenefit[0]->clmd_calamity, 2) : ''; ?>	</td>
		</tr>
		<?php $totalLessBfit=0; ?>
		<?php foreach ($claimBenefit as $row): ?>
			<?php if ($row->total_claim>0 && $row->claim_all == 0): ?>
			<tr>
				<td></td>
				<td><?php echo 'LESS: ('. $row->type_of_benefit . ') '; ?></td>
				<td>claim date <?php echo date('F j, Y', strtotime($row->claim_date)); ?></td>
				<td></td>
				<td></td>
				<td class="text-right"><?php echo '(' . number_format($row->total_claim, 2) . ')'; ?></td>
			</tr>
			<?php $totalLessBfit+=$row->total_claim; ?>
			<?php endif; ?>
		<?php endforeach; ?>
		<tr>
			<td></td>
			<td></td>
			<td>Total:</td>
			<td></td>
			<td></td>
			<td class="text-right"><?php echo !empty($claimBenefit) ? number_format(($claimBenefit[0]->clmd_sickness + $claimBenefit[0]->clmd_dif + 
																																							$claimBenefit[0]->clmd_accident + $claimBenefit[0]->clmd_calamity) - $totalLessBfit, 2) : ''; ?></td>
		</tr>

		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
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
				<tr class="">
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
				<td style="text-align: right;" colspan="5"><?php echo !empty($claimBenefit) ? ($claimBenefit[0]->lri_from_loan_balance>0?'BALANCE TO LRI:':'TOTAL LOAN BALANCE:') : 'TOTAL LOAN BALANCE:'; ?></td>
				<td style="text-align: right;" class=""><?php echo number_format($totalLoanBalance, 2); ?></td>
			</tr>
			<tr class="tfoot-total">
				<td style="text-align: right;" colspan="5">GRAND TOTAL: </td>
				<td style="text-align: right;" class=""><?php echo !empty($claimBenefit) ? number_format($claimBenefit[0]->total_claim, 2) : ''; ?></td>
			</tr>


	</table>
</div>

<style>
	#tbl-benefit-list-by-member_filter label {
		right: 25px;
		position: relative;
	}
</style>
