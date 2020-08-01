<div class="cont-view-coa w-100 row none">
		<div class="col-7">
   		<div class="row">
   			<div class="col-12">
 					<a href="javascript:void(0);" class="float-right pr-2 pb-2" 
					id="loadPage" data-link="view-setting-page" data-badge-head="SETTINGS"
 					data-cls="custom-container" data-placement="top" 
 					data-toggle="tooltip" title="Back to Settings"><i class="fas fa-times"></i></a>
   			</div>
			</div>
   		<div class="row">
				<div class="col-4 pb-3">
					<select class="custom-select custom-select-sm" name="coa-select">
					  <option selected hidden>SET ACCOUNT</option>
					  <option value="1">SUB ACCOUNT</option>
					  <option value="2">MAIN ACCOUNT</option>
					</select>
				</div>
			</div>
			<table class="table table-sm font-12">
				<tr>
					<th>ACCOUNT TITLE</th>
					<th>ACCOUNT SUB TITLE</th>
					<th>ACCOUNT CODE</th>
					<th>ACCOUNT MAIN DESCRIPTION</th>
					<th>ACTION</th>
				</tr>
				<?php foreach ($coaData as $row): ?>
					<?php if ($row->id!=''): ?>
					<tr 
						class="<?php 
							if($row->class_desc != ''){
								echo ' act-tit';
							} else if($row->group_desc != ''){
								echo ' sub-tit';
							}
						?>">
						<td><?php echo strtoupper($row->class_desc); ?></td>
						<td><?php echo strtoupper($row->group_desc); ?></td>
						<td class="text-center"><?php echo $row->code; ?></td>
						<td><?php echo strtoupper($row->main_desc); ?></td>
						<td class="text-center">
							<!-- EDIT -->
							<?php if ($row->class_desc !=''): ?>
							<?php elseif($row->group_desc!=''): ?>
								<a href="javascript:void(0);" onclick="editGroupCodeCoa(this)" data-gcode="<?php echo $row->group_code; ?>"><i class="fas fa-edit" data-toogle="tooltip" data-placement="right" title="Edit"></i></a>
							<?php elseif($row->main_desc!=''): ?>
								<a href="javascript:void(0);" onclick="editMainCodeCoa(this)" data-mcode="<?php echo $row->main_code; ?>"><i class="fas fa-edit" data-toogle="tooltip" data-placement="right" title="Edit"></i></a> 
							<?php endif; ?>

							<!-- DELETE -->
							<?php if ($row->class_desc !=''): ?>
							<?php elseif($row->group_desc!=''): ?>
								<a href="javascript:void(0);" onclick="deleteData(this)" data-fld="group_code" data-tbl="account_groups" data-code="<?php echo $row->group_code; ?>"><i class="fas fa-trash" data-toogle="tooltip" data-placement="right" title="Delete"></i></a>
							<?php elseif($row->main_desc!=''): ?>
								<a href="javascript:void(0);" onclick="deleteData(this)" data-fld="main_code" data-tbl="account_main" data-code="<?php echo $row->main_code; ?>"><i class="fas fa-trash" data-toogle="tooltip" data-placement="right" title="Delete"></i></a> 
							<?php endif; ?>
						</td>
					</tr>
					<?php endif; ?>
				<?php endforeach; ?>

			</table>
		</div>

		<div class="col-5 ">
			<div class="card coa-card-add none">
				<div class="card-body">
					<h5 class="title-coa-form"></h5>
					<div class="coa-cont-add"></div>
				</div>
			</div>
		</div>

</div>