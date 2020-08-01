<div class="modal-header">
  <h5 class="modal-title" id="cust-modal-title"></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
    <form id="frm-add-loan-payments-by-type">
      <div class="row">
        <div class="col-4 mt-2">
          <div class="row">
            <div class="col-12">
              <label for="status" class="font-12">OFFICE MANAGEMENT</label>
              <select class="custom-select custom-select-sm mb-2 font-12 rounded-0" id="office_management_id" name="office_management_id" required>
                <option value="" hidden>--</option>
                <?php foreach ($officeManagement as $row): ?>
                  <option value="<?php echo $row->office_management_id; ?>"><?php echo $row->office_name ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-12">
              <label for="date_applied" class="font-12">DATE PAID</label>
              <input type="text" class="form-control form-control-sm font-12 rounded-0 select-date-repayments" id="date_applied" value="" name="date_applied" placeholder="..." required>
            </div>
          </div>
        </div>
        <div class="col-8 mt-2">
          <span class="badge badge-info"><i>Select date paid you want to pay</i></span>
          <table class="table font-12 w-100" id="tbl-members-due-to-pay">
            <thead>
              <tr>
                <th scope="col">NAME</th>
                <th scope="col">AMOUNT TO PAY</th>
                <th scope="col">INTEREST TO PAY</th>
              </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
              <tr>
                <th>TOTAL:</th>
                <th></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <input type="hidden" name="has_update" value="<?php echo $has_update ?? ''; ?>">
    </form>
  </div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-custom-default rounded-0 font-12" id="btnAddLoanPaymentByType"><i class="fas fa-check"></i> Submit</button>
</div>

<style>
  .datepicker{z-index:1151 !important;}
</style>