<div class="settings-link w-100">
	<div class="row mb-3">
		<div class="col-3">
			<label for="" class="font-12">Approved Loan Request</label>
			<select class="custom-select custom-select-sm font-12" id="select-loan-request-comp">
					<option value="" selected hidden></option>
					<?php foreach($loan_request as $row): ?>
					<option value="<?php echo $row->members_id; ?>" data-loanreq-id="<?php echo $row->loan_request_id; ?>"><?php echo strtoupper($row->last_name) . ', ' . strtoupper($row->first_name) . ' ' . strtoupper($row->middle_name) . ' (' . $row->loan_code . ') (' . str_pad($row->loan_request_id, 5, '0', STR_PAD_LEFT) . ')'; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<table class="table font-12 w-100" id="tbl-member-list" data-page="loan-application-page">
		<thead>
			<tr>
				<!-- <th scope="col"><input type="checkbox" id="chk-const-list-tbl-all" name="chk-const-list-tbl-all"></th> -->
				<th scope="col">ID #</th>
				<th scope="col">NAME</th>
				<th scope="col">FIRST NAME</th>
				<th scope="col">MIDDLE NAME</th>
				<th scope="col">DATE OF BIRTH</th>
				<th scope="col">OFFICE</th>
				<th scope="col">DEPARTMENT</th>
				<th scope="col">MEMBER TYPE</th>
				<th scope="col">DATE OF EFFECTIVITY</th>
				<th scope="col">ACTION</th>
			</tr>
		</thead>
		<tbody>
		  
		</tbody>
	</table>
	
</div>