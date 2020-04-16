<div class="modal-header">
  <h5 class="modal-title" id="cust-modal-title"></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <form id="frm-pick-date-pay">
    <table class="table font-12 w-100" id="tbl-sched-pymnt-select">
      <tr>
        <td></td>
        <td class="text-right font-weight-bold">Schedule</td>
        <td class="text-right font-weight-bold">Monthly Amortization</td>
        <td class="text-right font-weight-bold">Balance</td>
        <td class="text-right font-weight-bold">Principal</td>
        <td class="text-right font-weight-bold">Monthly Interest</td>
        <td class="text-right font-weight-bold">Int Balance</td>
      </tr>
      <?php 
        $mA =0;
        $mAB =0;
        $ppl =0;
        $moInt =0;
        $intB =0;
      ?>
      <?php foreach ($loanSched as $row): ?>
      <tr>
        <td><input type="checkbox" id="chk-const-list-tbl-all" name="chk-select-payment-sched" value="<?php echo $row->loan_schedule_id; ?>"></td>
        <td class="text-right"><?php echo $row->payment_schedule; ?></td>
        <td class="text-right"><?php echo number_format($row->monthly_amortization, 2); ?></td>
        <td class="text-right"><?php echo number_format($row->monthly_amortization - $row->amnt_paid, 2); ?></td>
        <td class="text-right"><?php echo number_format($row->principal, 2); ?></td>
        <td class="text-right"><?php echo number_format($row->monthly_interest, 2); ?></td>
        <td class="text-right"><?php echo number_format($row->monthly_interest - $row->interest_paid, 2); ?></td>
      </tr>
      <?php 
        $mA    += $row->monthly_amortization;
        $mAB   += ($row->monthly_amortization - $row->amnt_paid);
        $ppl   += $row->principal;
        $moInt += $row->monthly_interest;
        $intB  += ($row->monthly_interest - $row->interest_paid);
      ?>
      <?php endforeach; ?>
      <tfoot>
        <tr>
          <th>TOTAL: </th>
          <th></th>
          <th class="text-right"><?php echo number_format($mA, 2); ?></th>
          <th class="text-right"><?php echo number_format($mAB, 2); ?></th>
          <th class="text-right"><?php echo number_format($ppl, 2); ?></th>
          <th class="text-right"><?php echo number_format($moInt, 2); ?></th>
          <th class="text-right"><?php echo number_format($intB, 2); ?></th>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-custom-default rounded-0" id="btnPickDatePay"><i class="fas fa-calendar-check"></i> Pick this date</button>
</div>