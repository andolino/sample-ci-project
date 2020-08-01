<div class="modal-header">
  <h5 class="modal-title" id="cust-modal-title"></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-12 mt-2">
      <label for="date_posted" class="font-12">Type of Print</label>
      <select class="form-control-sm custom-select custom-select-sm rounded-0 font-12" id="select-type-to-print">
        <option value="1">Official Station/Region</option>
        <option value="2">Members</option>
        <option value="3">Departments</option>
      </select>
    </div>
    <div class="col-12 mt-2">
      <label for="date_posted" class="font-12">Choose Members</label>
      <select class="form-control custom-select custom-select-sm rounded-0 font-12" id="select-members-to-print">
        <?php foreach ($members as $row): ?>
          <option value="<?php echo $row->members_id; ?>"><?php echo strtoupper($row->id_no . '-' . $row->last_name . ', ' . $row->first_name); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-12 mt-2">
      <label for="date_posted" class="font-12">Official Station</label>
      <select class="form-control custom-select custom-select-sm rounded-0 font-12" id="select-office-to-print">
        <?php foreach ($office_management as $row): ?>
          <option value="<?php echo $row->office_management_id; ?>"><?php echo strtoupper($row->office_name); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-12 mt-2">
      <label for="select-dept-to-print" class="font-12">Departments</label>
      <select class="form-control form-control-sm custom-select custom-select-sm rounded-0 font-12" id="select-dept-to-print">
        <option value="" hidden selected>--</option>
        <option value="CENTRAL OFFICE">CENTRAL OFFICE</option>
        <option value="REGIONAL OFFICE">REGIONAL OFFICE</option>
      </select>
    </div>
    <div class="col-12 mt-2">
      <label for="remarks" class="font-12">Remarks</label>
      <input type="text" class="form-control font-12 rounded-0" id="remarks" name="remarks">
    </div>
    <div class="col-12 mt-2">
      <label for="date_range_cg" class="font-12">Date Range</label>
      <input type="text" class="form-control font-12 rounded-0" id="date_range_cg" name="date_range_cg">
    </div>
  </div>
</div>
<div class="modal-footer">
  <a href="#" class="btn btn-sm btn-success rounded-0" onclick="exportCashGift(this)" data-id="<?php echo !empty($id) ? $id : ''; ?>"><i class="fas fa-file-excel"></i> Print Excel</a>
  <a href="#" class="btn btn-sm btn-danger rounded-0" data-id="<?php echo !empty($id) ? $id : ''; ?>"><i class="fas fa-file-pdf"></i> Print PDF</a>
  <!-- <button type="button" class="bstn btn-sm btn-danger rounded-0" onclick="window.open('print-members-docx/<?php //echo !empty($id) ? $id : ''; ?>')" data-id="<?php //echo !empty($id) ? $id : ''; ?>"><i class="fas fa-file-pdf"></i> Post Docx</button> -->
</div>

<div id="print-container-docx-or-excel" class="d-none">
  

</div>