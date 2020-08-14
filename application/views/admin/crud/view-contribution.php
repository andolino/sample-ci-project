<div class="cont-tbl-contribution row none">
	<div class="col-12">
		<a href="javascript:void(0);" class="float-right pr-2 pb-2" id="loadPage" data-link="tbl-members" data-badge-head="MEMBER LIST"
   								data-cls="cont-tbl-constituent" data-placement="top" data-toggle="tooltip" title="Back to List"><i class="fas fa-times"></i></a>
	</div>
	<div class="col-12">
		<div class="row d-none">
		  <div class="col-4 mb-3">
		    <button type="button" class="btn btn-default btn-md rounded-0 font-12" id="add-contribution" data-m-id="<?php echo $members_id ?? ''; ?>"><i class="fas fa-user-plus"></i> Add Contribution</button>
		  </div>
		</div>

		<table class="table font-12 w-100" id="tbl-contribution" data-m-id="<?php echo $members_id ?? ''; ?>">
		  <thead>
		    <tr>
		      <th scope="col">ID #</th>
		      <th scope="col">TOTAL</th>
		      <th scope="col">BALANCE</th>
		      <th scope="col">DEDUCTION</th>
		      <th scope="col">OR NO.</th>
		      <th scope="col">DATE</th>
		      <th scope="col">ACTION</th>
		    </tr>
		  </thead>
		  <tbody>
		    
		  </tbody>
		</table>

	</div>
</div>