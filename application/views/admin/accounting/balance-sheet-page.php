<div class="cont-general-ledger row w-100">
	<div class="row">
		<div class="col-12 pb-3">
			<!-- <button type="button" class="btn btn-default btn-lg font-12 rounded-0 border" id="loadPage" data-badge-head="ENTRY FOR GJ" data-link="add-gj-entry" data-ind="" data-cls="cont-gj-entry"><i class="fas fa-plus-circle"></i> Add Entry</button> -->
			<button type="button" class="btn btn-default btn-lg font-12 rounded-0 border" id="balance-sheet-search-date"><i class="fas fa-calendar-alt"></i> Select by Date</button>
			<button type="button" class="btn btn-success btn-lg font-12 rounded-0 border" id="balance-sheet-print"><i class="fas fa-print"></i> Print BS</button>
		</div>
	</div>
	<!-- ASSETS -->
	<div class="row w-100">
		<div class="col-6">
			<div class="" id="cont-search-t-bal">
		 		<table class="table table-sm font-12">
					<thead>
						<tr>
							<th class="">MAIN</th>
							<th class="">GROUP</th>
							<th class="">SUB</th>
							<th class="text-right">AMOUNT</th>
						</tr>
					</thead>
					<tbody>
						<?php $tot_amount=0; ?>
						<?php $i=0; ?>
						<?php foreach ($assets as $row): ?>
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
								<td class="text-right font-weight-bold"><?php echo $row->amount > 0 ? number_format($row->amount, 2) : ''; ?></td>
							</tr>
						<?php $tot_amount 	+= $row->amount > 0 ? $row->amount : 0; ?>
						<?php $i++; ?>
						<?php endforeach ?>
					</tbody>
					<tfoot>
						<tr>
							<th></th>
							<th></th>
							<th>TOTAL:</th>
							<th class="text-right"><?php echo number_format($tot_amount, 2); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

		<!-- LIABILITIES -->
		<div class="col-6">
			<div class="" id="cont-search-t-bal">
		 		<table class="table table-sm font-12">
					<thead>
						<tr>
							<th class="">MAIN</th>
							<th class="">GROUP</th>
							<th class="">SUB</th>
							<th class="text-right">AMOUNT</th>
						</tr>
					</thead>
					<tbody>
						<?php $tot_amount=0; ?>
						<?php $i=0; ?>
						<?php foreach ($liabilities as $row): ?>
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
								<td class="text-right font-weight-bold"><?php echo $row->amount > 0 ? number_format($row->amount, 2) : ''; ?></td>
							</tr>
						<?php $tot_amount 	+= $row->amount > 0 ? $row->amount : 0; ?>
						<?php $i++; ?>
						<?php endforeach ?>
					</tbody>
					<tfoot>
						<tr>
							<th></th>
							<th></th>
							<th>TOTAL:</th>
							<th class="text-right"><?php echo number_format($tot_amount, 2); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

	</div>
	
</div>
