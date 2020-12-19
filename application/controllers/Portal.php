<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Portal extends MY_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index(){
		
		$params['heading'] = 'WELCOME CPFI PANEL';
		$this->portalContainer('portal/index', $params);
  }
  
  public function show_profile(){
		$members_id 			 		 = $this->session->members_id;
		$params['uploads'] 		 = $this->db->get_where('uploads', array('members_id' => $members_id))->row();
		$params['membersData'] = $this->db->get_where('members', array('members_id' => $members_id))->row();
		$params['members_id']  = $members_id;
		$params['civilStatus'] = $this->db->get_where('civil_status', array('is_deleted' => 0))->result();
		$params['ofcMngmt'] 	 = $this->db->get_where('office_management', array('is_deleted' => 0))->result();
		$params['memberType']  = $this->db->get_where('member_type', array('is_deleted' => 0))->result();
    $this->load->view('portal/profile', $params);
	}
	
	public function show_loan_request(){
		$members_id 			 		 		= $this->session->members_id;
		$params['members_id']  		= $members_id;
		$params['loanCode']  			= $this->db->get_where('loan_code', array('is_deleted' => 0))->result();
		$params['co_maker']  			= $this->db->get_where('members', array('is_deleted' => 0, 'date_of_effectivity < DATE_SUB(NOW(),INTERVAL 1 YEAR) '))->result();
		
    $this->load->view('portal/request-a-loan', $params);
	}

	public function get_loan_settings(){
		$loan_code_id = $this->input->post('loan_code_id');
		$params['loan_settings']  = $this->db->get_where('loan_settings', array('loan_code_id' => $loan_code_id, 'is_deleted' => 0))->result();
		$params['loan_code_id']  = $loan_code_id;
		$this->load->view('portal/select-loan-settings', $params);
	}
	
	public function show_contribution(){
		$members_id 			 		 = $this->session->members_id;
		$params['members_id']  = $members_id;
		$params['data']=$this->AdminMod->getMembersContributionPortal($members_id);
    $this->load->view('portal/contribution', $params);
	}
	
	public function show_benefit_claims(){
		$members_id 			 		 = $this->session->members_id;
		$params['members_id']  		= $members_id;
		$params['loanCode']  			= $this->db->get_where('loan_code', array('is_deleted' => 0))->result();
		$params['benefit_type'] = $this->db->get_where('benefit_type', array('is_deleted' => 0))->result();
    $this->load->view('portal/request-a-benefit', $params);
	}
	
	public function show_account_ledger(){
		$members_id 			 		 	= $this->session->members_id;
		$title 			 		 				= $this->input->post('title');
		$params['members_id']   = $members_id;
		$params['title']   			= $title;
		$params['loanCode']  	  = $this->db->get_where('loan_code', array('is_deleted' => 0))->result();
		$params['benefit_type'] = $this->db->get_where('benefit_type', array('is_deleted' => 0))->result();
    $this->load->view('portal/account-ledger', $params);
	}

	public function getMembersPrintToPDF(){
		$m_id = $this->uri->segment(2);
		$params['data']=$this->AdminMod->getMembersContributionPortal($m_id);
		$html = $this->load->view('portal/contribution-excel', $params, TRUE);
		$this->AdminMod->pdf($html, 'Contribution Report', false, 'LEGAL', false, false, false, 'Contribution Report', '');
	}
	
	public function members_login(){
		if($this->session->userdata('members_id')){
			redirect(base_url('portal'));
		}
		$this->load->view('portal/login');
	}

	public function proceed_login(){
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$errors = array();
		if ($this->form_validation->run() == FALSE) {
			$errors = $this->form_validation->error_array();
			$errors['msg'] = 'failed';
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$q 				= $this->db->get_where('members', array('username' => $username, 'is_deleted' => '0'));
			if (!empty($q->row())) {
				$database_password = $q->row()->password;
				$found = password_verify($password, $database_password) ? 'success' : 'failed';
				// store info in session
				$userdata = array(
					'username'  => $username,
					'members_id' => $q->row()->members_id
				);
				$this->session->set_userdata($userdata);
			} else {
				$found = 'failed';
			}
			$errors['msg'] = $found;
		}
		echo json_encode($errors);
	}

	public function destroy_sess(){
		$this->session->sess_destroy();
		redirect(base_url('portal-login'), 'refresh');
	}

	public function save_members_info(){
		// $this->form_validation->set_rules('last_name', 'Last Name', 'required');
		// $this->form_validation->set_rules('first_name', 'First Name', 'required');
		// $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
		// $this->form_validation->set_rules('address', 'Address', 'required');
		// $this->form_validation->set_rules('civil_status_id', 'Civil Status', 'required');
		// $this->form_validation->set_rules('monthly_salary', 'Monthly Salary', 'required');
		// $this->form_validation->set_rules('designation', 'Designation', 'required');
		// $this->form_validation->set_rules('office_management_id', 'Office', 'required');
		// $this->form_validation->set_rules('date_of_effectivity', 'Date of Effectivity', 'required');
		// $this->form_validation->set_rules('member_type_id', 'Member', 'required');
		$this->form_validation->set_rules('contact_no', 'Contact', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		// if (array_key_exists('pwd_id', $_POST)) {
		// 	$this->form_validation->set_rules('pwd_id', 'PWD ID', 'trim|required');
		// }
		
		$errors 		 = array();
		$isForUpdate = false;
		$updateID 	 = '';
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
		} else {
			//save entry
			$dataField 						 = array();
			// $childrenNFieldData 	 = array();
			// $childrenBPFieldData 	 = array();
			foreach ($this->input->post() as $key => $value) {
				switch ($key) {
					case 'social_status':
						// $dataFieldSocialStatus[] = $value;
						break;
					case 'has_update':
						$isForUpdate = true;
						$updateID    = $value;
						break;
					default:
						$dataField[$key] 			 = str_replace(',', '', $value);
						break;
				}
			}
			$dataField['entry_date'] = date('Y-m-d');
			// $dataField['social_status'] 	 = implode('|', $dataFieldSocialStatus[0]);
			$dataField['users_id'] 				 = $this->session->users_id;
			
			/**
				Save members table
			*/
			if ($isForUpdate) {
				$this->db->update('members', $dataField, array('members_id'=>$updateID));
				$errors['members_id'] = $updateID;
			} else {
				$dataField['members_id'] = $this->AdminMod->primaryKey('members_id');
				// $genPw  = $this->generateKey(6);
				// $hashPw = password_hash($genPw, PASSWORD_BCRYPT);
				// $dataField['username'] 		 = strtolower(str_replace(' ', '', $this->input->post('first_name')[0]) . str_replace(' ', '', $this->input->post('last_name')));
				// $dataField['password'] 		 = $hashPw;
				// $dataField['password_txt'] = $genPw;

				// $from    		 = "manage_account@cpfi-webapp.com";
				// $from    		 = "no-reply@cpfi-webapp.com";
				// $to    	 		 = strtolower($this->input->post('email'));
				// $title    	 = "CPFI | Account Created";
				// $subject  	 = "New Member Created";
				// $message     = "Dear " . strtoupper($this->input->post('first_name')) . ", <br><br> 
				// 								Congratulations you already created you account below is your login credentials <br><br> Usename: " .
				// 								$dataField['username'] . " <br> Password: " . $dataField['password_txt'] . " <br><br> Thank you!";
				// $this->sendEmail($from, $to, $subject, $message, $title);
				
				$this->db->insert('members', $dataField);
				$errors['members_id'] 	 	 = $dataField['members_id'];
			}

		}
		echo json_encode($errors);
	}

	public function update_member_password(){
		$members_id = $this->input->post('members_id');
		$new_password = $this->input->post('new_password');
		$hashPw = password_hash($new_password, PASSWORD_BCRYPT);
		$q = $this->db->update('members', array(
			'password' => $hashPw,
			'password_txt' => $new_password
		), array('members_id' => $members_id));
		$res 								 = array();
		if ($q) {
			$res['param1'] 		 = 'Success!';
			$res['param2'] 		 = 'Password is Updated!';
			$res['param3'] 		 = 'success';
		} else {
			$res['param1']     = 'Opps!';
			$res['param2']     = 'Error Encountered Saved';
			$res['param3']     = 'warning';
		}
		echo json_encode($res);
	}

	public function upload_files(){
		$data = array(); 
		$errorUploadType = $statusMsg = ''; 
		// $uploadData = (object) array();
			// If files are selected to upload 
			if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0) { 
				$filesCount = count($_FILES['files']['name']); 
				for($i = 0; $i < $filesCount; $i++){ 
						$_FILES['file[]']['name']     = $_FILES['files']['name'][$i]; 
						$_FILES['file[]']['type']     = $_FILES['files']['type'][$i]; 
						$_FILES['file[]']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
						$_FILES['file[]']['error']    = $_FILES['files']['error'][$i]; 
						$_FILES['file[]']['size']     = $_FILES['files']['size'][$i]; 
							
						// File upload configuration 
						$uploadPath = './assets/image/uploads'; 
						$config['upload_path'] = $uploadPath; 
						$config['allowed_types'] = 'jpg|jpeg|png|gif'; 
						//$config['max_size']    = '100'; 
						//$config['max_width'] = '1024'; 
						//$config['max_height'] = '768'; 
							
						// Load and initialize upload library 
						$this->load->library('upload', $config); 
						$this->upload->initialize($config); 
							
						// Upload file to server 
						if($this->upload->do_upload('file[]')){ 
								// Uploaded file data 
								$fileData = $this->upload->data(); 
								$uploadData[$i]['file_name'] = $fileData['file_name']; 
								$uploadData[$i]['full_path'] = $fileData['full_path']; 
								$uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); 
								
						} else {  
								$errorUploadType .= $_FILES['file[]']['name'].' | ';  
						} 
						
				}
					
				// $errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
				// Insert files data into the database 
				$comaker_id_result = $this->input->post('co-maker-id');
				
				// get uploaded name
				$uploadedName = array();
				for ($i=0; $i < count($uploadData); $i++) { 
					$uploadedName[] = $uploadData[$i]['file_name'];
				}

				$this->db->insert("loan_request", array(
					'members_id' 	 => $this->input->post('has_update'),
					'entry_date' 	 => date('Y-m-d H:i:s'),
					'description'  => $this->input->post('description'),
					'loan_code_id' => $this->input->post('loan_code_id'),
					'co_maker_id'  => $comaker_id_result,
					'mo_terms' => $this->input->post('mo_terms'),
					'amnt_applied' => $this->input->post('amnt_applied')
				)); 
				$insert_id = $this->db->insert_id();
				$dataToDb = array();
				foreach ($uploadData as $key => $value) {
					array_push($dataToDb, array(
						'file_name' => $value['file_name'],
						'loan_request_id' => $insert_id,
						'transaction_date' => date('Y-m-d')
					));
				}
				
				$insert = $this->db->insert_batch("portal_uploads", $dataToDb); 
					
				$approver = $this->db->query("SELECT u.email, u.screen_name FROM request_approver ra LEFT JOIN users u ON u.users_id = ra.loan_first_approver_users_id WHERE ra.type = 'loans'")->row();
				$membersData = $this->db->get_where("members", array('members_id' => $this->input->post('has_update')))->row();
				$from    		 = "no-reply@cpfi-webapp.com";
				$to    	 		 = strtolower($approver->email);
				$title    	 = "CPFI REQUEST";
				$subject  	 = "Loan Request";
				$message     = "Dear " . strtoupper($approver->screen_name) . ", <br><br> 
												Loan request request from " . strtoupper($membersData->last_name) . ', ' . strtoupper($membersData->first_name) . " <br><br> Thank you!";
				$this->sendEmailWithAttachments($from, $to, $subject, $message, $title, $uploadedName);

				// Upload status message 
				// $statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
				if ($insert) {
					$res['param1'] 		 = 'Success!';
					$res['param2'] 		 = 'Request Submitted!';
					$res['param3'] 		 = 'success';
				} else {
					$res['param1']     = 'Opps!';
					$res['param2']     = 'Error Encountered Saved';
					$res['param3']     = 'warning';
				}
				echo json_encode($res);
		} else { 
			$comaker_id_result = $this->input->post('co-maker-id');

			$approver = $this->db->query("SELECT u.email, u.screen_name FROM request_approver ra LEFT JOIN users u ON u.users_id = ra.loan_first_approver_users_id WHERE ra.type = 'loans'")->row();
			$membersData = $this->db->get_where("members", array('members_id' => $this->input->post('has_update')))->row();
			$from    		 = "no-reply@cpfi-webapp.com";
			$to    	 		 = strtolower($approver->email);
			$title    	 = "CPFI REQUEST";
			$subject  	 = "New loan request from cpfi member";
			$message     = "Dear " . strtoupper($approver->screen_name) . ", <br><br> 
											Claim benefit request from " . strtoupper($membersData->last_name) . ', ' . strtoupper($membersData->first_name) . " <br><br> Thank you!";
			$this->sendEmail($from, $to, $subject, $message, $title);

			$insert =	$this->db->insert("loan_request", array(
				'members_id' 	 => $this->input->post('has_update'),
				'entry_date' 	 => date('Y-m-d H:i:s'),
				'description'  => $this->input->post('description'),
				'loan_code_id' => $this->input->post('loan_code_id'),
				'co_maker_id'  => $comaker_id_result,
				'mo_terms' 		 => $this->input->post('mo_terms'),
				'amnt_applied' => $this->input->post('amnt_applied')
			)); 
			if ($insert) {
				$res['param1'] 		 = 'Success!';
				$res['param2'] 		 = 'Request Submitted!';
				$res['param3'] 		 = 'success';
			} else {
				$res['param1']     = 'Opps!';
				$res['param2']     = 'Error Encountered Saved';
				$res['param3']     = 'warning';
			}
			echo json_encode($res);
		} 
	}

	public function option_co_maker(){
		$params['co_maker'] = $this->db->get_where('members', array('is_deleted' => 0, 'date_of_effectivity < DATE_SUB(NOW(),INTERVAL 1 YEAR) '))->result();
		$this->load->view('portal/option-co-maker', $params);
	}
	
	public function upload_files_benefit(){
		$data = array(); 
		$errorUploadType = $statusMsg = ''; 
			// If files are selected to upload 
			if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){ 
				$filesCount = count($_FILES['files']['name']); 
				for($i = 0; $i < $filesCount; $i++){ 
						$_FILES['file[]']['name']     = $_FILES['files']['name'][$i]; 
						$_FILES['file[]']['type']     = $_FILES['files']['type'][$i]; 
						$_FILES['file[]']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
						$_FILES['file[]']['error']    = $_FILES['files']['error'][$i]; 
						$_FILES['file[]']['size']     = $_FILES['files']['size'][$i]; 
							
						// File upload configuration 
						$uploadPath = './assets/image/uploads'; 
						$config['upload_path'] = $uploadPath; 
						$config['allowed_types'] = 'jpg|jpeg|png|gif'; 
						//$config['max_size']    = '100'; 
						//$config['max_width'] = '1024'; 
						//$config['max_height'] = '768'; 
							
						// Load and initialize upload library 
						$this->load->library('upload', $config); 
						$this->upload->initialize($config); 
							
						// Upload file to server 
						if($this->upload->do_upload('file[]')){ 
								// Uploaded file data 
								$fileData = $this->upload->data(); 
								$uploadData[$i]['file_name'] = $fileData['file_name']; 
								$uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); 
						}else{  
								$errorUploadType .= $_FILES['file[]']['name'].' | ';  
						} 
				} 
					
				// $errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
				$bClaimSettings = $this->db->get_where('benefit_type', array('benefit_type_id'=>$this->input->post('benefit_type_id')))->row();
				$bRequest = $this->db->get_where('benefit_request', 
																				array(
																					'benefit_type_id'=>$this->input->post('benefit_type_id'),
																					'members_id' => $this->input->post('has_update')
																				))->row();
				// get uploaded name
				$uploadedName = array();
				for ($i=0; $i < count($uploadData); $i++) { 
					$uploadedName[] = $uploadData[$i]['file_name'];
				}
				
				// if once avail and its already in request
				if ($bClaimSettings->is_avail_once == 1 && !empty($bRequest)) {
					$res['param1'] 		 = 'Opps!';
					$res['param2'] 		 = 'Sorry you are no longer request this type of benefit';
					$res['param3'] 		 = 'error';
					echo json_encode($res);
					die();
				}

				// Insert files data into the database 
				$this->db->insert("benefit_request", array(
					'members_id' 	 		 => $this->input->post('has_update'),
					'entry_date' 	 		 => date('Y-m-d H:i:s'),
					'benefit_type_id'  => $this->input->post('benefit_type_id'),
					'effectivity_date' => date('Y-m-d', strtotime($this->input->post('date_effectivity')))
				)); 
				$insert_id = $this->db->insert_id();
				$dataToDb = array();
				foreach ($uploadData as $key => $value) {
					array_push($dataToDb, array(
						'file_name' => $value['file_name'],
						'benefit_request_id' => $insert_id,
						'transaction_date' => date('Y-m-d')
					));
				}
				
				$insert = $this->db->insert_batch("portal_uploads", $dataToDb); 
				
				// $from    		 = "manage_account@cpfi-webapp.com";
				$approver 	 = $this->db->query("SELECT u.email, u.screen_name FROM request_approver ra LEFT JOIN users u ON u.users_id = ra.benefit_first_approver_users_id WHERE ra.type = 'benefit'")->row();
				$membersData = $this->db->get_where("members", array('members_id' => $this->input->post('has_update')))->row();
				$officeData  = $this->db->get_where("office_management", array('office_management_id' => $membersData->members_id))->row();
				$from    		 = "no-reply@cpfi-webapp.com";
				$to    	 		 = strtolower($approver->email);
				$title    	 = "CPFI REQUEST";
				$subject  	 = "Benefit Claim Request";
				$message     = "The Chairperson <br>"; 
				$message     .= "Board of Trustees <br>"; 
				$message     .= "Sir/Madam: <br><br>"; 
				$message     .= "This is to inform you that ".strtoupper($membersData->last_name) . ', ' . strtoupper($membersData->first_name) . ", " . (!empty($officeData) ? $officeData->office_name : '') . "<br><br>"; 
				$message     .= "Benefit Claim to avail : " . $bClaimSettings->type_of_benefit . "<br>"; 
				$message     .= "Date of Event / Effectivity : " . date('Y-m-d', strtotime($this->input->post('date_effectivity'))) . "<br><br>"; 
				$message     .= "Claimant : " . strtoupper($membersData->last_name) . ', ' . strtoupper($membersData->first_name) . "<br><br>"; 
				$message     .= "LBP Account No. : " . $membersData->bank_account . "<br>"; 
				$message     .= "Email Address. : " . $membersData->email . "<br>"; 
				$message     .= "Contact No. : " . $membersData->contact_no . "<br>"; 
				$this->sendEmailWithAttachments($from, $to, $subject, $message, $title, $uploadedName);
				// Upload status message 
				// $statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
				if ($insert) {
					$res['param1'] 		 = 'Success!';
					$res['param2'] 		 = 'Request Submitted!';
					$res['param3'] 		 = 'success';
				} else {
					$res['param1']     = 'Opps!';
					$res['param2']     = 'Error Encountered Saved';
					$res['param3']     = 'warning';
				}
				echo json_encode($res);

		}else{ 
			$approver = $this->db->query("SELECT u.email, u.screen_name FROM request_approver ra LEFT JOIN users u ON u.users_id = ra.loan_first_approver_users_id WHERE ra.type = 'benefit'")->row();
			$membersData = $this->db->get_where("members", array('members_id' => $this->input->post('has_update')))->row();
			$from    		 = "no-reply@cpfi-webapp.com";
			$to    	 		 = strtolower($approver->email);
			$title    	 = "CPFI REQUEST";
			$subject  	 = "Benefit Claim Request";
			$message     = "The Chairperson <br>"; 
			$message     .= "Board of Trustees <br>"; 
			$message     .= "Sir/Madam: <br><br>"; 
			$message     .= "This is to inform you that ".strtoupper($membersData->last_name) . ', ' . strtoupper($membersData->first_name) . ", " . (!empty($officeData) ? $officeData->office_name : '') . "<br><br>"; 
			$message     .= "Benefit Claim to avail : " . $bClaimSettings->type_of_benefit . "<br>"; 
			$message     .= "Date of Event / Effectivity : " . date('Y-m-d', strtotime($this->input->post('date_effectivity'))) . "<br><br>"; 
			$message     .= "Claimant : " . strtoupper($membersData->last_name) . ', ' . strtoupper($membersData->first_name) . "<br><br>"; 
			$message     .= "LBP Account No. : " . $membersData->bank_account . "<br>"; 
			$message     .= "Email Address. : " . $membersData->email . "<br>"; 
			$message     .= "Contact No. : " . $membersData->contact_no . "<br>"; 
			$this->sendEmail($from, $to, $subject, $message, $title);

			$insert =	$this->db->insert("benefit_request", array(
				'members_id' 	 		 => $this->input->post('has_update'),
				'entry_date' 	 		 => date('Y-m-d H:i:s'),
				'benefit_type_id'  => $this->input->post('benefit_type_id'),
				'effectivity_date' => date('Y-m-d', strtotime($this->input->post('date_effectivity')))
			)); 
			if ($insert) {
				$res['param1'] 		 = 'Success!';
				$res['param2'] 		 = 'Request Submitted!';
				$res['param3'] 		 = 'success';
			} else {
				$res['param1']     = 'Opps!';
				$res['param2']     = 'Error Encountered Saved';
				$res['param3']     = 'warning';
			}
			echo json_encode($res);
		} 
	}

	public function view_loan_comments(){
		$id = $this->input->post('id');
		$field = $this->input->post('field');
		if ($field=='loan_request') {
			$params['msg'] = $this->db->query("SELECT * FROM loan_req_msg lrm left join users u on u.users_id = lrm.user_id WHERE loan_request_id = $id")->result();
		} else {
			$params['msg'] = $this->db->query("SELECT * FROM benefit_req_msg lrm left join users u on u.users_id = lrm.user_id WHERE benefit_request_id = $id")->result();
		}
		$this->load->view('portal/loan-req-msg', $params);
	}

}
