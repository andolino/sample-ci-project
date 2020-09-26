<form id="frm-send-feedback-msg">
  <div class="panel-footer">
    <ul class="list-group mb-3 list-msg-fdbk">
      <?php if(count($msg) == 0): ?>
        <li class="list-group-item font-12 text-center">NO MESSAGE</li>
      <?php else: ?>
        <?php foreach($msg as $row): ?>
          <li class="list-group-item font-12"><?php echo $row->msg; ?></li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
    <div class="input-group">
      <input id="btn-input" type="text" class="form-control form-control-sm font-12" name="msg" placeholder="Type your message here..." />
      <input type="hidden" name="<?php echo $flag=='loans'?'loan_request_id':'benefit_request_id'; ?>" value="<?php echo $id; ?>" />
      <span class="input-group-btn">
      <button class="btn btn-warning btn-sm" id="btn-chat">
              Send</button>
      </span>
    </div>
  </div>
</form>
