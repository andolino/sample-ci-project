	<?php if (!empty($members_id)): ?>
		
	<div class="cont-loans-by-mem row w-100 none">
		<div class="col-9">
   		<div class="row">
   			<!-- <div class="col-12">
 					<a href="javascript:void(0);" class="float-right pr-2 pb-2" 
					id="loadPage" data-link="view-loan-app-page" data-badge-head="LOAN APPLICATION"
 					data-cls="cont-tbl-constituent" data-placement="top" 
 					data-toggle="tooltip" title="Back to Settings"><i class="fas fa-times"></i></a>
   			</div>	 -->
			</div>
			<!-- <div class="row">
				<div class="col-4 pb-3">
					<button type="button" class="btn btn-default btn-lg font-12 rounded-0 border" id="btn-add-loans" data-field="ADD"> Add</button>
				</div>
			</div> -->
   		<table class="table table-sm font-12" id="tbl-loans-by-member" data-page="" data-id="<?php echo $members_id; ?>">
				<thead>
					<tr>
						<th class="">LOAN TYPE.</th>
						<th class="">REF NO.</th>
						<th class="">FULL NAME</th>
						<th class="">START PAYMENT</th>
						<th class="">END PAYMENT</th>
						<th class="">LOAN AMOUNT</th>
						<th class="">PAYMENT</th>
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


<?php else: ?>


	<div class="cont-loans-by-mem row w-100">
		<div class="col-9">
   		<div class="row">
   			<div class="col-12">
 					<a href="javascript:void(0);" class="float-right pr-2 pb-2" 
					id="loadPage" data-link="view-loan-app-page" data-badge-head="LOAN APPLICATION"
 					data-cls="cont-tbl-constituent" data-placement="top" 
 					data-toggle="tooltip" title="Back to Settings"><i class="fas fa-times"></i></a>
   			</div>	
			</div>
			<!-- <div class="row">
				<div class="col-4 pb-3">
					<button type="button" class="btn btn-default btn-lg font-12 rounded-0 border" id="btn-add-loans" data-field="ADD"> Add</button>
				</div>
			</div> -->
   		<table class="table table-sm font-12" id="tbl-loans-by-member" data-page="" data-id="">
				<thead>
					<tr>
						<th class="">LOAN TYPE.</th>
						<th class="">REF NO.</th>
						<th class="">FULL NAME</th>
						<th class="">START PAYMENT</th>
						<th class="">END PAYMENT</th>
						<th class="">LOAN AMOUNT</th>
						<th class="">PAYMENT</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<div class="col-3">
			<div class="card loans-card-add none">
			<a href="#" class="font-12" style="text-align: right;
																					padding-right: 10px;
																					padding-top: 10px;" onclick="animateSingleOut('.loans-card-add', 'fadeOut');"><i class="fas fa-times"></i></a>
				<div class="card-body">
					<h5 class="title-loans-form"></h5>
					<div class="loans-cont-add"></div>
				</div>
			</div>
		</div>

		
		<!-- <button type="submit" class="btn btn-default btn-sm rounded-0 border float-right"><i class="fas fa-save"></i> Save</button> -->
	</div>

	<?php endif; ?>


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
