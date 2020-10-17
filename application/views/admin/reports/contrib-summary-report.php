<!DOCTYPE html>
<html>
<head>
	<title>Contribution Summary Report</title>
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
				<h4 class="mb-0">SUMMARY OF CONTRIBUTION</h4>
				<span>For the month of <?php echo $ed; ?></span	>
			</div>
			<div class="col-12 m-3">


			<table border="1" class="font-12" style="width:65%;" id="tbl-crj-report-excel" cellpadding="8">
				
				<tr>
					<th>DATE</th>
					<th>NAME OF MEMBER</th>
					<th>STATION</th>
					<th>MEMBERSHIP DATE</th>
					<th>MC AS OF <?php echo $ed; ?></th>
				</tr>
				<?php foreach($cPData as $row): ?>
					<tr>
						<td><?php echo date('F j, Y', strtotime($row->date_applied)); ?></td>
						<td><?php echo strtoupper($row->last_name) . ', ' . strtoupper($row->first_name) . ' ' . strtoupper($row->middle_name); ?></td>
						<td><?php echo strtoupper($row->office_name); ?></td>
						<td><?php echo date('F j, Y', strtotime($row->date_of_effectivity)); ?></td>
						<td><?php echo number_format($row->accum, 2); ?></td>
					</tr>
				<?php endforeach; ?>

			</table>
		</div>
	</div>

</body>
</html>

