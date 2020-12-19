<div class="modal-header">
  <h5 class="modal-title" id="cust-modal-title"></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
    <form id="frm-add-contribution-by-type">
      <div class="row">
        <div class="col-6 mt-2">
          <!-- <label for="status" class="font-12">OFFICE MANAGEMENT</label>
          <select class="custom-select custom-select-sm mb-2 font-12 rounded-0" id="office_management_id" name="office_management_id" required>
            <option value="" hidden>--</option>
            <?php //foreach ($officeManagement as $row): ?>
              <option value="<?php //echo $row->office_management_id; ?>"><?php //echo $row->office_name ?></option>
            <?php //endforeach; ?>
          </select> -->
          <label for="department_id" class="font-12">DEPARTMENTS</label>
          <select class="custom-select custom-select-sm mb-2 font-12 rounded-0" id="department_id" name="department_id" required>
            <option value="" hidden>--</option>
            <?php foreach ($departments as $row): ?>
              <option value="<?php echo $row->departments_id; ?>"><?php echo $row->region; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-6 mt-2">
          <label for="date_applied" class="font-12">DATE REMITTED</label>
          <input type="text" class="form-control form-control-sm font-12 rounded-0" id="date_applied" value="" name="date_applied" placeholder="..." required>
        </div>
        <!-- <div class="col-6 mt-2">
          <label for="remarks" class="font-12">REMARKS</label>
          <input type="text" class="form-control form-control-sm font-12 rounded-0" id="remarks" value="" name="remarks" placeholder="...">
        </div>
        <div class="col-6 mt-2">
          <label for="orno" class="font-12">OR NUMBER</label>
          <input type="text" class="form-control form-control-sm font-12 rounded-0" id="orno" value="" name="orno" placeholder="...">
        </div> -->
        <!-- <div class="col-6 mt-2">
          <label for="status" class="font-12">STATUS</label>
          <select class="custom-select custom-select-sm mb-2 font-12 rounded-0" id="status" name="status" required>
            <option value="" hidden>--</option>
            <option value="REGULAR">REGULAR</option>
            <option value="CASUAL">CASUAL</option>
            <option value="FIELD OFFICE">FIELD OFFICE</option>
          </select>
        </div> -->

      </div>
      <input type="hidden" name="has_update" value="<?php echo $has_update ?? ''; ?>">
    </form>
  </div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-custom-default rounded-0 font-12" id="btnAddContributionByType"><i class="fas fa-check"></i> Submit</button>
</div>