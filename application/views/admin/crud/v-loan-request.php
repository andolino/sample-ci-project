<div class="cont-loans-by-mem row w-100">
		<div class="col-sm-9">
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
   		
			<ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active font-12" id="home-tab" onclick="tbl_loans_by_request_pending.draw(); animateSingleOut('.loans-card-add', 'fadeOut')" data-toggle="tab" href="#pending_request" role="tab" aria-controls="home" aria-selected="true">Pending Request</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link font-12" id="profile-tab" onclick="tbl_loans_by_request_approved.draw(); animateSingleOut('.loans-card-add', 'fadeOut')" data-toggle="tab" href="#approved_request" role="tab" aria-controls="profile" aria-selected="false">Approved Request</a>
				</li>
				<li class="nav-item" role="presentation">
          <a class="nav-link font-12" id="profile-tab" onclick="tbl_loans_by_request_disapproved.draw() animateSingleOut('.loans-card-add', 'fadeOut')" data-toggle="tab" href="#disapproved_request" role="tab" aria-controls="profile" aria-selected="false">Disapproved Request</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active pt-3" id="pending_request" role="tabpanel" aria-labelledby="home-tab">
					<table class="table table-sm font-12 w-100" id="tbl-loans-by-request-pending" data-flag="0" data-id="">
						<thead>
							<tr>
								<th class="">REQUEST NO.</th>
								<th class="">MEMBERS NAME.</th>
								<th class="">LOAN REQUEST</th>
								<th class="">PURPOSE.</th>
								<th class="">AMOUNT</th>
								<th class="">APPROVED BY</th>
								<th class="">DATE/TIME</th>
								<th class="">DATE/TIME</th>
								<th class="">STATUS</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
        </div>
        <div class="tab-pane fade pt-3" id="approved_request" role="tabpanel" aria-labelledby="profile-tab">
					<table class="table table-sm font-12 w-100" id="tbl-loans-by-request-approved" data-flag="1" data-id="">
						<thead>
							<tr>
								<th class="">REQUEST NO.</th>
								<th class="">MEMBERS NAME.</th>
								<th class="">LOAN REQUEST</th>
								<th class="">PURPOSE.</th>
								<th class="">AMOUNT</th>
								<th class="">APPROVED BY</th>
								<th class="">DATE/TIME</th>
								<th class="">DATE/TIME</th>
								<th class="">STATUS</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
        <div class="tab-pane fade pt-3" id="disapproved_request" role="tabpanel" aria-labelledby="profile-tab">
					<table class="table table-sm font-12 w-100" id="tbl-loans-by-request-disapproved" data-flag="2" data-id="">
						<thead>
							<tr>
								<th class="">REQUEST NO.</th>
								<th class="">MEMBERS NAME.</th>
								<th class="">LOAN REQUEST</th>
								<th class="">PURPOSE.</th>
								<th class="">AMOUNT</th>
								<th class="">DISAPPROVED BY</th>
								<th class="">DATE/TIME</th>
								<th class="">REMARKS</th>
								<th class="">STATUS</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
      </div>


		</div>
		<div class="col-sm-3">
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