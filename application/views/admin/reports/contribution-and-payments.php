<!DOCTYPE html>
<html>
<head>
	<title>Contribution And Payments</title>
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
				<h4 class="mb-0">STATEMENT OF MEMBER'S CONTRIBUTIONS AND LOAN REPAYMENTS</h4>
				<span>For the month of <?php echo $ed; ?></span	>
			</div>
			<div class="col-12 m-3">


			<table border="1" class="font-12 w-100" id="tbl-crj-report-excel" cellpadding="8">
				<tr>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center" colspan="3">MEMBERS CONTRIBUTION</th>
					<th class="text-center" colspan="13">LOAN REPAYMENTS</th>
					<th class="text-center"></th>
					<th class="text-center"></th>
				</tr>
				<tr>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center">ADJ</th>
					<th class="text-center"></th>
					<th class="text-center" colspan="6"></th>
					<th class="text-center"></th>
					<th class="text-center"></th>
				</tr>
				<tr>
					<th>STATION</th>
					<th></th>
					<th>NAME OF MEMBER</th>
					<th>POSITION</th>
					<th>SG</th>
					<th>BASIC SALARY</th>
					<th class="text-center"><?php echo $ed; ?></th>
					<th class="text-center">Contribution</th>
					<th class="text-center">TOTAL</th>
					<th class="text-center">REF #</th>
					<th class="text-center">COLLECTION PERIOD</th>
					<th class="text-center">GPLN</th>
					<th class="text-center">GPLN Loans Receivable</th>
					<th class="text-center">GPLN Interest Receivable</th>
					<th class="text-center">EMLN</th>
					<th class="text-center">EMLN Loans Receivable</th>
					<th class="text-center">EMLN Interest Receivable</th>
					<th class="text-center">SLMV</th>
					<th class="text-center">SLMV Loans Receivable</th>
					<th class="text-center">SLMV Interest Receivable</th>
					<th class="text-center">ADJ <br> LOANS</th>
					<th class="text-center">TOTAL</th>
					<th class="text-center">TOTAL DEDUCTIONS</th>
					<th class="text-center">REMARKS</th>
				</tr>
				<?php $ctr=1 ?>
				<?php $mem=''; ?>
				<?php foreach ($cPData as $row): ?>
					<tr>
						<td><?php echo $row->office_name; ?></td>
						<td><?php echo $row->parent_mem == 'group_total' ? 'TOTAL' : ($row->parent_mem!=''?($row->parent_ofc==$mem?$ctr:$ctr=1):''); ?></td>
						<th><?php echo $row->parent_mem  == 'group_total' ? '' : strtoupper($row->parent_mem); ?></th>
						<th><?php echo $row->designation; ?></th>
						<th class="text-center"><?php echo $row->sg; ?></th>
						<td class="text-center"><?php echo $row->monthly_salary!='' ? number_format($row->monthly_salary, 2) : ''; ?></td>
						<td class="text-center"><?php echo $row->deduction!='' ? number_format($row->deduction, 2) : ''; ?></td>
						<td class="text-center"><?php echo $row->adjusted_amnt!='' ? number_format($row->adjusted_amnt, 2) : ''; ?></td>
						<td class="text-center"><?php echo $row->total_cont!='' ? $row->total_cont/*number_format($row->total_cont, 2)*/ : ''; ?></td>
						<td class="text-center"><?php echo $row->ref_no; ?></td>
						<td class="text-center"><?php echo $row->collection_period; ?></td>
						<td class="text-center"><?php echo $row->gpln>0?number_format($row->gpln, 2):''; ?></td>
						<td class="text-center"><?php echo $row->gpln>0?number_format($row->gpln_lr, 2):''; ?></td>
						<td class="text-center"><?php echo $row->gpln>0?number_format($row->gpln_ir, 2):''; ?></td>
						<td class="text-center"><?php echo $row->emln>0?number_format($row->emln, 2):''; ?></td>
						<td class="text-center"><?php echo $row->emln>0?number_format($row->emln_lr, 2):''; ?></td>
						<td class="text-center"><?php echo $row->emln>0?number_format($row->emln_ir, 2):''; ?></td>
						<td class="text-center"><?php echo $row->slmv>0?number_format($row->slmv, 2):''; ?></td>
						<td class="text-center"><?php echo $row->slmv>0?number_format($row->slmv_lr, 2):''; ?></td>
						<td class="text-center"><?php echo $row->slmv>0?number_format($row->slmv_ir, 2):''; ?></td>
						<td class="text-center"></td>
						<td class="text-center"><?php echo $row->total>0?number_format($row->total, 2):''; ?></td>
						<td class="text-center"><?php echo $row->total_deduction>0?number_format($row->total_deduction, 2):''; ?></td>
						<td class="text-center"><?php echo $row->remarks; ?></td>
					</tr>
					<?php $mem=$row->parent_ofc; ?>
				<?php $ctr++; ?>
				<?php endforeach; ?>

				
			</table>
		</div>
	</div>

</body>
</html>

