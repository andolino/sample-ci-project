<div class="cont-benefit-claims row w-100">
	<div class="col-9">
 		<!-- <div class="row">
 			<div class="col-12">
					<a href="javascript:void(0);" class="float-right pr-2 pb-2" 
				id="loadPage" data-link="view-loan-app-page" data-badge-head="LOAN APPLICATION"
					data-cls="cont-tbl-constituent" data-placement="top" 
					data-toggle="tooltip" title="Back to Settings"><i class="fas fa-times"></i></a>
 			</div>	
		</div> -->
		<!-- <div class="row">
			<div class="col-4 pb-3">
				<button type="button" class="btn btn-default btn-lg font-12 rounded-0 border" id="btn-add-loans" data-field="ADD"> Add</button>
			</div>
		</div> -->
	<div class="row mb-3">
		<div class="col-3">
			<label for="" class="font-12">Approved Benefit Claim Request</label>
			<select class="custom-select custom-select-sm font-12" id="select-benefit-request-comp">
					<option value="" selected hidden></option>
					<?php foreach($benefit_request as $row): ?>
					<option value="<?php echo $row->members_id; ?>" data-reqid="<?php echo $row->benefit_request_id; ?>"><?php echo strtoupper($row->last_name) . ', ' . strtoupper($row->first_name) . ' ' . strtoupper($row->middle_name) . ' (' . $row->type_of_benefit . ') (' . str_pad($row->benefit_request_id, 5, '0', STR_PAD_LEFT) . ')'; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
 		<table class="table table-sm font-12" id="tbl-benefit-claim-members" data-page="">
			<thead>
				<tr>
					<th class="">NAME</th>
					<th class="">DATE OF EFFECTIVITY</th>
					<th class="">STATUS</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
	<div class="col-3">
		<div class="card loans-card-add none">
			<div class="card-body">
				<h5 class="title-loans-form"></h5>
				<div class="loans-cont-add"></div>
			</div>
		</div>
	</div>
	<!-- <button type="submit" class="btn btn-default btn-sm rounded-0 border float-right"><i class="fas fa-save"></i> Save</button> -->
</div>



<!-- add input multiple -->
<!-- <div class="col-12"></div>
<div class="col-3 mt-2 govt-name-cont">
	<label for="govt_name" class="font-12">Govertment ID's/Docs</label>
	<select class="custom-select custom-select-sm" id="govt_name" name="govt_name[]">
	  <option selected value="">-NONE-</option>
	</select>
</div>
<div class="col-3 mt-2 pl-0">
	<label for="govt_id" class="font-12">Gov't ID #</label>
	<input type="text" class="form-control form-control-sm" id="govt_id" name="govt_id[]" placeholder="...">
</div>
<div class="col-1 mt-4 pt-3 pl-0" id="addgovt-sect">
	<button type="button" class="btn btn-success btn-sm" id="add-govt-field"><i class="fas fa-plus"></i></button>
</div> -->
