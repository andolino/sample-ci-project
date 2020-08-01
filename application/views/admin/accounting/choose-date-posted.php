<div class="modal-header">
  <h5 class="modal-title" id="cust-modal-title"></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-12">
      <label for="date_posted" class="font-12">Date Posted.</label>
      <input type="text" value="" class="form-control form-control-sm font-12 rounded-0 pickerDate" id="date_posted" name="date_posted" placeholder="...">
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-custom-default rounded-0" id="btnPickDatePosted" data-id="<?php echo !empty($id) ? $id : ''; ?>"><i class="fas fa-calendar-check"></i> Post</button>
</div>