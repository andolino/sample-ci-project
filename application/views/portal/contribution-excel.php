<table id="members-contribution-excel">
	<tr>
		<td style="width: 10%;"><img src="<?php echo base_url('assets/image/misc/logo.png'); ?>" width="50"></td>
		<td style="width: 60%; text-align: left;font-weight: 700;font-size:10px;">CENSUS PROVIDENT FUND, INC. (CPFI) <br>STATEMENT OF MEMBERSHIP CONTRIBUTIONS <br> <?php // echo date('F Y', strtotime($ed)); ?></td>
		<td style="width: 20%;"></td>
	</tr>
	<tr>
		<td style=""></td>
		<td style=""></td>
		<td style=""></td>
	</tr>
</table>
<table style="font-size:8px;">
	<tr>
		<td style="text-align: left;">Name of Member: </td>
		<td style="text-align: left"><?php echo !empty($data) ? strtoupper($data[0]->last_name . ', ' . $data[0]->first_name . ' ' . $data[0]->middle_name) : ''; ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">Employee Number:</td>
		<td style="text-align: left"><?php echo !empty($data) ? $data[0]->id_no : ''; ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">Official Station:</td>
		<td style="text-align: left"><?php echo !empty($data) ? $data[0]->office_name : ''; ?></td>
	</tr>
	<tr>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
	</tr>
	<tr>
		<td style="width: 33.33%;text-align: center;"><strong>MONTH COVERED</strong></td>
		<td style="width: 33.33%;text-align: right;"><strong>MONTHLY PAYMENT</strong></td>
		<td style="width: 33.33%;text-align: right;"><strong>CUMMULATIVE BALANCE</strong></td>
	</tr>
	<tr>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
	</tr>
	<?php $tota_ded=0; ?>
	<?php $tota_balance=0; ?>
	<?php foreach ($data as $row): ?>
		<tr>
			<td style="text-align: center;"><?php echo date('F, Y', strtotime($row->date_applied)); ?></td>
			<td style="text-align: right;"><?php echo number_format($row->deduction, 2); ?></td>
			<td style="text-align: right;"><?php echo number_format($row->deduction - $row->balance, 2); ?></td>
		</tr>
	<?php 
		$tota_ded+=$row->deduction;
		$tota_balance+=($row->deduction - $row->balance);
	?>
	<?php endforeach ?>
	<tr>
		<td style="border-bottom: 0.5px solid #000;"></td>
		<td style="border-bottom: 0.5px solid #000;"></td>
		<td style="border-bottom: 0.5px solid #000;"></td>
	</tr>
	<tr>
		<td style="font-weight: 800;text-align: right;"><strong></strong></td>
		<td style="font-weight: 800;text-align: right;"><strong>TOTAL<?php //echo number_format($tota_ded, 2); ?></strong></td>
		<td style="font-weight: 800;text-align: right;"><strong><?php echo number_format($tota_balance, 2); ?></strong></td>
	</tr>
</table>

