<table id="members-contribution-excel">
	<tr>
		<td style="width: 10%;"><img src="<?php echo base_url('assets/image/misc/logo.png'); ?>" width="50"></td>
		<td colspan="3" style="width: 60%; text-align: left;font-weight: 700;font-size:10px;">CENSUS PROVIDENT FUND, INC. (CPFI) <br>STATEMENT OF MEMBERSHIP CONTRIBUTIONS <br>As of <?php echo date('F Y', strtotime($ed)); ?></td>
		<td style="width: 20%;"></td>
	</tr>
</table>
<table border="0.5" style="font-size:8px;">
    <tr>
		<td style="text-align: left;">Official Station:</td>
		<td colspan="4" style="text-align: left"><?php echo !empty($data) ? $data[0]->office_name : ''; ?></td>
	</tr>
	<tr>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
	</tr>
	<tr>
		<td style="width: 20%;text-align: center;"><strong>MONTH COVERED</strong></td>
		<td style="width: 20%;text-align: center;"><strong>DATE OF RECEIPT</strong></td>
		<td style="width: 20%;text-align: center;"><strong>RECEIPT NUMBER</strong></td>
		<td style="width: 20%;text-align: center;"><strong>MONTHLY PAYMENT</strong></td>
		<td style="width: 20%;text-align: center;"><strong>CUMMULATIVE BALANCE</strong></td>
	</tr>
	<tr>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
	</tr>
	<?php $tota_ded=0; ?>
	<?php $tota_balance=0; ?>
	<?php foreach ($data as $row): ?>
		<tr>
			<td style="text-align: center;"><?php echo date('F/Y', strtotime($row->date_applied)); ?></td>
			<td style="text-align: center;"><?php echo date('m/d/Y', strtotime($row->entry_date)); ?></td>
			<td style="text-align: center;"><?php echo $row->orno; ?></td>
			<td style="text-align: right;"><?php echo $row->deduction; ?></td>
			<td style="text-align: right;"><?php echo $row->deduction - $row->balance; ?></td>
		</tr>
	<?php 
		$tota_ded+=$row->deduction;
		$tota_balance+=($row->deduction - $row->balance);
	?>
	<?php endforeach ?>
	<tr>
		<td></td>
		<td></td>
		<td style="font-weight: 700;text-align: right;">TOTAL</td>
		<td style="font-weight: 700;text-align: right;"><?php echo number_format($tota_ded, 2); ?></td>
		<td style="font-weight: 700;text-align: right;"><?php echo number_format($tota_balance, 2); ?></td>
	</tr>
</table>

