<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Admin extends MY_Controller 

	function __construct(){
		parent::__construct();
	}

	public function index(){
		$params['heading'] = 'WELCOME CPFI PANEL';
		$this->adminContainer('admin/index', $params);
	}

	public function usr_login(){
		$this->load->view('admin/login');
	}

	public function proceed_login(){
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$errors = array();
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$errors['msg'] = 'failed';
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$q 				= $this->db->get_where('users', array('username' => $username, 'is_deleted' => 'f'));
			if (!empty($q->row())) {
				$database_password = $q->row()->password;
				$found = password_verify($password, $database_password) ? 'success' : 'failed';
				// store info in session
				$userdata = array(
					'username'  => $username,
					'users_id' => $q->row()->users_id
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
		redirect(base_url(), 'refresh');
	}

	public function loanApplication(){
		$params['heading'] 		 = 'LOAN APPLICATION';
		$params['loansPage'] = $this->load->view('admin/crud/loans-application-page', $params, TRUE);
		$this->adminContainer('admin/loans-application', $params);	
	}

	public function view_loan_app_page(){
		$params['heading'] = 'LOAN APPLICATION';
		$this->load->view('admin/crud/loans-application-page', $params);	
	}

	public function show_settings(){
		$params['heading'] 		 = 'SETTINGS';
		$params['settingPage'] = $this->load->view('admin/crud/setting-page', $params, TRUE);
		$this->adminContainer('admin/settings', $params);	
	}

	public function view_settings_page(){
		$params['heading'] = 'SETTINGS';
		$this->load->view('admin/crud/setting-page', $params);	
	}

	public function view_chart_of_accounts(){
		$params['coaData'] = $this->db->get('v_acct_chart')->result();
		$this->load->view('admin/crud/view-coa', $params);
	}

	public function view_loan_type(){
		$params['loanCode'] = $this->db->get('loan_code')->result();
		$this->load->view('admin/crud/view-loan-code', $params);
	}

	public function view_loan_settings(){
		$params['loanSettings'] = '';//$this->db->get('settings')->result();
		$this->load->view('admin/crud/view-loan-settings', $params);
	}

	public function show_add_loans(){
		$id = $this->input->get('id');
		if ($id) {
			$params['loanSettingsData'] = $this->db->get_where('loan_settings', array('loan_settings_id' => $id))->row();	
		}
		$params['loanCode'] = $this->db->get('loan_code')->result();
		$this->load->view('admin/crud/frm-add-loans', $params);
	}

	public function show_schedule_list(){
		$loan_computation_id = $this->input->get('id');
		$params['loanSched'] = $this->db->query("SELECT * FROM v_loan_sched_choices 
																							WHERE loan_computation_id = 21 
																							AND (coalesce(monthly_amortization,0) - coalesce(amnt_paid,0)) > 0")->result();
		$this->load->view('admin/crud/tbl-select-payment-sched', $params);
	}

	public function show_add_payments(){
		$loan_computation_id           = $this->input->get('id');
		$params['loan_computation_id'] = $loan_computation_id;
		// if ($id) {
		// 	$params['loanSettingsData'] = $this->db->get_where('loan_settings', array('loan_settings_id' => $id))->row();	
		// }
		$this->load->view('admin/crud/frm-add-payments', $params);
	}

	public function savePostPayment(){

		$scheduleID = explode('|', $this->input->post('loanSchedID'));
		$fieldToSave = array();
		if (is_array($scheduleID)) {
			$loanSchedQue = $this->db->select('*')->from('loan_schedule')->where_in('loan_schedule_id', $scheduleID)->get()->result();
			$totalAmntPaid = floatval(str_replace(',', '', $this->input->post('amnt_to_pay')));
			foreach ($loanSchedQue as $row) {
				// $totalAmntPaid -= floatval(str_replace(',', '', $row->monthly_amortization));
				if ($totalAmntPaid > floatval(str_replace(',', '', $row->monthly_amortization))) {
					array_push($fieldToSave, array(
						'loan_schedule_id' => $row->loan_schedule_id,
						'orno' 						 => $this->input->post('orno'),
						'amnt_paid' 			 => floatval(str_replace(',', '', $row->monthly_amortization)),
						'interest_paid' 	 => (floatval(str_replace(',', '', $row->monthly_amortization)) / 
																	floatval(str_replace(',', '', $row->monthly_amortization))) * $row->monthly_interest,
						'date_paid' 			 => date('Y-m-d', strtotime($this->input->post('date_paid')))
					));
					$totalAmntPaid = $totalAmntPaid - floatval(str_replace(',', '', $row->monthly_amortization));
				} else {
					array_push($fieldToSave, array(
						'loan_schedule_id' => $row->loan_schedule_id,
						'orno' 						 => $this->input->post('orno'),
						'amnt_paid' 			 => $totalAmntPaid,
						'interest_paid' 	 => $totalAmntPaid / floatval(str_replace(',', '', $row->monthly_amortization)) * $row->monthly_interest,
						'date_paid' 			 => date('Y-m-d', strtotime($this->input->post('date_paid')))
					));
				}
				
			}
		}

		$q = $this->db->insert_batch('loan_receipt', $fieldToSave);
		$res = array();
		if ($q) {
			$res['param1'] = 'Success!';
			$res['param2'] = 'Thank you! your payment is successfully paid!';
			$res['param3'] = 'success';
		} else {
			$res['param1'] = 'Opps!';
			$res['param2'] = 'Error Encountered Saved';
			$res['param3'] = 'warning';
		}
		echo json_encode($res);
		// $params['loan_computation_id'] = $loan_computation_id;
		// $this->load->view('admin/crud/frm-add-payments', $params);
	}

	public function show_sub_frm(){
		$params['acctClass'] = $this->db->get('account_classes')->result();
		$this->load->view('admin/crud/frm-coa-sub', $params);
	}

	public function show_main_frm(){
		$params['acctGroups'] = $this->db->get('account_groups')->result();
		$this->load->view('admin/crud/frm-coa-main', $params);
	}

	public function save_sub_account(){
		// str_pad($value, 8, '0', STR_PAD_LEFT);
		
		$acctType 		= $this->input->post('acctType');
		$q 						= false;
		if ($acctType == 'account_groups') {
			$cntGroupAcct = $this->db->get_where('account_groups', array('class_code' => $this->input->post('class_code')))->num_rows();
			$group_code 	= str_pad($cntGroupAcct, 2, '0', STR_PAD_LEFT);
			$q 						= $this->db->insert($acctType,	array(
				'group_code' => $this->input->post('class_code'). '-' .$group_code,
				'group_desc' => $this->input->post('sub-name'),
				'class_code' => $this->input->post('class_code'),
				'user_id'		 => $this->session->users_id,
				'entry_date' => date('Y-m-d h:i:s')
			));
		} else {
			$cntMainAcct = $this->db->get_where('account_main', array('group_code' => $this->input->post('group_code')))->num_rows();
			$main_code 	 = str_pad($cntMainAcct, 2, '0', STR_PAD_LEFT);
			$q 						 = $this->db->insert($acctType,	array(
				'main_code'  => $this->input->post('group_code'). '-' . $main_code,
				'main_desc'  => $this->input->post('main-name'),
				'group_code' => $this->input->post('group_code'),
				'normal_bal' => $this->input->post('normal_bal'),
				'code' 			 => $this->input->post('code'),
				'user_id'		 => $this->session->users_id,
				'entry_date' => date('Y-m-d h:i:s')
			));
		}

		$res = array();
		if ($q) {
			$res['param1'] = 'Success!';
			$res['param2'] = 'Account Successfully Saved!';
			$res['param3'] = 'success';
		} else {
			$res['param1'] = 'Opps!';
			$res['param2'] = 'Error Encountered Saved';
			$res['param3'] = 'warning';
		}
		echo json_encode($res);
		// print_r($_POST);

	}

	public function save_loans_settings(){
		// str_pad($value, 8, '0', STR_PAD_LEFT);
		$data = array(
			'loan_code_id' 		 => $this->input->post('loan_code'),
			'number_of_month'  => $this->input->post('no_month'),
			'int_per_annum' 	 => $this->input->post('int_per_annum'),
			'lri' 						 => $this->input->post('lri'),
			'svc' 						 => $this->input->post('svc'),
			'repymnt_period'	 => $this->input->post('repayment_period'),
			'monthly_interest' => $this->input->post('monthly_interest'),
			'entry_date' 			 => date('Y-m-d h:i:s')
		);
		if ($this->input->post('loan_settings_id'))
			$q = $this->db->update('loan_settings',	$data, array('loan_settings_id' =>  $this->input->post('loan_settings_id')));
		else
			$q = $this->db->insert('loan_settings',	$data);
		
		
		$res = array();
		if ($q) {
			$res['param1'] = 'Success!';
			$res['param2'] = 'Loans Successfully Saved!';
			$res['param3'] = 'success';
		} else {
			$res['param1'] = 'Opps!';
			$res['param2'] = 'Error Encountered Saved';
			$res['param3'] = 'warning';
		}
		echo json_encode($res);
		// print_r($_POST);
	}

	public function control_token(){
		$params['heading'] 				 = 'CONTROL ACCESS TOKEN';
		$params['data'] 					 = $this->db->get('access_token')->row();
		$this->adminContainer('admin/token-ctrl-view', $params);	
	}

	public function show_gen_token(){
		$this->load->view('admin/crud/add-token');
	}

	public function generateToken(){
		$token                	= implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 16), 6));
		$encrpt_key 					 	= $this->AdminMod->encdec($token, 'e');
		// $hashed_key 					 	= password_hash($token, PASSWORD_BCRYPT);

		$params['token'] 		 		= $token;
		$params['encrypt_key'] 	= $encrpt_key;
		// $params['hashed_key'] 	= $hashed_key;

		echo json_encode($params);
	}

	public function saveToken(){
		$token 				 = $this->input->post('token');
		$secret_key		 = $this->input->post('secret-key');
		$hashed_key 	 = password_hash($token, PASSWORD_BCRYPT);

		$accessToken 	 = $this->db->get('access_token')->row();
		if ($accessToken) {
			$q = $this->db->update('access_token', array(
				'token' 		  => $token,
				'secret_key' 	=> $secret_key,
				'hashed_key'  => $hashed_key
			));
		} else {
			$q = $this->db->insert('access_token', array(
				'token' 		  => $token,
				'secret_key' 	=> $secret_key,
				'hashed_key'  => $hashed_key
			));
		}
		$res = array();
		if ($q) {
			$res['param1'] = 'Success!';
			$res['param2'] = 'Token Successfully Updated!';
			$res['param3'] = 'success';
		} else {
			$res['param1'] = 'Opps!';
			$res['param2'] = 'Error Encountered';
			$res['param3'] = 'warning';
		}
		echo json_encode($res);
	}

	public function tbl_members(){
		$this->load->view('admin/crud/tbl-members');
	}

	public function view_member(){
		$members_id 	  	 = $this->input->get('data');
		$params['data'] 	 = $this->AdminMod->getMembersRecord($members_id); 
		$params['uploads'] = $this->db->get_where('uploads', array('members_id' => $members_id))->row();
		$this->load->view('admin/crud/view-member', $params);
	}

	public function member_list(){
		$params['heading'] = 'MEMBER LIST';
		$params['tblMembers'] = $this->load->view('admin/crud/tbl-members', $params, TRUE);
		$this->adminContainer('admin/member-list', $params);	
	}

	public function server_tbl_members(){
		$result 	= $this->AdminMod->get_output_members();
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		$viewPage = $this->input->post('page');

		foreach ($result as $row) {
			$hashed_id = $this->encdec($row->members_id, 'e');
			$data = array();
			$no++;
   		$data[] = '<input type="checkbox" id="chk-const-list-tbl" value="'.$row->members_id.'" name="chk-const-list-tbl">';
   		$data[] = $row->id_no;
   		$data[] = $row->last_name;
   		$data[] = $row->first_name;
   		$data[] = $row->middle_name;
   		$data[] =	date('Y-m-d', strtotime($row->dob));
   		$data[] = $row->address;
   		$data[] = $row->status;
   		$data[] = date('Y-m-d', strtotime($row->date_of_effectivity));
   		
   		if ($viewPage == 'loan-application-page') {
   			$data[] = '<a href="javascript:void(0);" id="loadPage" data-link="process-a-loan" data-ind="'.$row->members_id.'" 
   								data-badge-head="LOAN PROCESS - (' . $row->id_no . ') ' . strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name).'" data-cls="cont-process-a-loan" data-placement="top" data-toggle="tooltip" title="Proccess a Loan" data-id="'.$row->members_id.'">
   								<i class="fas fa-edit"></i></a> | 
   								<a href="javascript:void(0);" id="loadPage" data-link="show-loans-list" data-ind="'.$row->members_id.'" 
   								data-badge-head="LOAN LIST - (' . $row->id_no . ') ' . strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name).'" data-cls="cont-loans-list-by-mem" data-placement="top" data-toggle="tooltip" title="Loans List" data-id="'.$row->members_id.'">
   								<i class="fas fa-list-alt"></i></a> | 
   								<a href="javascript:void(0);" id="loadPage" data-link="show-loans-by-member" data-ind="'.$row->members_id.'" 
   								data-badge-head="(' . $row->id_no . ') - ' . strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name).'" data-cls="cont-loans-by-mem" data-placement="top" data-toggle="tooltip" title="Loan by Member" data-id="'.$row->members_id.'">
   								<i class="fas fa-user"></i></a>';
   		} else {
   			$data[] = '<a href="javascript:void(0);" id="loadPage" data-link="view-member" data-ind="'.$row->members_id.'" 
   								data-badge-head="'.strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name).'" data-cls="cont-view-member" data-placement="top" data-toggle="tooltip" title="View" data-id="'.$row->members_id.'">
   								<i class="fas fa-search"></i></a> | 
   		 					<a href="javascript:void(0);" id="loadPage" data-placement="top" data-toggle="tooltip" title="Edit" data-link="edit-member" 
   		 						data-ind="'.$row->members_id.'" data-cls="cont-edit-member" data-badge-head="EDIT '.strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name).'"><i class="fas fa-edit"></i></a> | 
   		 					<a href="javascript:void(0);" id="remove-lgu-const-list" data-placement="top" data-toggle="tooltip" title="Remove" data-id="'.$row->members_id.'"><i class="fas fa-trash"></i></a>';
   		}

   		

   		// | 
   		// 					<a href="javascript:void(0);" id="loadPage" data-placement="top" data-toggle="tooltip" title="Edit" data-link="edit-constituent" 
   		// 						data-ind="'.$row->lgu_constituent_id.'" data-cls="cont-edit-member" data-badge-head="EDIT '.strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name).'"><i class="fas fa-edit"></i></a> | 
   		// 					<a href="javascript:void(0);" id="remove-lgu-const-list" data-placement="top" data-toggle="tooltip" title="Remove" data-id="'.$row->lgu_constituent_id.'"><i class="fas fa-trash"></i></a> | 
   		// 					<a href="'.base_url('lgu-id/').$hashed_id.'" target="_blank" data-placement="top" data-toggle="tooltip" title="View ID"><i class="fas fa-id-card-alt"></i></a>'

			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->AdminMod->count_all_members(),
			'recordsFiltered' => $this->AdminMod->count_filter_members(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function server_tbl_settings(){
		$result 	= $this->AdminMod->get_output_loan_settings();
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->loan_code;
   		$data[] = $row->number_of_month;
   		$data[] = number_format($row->int_per_annum, 2);
   		$data[] = number_format($row->lri, 2);
   		$data[] =	number_format($row->svc, 2);
   		$data[] = number_format($row->repymnt_period, 2);
   		$data[] = number_format($row->monthly_interest, 2);
 
 			$data[] = '<a href="javascript:void(0);" id="btn-add-loans" data-field="EDIT" data-id="'.$row->loan_settings_id.'" data-placement="top" data-toggle="tooltip" title="Edit" data-id="'.$row->loan_settings_id.'"><i class="fas fa-edit"></i> |  
   		 					<a href="javascript:void(0);" id="removeLoanSettings" data-placement="top" data-toggle="tooltip" title="Remove" data-id="'.$row->loan_settings_id.'"><i class="fas fa-trash"></i></a>';

   		

   		// | 
   		// 					<a href="javascript:void(0);" id="loadPage" data-placement="top" data-toggle="tooltip" title="Edit" data-link="edit-constituent" 
   		// 						data-ind="'.$row->lgu_constituent_id.'" data-cls="cont-edit-member" data-badge-head="EDIT '.strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name).'"><i class="fas fa-edit"></i></a> | 
   		// 					<a href="javascript:void(0);" id="remove-lgu-const-list" data-placement="top" data-toggle="tooltip" title="Remove" data-id="'.$row->lgu_constituent_id.'"><i class="fas fa-trash"></i></a> | 
   		// 					<a href="'.base_url('lgu-id/').$hashed_id.'" target="_blank" data-placement="top" data-toggle="tooltip" title="View ID"><i class="fas fa-id-card-alt"></i></a>'

			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->AdminMod->count_all_loan_settings(),
			'recordsFiltered' => $this->AdminMod->count_filter_loan_settings(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function server_tbl_loans_list(){
		$result 	= $this->AdminMod->get_output_loan_list();
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;


		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->ref_no;
   		$data[] = date('Y-m-d', strtotime($row->date_processed));
   		$data[] = $row->fname;
   		$data[] = $row->is_approved == '1' ? 'Approved' : 'Disapproved';
   		$data[] = $row->is_posted == '1' ? 'Posted' : 'Not Posted';
 
 			$data[] = '<a href="javascript:void(0);" id="loadPage" data-placement="top" data-toggle="tooltip" 
 																						title="Edit" data-link="edit-process-a-loan" data-ind="'.$row->loan_computation_id.'" data-cls="cont-edit-process-a-loan" data-badge-head="EDIT REF #: '.$row->ref_no. ' - '. $row->fname .'"><i class="fas fa-edit"></i>';

   		
   		// | 
   		// 					<a href="javascript:void(0);" id="loadPage" data-placement="top" data-toggle="tooltip" title="Edit" data-link="edit-constituent" 
   		// 						data-ind="'.$row->lgu_constituent_id.'" data-cls="cont-edit-member" data-badge-head="EDIT '.strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name).'"><i class="fas fa-edit"></i></a> | 
   		// 					<a href="javascript:void(0);" id="remove-lgu-const-list" data-placement="top" data-toggle="tooltip" title="Remove" data-id="'.$row->lgu_constituent_id.'"><i class="fas fa-trash"></i></a> | 
   		// 					<a href="'.base_url('lgu-id/').$hashed_id.'" target="_blank" data-placement="top" data-toggle="tooltip" title="View ID"><i class="fas fa-id-card-alt"></i></a>'

			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->AdminMod->count_all_loan_list(),
			'recordsFiltered' => $this->AdminMod->count_filter_loan_list(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function server_loans_by_member(){
		$result 	= $this->AdminMod->get_output_loan_by_member();
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;


		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->type;
   		$data[] = $row->ref_no;
   		$data[] = $row->col_period_start;
   		$data[] = $row->col_period_end ;
   		$data[] = number_format($row->amnt_of_loan, 2);
   		$data[] = number_format($row->payment, 2);
 
 			$data[] = '<a href="javascript:void(0);" id="btn-add-payments" data-field="ADD" data-id="'.$row->loan_computation_id.'" data-placement="top" data-toggle="tooltip" title="Pay Now" data-id="'.$row->loan_computation_id.'"><i class="fas fa-receipt"></i>';

   		
   		// | 
   		// 					<a href="javascript:void(0);" id="loadPage" data-placement="top" data-toggle="tooltip" title="Edit" data-link="edit-constituent" 
   		// 						data-ind="'.$row->lgu_constituent_id.'" data-cls="cont-edit-member" data-badge-head="EDIT '.strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name).'"><i class="fas fa-edit"></i></a> | 
   		// 					<a href="javascript:void(0);" id="remove-lgu-const-list" data-placement="top" data-toggle="tooltip" title="Remove" data-id="'.$row->lgu_constituent_id.'"><i class="fas fa-trash"></i></a> | 
   		// 					<a href="'.base_url('lgu-id/').$hashed_id.'" target="_blank" data-placement="top" data-toggle="tooltip" title="View ID"><i class="fas fa-id-card-alt"></i></a>'

			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->AdminMod->count_all_loan_by_member(),
			'recordsFiltered' => $this->AdminMod->count_filter_loan_by_member(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function add_member(){
		$params['civilStatus'] = $this->db->get('civil_status')->result();
		$params['ofcMngmt'] 	 = $this->db->get('office_management')->result();
		$params['memberType']  = $this->db->get('member_type')->result();
		$this->load->view('admin/crud/add-member', $params);	
	}

	public function process_a_loan(){
		$members_id 			 		 	= $this->input->get('data');
		$params['membersData'] 	= $this->db->get_where('v_members', array('members_id' => $members_id))->row();
		$params['loanTypes']	 	= $this->db->get('loan_types')->result();
		$params['loanSettings'] = $this->db->get('v_loan_settings')->result();
		$params['members_id'] 	= $members_id;
		$this->load->view('admin/crud/process-a-loan', $params);	
	}

	public function edit_process_a_loan(){
		$loan_computation_id 			 		 = $this->input->get('data');
		$params['loanComputation'] 		 = $this->db->get_where('loan_computation', array('loan_computation_id' => $loan_computation_id))->row();
		$params['membersData'] 		 		 = $this->db->get_where('v_members', array('members_id' => $params['loanComputation']->members_id))->row();
		$params['loanTypes']	 		 		 = $this->db->get('loan_types')->result();
		$params['loanSettings'] 	 		 = $this->db->get('v_loan_settings')->result();
		$params['members_id'] 		 		 = $params['loanComputation']->members_id;
		$params['loan_computation_id'] = $loan_computation_id;
		$this->load->view('admin/crud/edit-process-a-loan', $params);	
	}

	public function postLoanComp(){
		$loan_computation_id = $this->input->post('id');
		$q 									 = $this->db->update('loan_computation', array('is_posted' => '1'), array('loan_computation_id' => $loan_computation_id));
		$res 								 = array();
		if ($q) {
			$res['param1'] 		 = 'Success!';
			$res['param2'] 		 = 'Applied Loan is Successfully Posted!';
			$res['param3'] 		 = 'success';
		} else {
			$res['param1']     = 'Opps!';
			$res['param2']     = 'Error Encountered Saved';
			$res['param3']     = 'warning';
		}
		echo json_encode($res);
	}

	public function showLoansList(){
		$members_id 			 		 	= $this->input->get('data');
		$params['membersData'] 	= $this->db->get_where('v_members', array('members_id' => $members_id))->row();
		$params['loanTypes']	 	= $this->db->get('loan_types')->result();
		$params['loanSettings'] = $this->db->get('v_loan_settings')->result();
		$params['members_id'] 	= $members_id;
		$this->load->view('admin/crud/v-loans-list-by-member-id', $params);	
	}

	public function showLoansByMember(){
		$members_id 			 		 	= $this->input->get('data');
		$params['membersData'] 	= $this->db->get_where('v_members', array('members_id' => $members_id))->row();
		$params['loanTypes']	 	= $this->db->get('loan_types')->result();
		$params['loanSettings'] = $this->db->get('v_loan_settings')->result();
		$params['members_id'] 	= $members_id;
		$this->load->view('admin/crud/v-loans-by-member', $params);	
	}

	public function computeLoans(){
		//loan_settings_id
		$members_id					 = $this->input->post('m_id');
		$loanSettingsID 		 = $this->input->post('no_mos_applied');
		$monthlySalary 			 = floatval(str_replace(',', '', $this->input->post('monthly_salary')));
		$dateProcessed 			 = $this->input->post('date_processed');
		$loanSettingsDetails = $this->db->get_where('loan_settings', array('loan_settings_id' => $loanSettingsID))->row();
		$dataName 					 = array();

		//collection period date
		$oneYr = 12;
		$pD = date('Y-m-d', strtotime($dateProcessed));
		$arrPD = array();
		for($i = 1; $i <= $oneYr; $i++){
		 $arrPD[$i] = date('Y-m', strtotime("+".$i."months", strtotime($pD)));
		}

		$dataName['m_id'] 								= $members_id;
		$dataName['interest_per_annum'] 	= floatval($loanSettingsDetails->int_per_annum);
		$dataName['amnt_of_loan_applied'] = $monthlySalary;
		$dataName['add_interest'] 				= $monthlySalary * ($loanSettingsDetails->int_per_annum / 100) * $loanSettingsDetails->repymnt_period;
		$dataName['gross_amnt_of_loan'] 	= $monthlySalary + $dataName['add_interest'];
		$dataName['first_yr_int_ded'] 		= $monthlySalary * ($loanSettingsDetails->int_per_annum / 100);
		$dataName['tot_amnt_tobe_amort'] 	= $dataName['gross_amnt_of_loan'] - $dataName['first_yr_int_ded'];
		$dataName['monthly_amort'] 				= $dataName['tot_amnt_tobe_amort'] / $loanSettingsDetails->repymnt_period / 12;
		$dataName['ded_interest'] 				= $dataName['first_yr_int_ded'];
		$dataName['loan_red_ins'] 				= $monthlySalary * ($loanSettingsDetails->lri / 100);
		$dataName['service_charge'] 			= floatval($loanSettingsDetails->svc);
		$dataName['previouse_loan'] 			= 0;//floatval(83066.94);
		$dataName['prev_loans_pymnts'] 		= 0;//floatval(55377.96);
		$dataName['balance_on_prev_loan'] = 0;//floatval(27688.98);
		$dataName['total_deductions'] 		= $dataName['ded_interest'] + $dataName['loan_red_ins'] + $dataName['service_charge'] + $dataName['balance_on_prev_loan'];
		$dataName['net_proceeds'] 				= $monthlySalary - $dataName['total_deductions'];
		$dataName['collection_prd_start'] = $arrPD[1];
		$dataName['collection_prd_end'] 	= $arrPD[12];
		$dataName['bma_principal'] 	      = $dataName['monthly_amort'] / $loanSettingsDetails->monthly_interest;
		$dataName['bma_interest'] 	      = $dataName['monthly_amort'] - $dataName['bma_principal'];
		$dataName['bma_total'] 	      		= $dataName['bma_principal'] + $dataName['bma_interest'];

		echo json_encode($dataName, JSON_PRETTY_PRINT);

	}

	public function saveLoanComp(){
		$dataLoanComp = array(
			'members_id' 							 => $this->input->post('m_id'),
			'loan_types_id' 					 => $this->input->post('type_of_loan'),
			'loan_settings_id' 				 => $this->input->post('no_mos_applied'),
			'loan_release_mode' 			 => $this->input->post('modePymnt'),
			'purpose_of_loan' 				 => $this->input->post('purpose_of_loan'),
			'net_take_home_pay' 			 => str_replace(',', '', $this->input->post('net_takehome_pay')),
			'is_approved' 						 => $this->input->post('radioApprovalFlag'),
			'ref_no' 									 => $this->input->post('loancomp_ref_no'),
			'remarks' 								 => $this->input->post('lcomp_remarks'),
			'amnt_of_loan' 						 => str_replace(',', '', $this->input->post('amnt_of_loan_applied')),
			'add_interest' 						 => str_replace(',', '', $this->input->post('add_interest')),
			'gross_amnt' 							 => str_replace(',', '', $this->input->post('gross_amnt_of_loan')),
			'first_yr_int_ded' 				 => str_replace(',', '', $this->input->post('first_yr_int_ded')),
			'total_amnt_to_be_amort' 	 => str_replace(',', '', $this->input->post('tot_amnt_tobe_amort')),
			'monthly_amortization' 		 => str_replace(',', '', $this->input->post('monthly_amort')),
			'ded_interest' 						 => str_replace(',', '', $this->input->post('ded_interest')),
			'lri_comp' 								 => str_replace(',', '', $this->input->post('loan_red_ins')),
			'svc_comp' 								 => str_replace(',', '', $this->input->post('service_charge')),
			'total_deductions' 				 => str_replace(',', '', $this->input->post('total_deductions')),
			'net_proceeds' 						 => str_replace(',', '', $this->input->post('net_proceeds')),
			'col_period_start' 			 	 => $this->input->post('collection_prd_start'),
			'col_period_end' 				 	 => $this->input->post('collection_prd_end'),
			'breakdown_ma_principal' 	 => str_replace(',', '', $this->input->post('bma_principal')),
			'breakdown_ma_interest'  	 => str_replace(',', '', $this->input->post('bma_interest')),
			'breakdown_ma_total' 		 	 => str_replace(',', '', $this->input->post('bma_total')),
			'breakdown_lb_principal' 	 => str_replace(',', '', $this->input->post('blb_principal')),
			'breakdown_lb_interest'  	 => str_replace(',', '', $this->input->post('blb_interest')),
			'breakdown_lb_total' 		 	 => str_replace(',', '', $this->input->post('blb_total')),
			'date_processed' 				 	 => date('Y-m-d', strtotime($this->input->post('date_processed'))),
			// 'posted_date' 					 	 => '',
			// 'balance' 							 	 => $this->input->post('m_id'),
			// 'current_orno' 					 	 => $this->input->post('m_id'),
			// 'prev_loan_computation_id' => $this->input->post('m_id'),
			// 'is_posted' 							 => $this->input->post('m_id'),
			// 'is_deleted' 							 => $this->input->post('m_id'),
			'entry_date' 							 => date('Y-m-d')
		);

		$start    = new DateTime($this->input->post('collection_prd_start'));
		$start->modify('first day of this month');
		$end      = new DateTime($this->input->post('collection_prd_end'));
		$end->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);

		$loan_computation_id = 0;
		$q = false;
		if ($this->input->post('has_update') != '') {
			$dataLoanSchedule = array();
			$currSched = $this->db->get_where('loan_schedule', array('loan_computation_id' => $this->input->post('has_update')))->result();
			$ctr = 0;
			foreach ($period as $dt) {
				array_push($dataLoanSchedule, array(
					'loan_schedule_id'		 => $currSched[$ctr]->loan_schedule_id,
					'loan_computation_id'  => $this->input->post('has_update'),
					'payment_schedule' 		 => $dt->format("Y-m"),
					'monthly_amortization' => $dataLoanComp['breakdown_ma_total'],
					'principal'						 => $dataLoanComp['breakdown_ma_principal'],
					'monthly_interest' 		 => $dataLoanComp['breakdown_ma_interest'],	
					'entry_date'					 => date('Y-m-d')
				));	
				$ctr++;
			}
			$q1 = $this->db->update('loan_computation', $dataLoanComp, array('loan_computation_id' => $this->input->post('has_update')));
			$q2 = $this->db->update_batch('loan_schedule', $dataLoanSchedule, 'loan_schedule_id');
			if ($q1 || $q2) {
				$q = true;
			}
		} else {
			$this->db->insert('loan_computation', $dataLoanComp);
			$loan_computation_id = $this->db->insert_id();
			$dataLoanSchedule = array();
			foreach ($period as $dt) {
				array_push($dataLoanSchedule, array(
					'loan_computation_id'  => $loan_computation_id,
					'payment_schedule' 		 => $dt->format("Y-m"),
					'monthly_amortization' => $dataLoanComp['breakdown_ma_total'],
					'principal'						 => $dataLoanComp['breakdown_ma_principal'],
					'monthly_interest' 		 => $dataLoanComp['breakdown_ma_interest'],
					'entry_date'					 => date('Y-m-d')
				));	
			}
			$q = $this->db->insert_batch('loan_schedule', $dataLoanSchedule);

		}


		$res = array();
		if ($q) {
			$res['param1'] 		 = 'Success!';
			$res['param2'] 		 = 'Applied Loan is Successfully Saved!';
			$res['param3'] 		 = 'success';
			$res['id']         = $loan_computation_id;
		} else {
			$res['param1'] = 'Opps!';
			$res['param2'] = 'Error Encountered Saved';
			$res['param3'] = 'warning';
		}
		echo json_encode($res);
	}

	public function pdfVloanComp(){

	}

	public function edit_member(){
		$members_id 			 		 = $this->input->get('data');
		$params['uploads'] 		 = $this->db->get_where('uploads', array('members_id' => $members_id))->row();
		$params['membersData'] = $this->db->get_where('members', array('members_id' => $members_id))->row();
		$params['civilStatus'] = $this->db->get('civil_status')->result();
		$params['ofcMngmt'] 	 = $this->db->get('office_management')->result();
		$params['memberType']  = $this->db->get('member_type')->result();
		$this->load->view('admin/crud/edit-member', $params);
	}

	public function save_constituent(){
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('civil_status_id', 'Civil Status', 'required');
		$this->form_validation->set_rules('monthly_salary', 'Monthly Salary', 'required');
		$this->form_validation->set_rules('designation', 'Designation', 'required');
		$this->form_validation->set_rules('office_management_id', 'Office', 'required');
		$this->form_validation->set_rules('date_of_effectivity', 'Date of Effectivity', 'required');
		$this->form_validation->set_rules('member_type_id', 'Member', 'required');

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
				$this->db->insert('members', $dataField);
				$errors['members_id'] 	 = $dataField['members_id'];
			}
			
			//last insert id
			
			/**
				For Multiple Forms		
				Save children Table
			*/
			// $dataChildren = array();
			// if (!empty($childrenNFieldData[0])) {
			// 	for ($i=0; $i < count($childrenNFieldData[0]); $i++) { 
			// 		$dataChildren[$i]['lgu_constituent_id'] = ($isForUpdate) ? $updateID : $lguConstituentID;
			// 		$dataChildren[$i]['name'] 							= $childrenNFieldData[0][$i];
			// 		$dataChildren[$i]['birthplace'] 				= $childrenBPFieldData[0][$i];
			// 	}

			// 	if ($isForUpdate) {
			// 		$this->db->delete('children', array('lgu_constituent_id'=>$updateID));
			// 		$this->db->insert_batch('children', $dataChildren);	
			// 	} else {
			// 		$this->db->insert_batch('children', $dataChildren);
			// 	}
			// } else {
			// 	if ($isForUpdate) {
			// 		$this->db->delete('children', array('lgu_constituent_id'=>$updateID));
			// 	}
			// }

		}
		echo json_encode($errors);
	}

	public function showID(){
		$params 						= array();
		$hashedID 					= $this->uri->segment(2);
		$lgu_constituent_id = $this->encdec($hashedID, 'd');
		$res 								= $this->db->get_where('lgu_constituent', array(
			'lgu_constituent_id' => $lgu_constituent_id
		))->row();
		$params['data'] 	  = $res;
		$arrUploads 				= array();
		$resUploads 				= $this->db->get('uploads')->result();
		foreach ($resUploads as $row) {
			$arrUploads[$row->lgu_constituent_id] = $row->image_name;
		}
		$params['dUploads'] = $arrUploads;
		
		$ht 		= $this->load->view('admin/reports/identification', $params, TRUE);
		$this->AdminMod->pdf($ht, 
													'download', 
													'L', 
													false,
													true,
													base_url() . 'assets/image/misc/id-template.png',
													false,
													'Identification',
													'',
													true,
													$hashedID, 
													'A6');
	}

	public function show_multiple_constituent(){
		$hashedID 					= $this->uri->segment(2);
		$dataIDs 						= $this->encdec($hashedID, 'd');
		$params['dataIDs'] 	= $dataIDs;
		$decIDs							= explode('|', $dataIDs);
		$this->db->where_in('lgu_constituent_id', $decIDs);
		$res 								= $this->db->get('lgu_constituent')->result();
		$arrUploads 				= array();
		$resUploads 				= $this->db->get('uploads')->result();
		foreach ($resUploads as $row) {
			$arrUploads[$row->lgu_constituent_id] = $row->image_name;
		}
		$params['dUploads'] = $arrUploads;
		$ht = array();
		foreach ($res as $row) {
			$params['data'] = $row;
			array_push($ht, $this->load->view('admin/reports/identification', $params, TRUE));
		}
		$this->AdminMod->pdf($ht, 
													'download', 
													'L', 
													false, 
													true, 
													base_url() . 'assets/image/misc/id-template.png', 
													false, 
													'Identification', 
													'', 
													true, 
													$hashedID, 
													'A6',
													$decIDs);
	}

	public function upload_const_dp(){
		$config['upload_path'] 		= './assets/image/uploads';
		$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
		$config['max_size']  			= 0; // any size
		$config['remove_spaces']	= true;
		$id 											= $this->input->post('members_id');
		$this->load->library('upload', $config);
		$this->load->library('image_lib');
		if (!$this->upload->do_upload('upload-file-dp')) {
			$data['error']	 = array('error' => $this->upload->display_errors());
			$data['success'] = false;
		} else {
			$dImg = $this->upload->data();

			//resize image to fit
			$configer =  array(
        'image_library'   => 'gd2',
        'source_image'    =>  $dImg['full_path'],
        'maintain_ratio'  =>  TRUE,
        'width'           =>  1200,
        'height'          =>  1200,
        'x_axis'          =>  '0',
        'y_axis'          =>  '0'
      );

      $configer['quality'] = "100%";
			$configer['width'] = 176;
			$configer['height'] = 234;
			$dim = (intval($dImg["image_width"]) / intval($dImg["image_height"])) - ($configer['width'] / $configer['height']);
			$configer['master_dim'] = ($dim > 0)? "height" : "width";

      $this->image_lib->clear();
      $this->image_lib->initialize($configer);
      $this->image_lib->resize();

			$chkExisting    = $this->db->get_where('uploads', array('members_id' => $id))->result();
			if ($chkExisting) {
				$this->db->update('uploads', 
					array(
						'image_name' 			 => $dImg['file_name'],
						'image_path' 			 => $dImg['file_path'],
						'transaction_date' => date('Y-m-d')
					), 
					array('members_id' => $id)
				);
			} else {
				$this->db->insert('uploads', 
					array(
						'members_id' 				 => $id,
						'image_name' 				 => $dImg['file_name'],
						'image_path' 				 => $dImg['file_path'],
						'transaction_date' 	 => date('Y-m-d')
					)
				);	
			}
			$data['file_name'] = $dImg['file_name'];
			$data['success'] = true;
		}
		echo json_encode($data);
	}

	public function show_multiple_ids(){
		$ids 		= implode('|', $this->input->post('ids'));
		$objIDs = $this->encdec($ids, 'e');
		echo json_encode(array('ids' => $objIDs));
	}

	public function fetch_indvl_details(){
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
		header("Content-type: application/json charset=UTF-8");

		$request_body = file_get_contents('php://input');
		$requestData 	= json_decode($request_body);
		
		$hashedID="";
		$token ="";
		if($requestData){
			$hashedID 		= $requestData->q;
			$token 				= $requestData->token;
		}

		$dbTokenHashed			= $this->db->get('access_token')->row()->hashed_key;
		if (password_verify($token, $dbTokenHashed)) {
			
			$lgu_constituent_id = $this->encdec($hashedID, 'd');

			$data 						 	= $this->AdminMod->getConstituentRecord($lgu_constituent_id); 
			$govtID 						= $this->db->select('*')
																					->from('government_card g')
																					->join('card_type c', 'c.card_type_id = g.id_name', 'left')
																					->where('g.lgu_constituent_id', $lgu_constituent_id)
																					->get()
																					->result(); 
			$uploads 		 				= $this->db->get_where('uploads', array('lgu_constituent_id' => $lgu_constituent_id))->row();
			$child 			 				= $this->db->get_where('children', array('lgu_constituent_id' => $lgu_constituent_id))->result();
			$livingStatus 			= $this->db->select('*')
																					->from('constituent_living_status g')
																					->join('living_status c', 'c.living_status_id = g.status_id', 'left')
																					->where('g.lgu_constituent_id', $lgu_constituent_id)
																					->get()
																					->result(); 
			$education 	 				= function($id){ return $this->db->get_where('education', array('education_id' => $id))->row(); };
			$residential 				= function($id){ return $this->db->get_where('residential', array('residential_id' => $id))->row(); };

			$jsonData = array();
			$jsonData['personalInfo'] = array(
				'is_house_owner' => $data[0]->is_house_owner == '1' ? 'Yes' : 'No' 
			);
			if ($uploads && @file_exists('assets/image/uploads/' . $uploads->image_name)){
				$jsonData['personalInfo']['picture'] = base_url('assets/image/uploads/') . $uploads->image_name;
			} else {
				$jsonData['personalInfo']['picture'] = base_url('assets/image/misc/default-user-member-image.png');
			}
			
			foreach ($livingStatus as $row) {
				$jsonData['personalInfo']['living_status'][$row->name] = $row->id;	
			}

			$jsonData['personalInfo']['full_name'] = strtoupper($data[0]->last_name . ', ' . $data[0]->first_name . ' ' . $data[0]->middle_name);
			$jsonData['personalInfo']['nick_name'] = strtoupper($data[0]->other_name);
			$jsonData['personalInfo']['gender'] = strtoupper($data[0]->gender);
			$jsonData['personalInfo']['age'] = strtoupper($data[0]->age);
			$jsonData['personalInfo']['dob'] = date('F j, Y', strtotime($data[0]->dob));
			$jsonData['personalInfo']['citizenship'] = strtoupper($data[0]->citizenship);
			$jsonData['personalInfo']['civil_status'] = strtoupper($data[0]->civil_status);
			$jsonData['personalInfo']['ofc_address'] = strtoupper($data[0]->ofc_address);
			$jsonData['personalInfo']['residential_type'] = strtoupper($residential($data[0]->house_type)->residential_type);

			$jsonData['contactDetails']['residential_address'] = strtoupper($data[0]->residential_address);
			$jsonData['contactDetails']['email'] = strtoupper($data[0]->email);
			$jsonData['contactDetails']['tel_no'] = strtoupper($data[0]->tel_no);
			$jsonData['contactDetails']['mobile'] = strtoupper($data[0]->mobile);
			
			if (!empty($govtID)) {
				foreach ($govtID as $row){
					if ($row->card_name !='') {
						$jsonData['contactDetails']['govt_id'][$row->card_name] = $row->id_number;
					}
				}
			}
			
			$jsonData['familyBackground']['fathers_name'] = strtoupper($data[0]->fathers_name);
			$jsonData['familyBackground']['fathers_birth_place'] = strtoupper($data[0]->fathers_birth_place);
			$jsonData['familyBackground']['mothers_name'] = strtoupper($data[0]->mothers_name);
			$jsonData['familyBackground']['mothers_birth_place'] = strtoupper($data[0]->mothers_birth_place);
			$jsonData['familyBackground']['spouse_name'] = strtoupper($data[0]->spouce_name);
			$jsonData['familyBackground']['spouse_birth_place'] = strtoupper($data[0]->spouce_birth_place);

			if (!empty($child)) {
				foreach ($child as $row){
					if ($row->name!='') {
						$jsonData['familyBackground']['child'][$row->name] = strtoupper($row->birthplace);
					}
				}
			}

			$jsonData['otherInformation']['educational_attainment'] = strtoupper($education($data[0]->highest_educ_attmnt)->education_name);
			$jsonData['otherInformation']['occupation'] = strtoupper($data[0]->occupation);

			$relT = '';
			switch ($data[0]->religion) {
				case '1':
					$relT = 'Catholic';
					break;
				case '2':
					$relT = 'Muslim';
					break;
				default:
					$relT = $data[0]->religion_desc;
					break;
			}

			$jsonData['otherInformation']['religion'] 				 = $relT;
			$jsonData['otherInformation']['height'] 					 = strtoupper($data[0]->height);
			$jsonData['otherInformation']['weight'] 					 = strtoupper($data[0]->weight);
			$jsonData['otherInformation']['identifying_marks'] = strtoupper($data[0]->identifying_marks);
			
			echo json_encode($jsonData, JSON_PRETTY_PRINT);

		} else {
			header("HTTP\ 1.0 401 Unauthorized");
			echo "You are not authorized.";
		}
	}

	public function deleteMember(){
		$members_id = $this->input->post('id');
		$this->db->update('members', array('is_deleted' => '1'), array('members_id' => $members_id));
	}

	public function deleteLoanSettings(){
		$loan_settings_id = $this->input->post('id');
		$this->db->update('loan_settings', array('is_deleted' => '1'), array('loan_settings_id' => $loan_settings_id));
	}

}
