<form id="frm-save-loancomp">
	<input type="hidden" name="m_id" value="<?php echo $members_id; ?>">
	<input type="hidden" name="has_update" value="<?php echo $loan_computation_id; ?>">
	<div class="cont-edit-process-a-loan row w-100 none">
		<div class="col-12 pr-0">
			<div class="text-right mb-2">
				<a href="javascript:void(0);" id="loadPage" data-link="view-loan-app-page" data-badge-head="LOAN APPLICATION"
	   								data-cls="cont-tbl-constituent" data-placement="top" data-toggle="tooltip" title="Back to List"><i class="fas fa-times"></i></a>
			</div>

			<div class="navbar mb-3">
			  <div class="row">
			  	<?php if ($loanComputation->is_posted == 1): ?>
		  		<div class="col pr-0">
			      <button type="button" class="btn btn-default btn-lg font-12 rounded-0 border" id="saveLoansComp"> Print</button>
			    </div>
			  	<?php else: ?>
			    <div class="col pr-0">
			      <button type="button" class="btn btn-default btn-lg font-12 rounded-0 border" id="postThisLoan" data-id="<?php echo $loan_computation_id; ?>"> Post</button>
			    </div>
			    <div class="col pr-0 pl-0">
			      <button type="button" class="btn btn-default btn-lg font-12 rounded-0 border" id="loadPage" data-badge-head="ADD MEMBER" data-link="add-constituent" data-ind="" data-cls="cont-add-member" disabled> Edit</button>
			    </div>
			    <div class="col pr-0 pl-0">
			      <button type="button" class="btn btn-default btn-lg font-12 rounded-0 border" id="loadPage" data-badge-head="ADD MEMBER" data-link="add-constituent" data-ind="" data-cls="cont-add-member" disabled> Delete</button>
			    </div>
			    <div class="col pr-0 pl-0">
			      <button type="button" class="btn btn-default btn-lg font-12 rounded-0 border" id="saveLoansComp"> Save/Print</button>
			    </div>
			    <div class="col pr-0 pl-0">
			      <button type="button" class="btn btn-default btn-lg font-12 rounded-0 border" id="loadPage" data-badge-head="ADD MEMBER" data-link="add-constituent" data-ind="" data-cls="cont-add-member" disabled> Cancel</button>
			    </div>
			  	<?php endif; ?>
			    <div class="col pr-0 pl-0">
			      <button type="button" class="btn btn-default btn-lg font-12 rounded-0 border" id="loadPage" data-badge-head="ADD MEMBER" data-link="add-constituent" data-ind="" data-cls="cont-add-member"> CoMaker</button>
			    </div>
			    
			  </div>
			  <div class="row border mr-1 p-1">
			    <label for="office" class="col-sm-3 col-form-label col-form-label-sm font-12" style="line-height: 1.3;">Mode:</label>
      		<div class="col-sm-4 pr-0">	
			     	<div class="custom-control custom-radio">
						  <input type="radio" id="modeAtm" name="modePymnt" value="atm" class="custom-control-input" <?php echo $loanComputation->loan_release_mode == 'atm' ? 'checked' : ''; ?>>
						  <label class="custom-control-label font-12" for="modeAtm">ATM</label>
						</div>
			    </div>
			    <div class="col-sm-5 pl-0">
			      <div class="custom-control custom-radio">
						  <input type="radio" id="modeChk" name="modePymnt" value="check" class="custom-control-input" <?php echo $loanComputation->loan_release_mode == 'check' ? 'checked' : ''; ?>>
						  <label class="custom-control-label font-12" for="modeChk">Check</label>
						</div>
			    </div>

			  </div>

			</div>
		</div>
			<div class="col-4 pr-0">
				<div class="border">
					<!-- heading -->
					<div class="col-12 mb-3 mt-3">
						<div class="navbar mb-0 p-2">
							<h6 class="mb-0"><i class="fas fa-user-cog"></i> Member Information</h6>
						</div>
					</div>
					<!-- end -->
					<div class="col-12">
						<div class="form-group row">
					    <label for="office" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Office:</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control form-control-sm font-12" id="office" name="office" value="<?php echo !empty($membersData) ? $membersData->office_name : ''; ?>" readonly>
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="monthly_salary" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Monthly Salary:</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control form-control-sm font-12 text-right" id="monthly_salary" value="<?php echo !empty($membersData) ? number_format($membersData->monthly_salary, 2) : ''; ?>" name="monthly_salary" required>
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="address" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Address:</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control form-control-sm font-12" id="address" value="<?php echo !empty($membersData) ? strtoupper($membersData->address) : ''; ?>" name="address">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="bank_account_no" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Bank Account No.:</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control form-control-sm font-12" id="bank_account_no" value="<?php echo !empty($membersData) ? $membersData->bank_account : ''; ?>" name="bank_account_no">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="contact_no" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Contact No.:</label>
					    <div class="col-sm-7">
					      <input type="contact_no" class="form-control form-control-sm font-12" id="contact_no" value="<?php echo !empty($membersData) ? $membersData->contact_no : ''; ?>" name="contact_no">
					    </div>
					  </div>
					  <hr>
					  <div class="form-group row">
					    <label for="purpose_of_loan" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Purpose of Loan:</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control form-control-sm font-12" id="purpose_of_loan" name="purpose_of_loan" value="<?php echo $loanComputation->purpose_of_loan; ?>">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="net_takehome_pay" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Net Take Home Pay:</label>
					    <div class="col-sm-7">
					      <input type="contact_no" class="form-control form-control-sm font-12 isNum text-right" id="net_takehome_pay" name="net_takehome_pay" value="<?php echo number_format($loanComputation->net_take_home_pay, 2); ?>">
					    </div>
					  </div>
					</div>


					<!-- heading -->
					<div class="col-12 mb-3 mt-3">
						<div class="navbar mb-0 p-2">
							<h6 class="mb-0"><i class="fas fa-user-cog"></i> Previous Loan</h6>
						</div>
					</div>
					<!-- end -->
					<div class="col-12">
						<div class="form-group row">
					    <label for="ref_no" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">Ref No.:</label>
					    <div class="col-sm-6 pl-0">
					      <input type="text" class="form-control form-control-sm font-12" id="ref_no" name="ref_no">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="total_loan_amnt" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">Total Loan Amount:</label>
					    <div class="col-sm-6 pl-0">
					      <input type="text" class="form-control form-control-sm font-12 text-right" id="total_loan_amnt" name="total_loan_amnt">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="repymnt_start" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">	Repayment Start:</label>
					    <div class="col-sm-6 pl-0">
					      <input type="text" class="form-control form-control-sm font-12" id="repymnt_start" name="repymnt_start">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="repymnt_end" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">Repayment End:</label>
					    <div class="col-sm-6 pl-0">
					      <input type="text" class="form-control form-control-sm font-12" id="repymnt_end" name="repymnt_end">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="mo_amortization" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">Monthly Amortization:</label>
					    <div class="col-sm-6 pl-0">
					      <input type="text" class="form-control form-control-sm font-12" id="mo_amortization" name="mo_amortization">
					    </div>
					  </div>
					</div>


					<!-- heading -->
					<div class="col-12 mb-3 mt-3">
						<div class="navbar mb-0 p-2">
							<h6 class="mb-0"><i class="fas fa-user-cog"></i> Previous Loan Personal Payment</h6>
						</div>
					</div>
					<!-- end -->
					<div class="col-12">
						<div class="form-group row">
					    <label for="prev_loan_per_pay_start" class="col-sm-4 pr-0 col-form-label col-form-label-sm font-12">Period Start:</label>
					    <div class="col-sm-8 pl-0">
					      <input type="date" class="form-control form-control-sm font-12" id="prev_loan_per_pay_start" name="prev_loan_per_pay_start">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="prev_loan_per_pay_end" class="col-sm-4 pr-0 col-form-label col-form-label-sm font-12">Period End:</label>
					    <div class="col-sm-8 pl-0">
					      <input type="date" class="form-control form-control-sm font-12" id="prev_loan_per_pay_end" name="prev_loan_per_pay_end">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="prev_loan_orno" class="col-sm-4 pr-0 col-form-label col-form-label-sm font-12">OR No.:</label>
					    <div class="col-sm-8 pl-0">
					      <input type="text" class="form-control form-control-sm font-12" id="prev_loan_orno" name="prev_loan_orno">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="prev_loan_tot_amnt" class="col-sm-4 pr-0 col-form-label col-form-label-sm font-12">Total Amount:</label>
					    <div class="col-sm-8 pl-0">
					      <input type="text" class="form-control form-control-sm font-12" id="prev_loan_tot_amnt" name="prev_loan_tot_amnt">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="prev_loan_tot_pymnts" class="col-sm-4 pr-0 col-form-label col-form-label-sm font-12">Total Payments:</label>
					    <div class="col-sm-8 pl-0">
					      <input type="text" class="form-control form-control-sm font-12" id="prev_loan_tot_pymnts" name="prev_loan_tot_pymnts">
					    </div>
					  </div>
					</div>

				</div><!--border-->
			</div><!--col-4-->


			<div class="col-8 pr-0">
				<div class="border">
					<!-- heading -->
					<div class="col-12 mb-3 mt-3">
						<div class="navbar mb-0 p-2">
							<h6 class="mb-0"><i class="fas fa-user-cog"></i> Computation of Loan Proceeds</h6>
						</div>
					</div>
					<!-- end -->
					<div class="col-12">
						<div class="form-group row">
					    <label for="type_of_loan" class="col-sm-2 pr-0 col-form-label col-form-label-sm font-12">Type of Loan:</label>
					    <div class="col-sm-10 pl-0">
					      <select class="custom-select custom-select-sm" id="type_of_loan" name="type_of_loan" required>
								  <option selected value="" hidden>-NONE-</option>
								  <?php foreach ($loanTypes as $row): ?>
								  	<option value="<?php echo $row->loan_types_id; ?>" <?php echo $row->loan_types_id == $loanComputation->loan_types_id ? 'selected' : ''; ?>><?php echo $row->type; ?></option>
								  <?php endforeach; ?>
								</select>
					    </div>
					  </div>
					  <div class="form-group row">
		      		<div class="col-sm-2 pr-0">	
					     	<div class="custom-control custom-radio">
								  <input type="radio" id="radioLoanApprove" name="radioApprovalFlag" value="1" class="custom-control-input" <?php echo $loanComputation->is_approved == '1' ? 'checked' : ''; ?>>
								  <label class="custom-control-label font-12" for="radioLoanApprove">Approved</label>
								</div>
					    </div>
					    <div class="col-sm-4 pl-0">
					      <div class="custom-control custom-radio">
								  <input type="radio" id="radioLoanDisapproved" name="radioApprovalFlag" value="0" class="custom-control-input" <?php echo $loanComputation->is_approved == '0' ? 'checked' : ''; ?>>
								  <label class="custom-control-label font-12" for="radioLoanDisapproved">Disapproved</label>
								</div>
					    </div>
					    <label for="date_processed" class="col-sm-2 pr-0 col-form-label col-form-label-sm font-12">Date Processed:</label>
					    <div class="col-sm-4 pl-0">
					      <input type="date" class="form-control form-control-sm font-12" id="date_processed" name="date_processed" value="<?php echo date('Y-m-d', strtotime($loanComputation->date_processed)); ?>" required>
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="loancomp_ref_no" class="col-sm-2 pr-0 col-form-label col-form-label-sm font-12">Ref No.:</label>
					    <div class="col-sm-2 pl-0">
					      <input type="text" class="form-control form-control-sm font-12" id="loancomp_ref_no" name="loancomp_ref_no" value="<?php echo $loanComputation->ref_no; ?>">
					    </div>
					    <label for="is_posted" class="col-sm-2 offset-sm-2 pr-0 col-form-label col-form-label-sm font-12">Posted:</label>
					    <div class="col-sm-4 pl-0">
					      <input type="text" class="form-control form-control-sm font-12" id="is_posted" name="is_posted" value="<?php echo $loanComputation->is_posted == 1 ? 'Posted' : 'Not Posted'; ?>" readonly>
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="lcomp_remarks" class="col-sm-2 pr-0 col-form-label col-form-label-sm font-12">Remarks:</label>
					    <div class="col-sm-10 pl-0">
					      <input type="text" class="form-control form-control-sm font-12" id="lcomp_remarks" name="lcomp_remarks" value="<?php echo $loanComputation->remarks; ?>">
					    </div>
					  </div>

					</div>

				</div><!--border-->
				<div class="col-12 border pt-3">
					<div class="row">
						<div class="col-6">
							<div class="row ">
								<div class="col-12">
								  <div class="form-group row">
								    <label for="no_mos_applied" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">No. of Months Applied:</label>
								    <div class="col-sm-6 pl-0">
								      <select class="custom-select custom-select-sm" id="no_mos_applied" name="no_mos_applied" required>
											  <option selected value="" hidden>-NONE-</option>
											  <?php foreach ($loanSettings as $row): ?>
											  	<option value="<?php echo $row->loan_settings_id; ?>"><?php echo $row->number_of_month; ?></option>
											  <?php endforeach; ?>
											</select>
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="repayment_period" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">Repayment Period:</label>
								    <div class="col-sm-6 pl-0">
								      <select class="custom-select custom-select-sm" id="repayment_period" name="repayment_period" disabled>
											  <option selected value="" hidden>-NONE-</option>
											  <?php foreach ($loanSettings as $row): ?>
											  	<option value="<?php echo $row->loan_settings_id; ?>"><?php echo $row->repymnt_period; ?></option>
											  <?php endforeach; ?>
											</select>
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="interest_per_annum" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">Int. per Annum:</label>
								    <div class="col-sm-6 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="interest_per_annum" name="interest_per_annum" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="amnt_of_loan_applied" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">Amount of Loan Applied:</label>
								    <div class="col-sm-6 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="amnt_of_loan_applied" name="amnt_of_loan_applied" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="add_interest" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">Add: Interest:</label>
								    <div class="col-sm-6 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="add_interest" name="add_interest" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="gross_amnt_of_loan" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">Gross Amount of Loan:</label>
								    <div class="col-sm-6 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="gross_amnt_of_loan" name="gross_amnt_of_loan" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="first_yr_int_ded" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">First Year Int. Ded:</label>
								    <div class="col-sm-6 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="first_yr_int_ded" name="first_yr_int_ded" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="tot_amnt_tobe_amort" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">Total Amount to be Amort.:</label>
								    <div class="col-sm-6 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="tot_amnt_tobe_amort" name="tot_amnt_tobe_amort" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="monthly_amort" class="col-sm-6 pr-0 col-form-label col-form-label-sm font-12">Monthly Amortzation.:</label>
								    <div class="col-sm-6 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="monthly_amort" name="monthly_amort" readonly="">
								    </div>
								  </div>
								</div>
							</div>
						</div><!--col-6-->
						<div class="col-6 border-left">
							<div class="row ">
								<div class="col-12">
								  <div class="form-group row">
								    <label for="ded_interest" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Ded: % Interest:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="ded_interest" name="ded_interest" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="loan_red_ins" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">LRI:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="loan_red_ins" name="loan_red_ins" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="service_charge" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">SVC:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="service_charge" name="service_charge" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="previouse_loan" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Previous Loan:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="previouse_loan" name="previouse_loan" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="prev_loans_pymnts" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Payments:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="prev_loans_pymnts" name="prev_loans_pymnts" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="balance_on_prev_loan" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Balance on Prev. Loan:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="balance_on_prev_loan" name="balance_on_prev_loan" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="total_deductions" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Total Deductions:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="total_deductions" name="total_deductions" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="net_proceeds" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Net Proceeds:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="net_proceeds" name="net_proceeds" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="collection_prd_start" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Collection Period Start:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12" id="collection_prd_start" name="collection_prd_start" readonly="">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="collection_prd_end" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Collection Period End:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12" id="collection_prd_end" name="collection_prd_end" readonly="">
								    </div>
								  </div>
								</div>
							</div>
						</div><!--col-6-->

					</div>
				</div><!--col-12 border pt-3-->
				<div class="col-12 border pt-3">
					<div class="row">
						<div class="col-6">
							<div class="row ">
								<!-- heading -->
								<div class="col-12 mb-3 mt-3">
									<div class="navbar mb-0 p-2">
										<h6 class="mb-0"><i class="fas fa-user-cog"></i> Breakdown of Monthly Amortization</h6>
									</div>
								</div>
								<!-- end -->
								<div class="col-12">

									<div class="form-group row">
								    <label for="bma_principal" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Principal:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="bma_principal" name="bma_principal" readonly>
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="bma_interest" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Interest:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="bma_interest" name="bma_interest" readonly>
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12"></label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="" name="" disabled>
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="bma_total" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Total:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="bma_total" name="bma_total" readonly>
								    </div>
								  </div>
								  
								</div>
							</div>
						</div><!--col-6-->
						<div class="col-6 border-left">
							<div class="row ">
								<!-- heading -->
								<div class="col-12 mb-3 mt-3">
									<div class="navbar mb-0 p-2">
										<h6 class="mb-0"><i class="fas fa-user-cog"></i> Breakdown of Loan Balance</h6>
									</div>
								</div>
								<!-- end -->
								<div class="col-12">
								  <div class="form-group row">
								    <label for="blb_principal" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Principal:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="blb_principal" name="blb_principal">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="blb_interest" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Interest:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="blb_interest" name="blb_interest">
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12"></label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="" name="" disabled>
								    </div>
								  </div>
								  <div class="form-group row">
								    <label for="blb_total" class="col-sm-5 pr-0 col-form-label col-form-label-sm font-12">Total:</label>
								    <div class="col-sm-7 pl-0">
								      <input type="text" class="form-control form-control-sm font-12 text-right" id="blb_total" name="blb_total">
								    </div>
								  </div>
								  
								</div>
							</div>
						</div><!--col-6-->

					</div>
				</div><!--col-12 border pt-3-->
			
			</div><!--col-8-->

		<!-- <button type="submit" class="btn btn-default btn-sm rounded-0 border float-right"><i class="fas fa-save"></i> Save</button> -->
	</div>
</form>

<script type="text/javascript">

	$(document).ready(function() {
		setTimeout(function(){
			$('select[name="no_mos_applied"]').val('<?php echo $loanComputation->loan_settings_id; ?>').trigger('change');
		}, 1000);
	});
</script>



<!-- add input multiple -->
<!-- <div class="col-12"></div>
<div class="col-3 mt-2 govt-name-cont">
	<label for="govt_name" class="font-12">Govertment ID's/Docs</label>
	<select class="custom-select custom-select-sm" id="govt_name" name="govt_name[]">
	  <option selected value="">-NONE-</option>
	</select>
</div>
<div class="col-3 mt-2 pl-0">
	<label for="govt_id" class="font-12">Gov't ID #</label>
	<input type="text" class="form-control form-control-sm" id="govt_id" name="govt_id[]" placeholder="...">
</div>
<div class="col-1 mt-4 pt-3 pl-0" id="addgovt-sect">
	<button type="button" class="btn btn-success btn-sm" id="add-govt-field"><i class="fas fa-plus"></i></button>
</div> -->
