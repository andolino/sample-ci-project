<label for="select-payee" class="font-12">Payee.</label>
<select class="form-control custom-select custom-select-sm rounded-0" id="select-payee" name="payee_members_id">
  <option selected hidden value="">-SELECT-</option>
  <?php foreach ($members as $row): ?>
  	<option value="<?php echo $row->members_id; ?>" <?php echo !empty($has_update) ? ($has_update==$row->members_id ? 'selected' : '') : ''; ?>><?php echo strtoupper($row->id_no . '-' . $row->last_name . ', ' . $row->first_name); ?></option>
  <?php endforeach; ?>
</select>