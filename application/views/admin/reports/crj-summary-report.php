<!DOCTYPE html>
<html>
<head>
	<title>CRJ Summary Report</title>
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
			<h4 class="mb-0">CASH RECEIPT JOURNAL</h4>
			<span>For the month of <?php echo $ed; ?></span	>
		</div>
		<div class="col-12 m-3">


			<table border="1" class="font-12 w-100" id="tbl-crj-report-excel" cellpadding="8">
			<tr>
				<th rowspan="2">DATE</th>
				<th rowspan="2">OR NO.</th>
				<th rowspan="2">PARTICULARS</th>
				<th colspan="6" class="text-center">DEBITS</th>
				<th colspan="8" class="text-center">CREDITS</th>
			</tr>
			<tr>
				<th class="text-center">CASH ON HAND</th>
				<th class="text-center">CASH ON BANK LBP</th>
				<th class="text-center">CASH IN BANK (MBTC)</th>
				<th class="text-center">DEFERRED CREDITS</th>
				<th class="text-center">SUNDRY ACCOUNTS</th>
				<th class="text-center">AMOUNTS</th>
				<th class="text-center">CASH ON HAND</th>
				<th class="text-center">LOAN RECEIVABLE</th>
				<th class="text-center">INTEREST RECEIVABLE</th>
				<th class="text-center">INTEREST INCOME</th>
				<th class="text-center">DUE FROM PSA</th>
				<th class="text-center">DONATION-S. ALLOW</th>
				<th class="text-center">SUNDRY ACCOUNT</th>
				<th class="text-center">AMOUNT</th>
			</tr>
			<?php 
				$cash_on_hand_debit=0;
				$cash_in_bank_lbp_debit=0;
				$cash_in_bank_mbtc_debit=0;
				$deferred_credits_debit=0;
				$sundry_amount_debit=0;
				$cash_on_hand_credit=0;
				$loan_receivable_credit=0;
				$interest_receivable_credit=0;
				$interest_income_credit=0;
				$due_from_psa_credit=0;
				$donation_serv_allow_credit=0;
				$sundry_amount_credit=0;
			?>
			<?php foreach ($crjData as $row): ?>
				<tr>
					<td><?php echo date('m/d/Y', strtotime($row->journal_date)); ?></td>
					<td><?php echo $row->account_no; ?></td>
					<td><?php echo $row->particulars; ?></td>
					<td class="text-center"><?php echo number_format($row->cash_on_hand_debit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->cash_in_bank_lbp_debit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->cash_in_bank_mbtc_debit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->deferred_credits_debit, 2); ?></td>
					<td><?php echo $row->sundry_accounts_debit; ?></td>
					<td class="text-center"><?php echo number_format($row->sundry_amount_debit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->cash_on_hand_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->loan_receivable_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->interest_receivable_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->interest_income_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->due_from_psa_credit, 2); ?></td>
					<td class="text-center"><?php echo number_format($row->donation_serv_allow_credit, 2); ?></td>
					<td><?php echo $row->sundry_accounts_credit; ?></td>
					<td class="text-center"><?php echo number_format($row->sundry_amount_credit, 2); ?></td>
				</tr>
				<?php 
					$cash_on_hand_debit+=$row->cash_on_hand_debit;
					$cash_in_bank_lbp_debit+=$row->cash_in_bank_lbp_debit;
					$cash_in_bank_mbtc_debit+=$row->cash_in_bank_mbtc_debit;
					$deferred_credits_debit+=$row->deferred_credits_debit;
					$sundry_amount_debit+=$row->sundry_amount_debit;
					$cash_on_hand_credit+=$row->cash_on_hand_credit;
					$loan_receivable_credit+=$row->loan_receivable_credit;
					$interest_receivable_credit+=$row->interest_receivable_credit;
					$interest_income_credit+=$row->interest_income_credit;
					$due_from_psa_credit+=$row->due_from_psa_credit;
					$donation_serv_allow_credit+=$row->donation_serv_allow_credit;
					$sundry_amount_credit+=$row->sundry_amount_credit;
				?>
			<?php endforeach ?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-center font-weight-bold"><?php echo number_format($cash_on_hand_debit, 2); ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($cash_in_bank_lbp_debit, 2); ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($cash_in_bank_mbtc_debit, 2); ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($deferred_credits_debit, 2); ?></td>
					<td></td>
					<td class="text-center font-weight-bold"><?php echo number_format($sundry_amount_debit, 2); ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($cash_on_hand_credit, 2); ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($loan_receivable_credit, 2); ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($interest_receivable_credit, 2); ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($interest_income_credit, 2); ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($due_from_psa_credit, 2); ?></td>
					<td class="text-center font-weight-bold"><?php echo number_format($donation_serv_allow_credit, 2); ?></td>
					<td></td>
					<td class="text-center font-weight-bold"><?php echo number_format($sundry_amount_credit, 2); ?></td>
				</tr>
			</table>
		</div>
	</div>

</body>
</html>