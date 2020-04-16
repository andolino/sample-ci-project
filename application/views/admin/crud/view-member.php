<div class="cont-view-member row none">
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
					<input type="hidden" class="lgu-cons-id" value="<?php echo $data[0]->members_id; ?>" name="members_id">
					<input type="file" class="d-none" id="upload-file-dp" name="upload-file-dp">
				</form>
		</div>
	</div>
	<div class="col-10">
			<div class="row">
					<!-- heading -->
					<div class="col-12 mb-3">
						<div class="navbar mb-0">
							<h6 class="mb-0"><i class="fas fa-user-cog"></i> Personal Info</h6>
						</div>
					</div>

					<div class="col-12 mt-2">
						<div class="card">
					    <div class="card-body">
					      <div class="row">
					      	<div class="col-3">
						      	<label class="card-title font-12">Name</label>
						      	<p class="card-text font-12"><?php echo strtoupper($data[0]->last_name . ', ' . $data[0]->first_name . ' ' . $data[0]->middle_name); ?></p>
						      </div>
						      <div class="col-2">
						      	<label class="card-title font-12">Date of Birth</label>
						      	<p class="card-text font-12"><?php echo date('F j, Y', strtotime($data[0]->dob)); ?></p>
						      </div>
						      <div class="col-2">
						      	<label class="card-title font-12">Civil Status</label>
						      	<p class="card-text font-12"><?php echo strtoupper($data[0]->status); ?></p>
						      </div>
						      <div class="col-2">
						      	<label class="card-title font-12">Address</label>
						      	<p class="card-text font-12"><?php echo strtoupper($data[0]->address); ?></p>
						      </div>
						      <div class="col-2">
						      	<label class="card-title font-12">Monthly Salary</label>
						      	<p class="card-text font-12"><?php echo strtoupper($data[0]->monthly_salary); ?></p>
						      </div>
						      <div class="col-3 mt-3">
						      	<label class="card-title font-12">Designation</label>
						      	<p class="card-text font-12"><?php echo strtoupper($data[0]->designation); ?></p>
						      </div>
						      <div class="col-2 mt-3">
						      	<label class="card-title font-12">Office</label>
						      	<p class="card-text font-12"><?php echo strtoupper($data[0]->office_name); ?></p>
						      </div>
						      <div class="col-2 mt-3">
						      	<label class="card-title font-12">Date of Effectivity</label>
						      	<p class="card-text font-12"><?php echo strtoupper($data[0]->date_of_effectivity); ?></p>
						      </div>
						      <div class="col-2 mt-3">
						      	<label class="card-title font-12">Member Type</label>
						      	<p class="card-text font-12"><?php echo strtoupper($data[0]->type); ?></p>
						      </div>
					      </div>
					    </div>
					  </div>
					</div>
					<!-- end -->

			</div>	
			<div class="line mt-3 mb-3 pt-0 pb-0"></div>

	</div>
</div>