<?php if($loan_code_id == 3): ?>
<div class="form-group mb-1">
  <label for="amnt_applied" class="font-12">Amount</label>
  <input type="text" class="form-control form-control-sm font-12" id="amnt_applied" name="amnt_applied"/>
</div>
<?php else: ?>
<label for="mo_terms" class="font-12">Months</label>
<select class="custom-select custom-select-sm font-12" id="mo_terms" name="mo_terms">
  <option selected hidden value="">-SELECT-</option>
  <?php foreach ($loan_settings as $row): ?>
    <option value="<?php echo $row->loan_settings_id; ?>"><?php echo $row->number_of_month; ?></option>
  <?php endforeach; ?>
</select>
<?php endif; ?>