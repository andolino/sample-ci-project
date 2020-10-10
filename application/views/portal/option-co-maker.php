<?php foreach($co_maker as $row): ?>
  <option value="<?php echo $row->members_id; ?>"><?php echo strtoupper($row->last_name) . ', ' . strtoupper($row->first_name); ?></option>
<?php endforeach; ?>