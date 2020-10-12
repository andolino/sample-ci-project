<!DOCTYPE html>
<html>
<head>
	<title>Loan Summary Report</title>
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
				<h4 class="mb-0">SUMMARY OF LOANS</h4>
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
					
				</tr>
				<tr>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center"></th>
					<th class="text-center"></th>
					
				</tr>
				<tr>
					<th>STATION</th>
					<th></th>
					<th>NAME OF MEMBER</th>
					<th>POSITION</th>
					<th>SG</th>
					
				</tr>
				<tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>

				
			</table>
		</div>
	</div>

</body>
</html>

