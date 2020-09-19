<div class="cont-add-member row none">
	<div class="col-12">
		<a href="javascript:void(0);" class="float-right pr-2 pb-2" id="loadPage" data-link="tbl-members" data-badge-head="MEMBER LIST"
   								data-cls="cont-tbl-constituent" data-placement="top" data-toggle="tooltip" title="Back to List"><i class="fas fa-times"></i></a>
	</div>
	<div class="col-2">
		<div class="picture-cont text-center">
			<img src="<?php echo base_url('assets/image/misc/default-user-member-image.png'); ?>" class="img-thumbnail">
				<small><i>NOTE: You can update your picture after you save the details.</i></small>
				<form id="frm-upload-dp">
					<input type="file" class="d-none" name="upload-file-dp">
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
						<input type="text" class="form-control form-control-sm" id="id_no" name="id_no" placeholder="...">
					</div>
					<div class="col-3 pl-0">
						<label for="last_name" class="font-12">Last Name</label>
						<input type="text" class="form-control form-control-sm" id="last_name" name="last_name" placeholder="...">
					</div>
					<div class="col-3 pl-0">
						<label for="first_name" class="font-12">First Name</label>
						<input type="text" class="form-control form-control-sm" id="first_name" name="first_name" placeholder="...">
					</div>
					<div class="col-3 pl-0">
						<label for="middle_name" class="font-12">Middle Name</label>
						<input type="text" class="form-control form-control-sm" id="middle_name" name="middle_name" placeholder="...">
					</div>
					<div class="col-3 mt-2">
						<label for="dob" class="font-12">Date of birth</label>
						<input type="date" class="form-control form-control-sm" id="dob" name="dob" placeholder="...">
					</div>
					<div class="col-3 mt-2 pl-0">
						<label for="address" class="font-12">Address</label>
						<input type="text" class="form-control form-control-sm" id="address" name="address" placeholder="...">
					</div>
					<div class="col-3 mt-2 pl-0 rel-cont">
						<label for="civil_status_id" class="font-12">Civil Status</label>
						<select class="custom-select custom-select-sm" id="civil_status_id" name="civil_status_id">
						  <option selected hidden value="">-SELECT-</option>
						  <?php foreach ($civilStatus as $row): ?>
						  	<option value="<?php echo $row->civil_status_id; ?>"><?php echo $row->status; ?></option>
						  <?php endforeach; ?>
						</select>
					</div>
					<div class="col-3 mt-2 pl-0">
						<label for="monthly_salary" class="font-12">Monthly Salary</label>
						<input type="text" class="form-control form-control-sm isNum" id="monthly_salary" name="monthly_salary" placeholder="...">
					</div>
					<div class="col-3 mt-2">
						<label for="salary_grade" class="font-12">Salary Grade</label>
						<input type="text" class="form-control form-control-sm isNum" id="salary_grade" name="salary_grade" placeholder="...">
					</div>
					<div class="col-3 pl-0 mt-2">
						<label for="designation" class="font-12">Designation</label>
						<input type="text" class="form-control form-control-sm" id="designation" name="designation" placeholder="...">
					</div>
					<div class="col-3 mt-2 pl-0 rel-cont">
						<label for="office_management_id" class="font-12">Office</label>
						<select class="custom-select custom-select-sm" id="office_management_id" name="office_management_id">
						  <option selected hidden value="">-SELECT-</option>
						  <?php foreach ($ofcMngmt as $row): ?>
						  	<option value="<?php echo $row->office_management_id; ?>"><?php echo $row->office_name; ?></option>
						  <?php endforeach; ?>
						</select>
					</div>
					<div class="col-3 mt-2 pl-0">
						<label for="date_of_effectivity" class="font-12">Date of Effectivity</label>
						<input type="date" class="form-control form-control-sm" id="date_of_effectivity" name="date_of_effectivity" placeholder="...">
					</div>
					<div class="col-3 mt-2">
						<label for="member_type_id" class="font-12">Member Type</label>
						<select class="custom-select custom-select-sm" id="member_type_id" name="member_type_id">
						  <option selected hidden value="">-SELECT-</option>
						  <?php foreach ($memberType as $row): ?>
						  	<option value="<?php echo $row->member_type_id; ?>"><?php echo $row->type; ?></option>
						  <?php endforeach; ?>
						</select>
					</div>
					<div class="col-3 pl-0 mt-2">
						<label for="bank_account" class="font-12">Bank Account</label>
						<input type="text" class="form-control form-control-sm" id="bank_account" name="bank_account" placeholder="Ex. 'BPI - 012345678'">
					</div>
					<div class="col-3 mt-2 pl-0">
						<label for="contact_no" class="font-12">Contact #:</label>
						<input type="text" class="form-control form-control-sm" id="contact_no" name="contact_no" placeholder="">
					</div>
					<div class="col-3 mt-2 pl-0">
						<label for="email" class="font-12">Email:</label>
						<input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="">
					</div>
					<!-- heading -->
					<!-- <div class="col-12 mb-3 mt-4">
						<div class="navbar mb-0">
							<h6 class="mb-0"><i class="fas fa-address-card"></i> Contact Details</h6>
						</div>
					</div> -->
					<!--  -->
					
					<!-- heading -->
					<!-- <div class="col-12 mb-3 mt-4">
						<div class="navbar mb-0">
							<h6 class="mb-0"><i class="fas fa-child"></i> Family Background</h6>
						</div>
					</div> -->
					<!-- end -->
					

			</div>	
			<div class="line mt-3 mb-3 pt-0 pb-0"></div>
			<button type="submit" class="btn btn-default btn-sm rounded-0 border float-right"><i class="fas fa-save"></i> Save</button>
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