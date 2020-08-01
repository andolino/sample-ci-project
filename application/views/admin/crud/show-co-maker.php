<div class="modal-header">
  <h5 class="modal-title" id="cust-modal-title"></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <form id="frm-add-comaker" class="d-none">
    <div class="row">
      <div class="form-group col-4">
        <label for="last_name" class="col-form-label col-form-label-sm font-12">Last Name:</label>
        <input type="text" class="form-control form-control-sm font-12" id="last_name" name="last_name" required>
      </div>
      <div class="form-group col-4 pl-0">
        <label for="first_name" class="col-form-label col-form-label-sm font-12">First Name:</label>
        <input type="text" class="form-control form-control-sm font-12" id="first_name" name="first_name" required>
      </div>
      <div class="form-group col-4 pt-4 mt-1 pl-0">
        <input type="hidden" id="co_members_id_hddn" name="co_members_id_hddn">
        <button type="submit" class="btn btn-sm btn-success font-12"><i class="fa fa-plus"></i> Add</button>
      </div>
    </div>
  </form>
  <div class="navbar mb-2"><h6 class="mb-0">CO-MAKER LIST</h6></div>
  <table class="table font-12 w-100" id="tbl-comaker">
    <thead>
      <tr>
        <td class="text-right font-weight-bold">Members ID</td>
        <td class="text-right font-weight-bold">Members Last Name</td>
        <td class="text-right font-weight-bold">Members First Name</td>
        <td class="text-right font-weight-bold">Action</td>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
  <hr>
  <div class="navbar mb-2"><h6 class="mb-0">MEMBERS</h6></div>
  <table class="table font-12 w-100" id="tbl-members">
    <thead>
      <tr>
        <td class="text-right font-weight-bold">Members ID</td>
        <td class="text-right font-weight-bold">Members Last Name</td>
        <td class="text-right font-weight-bold">Members First Name</td>
        <td class="text-right font-weight-bold">Action</td>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>
<!-- <div class="modal-footer">
  <button type="button" class="btn btn-sm btn-custom-default rounded-0"><i class="fas fa-calendar-check"></i> </button>
</div> -->