<div class="cont-edit-member row none">
	<div class="col-12">
		<a href="javascript:void(0);" class="float-right pr-2 pb-2" id="loadPage" data-link="tbl-members" data-badge-head="MEMBER LIST"
   								data-cls="cont-tbl-constituent" data-placement="top" data-toggle="tooltip" title="Back to List"><i class="fas fa-times"></i></a>
	</div>
	<div class="col-2">
		<div class="picture-cont text-center">
			<?php if ($uploads && @file_exists('assets/image/uploads/' . $uploads->image_name)): ?>
				<img id="lgu-captured-image" src="<?php echo base_url('assets/image/uploads/') . $uploads->image_name; ?>" class="img-thumbnail">
			<?php else: ?>
				<img id="lgu-captured-image" src="<?php echo base_url('assets/image/misc/default-user-member-image.png'); ?>" class="img-thumbnail">
			<?php endif; ?>
			<div class="upload-ctrl none">
				<a href="#" onclick="doUploadDb();"><i class="fas fa-camera-retro"></i></a>
			</div>
			<form id="frm-upload-dp">
				<input type="hidden" class="lgu-cons-id" value="<?php echo $membersData->members_id; ?>" name="members_id">
				<input type="file" class="d-none" id="upload-file-dp" name="upload-file-dp">
			</form>
		</div>
	</div>
	<div class="col-10">
		<form id="frm-add-member">
			<div class="row">
					<!-- heading -->
					<div class="col-12 mb-3">
						<div class="navbar mb-0">
							<h6 class="mb-0"><i class="fas fa-user-cog"></i> Personal Info</h6>
						</div>
					</div>
					<!-- end -->

					<div class="col-3">
						<label for="id_no" class="font-12">ID No.</label>
						<input type="text" class="form-control form-control-sm font-12" id="id_no" name="id_no" value="<?php echo $membersData->id_no; ?>" placeholder="...">
					</div>
					<div class="col-3 pl-0">
						<label for="last_name" class="font-12">Last Name</label>
						<input type="text" class="form-control form-control-sm font-12" id="last_name" name="last_name" value="<?php echo $membersData->last_name; ?>" placeholder="...">
					</div>
					<div class="col-3 pl-0">
						<label for="first_name" class="font-12">First Name</label>
						<input type="text" class="form-control form-control-sm font-12" id="first_name" name="first_name" value="<?php echo $membersData->first_name; ?>" placeholder="...">
					</div>
					<div class="col-3 pl-0">
						<label for="middle_name" class="font-12">Middle Name</label>
						<input type="text" class="form-control form-control-sm font-12" id="middle_name" name="middle_name" value="<?php echo $membersData->middle_name; ?>" placeholder="...">
					</div>
					<div class="col-3 mt-2">
						<label for="name_extension" class="font-12">Extension Name</label>
						<input type="text" class="form-control form-control-sm font-12" id="name_extension" value="<?php echo $membersData->name_extension; ?>" name="name_extension" placeholder="...">
					</div>
					<div class="col-3 mt-2 pl-0">
						<label for="dob" class="font-12">Date of birth</label>
						<input type="date" class="form-control form-control-sm font-12" id="dob" name="dob" value="<?php echo $membersData->dob; ?>" placeholder="...">
					</div>
					<div class="col-3 mt-2 pl-0">
						<label for="sex" class="font-12">Sex</label>
						<select class="custom-select custom-select-sm font-12" id="sex" name="sex">
						  <option value="MALE" <?php echo $membersData->sex == 'MALE' ? 'selected' : ''; ?>></option>
						  <option value="FEMALE" <?php echo $membersData->sex == 'FEMALE' ? 'selected' : ''; ?>></option>
						</select>
					</div>
					<!-- <div class="col-3 mt-2 pl-0">
						<label for="address" class="font-12">Address</label>
						<input type="text" class="form-control form-control-sm" id="address" name="address" value="<?php echo $membersData->address; ?>" placeholder="...">
					</div> -->
					<div class="col-3 mt-2 pl-0 rel-cont">
						<label for="civil_status_id" class="font-12">Civil Status</label>
						<select class="custom-select custom-select-sm font-12" id="civil_status_id" name="civil_status_id">
						  <option selected hidden value="">-SELECT-</option>
						  <?php foreach ($civilStatus as $row): ?>
						  	<option value="<?php echo $row->civil_status_id; ?>" <?php echo $membersData->civil_status_id == $row->civil_status_id ? 'selected' : ''; ?>><?php echo $row->status; ?></option>
						  <?php endforeach; ?>
						</select>
					</div>
					<div class="col-3 mt-2">
						<label for="monthly_salary" class="font-12">Monthly Salary</label>
						<input type="text" class="form-control form-control-sm isNum font-12" id="monthly_salary" name="monthly_salary" value="<?php echo number_format($membersData->monthly_salary, 2); ?>" placeholder="...">
					</div>
					<div class="col-3 mt-2 pl-0">
						<label for="salary_grade" class="font-12">Salary Grade</label>
						<input type="text" class="form-control form-control-sm isNum font-12" id="salary_grade" name="salary_grade" value="<?php echo $membersData->salary_grade; ?>" placeholder="...">
					</div>
					<div class="col-3 pl-0 mt-2">
						<label for="designation" class="font-12">Designation</label>
						<input type="text" class="form-control form-control-sm font-12" id="designation" name="designation" value="<?php echo $membersData->designation; ?>" placeholder="...">
					</div>
					<div class="col-3 mt-2 pl-0 rel-cont">
						<label for="office_management_id" class="font-12">Departments</label>
						<select class="custom-select custom-select-sm font-12" id="office_management_id" name="office_management_id">
						  <option selected hidden value="">-SELECT-</option>
						  <?php foreach ($ofcMngmt as $row): ?>
						  	<option value="<?php echo $row->office_management_id; ?>" <?php echo $membersData->office_management_id == $row->office_management_id ? 'selected' : ''; ?>><?php echo $row->office_name; ?></option>
						  <?php endforeach; ?>
						</select>
					</div>
					<div class="col-3 mt-2">
						<label for="date_of_effectivity" class="font-12">Date of Effectivity</label>
						<input type="date" class="form-control form-control-sm font-12" id="date_of_effectivity" name="date_of_effectivity" value="<?php echo $membersData->date_of_effectivity; ?>" placeholder="...">
					</div>
					<div class="col-3 mt-2 pl-0">
						<label for="member_type_id" class="font-12">Member Type</label>
						<select class="custom-select custom-select-sm font-12" id="member_type_id" name="member_type_id">
						  <option selected hidden value="">-SELECT-</option>
						  <?php foreach ($memberType as $row): ?>
						  	<option value="<?php echo $row->member_type_id; ?>" <?php echo $membersData->member_type_id == $row->member_type_id ? 'selected' : ''; ?>><?php echo $row->type; ?></option>
						  <?php endforeach; ?>
						</select>
					</div>
					<div class="col-3 pl-0 mt-2">
						<label for="bank_account" class="font-12">Bank Account</label>
						<input type="text" class="form-control form-control-sm font-12" id="bank_account" name="bank_account" value="<?php echo $membersData->bank_account; ?>" placeholder="Ex. 'BPI - 012345678'">
					</div>
					<div class="col-3 mt-2 pl-0">
						<label for="contact_no" class="font-12">Contact #:</label>
						<input type="text" class="form-control form-control-sm font-12" id="contact_no" name="contact_no" value="<?php echo $membersData->contact_no; ?>" placeholder="">
					</div>
					<div class="col-3 mt-2">
						<label for="email" class="font-12">Email:</label>
						<input type="text" class="form-control form-control-sm font-12" id="email" name="email" value="<?php echo $membersData->email; ?>" placeholder="">
					</div>
					<?php $tota_ded=0; ?>
					<?php $tota_balance=0; ?>
					<?php $sum=0; ?>
					<?php foreach ($contrib as $row): ?>
					<?php $sum+=($row->deduction - $row->balance + $row->total); ?> 
					<?php 
						$tota_ded+=$row->total;
						$tota_balance+=($row->deduction - $row->balance);
					?>
					<?php endforeach ?>
					<!-- <pre>
						<?php //print_r($contrib); ?>
					</pre> -->
					<div class="col-3 pl-0 mt-2">
						<label for="contribution" class="font-12">Contribution:</label>
						<div class="input-group mb-3">
							<input type="text" class="form-control form-control-sm font-12" placeholder="0.00" value="<?php echo number_format($sum, 2); ?>">
							<div class="input-group-append">
								<button 
									class="btn btn-sm btn-outline-secondary font-12" 
									type="button"
									id="loadPage" 
									data-placement="top" 
									data-toggle="tooltip" 
									title="Edit Contribution" 
									data-link="view-contribution" 
									data-ind="<?php echo $membersData->members_id; ?>" 
									data-cls="cont-tbl-contribution"
									data-badge-head="CONTRIBUTION - <?php echo strtoupper($membersData->last_name) . ', ' . strtoupper($membersData->first_name); ?>"
								>Edit</button>
							</div>
						</div>
					</div>
					

			
			</div>	
			<div class="line mt-3 mb-3 pt-0 pb-0"></div>
			<button type="submit" class="btn btn-default btn-sm rounded-0 border float-right"><i class="fas fa-save"></i> Save</button>
			<input type="hidden" id="has_update" name="has_update" value="<?php echo $membersData->members_id; ?>">
		</form>

	</div>
</div>