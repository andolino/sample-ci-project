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
        <option value="1">Members</option>
        <option value="2">Official Station</option>
        <option value="3">Loans</option>
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
      <label for="date_range" class="font-12">Date Range</label>
      <input type="text" class="form-control font-12 rounded-0" id="date_range" name="date_range" data-pick="<?php echo date('Y-01-01') . ' ' . date('Y-m-t');?>">
    </div>
  </div>
</div>
<div class="modal-footer">
  <a href="#" class="btn btn-sm btn-success rounded-0" onclick="exportMemberContribution(this)" data-id="<?php echo !empty($id) ? $id : ''; ?>"><i class="fas fa-file-excel"></i> Print Excel</a>
  <button type="button" class="bstn btn-sm btn-danger rounded-0" id="membersOfcContribution" data-id="<?php echo !empty($id) ? $id : ''; ?>"><i class="fas fa-file-pdf"></i> Post Docx</button>
</div>

<div id="print-container-docx-or-excel" class="d-none">
  

</div>