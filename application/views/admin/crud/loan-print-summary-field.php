<div class="modal-header">
  <h5 class="modal-title" id="cust-modal-title"></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-12 pb-3">
      <button type="button" class="btn btn-default btn-lg font-12 rounded-0 border w-100" id="posted-crj-search-date"><i class="fas fa-calendar-alt"></i> Select by Date</button>
    </div>

  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-custom-default rounded-0" id="btnPrintLoanSummary" data-id="<?php echo !empty($id) ? $id : ''; ?>"><i class="fas fa-calendar-check"></i> Print</button>
</div>