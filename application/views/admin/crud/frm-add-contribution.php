<div class="modal-header">
  <h5 class="modal-title" id="cust-modal-title"></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
    <form id="frm-add-contribution">
      <div class="row">
        <div class="col-12 mb-2">
          <div class="navbar mb-0">
            <h6 class="mb-0"><i class="fas fa-user-cog"></i> Members Info</h6>
          </div>
        </div>
        <div class="col-6">
          <label for="id_no" class="font-12">ID No.</label>
          <input type="text" class="form-control form-control-sm font-12" id="id_no" name="id_no" value="<?php echo !empty($membersData) ? $membersData->id_no : ''; ?>" placeholder="..." readonly="">
        </div>
        <div class="col-12 mt-2">
          <label for="office_name" class="font-12">REGION</label>
          <input type="text" class="form-control form-control-sm font-12" id="office_name" value="<?php echo !empty($contributionData) ? $contributionData->region : ''; ?>" name="office_name" placeholder="..." readonly="">
        </div>
        <div class="col-12 mt-2">
          <label for="office_name" class="font-12">OFFICIAL STATION</label>
          <input type="text" class="form-control form-control-sm font-12" id="office_name" value="<?php echo !empty($membersData) ? $membersData->office_name : ''; ?>" name="office_name" placeholder="..." readonly="">
        </div>
        <div class="col-6 mt-2">
          <label for="last_name" class="font-12">FULL NAME</label>
          <input type="text" class="form-control form-control-sm font-12" id="last_name" value="<?php echo !empty($membersData) ? strtoupper($membersData->last_name . ', ' . $membersData->first_name . ' ' . $membersData->middle_name) : ''; ?>" name="last_name" placeholder="..." readonly="">
        </div>
        <div class="col-12 mt-2 mb-2">
          <div class="navbar mb-0">
            <h6 class="mb-0"><i class="fas fa-user-cog"></i> Contribution Computation</h6>
          </div>
        </div>
        <!-- <div class="col-6 mt-2">
          <label for="orno" class="font-12">OR NUMBER</label>
          <input type="text" class="form-control form-control-sm font-12" id="orno" value="<?php //echo !empty($contributionData) ? $contributionData->orno : ''; ?>" name="orno" placeholder="..." required>
        </div> -->
        <div class="col-6 mt-2">
          <label for="date_applied" class="font-12">DATE REMITTED</label>
          <input type="date" class="form-control form-control-sm font-12" id="date_applied" value="<?php echo !empty($contributionData) ? strtoupper($contributionData->date_applied) : ''; ?>" name="date_applied" placeholder="..." required>
        </div>
        <!-- <div class="col-6 mt-2">
          <label for="total" class="font-12">TOTAL</label>
          <input type="text" class="form-control form-control-sm font-12 isNum" id="total" value="<?php //echo !empty($contributionData) ? strtoupper($contributionData->total) : ''; ?>" name="total" placeholder="...">
        </div> -->
        <!-- <div class="col-6 mt-2">
          <label for="balance" class="font-12">BALANCE</label>
          <input type="text" class="form-control form-control-sm font-12 isNum" id="balance" value="<?php //echo !empty($contributionData) ? strtoupper($contributionData->balance) : ''; ?>" name="balance" placeholder="...">
        </div> -->
        <div class="col-6 mt-2">
          <label for="adjusted_amnt" class="font-12">ADJUSTED AMOUNT</label>
          <input type="text" class="form-control form-control-sm font-12 isNum" id="adjusted_amnt" value="<?php echo !empty($contributionData) ? strtoupper($contributionData->adjusted_amnt) : ''; ?>" name="adjusted_amnt" placeholder="...">
        </div>
        <div class="col-6 mt-2">
          <label for="deduction" class="font-12">CONTIBUTION</label>
          <input type="text" class="form-control form-control-sm font-12 isNum" id="deduction" value="<?php echo !empty($contributionData) ? strtoupper($contributionData->deduction) : ''; ?>" name="deduction" placeholder="..." required>
        </div>
        <div class="col-6 mt-2">
          <label for="remarks" class="font-12">REMARKS</label>
          <input type="text" class="form-control form-control-sm font-12" id="remarks" value="<?php echo !empty($contributionData) ? strtoupper($contributionData->remarks) : ''; ?>" name="remarks" placeholder="..." readonly>
        </div>
        <!-- <div class="col-6 mt-2">
          <label for="status" class="font-12">STATUS</label>
          <select class="custom-select custom-select-sm mb-2 font-12" id="status" name="status" required>
            <option value="" hidden>--</option>
            <option value="REGULAR" <?php //echo !empty($contributionData) ? ($contributionData->status == 'REGULAR' ? 'selected' : '') : ''; ?>>REGULAR</option>
            <option value="CASUAL" <?php //echo !empty($contributionData) ? ($contributionData->status == 'CASUAL' ? 'selected' : '') : ''; ?>>CASUAL</option>
            <option value="FIELD OFFICE" <?php //echo !empty($contributionData) ? ($contributionData->status == 'FIELD OFFICE' ? 'selected' : '') : ''; ?>>FIELD OFFICE</option>
          </select>
        </div> -->
        
      </div>
      <input type="hidden" name="members_id" value="<?php echo !empty($contributionData) ? $contributionData->members_id : $membersData->members_id; ?>">
      <input type="hidden" name="has_update" value="<?php echo $has_update ?? ''; ?>">
    </form>
  </div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-custom-default rounded-0 font-12" id="btnAddContribution"><i class="fas fa-check"></i> Submit</button>
</div>