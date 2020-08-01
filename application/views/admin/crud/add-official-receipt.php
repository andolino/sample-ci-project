<form id="frm-official-receipt">
	<div class="row">
		<div class="col-12">
			<div class="row">
				<div class="col-4">
					<div class="form-group">
		    		<label for="or_departments" class="font-12">DEPARTMENTS</label>
		   	 		<select class="custom-select custom-select-sm rounded-0" id="or_departments" name="departments_id">
						  <option value="" selected hidden>--</option>
							<?php foreach ($region as $row): ?>
								<option value="<?php echo $row->departments_id; ?>" <?php echo !empty($officialReceipt) ? ($officialReceipt->departments_id == $row->departments_id ? 'selected' : '') : ''; ?>><?php echo strtoupper($row->region); ?></option>
							<?php endforeach; ?>
						</select>
		  		</div>
				</div>
				<div class="col-4">
					<div class="form-group">
		    		<label for="orno" class="font-12">OR NO.</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12" id="orno" name="orno" value="<?php echo !empty($officialReceipt) ? $officialReceipt->orno : ''; ?>" required="">
		  		</div>
				</div>
				<div class="col-4">
					<div class="form-group">
		    		<label for="amount_type" class="font-12">OR TYPE</label>
		   	 		<select class="custom-select custom-select-sm rounded-0" id="amount_type" name="amount_type">
						  <option value="" selected hidden>--</option>
						  <option value="1">CASH</option>
						  <option value="2">CHECK</option>
						  <option value="3">BANK</option>
						</select>
		  		</div>
				</div>
				<div class="col-4">
					<div class="form-group">
		    		<label for="date_applied" class="font-12">DATE APPLIED</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12" id="date_applied" name="date_applied" value="<?php echo !empty($officialReceipt) ? date('m/d/Y', strtotime($officialReceipt->date_applied)) : ''; ?>" required="">
		  		</div>
				</div>
				<div class="col-12">
					<div class="form-group">
		    		<label for="address" class="font-12">ADDRESS</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12" id="address" name="address" value="<?php echo !empty($officialReceipt) ? $officialReceipt->address : ''; ?>">
		  		</div>
				</div>
				<div class="col-4">
					<div class="form-group">
		    		<label for="tin" class="font-12">TIN</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12" id="tin" name="tin" value="<?php echo !empty($officialReceipt) ? $officialReceipt->tin : ''; ?>">
		  		</div>
				</div>
				<div class="col-4">
					<div class="form-group">
		    		<label for="business_style" class="font-12">BUSINESS STYLE</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12" id="business_style" name="business_style" value="<?php echo !empty($officialReceipt) ? $officialReceipt->business_style : ''; ?>">
		  		</div>
				</div>
				<div class="col-4">
					<div class="form-group">
		    		<label for="senior_citizen_tin" class="font-12">SENIOR TIN</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12" id="senior_citizen_tin" name="senior_citizen_tin" value="<?php echo !empty($officialReceipt) ? $officialReceipt->senior_citizen_tin : ''; ?>">
		  		</div>
				</div>
				<div class="col-4">
					<div class="form-group">
		    		<label for="osca_pwd_citizen_tin" class="font-12">OSCA/PWD ID No.</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12" id="osca_pwd_citizen_tin" name="osca_pwd_citizen_tin" value="<?php echo !empty($officialReceipt) ? $officialReceipt->osca_pwd_citizen_tin : ''; ?>">
		  		</div>
				</div>
				<div class="col-4">
					<div class="form-group">
		    		<label for="contribution" class="font-12">CONTRIBUTION</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12 isNum orcompamnt" id="contribution" name="contribution" value="<?php echo !empty($officialReceipt) ? number_format($officialReceipt->contribution, 2) : ''; ?>" readonly>
		  		</div>
				</div>
				<div class="col-4">
					<div class="form-group">
		    		<label for="gpln" class="font-12">GPLN</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12 isNum orcompamnt" id="gpln" name="gpln" value="<?php echo !empty($officialReceipt) ? number_format($officialReceipt->gpln, 2) : ''; ?>">
		  		</div>
				</div>
				<div class="col-4">
					<div class="form-group">
		    		<label for="emln" class="font-12">EMLN</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12 isNum orcompamnt" id="emln" name="emln" value="<?php echo !empty($officialReceipt) ? number_format($officialReceipt->emln, 2) : ''; ?>">
		  		</div>
				</div>
				<div class="col-4">
					<div class="form-group">
		    		<label for="slmv" class="font-12">SLMV</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12 isNum orcompamnt" id="slmv" name="slmv" value="<?php echo !empty($officialReceipt) ? number_format($officialReceipt->slmv, 2) : ''; ?>">
		  		</div>
				</div>
				<div class="col-4">
					<div class="form-group">
		    		<label for="others" class="font-12">OTHERS</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12 isNum orcompamnt" id="others" name="others" value="<?php echo !empty($officialReceipt) ? number_format($officialReceipt->others, 2) : ''; ?>">
		  		</div>
				</div>
				<div class="col-6">
					<div class="form-group">
		    		<label for="total" class="font-12">TOTAL SALES</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12 isNum" id="total" name="amount" value="<?php echo !empty($officialReceipt) ? number_format($officialReceipt->amount, 2) : ''; ?>" readonly>
		  		</div>
				</div>
				<div class="col-6"></div>
				<div class="col-6">
					<div class="form-group">
		    		<label for="sc_pw_discount" class="font-12">Less: SC/PWD Discount:</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12 isNum" id="sc_pw_discount" name="sc_pw_discount" value="<?php echo !empty($officialReceipt) ? number_format($officialReceipt->sc_pw_discount, 2) : ''; ?>">
		  		</div>
				</div>
				<div class="col-6"></div>
				<div class="col-6">
					<div class="form-group">
		    		<label for="total_due" class="font-12">TOTAL DUE:</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12 isNum" id="total_due" name="total_due" value="<?php echo !empty($officialReceipt) ? number_format($officialReceipt->total_due, 2) : ''; ?>" readonly>
		  		</div>
				</div>
				<div class="col-6"></div>
				<div class="col-6">
					<div class="form-group">
		    		<label for="withholding_tax" class="font-12">LESS WITHHOLDING TAX:</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12 isNum" id="withholding_tax" name="withholding_tax" value="<?php echo !empty($officialReceipt) ? number_format($officialReceipt->withholding_tax, 2) : ''; ?>">
		  		</div>
				</div>
				<div class="col-6"></div>
				<div class="col-6">
					<div class="form-group">
		    		<label for="payment_due" class="font-12">PAYMENT DUE:</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12 isNum" id="payment_due" name="payment_due" value="<?php echo !empty($officialReceipt) ? number_format($officialReceipt->payment_due, 2) : ''; ?>">
		  		</div>
				</div>
				<div class="col-6">
					<div class="form-group">
		    		<label for="total" class="font-12">TOTAL:</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12 isNum" id="total" name="total" value="<?php echo !empty($officialReceipt) ? number_format($officialReceipt->total, 2) : ''; ?>" readonly>
		  		</div>
				</div>
				<div class="col-12">
					<div class="form-group">
		    		<label for="remarks" class="font-12">REMARKS</label>
		   	 		<input type="text" class="form-control form-control-sm rounded-0 font-12" id="remarks" name="remarks" value="<?php echo !empty($officialReceipt) ? $officialReceipt->remarks : ''; ?>">
		  		</div>
				</div>
				
				<div class="col-3 offset-9">
					<input type="hidden" name="has_update">
					<button type="submit" class="btn btn-sm btn-success font-12 rounded-0 float-right"><i class="fas fa-save"></i> Save</button>
				</div>
				
			</div>
		</div>
		
	</div>
</form>