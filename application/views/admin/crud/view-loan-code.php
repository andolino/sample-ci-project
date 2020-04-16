<div class="cont-view-ltype w-100 row none">
		<div class="col-7">
   		<div class="row">
   			<div class="col-12">
 					<a href="javascript:void(0);" class="float-right pr-2 pb-2" 
					id="loadPage" data-link="view-setting-page" data-badge-head="SETTINGS"
 					data-cls="custom-container" data-placement="top" 
 					data-toggle="tooltip" title="Back to Settings"><i class="fas fa-times"></i></a>
   			</div>
			</div>
   		<table class="table table-sm font-12">
				<thead>
					<tr>
						<th>LOAN CODE</th>
						<th>NAME TYPE</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($loanCode as $row): ?>
					<tr>
						<td><?php echo $row->loan_code; ?></td>
						<td><?php echo $row->loan_type_name; ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>


</div>