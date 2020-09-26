<div class="cont-view-benefit-type w-100 row none">
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
				<div class="col-4">
					<!-- <button type="button" class="btn btn-sm font-12 btn-default rounded-0 border" id="loadSidePage" data-link="get-benefit-type-frm" data-title="ADD BENEFIT TYPE" data-id=""><i class="fas fa-user-plus"></i> Add Benefit Type</button> -->
				</div>
			</div>
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active font-12" id="home-tab" data-toggle="tab" href="#loan_request" role="tab" aria-controls="home" aria-selected="true">Loan Request</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link font-12" id="profile-tab" data-toggle="tab" href="#benefit_claims" role="tab" aria-controls="profile" aria-selected="false">Benefit Claim Request</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="loan_request" role="tabpanel" aria-labelledby="home-tab">
        <form class="pt-2" id="frm-save-loan-approval-settings">
          <div class="card">
            <!-- <div class="row"> -->
              <div class="col-5 mt-3">
                <div class="form-group">
                  <label for="first_approver" class="font-12">Approver</label>
                  <select class="custom-select custom-select-sm" name="loan_first_approver_users_id">
                    <?php foreach($users as $row): ?>
                      <option value="<?php echo $row->users_id; ?>"><?php echo $row->screen_name; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-5">
                <div class="form-group none">
                  <label for="second_approver" class="font-12">Second Approver</label>
                  <div class="row">
                      <div class="col-12 font-12 pr-0">
                        <input type="checkbox" class="mt-2" name="loan_req_second_approver" value="1"> Require 2nd Approver
                      </div>
                      <div class="col-12 font-12 pr-0">
                        <input type="checkbox" class="mt-2" name="loan_override_first_approver" value="1" disabled> Override approval/disapproval of 1st approver
                      </div>
                      <div class="col-12 mt-2">
                        <select class="custom-select custom-select-sm" name="loan_second_approver_users_id">
                        <?php foreach($users as $row): ?>
                            <option value="<?php echo $row->users_id; ?>"><?php echo $row->screen_name; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-sm font-12 btn-default rounded-0 border mb-3"><i class="fas fa-save"></i> UPDATE</button>
              </div>
            <!-- </div> -->
          </div>
          
        </form>
        </div>
        <div class="tab-pane fade" id="benefit_claims" role="tabpanel" aria-labelledby="profile-tab">
          <form class="pt-2" id="frm-save-benefit-approval-settings">
            <div class="card">
              <!-- <div class="row"> -->
                <div class="col-5 mt-3">
                  <div class="form-group">
                    <label for="first_approver" class="font-12">Approver</label>
                    <select class="custom-select custom-select-sm" name="loan_first_approver_users_id">
                      <?php foreach($users as $row): ?>
                        <option value="<?php echo $row->users_id; ?>"><?php echo $row->screen_name; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-5">
                  <div class="form-group none">
                    <label for="second_approver" class="font-12">Second Approver</label>
                    <div class="row">
                        <div class="col-12 font-12 pr-0">
                          <input type="checkbox" class="mt-2" name="loan_req_second_approver" value="1"> Require 2nd Approver
                        </div>
                        <div class="col-12 font-12 pr-0">
                          <input type="checkbox" class="mt-2" name="loan_override_first_approver" value="1" disabled> Override approval/disapproval of 1st approver
                        </div>
                        <div class="col-12 mt-2">
                          <select class="custom-select custom-select-sm" name="loan_second_approver_users_id">
                          <?php foreach($users as $row): ?>
                              <option value="<?php echo $row->users_id; ?>"><?php echo $row->screen_name; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-sm font-12 btn-default rounded-0 border mb-3"><i class="fas fa-save"></i> UPDATE</button>
                </div>
              <!-- </div> -->
            </div>
            
          </form>
        </div>
      </div>
		</div>

		<div class="col-5 ">
			<div class="card cont-card-add none">
				<div class="card-body">
					<h5 class="title-cont-form"></h5>
					<div class="cont-add-body"></div>
				</div>
			</div>
		</div>

</div>