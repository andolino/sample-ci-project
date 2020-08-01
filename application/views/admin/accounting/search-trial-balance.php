<table class="table table-sm font-12">
	<thead>
		<tr>
			<th class="">MAIN</th>
			<th class="">GROUP</th>
			<th class="">SUB</th>
			<th class="text-right">DEBIT</th>
			<th class="text-right">CREDIT</th>
		</tr>
	</thead>
	<tbody>
		<?php $tot_deb=0; ?>
		<?php $tot_cred=0; ?>
		<?php $i=0; ?>
		<?php foreach ($data as $row): ?>
			<?php if ($row->class_desc!=''): ?>
				<tr class="tr-cd">
			<?php elseif($row->group_desc!=''): ?>
				<tr class="tr-gd">
			<?php else: ?>
				<?php if (($i % 2)==0): ?>
					<tr class="tr-md">
				<?php else: ?>
					<tr class="">
				<?php endif; ?>
			<?php endif; ?>
				<td><?php echo strtoupper($row->class_desc); ?></td>
				<td><?php echo strtoupper($row->group_desc); ?></td>
				<td><?php echo strtoupper($row->main_desc) ?></td>
				<td class="text-right"><?php echo $row->debit > 0 ? number_format($row->debit, 2) : ''; ?></td>
				<td class="text-right"><?php echo $row->credit > 0 ? number_format($row->credit, 2) : ''; ?></td>
			</tr>
		<?php $tot_deb 	+= $row->debit > 0 ? $row->debit : 0; ?>
		<?php $tot_cred += $row->credit > 0 ? $row->credit : 0; ?>
		<?php $i++; ?>
		<?php endforeach ?>
	</tbody>
	<tfoot>
		<tr>
			<th></th>
			<th></th>
			<th>TOTAL:</th>
			<th><?php echo number_format($tot_deb, 2); ?></th>
			<th><?php echo number_format($tot_cred, 2); ?></th>
		</tr>
	</tfoot>
</table>