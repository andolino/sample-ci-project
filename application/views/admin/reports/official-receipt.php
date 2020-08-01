<style type="text/css">
	.
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
	</tr>
</table>
<h4>OFFICIAL RECEIPT</h4>
<table cellpadding="3">
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;height: 30px;">
			<strong>RECEIVED FROM: </strong> <br>
			<?php echo !empty($data) ? $data->short: ''; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 25%;">
			<strong>Date:</strong> <br>
			<?php echo !empty($data) ? date('F j, Y', strtotime($data->date_applied)): ''; ?>
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 60%;height: 30px;">
			<strong>ADDRESS:</strong> <br>
			<?php echo !empty($data) ? $data->address: ''; ?>
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;height: 30px;">
			<strong>TIN:</strong> <br>
			<?php echo !empty($data) ? $data->tin: ''; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 25%;">
			<strong> BUSINESS STYLE:</strong> <br>
			<?php echo !empty($data) ? $data->business_style: ''; ?>
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 40%;height: 30px;">
			<strong>THE SUM OF:</strong> <br>
			<?php $sum = $sum_words(str_replace('.00', '', $data->total)); ?>
			<?php echo !empty($sum) ? $sum : ''; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 20%;">
			<?php echo !empty($data) ? $data->total : 0; ?>
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 20%;height: 30px;">
			<strong>Sr. Citizen TIN:</strong> <br>
			<?php echo !empty($data) ? $data->senior_citizen_tin : 0; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 20%;">
			<strong>OSCA/PWD ID No.:</strong> <br>
			<?php echo !empty($data) ? $data->osca_pwd_citizen_tin : 0; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 20%;">
			<strong>Signature:</strong>
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 60%;text-align: center;">
			<strong>IN PAYMENT OF THE FOLLOWING</strong>
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: center;">
			<strong>PARTICULARS:</strong>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 25%;text-align: center;">
			<strong>AMOUNT:</strong>
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: left;">
			<strong>Contribution:</strong>
			
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 22%;text-align: center;">
			<?php echo !empty($data) ? number_format($data->contribution, 2) : 0; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 3%;text-align: center;">
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: left;">
			<strong>Loans (GPLN): </strong>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 22%;text-align: center;">
			<?php echo !empty($data) ? number_format($data->gpln, 2) : 0; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 3%;text-align: center;">
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: left;">
			<strong>Loans (EMLN) : </strong>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 22%;text-align: center;">
			<?php echo !empty($data) ? number_format($data->emln, 2) : 0; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 3%;text-align: center;">
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: left;">
			<strong>Loans (SLMV) :</strong>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 22%;text-align: center;">
			<?php echo !empty($data) ? number_format($data->slmv, 2) : 0; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 3%;text-align: center;">
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: left;">
			<strong>Others</strong>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 22%;text-align: center;">
			<?php echo !empty($data) ? number_format($data->others, 2) : 0; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 3%;text-align: center;">
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: left;">
			<?php echo !empty($data) ? '***' . $data->remarks : 0; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 22%;text-align: center;">
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 3%;text-align: center;">
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: left;">
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 22%;text-align: center;">
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 3%;text-align: center;">
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: left;">
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 22%;text-align: center;">
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 3%;text-align: center;">
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: left;">
			<strong>Total Sales:</strong>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 22%;text-align: center;">
			<?php echo !empty($data) ? number_format($data->amount, 2) : 0; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 3%;text-align: center;">
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: left;">
			<strong>Less SC/PWD Discount:</strong>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 22%;text-align: center;">
			<?php echo !empty($data) ? number_format($data->sc_pw_discount, 2) : 0; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 3%;text-align: center;">
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: left;">
			<strong>Total Due:</strong>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 22%;text-align: center;">
			<?php echo !empty($data) ? number_format($data->total_due, 2) : 0; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 3%;text-align: center;">
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: left;">
			<strong>Less Withholding Tax:</strong>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 22%;text-align: center;">
			<?php echo !empty($data) ? number_format($data->withholding_tax, 2) : 0; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 3%;text-align: center;">
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;text-align: left;">
			<strong>Payment Due:</strong>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 22%;text-align: center;">
			<?php echo !empty($data) ? number_format($data->payment_due, 2) : 0; ?>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 3%;text-align: center;">
		</td>
	</tr>
	<tr>
		<td style="border:0.2px solid #000; font-size: 8px;width: 35%;height: 40px;text-align: left;">
			<strong>RECEIVED PAYMENT</strong>
			<br>
			<br>
			<table>
				<tr>
					<td style="width: 80%;border-bottom: 1px solid #000;"></td>
				</tr>
				<tr>
					<td style="width: 80%;text-align: center;line-height: 2.5">
						Cashier / Authorized Signature
					</td>
				</tr>
			</table>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 10%;text-align: center;line-height: 6">
			<strong>TOTAL</strong>
		</td>
		<td style="border:0.2px solid #000; font-size: 8px;width: 15%;text-align: center;line-height: 6">
			<?php echo !empty($data) ? number_format($data->total, 2) : 0; ?>
		</td>
	</tr>
	<tr>
		<td></td>
	</tr>
	<tr>
		<td></td>
	</tr>
	<tr>
		<td style="text-align: center;font-size: 8px;font-weight: 700;width: 61%;">
			* THIS DOCUMENT IS NOT VALID FOR CLAIMING INPUT TAXES* <br>
			THIS OFFICIAL RECEIPT SHALL BE VALID FOR YEARS FROM THE DATE OF ATP.
		</td>
	</tr>
</table>

<br>
<br>

