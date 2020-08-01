<table id="members-contribution-excel" border="1">
	<tr>
		<td style="width: 20%;"></td>
		<td colspan="3" style="width: 60%; text-align: center;font-weight: 700;">CENSUS PROVIDENT FUND, INC. (CPFI)</td>
		<td style="width: 20%;"></td>
	</tr>
	<tr>
		<td style="width: 20%;"></td>
		<td colspan="3" style="width: 60%; text-align: center;font-weight: 700;">STATEMENT OF MEMBERSHIP CONTRIBUTIONS </td>
		<td style="width: 20%;"></td>
	</tr>
	<tr>
		<td style="width: 20%;"></td>
		<td colspan="3" style="width: 60%; text-align: center;font-weight: 700;">As of <?php echo date('F Y', strtotime($sd)); ?></td>
		<td style="width: 20%;"></td>
	</tr>
	<tr>
		<td style="text-align: left;">Name of Member: </td>
		<td colspan="4" style="text-align: left"><?php echo !empty($data) ? strtoupper($data[0]->last_name . ', ' . $data[0]->first_name . ' ' . $data[0]->middle_name) : ''; ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">Employee Number:</td>
		<td colspan="4" style="text-align: left"><?php echo !empty($data) ? $data[0]->id_no : ''; ?></td>
	</tr>
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
		<td style="width: 20%;text-align: center;font-weight: 800;">MONTH COVERED</td>
		<td style="width: 20%;text-align: center;font-weight: 800;">DATE OF RECEIPT</td>
		<td style="width: 20%;text-align: center;font-weight: 800;">RECEIPT NUMBER</td>
		<td style="width: 20%;text-align: center;font-weight: 800;">MONTHLY PAYMENT</td>
		<td style="width: 20%;text-align: center;font-weight: 800;">BALANCE</td>
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
			<td style="text-align: center;"><?php echo date('F/Y', strtotime($row->payment_schedule)); ?></td>
			<td style="text-align: center;"><?php echo date('m/d/Y', strtotime($row->date_paid)); ?></td>
			<td style="text-align: center;"><?php echo $row->orno; ?></td>
			<td style="text-align: right;"><?php echo $row->amnt_paid; ?></td>
			<td style="text-align: right;"><?php echo $row->balance; ?></td>
		</tr>
	<?php 
		$tota_ded+=$row->amnt_paid;
		$tota_balance+=$row->balance;
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

