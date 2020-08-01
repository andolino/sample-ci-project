<div class="modal-header">
  <h5 class="modal-title" id="cust-modal-title"></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
<!-- frm-pick-date-pay -->
  <form id="frm-update-payments">
    <table class="table font-12 w-100" id="tbl-sched-pymnt-select">
      <tr>
        <td class="text-right font-weight-bold">Schedule</td>
        <td class="text-center font-weight-bold">OR No. </td>
        <td class="text-right font-weight-bold">Amount to Pay</td>
        <td class="text-right font-weight-bold">Monthly Interest</td>
        <td class="text-right font-weight-bold">Amount Paid</td>
        <td class="text-right font-weight-bold">Interest Paid</td>
      </tr>
      <?php 
        $principal =0;
        $monthly_interest =0;
        $amnt_paid =0;
        $interest_paid =0;
      ?>
      <?php foreach ($loanSched as $row): ?>
      <tr>
        <td class="text-right"><?php echo $row->payment_schedule; ?></td>
        <td class="text-right"><input type="text" class="form-control form-control-sm font-12" data-id="<?php echo $row->loan_receipt_id; ?>" name="orno[]" value="<?php echo $row->orno; ?>"></td>
        <td class="text-right"><?php echo number_format($row->principal, 2); ?></td>
        <td class="text-right"><?php echo number_format($row->monthly_interest, 2); ?></td>
        <td class="text-right"><input type="text" class="form-control form-control-sm font-12 text-right isNum" id="edit-amnt-paid" value="<?php echo number_format($row->amnt_paid, 2); ?>" name="amnt_paid[]"></td>
        <td class="text-right"><input type="text" class="form-control form-control-sm font-12 text-right isNum" value="<?php echo number_format($row->interest_paid, 2); ?>" name="interest_paid[]" readonly></td>
      </tr>
      <?php 
        $principal += ($row->principal);
        $monthly_interest += ($row->monthly_interest);
        $amnt_paid += ($row->amnt_paid);
        $interest_paid += ($row->interest_paid);
      ?>
      <?php endforeach; ?>
      <tfoot>
        <tr>
          <th></th>
          <th class="text-right">TOTAL:</th>
          <th class="text-right"><?php echo number_format($principal, 2); ?></th>
          <th class="text-right"><?php echo number_format($monthly_interest, 2); ?></th>
          <th class="text-right"><?php echo number_format($amnt_paid, 2); ?></th>
          <th class="text-right"><?php echo number_format($interest_paid, 2); ?></th>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-custom-default rounded-0" onclick="$('#frm-update-payments').trigger('submit');"><i class="fas fa-calendar-check"></i> Update Payment</button>
</div>
