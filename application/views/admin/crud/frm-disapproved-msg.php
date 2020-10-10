<form id="frm-send-disapproved-msg">
  <div class="panel-footer">
    <div class="input-group">
      <div class="row">
        <div class="col-sm-12">
          <input id="btn-input" type="text" class="form-control form-control-sm font-12" name="remarks" placeholder="Type your remarks here..." required/>
          <input type="hidden" name="<?php echo $flag=='loans'?'loan_request_id':'benefit_request_id'; ?>" value="<?php echo $id; ?>" />
          <input type="hidden" name="field" value="Disapproved" />
          <input type="hidden" name="id" value="<?php echo $id; ?>" />
        </div>
        <div class="col-sm-12 mt-2">
          <span class="input-group-btn">
          <button class="btn btn-warning btn-sm float-right" id="btn-chat">
                  Disapproved Request</button>
          </span>
        </div>
      </div>
      
    </div>
  </div>
</form>

  