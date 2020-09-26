<div class="cont-add-member row">
	<div class="col-sm-12">
		<!-- <a href="javascript:void(0);" class="float-right pr-2 pb-2" id="loadPage" data-link="tbl-members" data-badge-head="MEMBER LIST"
   								data-cls="cont-tbl-constituent" data-placement="top" data-toggle="tooltip" title="Back to List"><i class="fas fa-times"></i></a> -->
	</div>
	<div class="col-sm-2 mb-3">
		<div class="picture-cont text-center">
			<?php if ($uploads && @file_exists('assets/image/uploads/' . $uploads->image_name)): ?>
				<img onclick="doUploadDb();" id="lgu-captured-image" src="<?php echo base_url('assets/image/uploads/') . $uploads->image_name; ?>" class="img-thumbnail">
			<?php else: ?>
				<img onclick="doUploadDb();" id="lgu-captured-image" src="<?php echo base_url('assets/image/misc/default-user-member-image.png'); ?>" class="img-thumbnail">
			<?php endif; ?>
			<div class="upload-ctrl none">
				<a href="#" onclick="doUploadDb();"><i class="fas fa-camera-retro"></i></a>
			</div>
			<form id="frm-upload-dp">
				<input type="hidden" class="lgu-cons-id" value="<?php echo $members_id; ?>" name="members_id">
				<input type="file" class="d-none" id="upload-file-dp" name="upload-file-dp">
			</form>
			<small id="emailHelp" class="form-text text-muted">Maximum upload file size: 3MB.</small>
		</div>
	</div>
	<div class="col-sm-10">

		<form id="frm-update-member">
			<div class="row">
					<!-- heading -->
					<div class="col-sm-12 mb-3">
						<div class="navbar mb-0">
							<h6 class="mb-0"><i class="fas fa-user-cog"></i> Personal Info</h6>
						</div>
					</div>
					<!-- end -->

					<div class="col-sm-3">
						<label for="id_no" class="font-12">ID No.</label>
						<div class="card-footer">
							<small class="text-muted"><?php echo !empty($membersData) ? $membersData->id_no : ''; ?></small>
						</div>
					</div>
					<div class="col-sm-3">
						<label for="last_name" class="font-12">Last Name</label>
						<div class="card-footer">
							<small class="text-muted"><?php echo !empty($membersData) ? $membersData->last_name : ''; ?></small>
						</div>
					</div>
					<div class="col-sm-3">
						<label for="first_name" class="font-12">First Name</label>
						<div class="card-footer">
							<small class="text-muted"><?php echo !empty($membersData) ? $membersData->first_name : ''; ?></small>
						</div>
					</div>
					<div class="col-sm-3">
						<label for="middle_name" class="font-12">Middle Name</label>
						<div class="card-footer">
							<small class="text-muted"><?php echo !empty($membersData) ? $membersData->middle_name : ''; ?></small>
						</div>
					</div>
					<div class="col-sm-3">
						<label for="dob" class="font-12">Date of birth</label>
						<div class="card-footer">
							<small class="text-muted"><?php echo !empty($membersData) ? $membersData->dob : ''; ?></small>
						</div>
					</div>
					<div class="col-sm-3">
						<label for="address" class="font-12">Address</label>
						<div class="card-footer">
							<small class="text-muted"><?php echo !empty($membersData) ? $membersData->address : ''; ?></small>
						</div>
					</div>
					<div class="col-sm-3 rel-cont">
						<label for="civil_status_id" class="font-12">Civil Status</label>
						<div class="card-footer">
							<?php foreach ($civilStatus as $row): ?>
								<small class="text-muted"><?php echo !empty($membersData) ? ($membersData->civil_status_id == $row->civil_status_id ? $row->status : '') : ''; ?></small>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="col-sm-3">
						<label for="monthly_salary" class="font-12">Monthly Salary</label>
						<div class="card-footer">
							<small class="text-muted"><?php echo !empty($membersData) ? $membersData->monthly_salary : ''; ?></small>
						</div>
					</div>
					<div class="col-sm-3">
						<label for="salary_grade" class="font-12">Salary Grade</label>
						<div class="card-footer">
							<small class="text-muted"><?php echo !empty($membersData) ? $membersData->salary_grade : ''; ?></small>
						</div>
					</div>
					<div class="col-sm-3">
						<label for="designation" class="font-12">Designation</label>
						<div class="card-footer">
							<small class="text-muted"><?php echo !empty($membersData) ? $membersData->designation : ''; ?></small>
						</div>
					</div>
					<div class="col-sm-3 rel-cont">
						<label for="office_management_id" class="font-12">Office</label>
						<div class="card-footer">
							<?php foreach ($ofcMngmt as $row): ?>
								<small class="text-muted"><?php echo !empty($membersData) ? ($membersData->office_management_id == $row->office_management_id ? $row->office_name : '') : ''; ?></small>
							<?php endforeach; ?>
						</div>
					</div>
					<!-- <div class="col-sm-3 mt-2 pl-0">
						<label for="date_of_effectivity" class="font-12">Date of Effectivity</label>
						<input type="date" class="form-control form-control-sm" id="date_of_effectivity" name="date_of_effectivity" placeholder="...">
					</div> -->
					<div class="col-sm-3">
						<label for="member_type_id" class="font-12">Member Type</label>
						<div class="card-footer">
							<?php foreach ($memberType as $row): ?>
								<small class="text-muted"><?php echo !empty($membersData) ? ($membersData->member_type_id == $row->member_type_id ? $row->type : '') : ''; ?></small>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="col-sm-3">
						<label for="bank_account" class="font-12">Bank Account</label>
						<div class="card-footer">
							<small class="text-muted"><?php echo !empty($membersData) ? $membersData->bank_account : ''; ?></small>
						</div>
					</div>
					<div class="col-sm-3">
						<label for="contact_no" class="font-12">Contact #:</label>
						<input type="text" class="form-control form-control-sm" id="contact_no" name="contact_no" value="<?php echo !empty($membersData) ? $membersData->contact_no : ''; ?>" placeholder="">
					</div>
					<div class="col-sm-3">
						<label for="email" class="font-12">Email:</label>
						<input type="text" class="form-control form-control-sm" id="email" name="email" value="<?php echo !empty($membersData) ? $membersData->email : ''; ?>" placeholder="">
					</div>
					<!-- heading -->
					<!-- <div class="col-sm-12 mb-3 mt-4">
						<div class="navbar mb-0">
							<h6 class="mb-0"><i class="fas fa-address-card"></i> Contact Details</h6>
						</div>
					</div> -->
					<!--  -->
					
					<!-- heading -->
					<!-- <div class="col-sm-12 mb-3 mt-4">
						<div class="navbar mb-0">
							<h6 class="mb-0"><i class="fas fa-child"></i> Family Background</h6>
						</div>
					</div> -->
					<!-- end -->
					
					<input type="hidden" id="has_update" name="has_update" value="<?php echo $members_id; ?>">
			</div>	
			<div class="line mt-3 mb-3 pt-0 pb-0"></div>
			<button type="button" onclick="window.location.reload()" class="btn btn-danger btn-sm rounded-0 border float-right"><i class="fas fa-times"></i> BACK</button>
			<button type="submit" class="btn btn-default btn-sm rounded-0 border float-right"><i class="fas fa-save"></i> UPDATE</button>
			<button type="button" class="btn btn-success btn-sm rounded-0 border float-right" data-toggle="modal" data-target="#newpw"><i class="fas fa-save"></i> CHANGE PASSWORD</button>
		</form>

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

<!-- Modal -->
<div class="modal fade" id="newpw" tabindex="-1" aria-labelledby="newpwLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<form action="" id="frm-update-password">
				<input type="hidden" value="<?php echo $members_id; ?>" name="members_id">
				  <input type="password" class="form-control form-control-sm" id="new_password" name="new_password">
				</form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="$('#frm-update-password').trigger('submit');" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>