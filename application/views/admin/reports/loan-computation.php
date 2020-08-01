<style type="text/css">
	.font-9{
		font-size: 9px !important;
	}
	.font-7{
		font-size: 7px !important;
	}
	.text-center{
		text-align: center;
	}
	.text-right{
		text-align: right;
	}
	.text-left{
		text-align: left;
	}
	div.u-div{
		font-size: 7px;
		border-bottom: 0.2px solid #000;
		display:inline-block;
	}
	.is_checked{
		background-color: #000;
	}
</style>
<table>
	<tr>
		<td style="width: 12%;"><img src="<?php echo 'assets/image/misc/logo.png'; ?>" width="57"></td>
		<td style=""><span style="font-size: 14px;">CPFI</span><br>
			<span style="font-size: 6px;">5th Flr., TAM Bldg., PSA Complex, Brgy. Pinyahan, East Ave., Diliman, Quezon City 1101 <br>
			Tel No. (02)8666 2401 <br>
			Email: Provident.Fund@psa.gov.ph</span>
		</td>
		<td style="width: 50%"></td>
		<td><strong style="font-size: 14px;">RECEIVED</strong><br><span style="font-size: 10px;">Date: __/__/__ <br> By: _________</span></td>
	</tr>
</table>
<br>
<br>
<table>
	<tr>
		<td style="width: 26.5%;"></td>
		<td style="font-size: 16px;"><strong>LOAN APPLICATION/AGREEMENT</strong></td>
	</tr>
	<tr>
		<td style="width: 41.5%;"></td>
		<td style="font-size: 9px;"><strong>CPFI Form No. 03 (2017)</strong></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
</table>
<table border="0.4" cellpadding="2">
	<tr>
		<td rowspan="2" style="font-size: 10px;line-height: 2.5;height: 10px; text-align: center;width: 25%;"><span><i><strong>TYPE OF LOAN</strong></i></span></td>
		<td style="font-size: 9px;font-weight: bold;width: 75%;"><?php echo $loan_code->loan_type_name; ?> (<?php echo $loan_code->loan_code; ?>) </td>
	</tr>
	<tr>
		<td style="font-size: 8px;">Ref. No. 20</td>
	</tr>
</table>

<table border="0.4" cellpadding="3" style="font-size: 8px;">
	<tr>
		<td style="width:57%;">Applicant: (Print Name): <strong><?php echo strtoupper($members->last_name . ', ' . $members->first_name . ' ' . $members->middle_name); ?></strong></td>
		<td style="width:43%;">PSA Employee ID No.: <strong><?php echo $members->id_no; ?></strong></td>
	</tr>
	<tr>
		<td>Official Station: <strong><?php echo $result->office; ?></strong></td>
		<td>Basic Salary/Mo.: <strong><?php echo number_format($members->monthly_salary, 2); ?></strong></td>
	</tr>
	<tr>
		<td>Residence: <strong><?php echo strtoupper($members->address); ?></strong></td>
		<td>Contact No.: <strong><?php echo $members->contact_no; ?></strong></td>
	</tr>
	<tr>
		<td>Purpose of Loan: <strong><?php echo strtoupper($result->purpose_of_loan); ?></strong></td>
		<td>LBP ACCOUNT No.: <strong><?php echo strtoupper($result->bank_account_no); ?></strong></td>
	</tr>
</table>
<table border="0.4" cellpadding="5">
	<tr>
		<td style="width: 100%;">
			<h6 style="text-align: center;line-height: 2.3;font-weight: bold;">Application/Agreement</h6>
			<span style="font-size: 7px;text-align: left;line-height: 0.3;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I hereby apply for loan (please check type of loan) loan equivalent to <u>&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo (int) $loan_settings->number_of_month; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;</u> (no. of month/s salary if GPLN or EMLN) in the amount of P <u>&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $result->monthly_salary; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;</u>. <br>     
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In consideration thereof, I promise to pay in accordance with terms and conditions set forth in the implementing guidelines of the Census Provident Fund, Inc. </span>
			<span style="font-size: 7px;text-align: left;line-height: 1.6;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I hereby authorize the Cashier/Disbursing Officer to deduct from my monthly salary the installments due on the loan that may be granted by virtue of this <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;application. In case of my failure to pay three (3) consecutive loan installments, my co-maker/s assumes the responsibility to pay and authorize the <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cashier/Disbursing Officer to deduct same from his pay envelope. 
			</span>
			<br>
			<br>
			<br>
			
			<table cellpadding="0">
				<tr>
					<td style="font-size: 8px;">
						<span>______________________________</span><br>
						<span>Signature of Applicant</span><br>
						<span>Position: <u><strong><?php echo $members->designation; ?></strong></u></span><br>
						<span>SG_______Basic Salary <u><strong><?php echo number_format($members->monthly_salary, 2); ?></strong></u></span>
					</td>
					<td style="font-size: 8px;text-align: right;">
						<span><strong>Conforme: (Co-maker/s)</strong></span><br>
					</td>
					<?php foreach ($co_maker as $row): ?>
						<td style="font-size: 8px;">
							<div class="u-div" style="text-align: center;"><?php echo strtoupper($row->last_name) . ', ' . strtoupper($row->first_name); ?></div>
							<span>Signature of Applicant</span><br>
							<span>Position <u><strong><?php echo $row->designation; ?></strong></u></span><br>
							<span>SG_______Basic Salary: <u><strong><?php echo number_format($row->monthly_salary, 2); ?></strong></u></span>
						</td>
					<?php endforeach; ?>
				</tr>
			</table>

			<table cellpadding="2">
				<tr>
					<td></td>
				</tr>

				<tr>
					<td style="font-size: 9px;text-align:center;font-weight: bold;background-color:#acafb2;color: #000;"><strong>TO BE FILLED OUT BY THE CPFI</strong></td>
				</tr>
				<tr>
					<td style="font-size: 7px;text-align:center;font-weight: bold;"><strong>Evaluation of Loan</strong></td>
				</tr>
			</table>

			<table style="border-bottom: 0.2px solid #000;">
				<tr>
					<td style="font-size: 8px;">
						<span>Leave Credits_______________</span><br>
						<table>
							<tr>
								<td style="border:0.2px solid #000;width: 5%;" class="<?php echo $result->radioApprovalFlag == 1 ? 'is_checked' : ''; ?>"></td>
								<?php if ($result->radioApprovalFlag == 1): ?>
									<td style="font-size: 8px;width: 94%">&nbsp;&nbsp;Approved for <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (int) $loan_settings->number_of_month; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> mos.</td>
								<?php else: ?>
									<td style="font-size: 8px;width: 94%">&nbsp;&nbsp;Approved for ____________ mos.</td>
								<?php endif; ?>
								
						</tr>
						</table>
					</td>
					<td style="font-size: 8px;">
						<span>Monthly Net Take Home Pay:_____________</span><br>
						<table>
							<tr>
								<td style="border:0.2px solid #000;width: 5%;" class="<?php echo $result->radioApprovalFlag == 0 ? 'is_checked' : ''; ?>"></td>
								<?php if ($result->radioApprovalFlag == 0): ?>
									<td style="font-size: 8px;width: 94%">&nbsp;&nbsp;Disapprove/Remarks <u>&nbsp;&nbsp;&nbsp;<?php echo $result->lcomp_remarks; ?>&nbsp;&nbsp;&nbsp;</u> </td>
								<?php else: ?>
									<td style="font-size: 8px;width: 94%">&nbsp;&nbsp;Disapprove/Remarks ________________ </td>
								<?php endif ?>
						</tr>
						</table>
					</td>
					<td style="font-size: 8px;">
						<span>Payment period <u>&nbsp;&nbsp;&nbsp;<?php echo $result->prev_loan_per_pay_start; ?>&nbsp;&nbsp;&nbsp;</u> to <u>&nbsp;&nbsp;&nbsp;<?php echo $result->prev_loan_per_pay_end; ?>&nbsp;&nbsp;&nbsp;</u> </span><br>
						<table>
							<tr>
								<td style="font-size: 8px;">&nbsp;OR No: <u>&nbsp;&nbsp;&nbsp;<?php echo $result->prev_loan_orno; ?>&nbsp;&nbsp;&nbsp;</u> Amount. <u><?php echo $result->prev_loan_tot_pymnts; ?>&nbsp;&nbsp;&nbsp;</u></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td></td>
				</tr>
			</table>
			<br>
			<br>
			<br>
			<br>
			<br>

			<table>
				<tr>
					<td style="width: 35%;"></td>
					<td style="font-size: 10px;font-weight: 700;width: 45%;"><strong>COMPUTATION OF LOAN PROCEEDS</strong></td>
					<td style="width: 20%;"></td>
				</tr>
			</table>
			<table border="0">
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>	
				<tr style="line-height: 1.8">
					<td class="font-7 text-center" style="width: 14%;"></td>
					<td class="font-7 text-center" style="width: 21%;margin-left: 100px;"><i><strong>Basic Salary:</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->monthly_salary; ?></td>
					<td class="font-7 text-center" style="width: 22%;"><i><strong>Interest per annum:</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo (int) $result->interest_per_annum . '%'; ?></td>
				</tr>
				<tr style="line-height: 1.8">
					<td class="font-7 text-center" style="width: 14%;"></td>
					<td class="font-7 text-center" style="margin-left: 100px;"><i><strong>No. of months:</strong></i></td>
					<td class="font-7 text-right" style="border-bottom:0.4px solid #000;"><?php echo (int) $loan_settings->number_of_month; ?></td>
					<td class="font-7 text-center" style=""><i><strong>Repayment period:</strong></i></td>
					<td class="font-7 text-right" style="border-bottom:0.4px solid #000;"><?php echo (int) $result->repayment_period; ?></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>	
			</table>
			<table>
				<tr style="line-height: 1.8">
					<td class="font-7 text-left" style="width: 35%;margin-left: 100px;"><i><strong>Amount of loan applied:</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->amnt_of_loan_applied; ?></td>
					<td class="font-7 text-center" style="width: 4%;"></td>		
					<td class="font-7 text-left" style="width: 34%;"><i><strong>Amount of loan applied:</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->amnt_of_loan_applied; ?></td>
				</tr>
				<tr style="line-height: 1.8">
					<td class="font-7 text-left" style="width: 25%;margin-left: 100px;"></td>
					<td class="font-7" style="width: 27%;"></td>
					<td class="font-7 text-left" style="width: 18%;"><i><strong>Ded: <?php echo (int) $result->interest_per_annum . '%'; ?> Interest</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->ded_interest; ?></td>		
					<td class="font-7" style="width: 14%;"></td>
				</tr>
				<tr style="line-height: 1.8">
					<td class="font-7 text-left" style="width: 35%;margin-left: 100px;"><i><strong>Add: Interest (Loan Applied x <?php echo (int) $result->interest_per_annum . '%'; ?> x Repayment Period)</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->add_interest; ?></td>
					<td class="font-7" style="width: 4%;"></td>
					<td class="font-7 text-left" style="width: 18%;"><i><strong>LRI</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->loan_red_ins; ?></td>		
				</tr>
				<tr style="line-height: 1.8">
					<td class="font-7 text-left" style="width: 35%;margin-left: 100px;"><i><strong>Gross Loan Amount:</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->gross_amnt_of_loan; ?></td>
					<td class="font-7" style="width: 4%;"></td>
					<td class="font-7 text-left" style="width: 18%;"><i><strong>SVC</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->service_charge; ?></td>		
				</tr>
				<tr style="line-height: 1.8">
					<td class="font-7 text-left" style="width: 35%;margin-left: 100px;"><i><strong>First Year Int. Deductible from Loan Applied:</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->first_yr_int_ded; ?></td>
					<td class="font-7" style="width: 4%;"></td>
					<td class="font-7 text-left" style="width: 18%;"><i><strong>Previous Loan:</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->previous_loan; ?></td>		
				</tr>
				<tr style="line-height: 1.8">
					<td class="font-7 text-left" style="width: 35%;margin-left: 100px;"><i><strong>Total Amount to be Amortized:</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->tot_amnt_tobe_amort; ?></td>
					<td class="font-7" style="width: 4%;"></td>
					<td class="font-7 text-left" style="width: 18%;"><i><strong>Payments:</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->prev_loans_pymnts; ?></td>		
				</tr>
					<tr style="line-height: 1.8">
					<td class="font-7 text-left" style="width: 35%;margin-left: 100px;"></td>
					<td class="font-7" style="width: 13%;"></td>
					<td class="font-7" style="width: 4%;"></td>
					<td class="font-7 text-left" style="width: 18%;"><i><strong>Balance on  Prev Loan:</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->balance_on_prev_loan; ?></td>		
				</tr>
				<tr style="line-height: 1.8">
					<td class="font-7 text-left" style="width: 35%;margin-left: 100px;"><i><strong>Monthly Amortization:</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->monthly_amort; ?></td>
					<td class="font-7 text-center" style="width: 4%;"></td>		
					<td class="font-7 text-left" style="width: 34%;"><i><strong>Total Deduction:</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->total_deductions; ?></td>
				</tr>
				<tr style="line-height: 0.2">
					<td class="font-7 text-left" style="width: 35%;margin-left: 100px;"></td>
					<td class="font-7" style="width: 13%;"></td>
					<td class="font-7 text-center" style="width: 4%;"></td>		
					<td class="font-7 text-left" style="width: 34%;"></td>
					<td class="font-7" style="width: 13%;"></td>
				</tr>
				<tr style="">
					<td class="font-7 text-left" style="width: 35%;margin-left: 100px;">&nbsp;</td>
					<td class="font-7" style="width: 13%;border-top:0.4px solid #000;"></td>
					<td class="font-7 text-center" style="width: 4%;"></td>		
					<td class="font-7 text-left" style="width: 34%;"></td>
					<td class="font-7" style="width: 13%;"></td>
				</tr>
				<tr style="">
					<td class="font-7 text-left" style="width: 35%;margin-left: 100px;"></td>
					<td class="font-7" style="width: 13%;"></td>
					<td class="font-7 text-center" style="width: 4%;"></td>		
					<td class="font-7 text-left" style="width: 34%;"><i><strong>Net Proceeds:</strong></i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom:0.4px solid #000;"><?php echo $result->net_proceeds; ?></td>
				</tr>
				<tr style="line-height: 0.2">
					<td class="font-7 text-left" style="width: 35%;margin-left: 100px;"></td>
					<td class="font-7" style="width: 13%;"></td>
					<td class="font-7 text-center" style="width: 4%;"></td>		
					<td class="font-7 text-left" style="width: 34%;"></td>
					<td class="font-7" style="width: 13%;border-bottom:0.4px solid #000;"></td>
				</tr>
				<tr style="">
					<td class="font-7 text-left" style="width: 35%;margin-left: 100px;">&nbsp;</td>
					<td class="font-7" style="width: 13%;"></td>
					<td class="font-7 text-center" style="width: 4%;"></td>		
					<td class="font-7 text-left" style="width: 34%;"></td>
					<td class="font-7" style="width: 13%;border-top:0.4px solid #000;"></td>
				</tr>
				<tr style="">
					<td class="font-7 text-left" style="width: 35%;margin-left: 100px;"></td>
					<td class="font-7" style="width: 13%;"></td>
					<td class="font-7 text-center" style="width: 4%;"></td>		
					<td class="font-7 text-left" style="width: 34%;"><i>Breakdown Balance:</i></td>
					<td class="font-7" style="width: 13%;"></td>
				</tr>
			</table>
			<table border="0">
				<tr style="line-height: 1.6">
					<td class="font-7 text-right" style="width: 22%;">Principal&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td class="font-7 text-right" style="width: 13%;border-bottom: 0.4px solid #000;"><?php echo $result->bma_principal; ?></td>
					<td class="font-7 text-center" style="width: 17%;"></td>		
					<td class="font-7 text-right" style="width: 18%;"><i>Principal&nbsp;&nbsp;&nbsp;&nbsp;</i></td>
					<td class="font-7 text-right" style="width: 13%;border-bottom: 0.4px solid #000;"><?php echo $result->blb_principal; ?></td>
				</tr>
				<tr style="line-height: 1.6">
					<td class="font-7 text-right" style="">Interest&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td class="font-7 text-right" style="border-bottom: 0.4px solid #000;"><?php echo $result->bma_interest; ?></td>
					<td class="font-7 text-center" style=""></td>		
					<td class="font-7 text-right" style=""><i>Interest&nbsp;&nbsp;&nbsp;&nbsp;</i></td>
					<td class="font-7 text-right" style="border-bottom: 0.4px solid #000;"><?php echo $result->blb_interest; ?></td>
				</tr>
				<tr style="line-height: 1.6">
					<td class="font-7 text-right" style="">Total&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td class="font-7 text-right" style="border-bottom: 0.4px solid #000;"><?php echo $result->bma_total; ?></td>
					<td class="font-7 text-center" style=""></td>		
					<td class="font-7 text-right" style=""><i>Total&nbsp;&nbsp;&nbsp;&nbsp;</i></td>
					<td class="font-7 text-right" style="border-bottom: 0.4px solid #000;"><?php echo $result->blb_total; ?></td>
				</tr>
				<tr style="line-height: 0.2">
					<td class="font-7 text-right" style=""></td>
					<td class="font-7" style=""></td>
					<td class="font-7 text-center" style=""></td>		
					<td class="font-7 text-right" style=""><i></i></td>
					<td class="font-7" style=""></td>
				</tr>
				<tr style="line-height: 0.4">
					<td class="font-7 text-right" style=""></td>
					<td class="font-7" style="border-top: 0.4px solid #000;"></td>
					<td class="font-7 text-center" style=""></td>		
					<td class="font-7 text-right" style=""><i></i></td>
					<td class="font-7" style="border-top: 0.4px solid #000;"></td>
				</tr>
				
			</table>
		<br>
		<br>
		<br>
		<br>
		<br>

		</td>
	</tr>

</table>
<table border="0.4" cellpadding="4">
	<tr style="font-size: 8px;">
		<td style="height: 60px;">
			<span>Certified Correct</span>
		</td>
		<td style="height: 60px;">
			<span>Recommending Approval</span>
		</td>
		<td style="height: 60px;">
			<span>Approved for Payment</span>
		</td>
		<td style="height: 60px;">
			<span>Received Payment: By/Date</span>
		</td>
	</tr>
	<tr style="font-size: 8px;">
		<td style="text-align: center;">
			<span>Accountant</span>
		</td>
		<td style="text-align: center;">
			<span>Vice-Chairperson/ Treasurer</span>
		</td>
		<td style="text-align: center;">
			<span>Chairperson/Vice-Chairperson</span>
		</td>
		<td style="text-align: center;">
			<span>Signature over printed name</span>
		</td>
	</tr>
</table>