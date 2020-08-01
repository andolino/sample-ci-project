<!DOCTYPE html>
<html>
<head>
	<title>CDJ Summary Report</title>
</head>
<link 
		rel="stylesheet" 
		href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
<link rel="shortcut icon" href="<?= base_url('assets/image/misc/ico.ico') ?>" type="image/x-icon">
<link 
		rel="stylesheet" 
		href="<?php echo base_url(); ?>assets/css/custom.css?random=<?php echo mt_rand(); ?>">

		<style type="text/css">
			td, th{
				width: 1px;
				white-space: nowrap;
			}
		</style>

<body>

	<div class="row">
		<div class="col-1 mt-3 ml-3 mb-0 pr-0">
			<img src="<?php echo base_url('assets/image/misc/logo.png'); ?>" width="100">
		</div>
		<div class="col-6 mt-3 pl-0" style="line-height: 1.6">
			<h6 class="mb-0">CENSUS PROVIDENT FUND, INC.</h6>
			<h4 class="mb-0">CHECK DISBURSEMENT JOURNAL</h4>
			<span>For the month of <?php echo $ed; ?></span	>
		</div>
		<div class="col-12 m-3">


			<table border="1" class="font-12 w-100" id="tbl-crj-report-excel" cellpadding="8">
			<tr>
				<th rowspan="2">DATE</th>
				<th rowspan="2">CV NO.</th>
				<th rowspan="2">CK NO.</th>
				<th rowspan="2">REF NO.</th>
				<th rowspan="2">PAYEE</th>
				<th rowspan="2">COLLECTION PERIOD</th>
				<th rowspan="2">MO AMORT</th>
				<th colspan="10" class="text-center">CREDITS</th>
				<th colspan="9" class="text-center">DEBITS</th>
			</tr>
			<tr>
				<th class="text-center">CASH ON HAND</th>
				<th class="text-center">CASH ON BANK LBP</th>
				<th class="text-center">CASH IN BANK (MBTC)</th>
				<th class="text-center">UNEARNED INTEREST</th>
				<th class="text-center">INTEREST INCOME</th>
				<th class="text-center">DEFERRED CREDITS</th>
				<th class="text-center">LRI</th>
				<th class="text-center">LOAN RECEIVABLE CREDIT</th>
				<th class="text-center">INTEREST</th>
				<th class="text-center">SERVICE CHARGE</th>
				<th class="text-center">LOAN RECEIVABLE DEBIT</th>
				<th class="text-center">INTEREST INCOME</th>
				<th class="text-center">DEFERRED CREDITS</th>
				<th class="text-center">BENEFIT CLAIM</th>
				<th class="text-center">MEMBERS CONTRIBUTION</th>
				<th class="text-center">SUNDRY ACCOUNT</th>
				<th class="text-center">DB</th>
				<th class="text-center">CR</th>
				<th class="text-center">BALANCE</th>
				<th class="text-center">COMAKER</th>
				<th class="text-center">REMARKS</th>
			</tr>
			<?php 
				$monthly_amortization=0;
				$cash_on_hand_credit=0;
				$cash_in_bank_lbp_credit=0;
				$cash_in_bank_mbtc_credit=0;
				$unearned_interest_credit=0;
				$interest_income_credit=0;
				$deferred_credits_credit=0;
				$lri_credit=0;
				$loan_receivable_credit=0;
				$interest_credit=0;
				$service_charge_credit=0;
				$loan_receivable_debit=0;
				$interest_income_debit=0;
				$deferred_credits_debit=0;
				$benefit_claim_debit=0;
				$members_contribution_debit=0;
				$subsid=0;
				$sundry_amount_debit=0;
				$sundry_amount_credit=0;
				$balance=0;
			?>
			<?php foreach ($cdjData as $row): ?>
				<?php $comaker = explode('|', $row->comaker); ?>
				<tr>
					<td><?php echo date('m/d/Y', strtotime($row->journal_date)); ?></td>
					<td><?php echo $row->check_voucher_no; ?></td>
					<td><?php echo $row->check_no; ?></td>
					<td><?php echo $row->reference_no; ?></td>
					<td><?php echo $row->payee == '' ? $row->payee_member : $row->payee; ?></td>
					<td></td>
					<td class="text-center"><?php echo number_format($row->monthly_amortization, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->cash_on_hand_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->cash_in_bank_lbp_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->cash_in_bank_mbtc_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->unearned_interest_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->interest_income_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->deferred_credits_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->lri_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->loan_receivable_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->interest_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->service_charge_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->loan_receivable_debit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->interest_income_debit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->deferred_credits_debit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->benefit_claim_debit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->members_contribution_debit, 2); ?></td>
					<td class="text-center"><?php echo $row->sundry_accounts_debit == '' ? $row->sundry_accounts_credit : $row->sundry_accounts_debit; ?></td>
					<td class="text-center"><?php echo number_format($row->sundry_amount_debit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->sundry_amount_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->sundry_amount_debit - $row->sundry_amount_credit, 2); ?></td>
					<td class="text-center"><?php echo implode('/', $comaker); ?></td>
					<td class="text-center"><?php echo $row->remarks; ?></td>
				</tr>
				<?php 
					$monthly_amortization += $row->monthly_amortization;
					$cash_on_hand_credit += $row->cash_on_hand_credit;
					$cash_in_bank_lbp_credit += $row->cash_in_bank_lbp_credit;
					$cash_in_bank_mbtc_credit += $row->cash_in_bank_mbtc_credit;
					$unearned_interest_credit += $row->unearned_interest_credit;
					$interest_income_credit += $row->interest_income_credit;
					$deferred_credits_credit += $row->deferred_credits_credit;
					$lri_credit += $row->lri_credit;
					$loan_receivable_credit += $row->loan_receivable_credit;
					$interest_credit += $row->interest_credit;
					$service_charge_credit += $row->service_charge_credit;
					$loan_receivable_debit += $row->loan_receivable_debit;
					$interest_income_debit += $row->interest_income_debit;
					$deferred_credits_debit += $row->deferred_credits_debit;
					$benefit_claim_debit += $row->benefit_claim_debit;
					$members_contribution_debit += $row->members_contribution_debit;
					$sundry_amount_debit += $row->sundry_amount_debit;
					$sundry_amount_credit += $row->sundry_amount_credit;
					$balance += ($row->sundry_amount_debit - $row->sundry_amount_credit);
				?>
			<?php endforeach ?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-center font-weight-bold"><?php echo number_format($monthly_amortization, 2); ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($cash_on_hand_credit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($cash_in_bank_lbp_credit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($cash_in_bank_mbtc_credit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($unearned_interest_credit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($interest_income_credit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($deferred_credits_credit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($lri_credit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($loan_receivable_credit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($interest_credit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($service_charge_credit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($loan_receivable_debit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($interest_income_debit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($deferred_credits_debit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($benefit_claim_debit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($members_contribution_debit, 2);  ?></td>
					<td class="text-center font-weight-bold"></td>
					<td class="text-center font-weight-bold"><?php echo number_format($sundry_amount_debit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($sundry_amount_credit, 2);  ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($balance, 2);  ?></td>
					<td class="text-center font-weight-bold"></td>
					<td class="text-center font-weight-bold"></td>
				</tr>
			</table>
		</div>
	</div>

</body>
</html>