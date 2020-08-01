<table id="members-contribution-excel" border="1">
	<tr>
		<td style="width: 20%;"></td>
		<td colspan="4" style="width: 60%; text-align: center;font-weight: 700;">CENSUS PROVIDENT FUND, INC. (CPFI)</td>
		<td style="width: 20%;"></td>
	</tr>
	<tr>
		<td style="width: 20%;"></td>
		<td colspan="4" style="width: 60%; text-align: center;font-weight: 700;">CASHGIFT FOR <?php echo date('F Y', strtotime($ed)); ?> </td>
		<td style="width: 20%;"></td>
	</tr>
	<!-- <tr>
		<td style="text-align: left;">Name of Member: </td>
		<td colspan="4" style="text-align: left"><?php //echo !empty($data) ? strtoupper($data[0]->last_name . ', ' . $data[0]->first_name . ' ' . $data[0]->middle_name) : ''; ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">Employee Number:</td>
		<td colspan="4" style="text-align: left"><?php //echo !empty($data) ? $data[0]->id_no : ''; ?></td>
	</tr> -->
	<?php if (!empty($place)): ?>
		<tr>
			<td style="text-align: left;">PLACE:</td>
			<td colspan="5" style="text-align: left"><?php echo !empty($data) ? $place : ''; ?></td>
		</tr>
	<?php else: ?>
		<tr>
			<td style="text-align: left;">Official Station:</td>
			<td colspan="5" style="text-align: left"><?php echo !empty($data) ? $data[0]->office_name : ''; ?></td>
		</tr>
	<?php endif; ?>
	

	<tr>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
	</tr>
	<tr>
		<td style="width: 20%;text-align: center;font-weight: 800;">MEMBER ID</td>
		<td style="width: 20%;text-align: center;font-weight: 800;">NAME</td>	
		<td style="width: 20%;text-align: center;font-weight: 800;">DATE</td>	
		<td style="width: 20%;text-align: center;font-weight: 800;">REGION</td>	
		<td style="width: 20%;text-align: center;font-weight: 800;">TOTAL MC</td>	
		<td style="width: 20%;text-align: center;font-weight: 800;">PERCENTAGE</td>
		<td style="width: 20%;text-align: center;font-weight: 800;">AMOUNT</td>
	</tr>
	<tr>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;">AS OF <?php echo date('m/d/Y', strtotime($ed)); ?></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"><?php echo !empty($remarks) ? $remarks : ''; ?></td>
	</tr>
	<?php $total_cont=0; ?>
	<?php $total=0; ?>
	<?php foreach ($data as $row): ?>
		<?php $date_applied = strtotime($row->date_applied); ?>
		<?php $d = date('F Y', $date_applied); ?>
		<tr>
			<td style="text-align: center;"><?php echo "'" . $row->members_id; ?></td>
			<td style="text-align: center;"><?php echo strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name); ?></td>
			<td style="text-align: center;"><?php echo "'" . $d; ?></td>
			<td style="text-align: center;"><?php echo $row->region; ?></td>
			<td style="text-align: center;"><?php echo $row->tot_contribution; ?></td>
			<td style="text-align: center;"><?php echo $row->rate; ?></td>
			<td style="text-align: right;"><?php echo number_format($row->amount); ?></td>
		</tr>
	<?php 
		$total_cont+=(floatval(str_replace(',', '', $row->tot_contribution)));
		$total+=(floatval(str_replace(',', '', $row->amount)));
	?>
	<?php endforeach ?>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td style="font-weight: 700;text-align: right;">TOTAL:</td>
		<td style="font-weight: 700;text-align: right;"><?php echo number_format($total_cont, 2); ?></td>
		<td></td>
		<td style="font-weight: 700;text-align: right;"><?php echo number_format($total, 2); ?></td>
	</tr>
</table>

