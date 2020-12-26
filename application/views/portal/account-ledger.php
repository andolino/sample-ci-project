<div class="cont-add-member row w-100 m-auto">
	<div class="col-sm-12 req-ln-tbl">
		<h4><?php echo $title; ?></h4>
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-3">
				<!-- <button type="button" class="btn btn-purple btn-sm rounded-0 border mb-3 w-100" onclick="
					animateSingleOut('.req-ln-tbl', 'fadeOut');
					setTimeout(function(){ animateSingleIn('.req-ln-frm', 'fadeIn'); },1000)"><i class="fas fa-save"></i> ACCOUNTING LEDGER</button> -->
			</div>
		</div>
		<table class="table font-12 w-100 condensed" id="">
			<thead>
				<tr>
					<!-- <th scope="col"><input type="checkbox" id="chk-const-list-tbl-all" name="chk-const-list-tbl-all"></th> -->
					<th scope="col">DATE</th>
					<th class="text-right" scope="col">DEBIT</th>
					<th class="text-right" scope="col">CREDIT</th>
					<th class="text-right" scope="col">BALANCE</th>
				</tr>
			</thead>
			<tbody>
				<?php $totDeb  = 0; ?>
				<?php $totCred = 0; ?>
				<?php $totBal  = 0; ?>
				<?php foreach($ledger as $row): ?>
				<tr>
					<td><?php echo $row->payment_schedule == '' ? '' : date('F j', strtotime($row->payment_schedule)); ?></td>
					<td class="text-right"><?php echo $row->debit == '' ? '' : number_format($row->debit, 2); ?></td>
					<td class="text-right"><?php echo $row->credit == '' ? '' : number_format($row->credit, 2); ?></td>
					<td class="text-right"><?php echo $row->balance == '' ? '' : number_format($row->balance, 2); ?></td>
				</tr>
				<?php 
					$totDeb += $row->debit;
					$totCred += $row->credit;
				 	$totBal = $row->balance;
				?>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<!-- <th scope="col"><input type="checkbox" id="chk-const-list-tbl-all" name="chk-const-list-tbl-all"></th> -->
					<th scope="col">DATE</th>
					<th class="text-right" scope="col"><?php echo $totDeb > 0 ? number_format($totDeb, 2) : ''; ?></th>
					<th class="text-right" scope="col"><?php echo $totCred > 0 ? number_format($totCred, 2) : ''; ?></th>
					<th class="text-right" scope="col"><?php echo $totBal > 0 ? number_format($totBal, 2) : ''; ?></th>
				</tr>
			</tfoot>
		</table>
		<button type="button" class="btn btn-danger btn-sm rounded-0 border float-right mt-3" onclick="window.location.reload()"><i class="fas fa-times"></i> BACK</button>
	</div>
	<div class="col-sm-12 req-ln-attmnt none">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-3">
				
			</div>
		</div>
		<table class="table font-12 w-100" id="tbl-portal-loan-request-attmnt">
			<thead>
				<tr>
					<!-- <th scope="col"><input type="checkbox" id="chk-const-list-tbl-all" name="chk-const-list-tbl-all"></th> -->
					<th scope="col">FILE NAME</th>
					<th scope="col">ACTION</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
		<button type="button" class="btn btn-danger btn-sm rounded-0 border float-right mt-3" onclick="
					animateSingleOut('.req-ln-attmnt', 'fadeOut');
					setTimeout(function(){ animateSingleIn('.req-ln-tbl', 'fadeIn'); },1000)"><i class="fas fa-times"></i> BACK</button>
	</div>
	<div class="col-sm-12 req-ln-msg none">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-3">
				
			</div>
		</div>
		<div class="container req-ln-msg-container">
			
		</div>

		<button type="button" class="btn btn-danger btn-sm rounded-0 border float-right mt-3" onclick="
					animateSingleOut('.req-ln-msg', 'fadeOut');
					setTimeout(function(){ animateSingleIn('.req-ln-tbl', 'fadeIn'); },1000)"><i class="fas fa-times"></i> BACK</button>
	</div>
	<div class="col-sm-12 req-ln-frm none">
		<form id="frm-request-a-benefit" enctype="multipart/form-data">
			<div class="row">
					<!-- heading -->
					<div class="col-sm-12 mb-3">
						<div class="navbar mb-0">
							<h6 class="mb-0"><i class="fas fa-user-cog"></i> Benefit Request</h6>
						</div>
					</div>
					<!-- end -->
					<div class="col-sm-6 mb-2">
						<label for="benefit_type_id" class="font-12">Benefit Type</label>
						<select class="custom-select custom-select-sm font-12" id="benefit_type_id" name="benefit_type_id" required>
						  <option selected hidden value="">-SELECT-</option>
						  <?php foreach ($benefit_type as $row): ?>
						  	<option value="<?php echo $row->benefit_type_id; ?>"><?php echo $row->description; ?></option>
						  <?php endforeach; ?>
						</select>
						<div class="row mt-2">
							<div class="col-sm-12">
								<label for="date_effectivity" class="font-12">Date of Effectivity</label>
								<input type="text" class="form-control form-control-sm font-12" id="date_effectivity" name="date_effectivity" required>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-sm-12 mo-term-n-amnt none"></div>
							<div class="col-sm-6 mt-2">
								<fieldset>      
									<label class="font-12">Files : </label>                     
									<input type="file" multiple="" name="files[]" class="font-12" required>                             
								</fieldset> 
							</div>
						</div>
					</div>
					
					<!-- <div class="col-sm-6">
            <div class="form-group">
              <label for="description" class="font-12">Purpose of Loan</label>
              <textarea class="form-control font-12" id="description" name="description" rows="3"></textarea>
            </div>
          </div> -->
					<!-- heading -->
					<!-- <div class="col-sm-12 mb-3 mt-4">
						<div class="navbar mb-0">
							<h6 class="mb-0"><i class="fas fa-address-card"></i> Contact Details</h6>
						</div>
					</div> -->
					<!--  -->
					
					<!-- heading -->
					<!-- <div class="col-sm-12 mb-3 mt-4">
						<div class="navbar mb-0">
							<h6 class="mb-0"><i class="fas fa-child"></i> Family Background</h6>
						</div>
					</div> -->
					<!-- end -->
					<input type="hidden" id="has_update" name="has_update" value="<?php echo $members_id; ?>">
			</div>	
			<div class="line mt-3 mb-3 pt-0 pb-0"></div>
			<button type="button" class="btn btn-danger btn-sm rounded-0 border float-right" onclick="
					animateSingleOut('.req-ln-frm', 'fadeOut');
					setTimeout(function(){ animateSingleIn('.req-ln-tbl', 'fadeIn'); },1000)"><i class="fas fa-times"></i> BACK</button>
			<button type="submit" class="btn btn-default btn-sm rounded-0 border float-right"><i class="fas fa-save"></i> SUBMIT</button>
		</form>

	</div>
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

<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="newpw" tabindex="-1" aria-labelledby="newpwLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<form action="" id="frm-update-password">
				<input type="hidden" value="<?php echo $members_id; ?>" name="members_id">
				  <input type="password" class="form-control form-control-sm" id="new_password" name="new_password">
				</form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="$('#frm-update-password').trigger('submit');" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>


<style>
.chat{
    list-style: none;
    margin: 0;
    padding: 0;
}

.chat li{
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
}

.chat li.left .chat-body{
    margin-left: 60px;
}

.chat li.right .chat-body{
    margin-right: 60px;
}

.chat li .chat-body p{
    margin: 0;
    color: #777777;
}

.panel .slidedown .glyphicon, .chat .glyphicon{
    margin-right: 5px;
}

.panel-body{
    overflow-y: scroll;
    height: 250px;
}

::-webkit-scrollbar-track{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

::-webkit-scrollbar {
    width: 12px;
    background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}

.chat-img.pull-left {
	float:left;
}

.chat-img.pull-right {
	float:right;
}
</style>