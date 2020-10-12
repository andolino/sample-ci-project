<div class="cont-view-immediate-family-relation w-100 row none">
		<div class="col-7">
   		<div class="row">
   			<div class="col-12">
 					<a href="javascript:void(0);" class="float-right pr-2 pb-2" 
					id="loadPage" data-link="view-setting-page" data-badge-head="DASHBOARD"
 					data-cls="custom-container" data-placement="top" 
 					data-toggle="tooltip" title="Back to Settings"><i class="fas fa-times"></i></a>
   			</div>
			</div>
   		<div class="row">
				<div class="col-4 pb-3">
					<button type="button" class="btn btn-sm font-12 btn-default rounded-0 border" id="loadSidePage" data-fn="add" data-link="get-immediate-family-frm" data-title="ADD IMMEDIATE FAMILY" data-id="<?php echo $members_id; ?>"><i class="fas fa-user-plus"></i> Add Immediate Family</button>
				</div>
			</div>
			<table class="table table-sm font-12" id="tbl-immediate-family-settings" data-id="<?php echo $members_id; ?>">
				<thead>
					<tr>
						<th>NAME</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>

		<div class="col-5 ">
			<div class="card cont-card-add none">
				<div class="card-body">
					<h5 class="title-cont-form"></h5>
					<div class="cont-add-body">
						
					</div>
				</div>
			</div>
		</div>

</div>