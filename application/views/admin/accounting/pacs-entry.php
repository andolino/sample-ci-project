<div class="cont-cdj-entry row none w-100">
	<div class="col-12">
		<a href="javascript:void(0);" class="float-right pr-2 pb-2" id="loadPage" data-link="tbl-pacs-page" data-badge-head="PACS"
   								data-cls="cont-pacs" data-placement="top" data-toggle="tooltip" title="Back to List"><i class="fas fa-times"></i></a>
	</div>
	
	<div class="col-12">
		<form id="frm-accounting-entry">
			<div class="row">
					<!-- heading -->
					<!-- <div class="col-12 mb-3">
						<div class="navbar mb-0">
							<h6 class="mb-0"><i class="fas fa-user-cog"></i> Personal Info</h6>
						</div>
					</div> -->
					<!-- end -->

					<div class="col-3">
						<label for="journal_date" class="font-12">Journal Date.</label>
						<!-- 3 means CDJ -->
						<input type="hidden" name="j_type_id" value="4">
						<input type="text" value="<?php echo !empty($master) ? date('m/d/Y', strtotime($master->journal_date)) : ''; ?>" class="form-control form-control-sm font-12 rounded-0 pickerDate" id="journal_date" name="journal_date" placeholder="...">
					</div>
					<div class="col-3">
						<label for="cv_no" class="font-12">Account No.</label>
						<input type="text" value="<?php echo !empty($master) ? $master->account_no : ''; ?>" class="form-control form-control-sm font-12 rounded-0" id="account_no" name="account_no" placeholder="...">
					</div>
					<div class="col-3">
						<label for="ref_no" class="font-12">Reference No.</label>
						<input type="text" value="<?php echo !empty($master) ? $master->reference_no : ''; ?>" class="form-control form-control-sm font-12 rounded-0" id="ref_no" name="ref_no" placeholder="...">
					</div>
					<div class="col-3">
						<label for="particulars" class="font-12">Particulars.</label>
						<input type="text" value="<?php echo !empty($master) ? $master->particulars : ''; ?>" class="form-control form-control-sm font-12 rounded-0" id="particulars" name="particulars" placeholder="...">
					</div>
					<div class="col-12"></div>
					<div class="col-3 mt-2">
						<label for="ref_no" class="font-12">Payee Type.</label>
						<select class="custom-select custom-select-sm rounded-0" data-has-update="<?php echo !empty($master) ? ($master->payee_type==1 ? $master->payee_members_id : $master->payee) : ''; ?>" id="payee_select" name="payee_type">
						  <option hidden value="">-SELECT-</option>
						  <option value="1" <?php echo !empty($master) ? ($master->payee_type==1?'selected':'') : ''; ?>>Members</option>
						  <option value="2" <?php echo !empty($master) ? ($master->payee_type==2?'selected':'') : 'selected'; ?>>Others</option>s
						</select>
					</div>
					<div class="col-3 mt-2 payee-cont d-none">
						
					</div>
					<div class="col-12 mt-3">
						<table class="table" id="tbl-cdj-entry-form">
							<thead>
								<tr>
									<th class="font-12">Account</th>
									<th class="font-12">Subsidiary</th>
									<th class="font-12">Debit</th>
									<th class="font-12">Credit</th>
									<th class="font-12">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($details)): ?>
									<?php $i=1; ?>
									<?php foreach ($details as $row): ?>
										<?php $main = $mainAcct($row->acct_code); ?>
										<?php $subsid = $subAcct($row->subsidiary); ?>
										<tr>
											<td>
												<select class="form-control custom-select custom-select-sm rounded-0 main_code" id="select-main<?php echo $i;?>" name="main_code[]">
													<option value="<?php echo !empty($main) ? $main->code : ''; ?>"><?php echo !empty($main) ? $main->code . ' :: ' . $main->main_desc : ''; ?></option>	
												</select>
											</td>
											<td>
												<select class="form-control-sm custom-select custom-select-sm rounded-0 sub_code" id="select-sub<?php echo $i;?>" name="sub_code[]">
													<option value="<?php echo !empty($subsid) ? $subsid->sub_code : ''; ?>"><?php echo !empty($subsid) ? $subsid->employee_id . ' :: ' . $subsid->name : ''; ?></option>	
												</select>
											</td>
											<td><input type="text" value="<?php echo number_format($row->debit, 2); ?>" class="form-control form-control-sm font-12 rounded-0 text-right isNum debit" id="debit" name="debit[]" placeholder="0.00"></td>
											<td><input type="text" value="<?php echo number_format($row->credit, 2); ?>" class="form-control form-control-sm font-12 rounded-0 text-right isNum credit"  id="credit" name="credit[]" placeholder="0.00"></td>
											<td class="text-center"><button type="button" class="btn btn-sm btn-success font-12" id="add-row-acct-entry"><i class="fas fa-plus-square"></i></button> 
											<?php if ($i==1): ?>
											<?php else: ?>
												| <button type="button" class="btn btn-sm btn-danger font-12" id="remove-row-acct-entry"><i class="fas fa-minus-square"></i></button>	
											<?php endif ?>
											</td>
											<!-- | <button type="button" class="btn btn-sm btn-danger font-12"><i class="fas fa-minus-square"></i></button> -->
										</tr>
										<?php $i++; ?>
									<?php endforeach; ?>
								<?php else: ?>
									<tr>
										<td>
											<select class="form-control custom-select custom-select-sm rounded-0 main_code" id="select-main" name="main_code[]"></select>
										</td>
										<td>
											<select class="form-control-sm custom-select custom-select-sm rounded-0 sub_code" id="select-sub" name="sub_code[]"><option value=""></option></select>
										</td>
										<td><input type="text" class="form-control form-control-sm font-12 rounded-0 text-right isNum debit" id="debit" name="debit[]" placeholder="0.00"></td>
										<td><input type="text" class="form-control form-control-sm font-12 rounded-0 text-right isNum credit"  id="credit" name="credit[]" placeholder="0.00"></td>
										<td class="text-center"><button type="button" class="btn btn-sm btn-success font-12" id="add-row-acct-entry"><i class="fas fa-plus-square"></i></button> </td>
										<!-- | <button type="button" class="btn btn-sm btn-danger font-12"><i class="fas fa-minus-square"></i></button> -->
									</tr>
								<?php endif ?>


							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th class="text-right font-weight-bold font-12">TOTAL</th>
									<th class="text-right font-weight-bold font-12 total_debit">0.00</th>
									<th class="text-right font-weight-bold font-12 total_credit">0.00</th>
									<th></th>
								</tr>
							</tfoot>
						</table>
					</div>
					

			</div>	
			<div class="line mt-3 mb-3 pt-0 pb-0"></div>
			<input type="hidden" name="has_update" value="<?php echo $has_update ?? ''; ?>">
			<button type="<?php echo !empty($master) ? ($master->date_posted=='' ? 'submit' : 'button') : ''; ?>" class="btn btn-default btn-sm rounded-0 border float-right"><i class="fas fa-save"></i> Save</button>
		</form>

	</div>

</div>