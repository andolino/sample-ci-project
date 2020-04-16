<form id="frm-add-payments">
	<input type="hidden" name="loanSchedID">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
		   
		    <label for="period_start" class="font-12">PERIOD START</label>
		    <input type="text" class="form-control form-control-sm rounded-0 dp-ym" id="period_start" name="period_start" value="" readonly>
		    <label for="period_end" class="font-12">PERIOD END</label>
		    <input type="text" class="form-control form-control-sm rounded-0 dp-ym" id="period_end" name="period_end" value="" readonly>

		    <label for="date_paid" class="font-12">DATE PAID</label>
		    <input type="date" class="form-control form-control-sm rounded-0 dp-ym" id="date_paid" name="date_paid" value="<?php echo date('Y-m-d'); ?>">

		    <label for="orno" class="font-12">OR No.</label>
		    <input type="text" class="form-control form-control-sm rounded-0" id="orno" name="orno" required>

		    <label for="tot_amnt" class="font-12">Total Amount</label>
		    <input type="text" class="form-control form-control-sm rounded-0 isNum" id="tot_amnt" name="tot_amnt" readonly>

		    <label for="amnt_to_pay" class="font-12">Amout to Pay</label>
		    <input type="text" class="form-control form-control-sm rounded-0 isNum" id="amnt_to_pay" name="amnt_to_pay" required>
		    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
		  </div>
		</div>
		<div class="col-12">
			<button type="submit" class="btn btn-sm btn-default float-right ml-1 rounded-0"><i class="fas fa-save"></i> Save</button>
			<button type="button" class="btn btn-sm btn-custom-default float-right rounded-0" id="view-monthly-schedule" data-comp-id="<?php echo $loan_computation_id; ?>"><i class="fas fa-calendar-alt"></i> Check Sched.</button>
		</div>
		
	</div>
</form>