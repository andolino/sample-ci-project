<div class="cont-add-member row w-100 m-auto">
	<div class="col-sm-12 req-ln-tbl">
		<div class="row">
			<!-- <div class="col-sm-12 col-md-6 col-lg-3">
				<a class="btn btn-purple btn-sm rounded-0 border mb-3 w-100 text-light" onclick="exportMemberContribution(this)"><i class="fas fa-save"></i> PRINT EXCEL</a>
      </div> -->
      <div class="col-sm-12 col-md-6 col-lg-3">
				<a class="btn btn-purple btn-sm rounded-0 border mb-3 w-100 text-light" id="membersOfContributionPortalPdf" data-id="<?php echo $members_id; ?>"><i class="fas fa-save"></i> EXPORT TO PDF</a>
			</div>
    </div>
    <!-- tbl-portal-loan-request-list -->
		<table class="table font-12 w-100" id="">
			<thead>
				<tr>
					<!-- <th scope="col"><input type="checkbox" id="chk-const-list-tbl-all" name="chk-const-list-tbl-all"></th> -->
					<th scope="col">MONTHLY COVERED</th>
					<th scope="col" class="text-right" style="text-align: right;">MONTHLY PAYMENT</th>
					<th scope="col" class="text-right" style="text-align: right;">COMMULATIVE BALANCE</th>
				</tr>
			</thead>
			<tbody>
        <?php $tota_ded=0; ?>
        <?php $tota_balance=0; ?>
        <?php $sum=0; ?>
        <?php foreach ($data as $row): ?>
        <?php $sum+=($row->deduction - $row->balance); ?> 
          <tr>
            <td style="text-align: left;"><?php echo date('F, Y', strtotime($row->date_applied)); ?></td>
            <td style="text-align: right;"><?php echo number_format($row->deduction, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($sum, 2); ?></td>
          </tr>
        <?php 
          $tota_ded+=$row->deduction;
          $tota_balance+=($row->deduction - $row->balance);
        ?>
        <?php endforeach ?>
        <tr>
          <td style="font-weight: 700;text-align: right;">TOTAL</td>
          <td style="font-weight: 700;text-align: right;"><?php //echo number_format($tota_ded, 2); ?></td>
          <td style="font-weight: 700;text-align: right;"><?php echo number_format($tota_balance, 2); ?></td>
        </tr>
			</tbody>
		</table>
		<button type="button" class="btn btn-danger btn-sm rounded-0 border float-right" onclick="window.location.reload()"><i class="fas fa-times"></i> BACK</button>
	</div>
	
</div>



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

<!-- Button trigger modal -->



<table id="members-contribution-excel" class="none" border="1">
	<tr>
		<td style="width: 20%;"></td>
		<td style="width: 60%; text-align: center;font-weight: 700;">CENSUS PROVIDENT FUND, INC. (CPFI)</td>
		<td style="width: 20%;"></td>
	</tr>
	<tr>
		<td style="width: 20%;"></td>
		<td style="width: 60%; text-align: center;font-weight: 700;">STATEMENT OF MEMBERSHIP CONTRIBUTIONS </td>
		<td style="width: 20%;"></td>
	</tr>
	<!-- <tr>
		<td style="width: 20%;"></td>
		<td style="width: 60%; text-align: center;font-weight: 700;">As of <?php //echo date('F Y', strtotime($sd)); ?></td>
		<td style="width: 20%;"></td>
	</tr> -->
	<tr>
		<td style="text-align: left;">Name of Member: </td>
		<td colspan="2" style="text-align: left"><?php echo !empty($data) ? strtoupper($data[0]->last_name . ', ' . $data[0]->first_name . ' ' . $data[0]->middle_name) : ''; ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">Employee Number:</td>
		<td colspan="2" style="text-align: left"><?php echo !empty($data) ? $data[0]->id_no : ''; ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">Official Station:</td>
		<td colspan="2" style="text-align: left"><?php echo !empty($data) ? $data[0]->office_name : ''; ?></td>
	</tr>
	<tr>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
	</tr>
	<tr>
		<td style="width: 20%;text-align: center;font-weight: 800;">MONTH COVERED</td>
		<td style="width: 20%;text-align: center;font-weight: 800;">MONTHLY PAYMENT</td>
		<td style="width: 20%;text-align: center;font-weight: 800;">CUMMULATIVE BALANCE</td>
	</tr>
	<tr>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
		<td style="border-top: 0.5px solid #000;"></td>
	</tr>
	<?php $tota_ded=0; ?>
	<?php $tota_balance=0; ?>
	<?php foreach ($data as $row): ?>
		<tr>
			<td style="text-align: center;"><?php echo date('F/Y', strtotime($row->date_applied)); ?></td>
			<td style="text-align: right;"><?php echo $row->deduction; ?></td>
			<td style="text-align: right;"><?php echo $row->deduction - $row->balance; ?></td>
		</tr>
	<?php 
		$tota_ded+=$row->deduction;
		$tota_balance+=($row->deduction - $row->balance);
	?>
	<?php endforeach ?>
	<tr>
		<td style="font-weight: 700;text-align: right;">TOTAL</td>
		<td style="font-weight: 700;text-align: right;"><?php echo number_format($tota_ded, 2); ?></td>
		<td style="font-weight: 700;text-align: right;"><?php echo number_format($tota_balance, 2); ?></td>
	</tr>
</table>



