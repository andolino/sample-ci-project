<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Admin extends MY_Controller {

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
	
	public function forgot_password(){
		$this->load->view('admin/forgot-password');
	}
	
	public function entry_new_password(){
		$un     = $this->uri->segment(2);
		$dec_un = $this->encdec($un, 'd');
		$q 			= $this->db->get_where('users', array('username' => $dec_un))->row();
		if ($q) {
			if (strtotime("-30 minutes") > $q->fp_time) {
				$params['fp_expired'] = 'Request is expired';
				$this->load->view('admin/forgot-password', $params);
			} else {
				$params['username'] = $dec_un;
				$this->load->view('admin/entry-new-password', $params);
			}
		} else {
			$this->load->view('admin/login');
		}
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
			$q 				= $this->db->get_where('users', array('username' => $username, 'is_deleted' => '0'));
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
	
	public function proceed_fg_pw(){
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$errors 				 = array();
		if ($this->form_validation->run() == FALSE) {
			$errors 			 = $this->form_validation->error_array();
			$errors['msg'] = 'failed';
		} else {
			$email  			 = $this->input->post('email');
			$q 		  			 = $this->db->get_where('users', array('email' => $email, 'is_deleted' => '0'));
			if (!empty($q->row())) {
				$data 			 = $q->row();
				$found 			 = 'success';
				$encUname 	 = $this->encdec($data->username, 'e');

				// $from    		 = "manage_account@cpfi-webapp.com";
				$from    		 = "no-reply@cpfi-webapp.com";
				$to    	 		 = strtolower($data->email);
				$title    	 = "CPFI | Forgot Password";
				$subject  	 = "Forgot Password";
				$message     = "Dear ".strtoupper($data->screen_name).", <br><br> Your password has been reset. Please provide a new password by clicking on this link within the next 30 minutes: <a href=".base_url().'entry-new-password/'.$encUname.">Click here</a> <br><br> Thank you!";
				$this->sendEmail($from, $to, $subject, $message, $title);
				$this->db->update('users', array('fp_time' => time()), array('users_id' => $data->users_id));
			} else {
				$found 			 = 'failed';
			}
			$errors['msg'] = $found;
		}
		echo json_encode($errors);
	}

	public function submit_new_password(){
		$this->form_validation->set_rules('new-password', 'New Password', 'required');
		$this->form_validation->set_rules('re-new-password', 'Re-Enter New Password', 'required|matches[new-password]');
		$errors 				 = array();
		if ($this->form_validation->run() == FALSE) {
			$errors 			 = $this->form_validation->error_array();
			$errors['msg'] = 'failed';
		} else {
			$un     = $this->uri->segment(2);
			$username = $this->input->post('username');
			$hashed_pw 	 = password_hash($this->input->post('re-new-password'), PASSWORD_BCRYPT);
			$this->db->update('users', array('password' => $hashed_pw, 'txt_password' => $this->input->post('re-new-password')), array('username' => $username));
			$errors['msg'] = 'success';
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

	public function loanByMember(){
		$params['heading'] 		 			= 'LOAN BY MEMBER';
		$params['membersData'] 			= $this->db->get('v_members')->row();
		$params['loanSettings'] 		= $this->db->get('v_loan_settings')->result();
		$params['loanByMemberPage']	= $this->load->view('admin/crud/v-loans-by-member', $params, TRUE);
		$this->adminContainer('admin/loan-by-member', $params);	
	}
	
	public function loan_request_by_member(){
		$params['heading'] 		 			= 'LOAN BY REQUEST';
		$params['loanByMemberPage']	= $this->load->view('admin/crud/v-loan-request', $params, TRUE);
		$this->adminContainer('admin/loan-by-member', $params);	
	}

	public function loanList(){
		$params['heading'] 		 	= 'LOANS LIST';
		$params['membersData'] 	= $this->db->get_where('v_members')->row();
		$params['loanSettings'] = $this->db->get('v_loan_settings')->result();
		$params['loanList'] 		= $this->load->view('admin/crud/v-loans-list-by-member-id', $params, TRUE);	
		$this->adminContainer('admin/loans-list', $params);	
	}

	public function showBenefitClaim(){
		$this->load->view('admin/crud/benefit-claim-page');	
	}

	public function saveContribution(){
		$rate = $this->db->get('contribution_rate')->row();
		$fieldToSave=array();
		$fieldToSave['members_id']=$this->input->post('members_id');
		$fieldToSave['total']=str_replace(',', '', $this->input->post('total'));
		$fieldToSave['balance']=str_replace(',', '', $this->input->post('balance'));
		$fieldToSave['deduction']=str_replace(',', '', $this->input->post('deduction'));
		$fieldToSave['orno']=$this->input->post('orno');
		$fieldToSave['entry_date']=date('Y-m-d');
		$fieldToSave['status']=$this->input->post('status');
		$fieldToSave['date_applied']=$this->input->post('date_applied');
		$fieldToSave['remarks']=$this->input->post('remarks');
		$fieldToSave['adjusted_amnt']=str_replace(',', '', $this->input->post('adjusted_amnt'));
		if ($this->input->post('has_update')!='') {
			$q=$this->db->update('contributions', $fieldToSave, array('contributions_id' => $this->input->post('has_update')));	
		} else {
			$q=$this->db->insert('contributions', $fieldToSave);
		}
		$res=array();
		if ($q) {
			$res['param1']='Success!';
			$res['param2']='Thank you! successfully contributed!';
			$res['param3']='success';
		} else {
			$res['param1']='Opps!';
			$res['param2']='Error Encountered Saved';
			$res['param3']='warning';
		}
		echo json_encode($res);
	}

	public function saveContributionByType(){
		$office_management_id=$this->input->post('office_management_id');
		$result = $this->db->query("SELECT members_id, date_of_effectivity, monthly_salary FROM members where date_of_effectivity < date_add(now(), interval -1 month) AND office_management_id = $office_management_id")->result();
		$rate = $this->db->get('contribution_rate')->row();
		$data = array();
		foreach ($result as $row) {
			array_push($data, array(
				'members_id'		=> $row->members_id,
				'deduction'			=> (floatval(str_replace(',', '', $row->monthly_salary)) * (((int) $rate->rate)/100)),
				'entry_date'		=>  date('Y-m-d'),
				'date_applied'	=> date('Y-m-d', strtotime($this->input->post('date_applied'))),
				'status'				=> $this->input->post('status'),
				'remarks'				=> $this->input->post('remarks'),
				'orno'					=> $this->input->post('orno')
			));
		}
		if (count($data)>0) {
			$q = $this->db->insert_batch('contributions', $data);
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
		} else {
			$res['param1'] = 'Oops!';
			$res['param2'] = 'There is no member for this office!';
			$res['param3'] = 'danger';
		}

		echo json_encode($res);
	}
	
	public function saveLoanPaymentsByType(){
		$office_management_id = $this->input->post('office_management_id');
		$date_applied 				= date('Y-m', strtotime($this->input->post('date_applied')));
		$date_paid 						= date('Y-m-d', strtotime($this->input->post('date_applied')));
		$sched_data 					= $this->db->query("SELECT ls.* from members m 
																								LEFT JOIN loan_computation lc ON lc.members_id = m.members_id
																								LEFT JOIN loan_schedule ls ON ls.loan_computation_id = lc.loan_computation_id
																								WHERE m.office_management_id = $office_management_id 
																								AND ls.payment_schedule = '$date_applied' 
																								AND ls.loan_schedule_id NOT IN (SELECT lr.loan_schedule_id from loan_receipt lr)")->result();
		// $rate 								= $this->db->get('contribution_rate')->row();
		
		$dataSaveLoanReceipt = array();
		foreach ($sched_data as $row) {
			array_push($dataSaveLoanReceipt, array(
				'loan_schedule_id'	=> $row->loan_schedule_id,
				'amnt_paid' 				=> $row->principal,
				'interest_paid'			=> $row->monthly_interest,
				'date_paid'					=> $date_paid
			));
		}

		if (count($dataSaveLoanReceipt)>0) {
			$q = $this->db->insert_batch('loan_receipt', $dataSaveLoanReceipt);
			$res = array();
			if ($q) {
				$res['param1'] = 'Success!';
				$res['param2'] = 'Payment Saved!';
				$res['param3'] = 'success';
			} else {
				$res['param1'] = 'Opps!';
				$res['param2'] = 'Error Encountered Saved';
				$res['param3'] = 'warning';
			}
		} else {
			$res['param1'] = 'Oops!';
			$res['param2'] = 'Sorry.. There is no pending payment on this schedule..';
			$res['param3'] = 'danger';
		}
		echo json_encode($res);
	}

	public function getLastdateApCont(){
		$maxDate = $this->db->query("SELECT max(date_applied) as date_applied from contributions")->row();
		echo json_encode(array('data'=>$maxDate->date_applied));
	}

	public function getLastdateApCashGift(){
		$maxDate = $this->db->query("SELECT max(date_applied) as date_applied from cash_gift")->row();
		echo json_encode(array('data'=>$maxDate->date_applied));
	}

	public function frmAddContribution(){
		$id=$this->input->post('id');
		$params['has_update']=$this->input->post('c_id');
		$params['contributionData']=$this->db->get_where('contributions', array('contributions_id'=>$this->input->post('c_id')))->row();
		$params['membersData'] = $this->db->get_where('v_members', array('members_id'=>$id))->row();
		$this->load->view('admin/crud/frm-add-contribution', $params);	
	}

	public function frmAddContributionByType(){
		$params['officeManagement']	= $this->db->get_where('office_management')->result();
		$params['membersData'] 		 	= $this->db->get_where('v_members')->result();
		$this->load->view('admin/crud/frm-add-contribution-by-type', $params);	
	}
	
	public function frmAddLoanPaymentsByType(){
		$params['officeManagement']	= $this->db->get_where('office_management')->result();
		$params['membersData'] 		 	= $this->db->get_where('v_members')->result();
		$this->load->view('admin/crud/frm-add-loan-payments-by-type', $params);	
	}

	public function viewClaimBenefit(){	
		$params['heading'] 			 = 'BENEFIT CLAIMS';
		$params['benefitClaims'] = $this->load->view('admin/crud/benefit-claim-page', $params, TRUE);	
		$this->adminContainer('admin/benefit-claims', $params);	
	}

	public function viewGeneralJournal(){	
		$params['heading'] 			 = 'GENERAL JOURNAL';
		$params['generalJournal'] = $this->load->view('admin/accounting/general-journal-page', $params, TRUE);	
		$this->adminContainer('admin/gj-transaction', $params);	
	}

	public function viewCheckDisbursement(){	
		$params['heading'] 			 = 'CHECK DISBURSEMENT';
		$params['checkDisbursement'] = $this->load->view('admin/accounting/check-disbursement-page', $params, TRUE);	
		$this->adminContainer('admin/cdj-transaction', $params);	
	}

	public function viewCashReceiptJournal(){	
		$params['heading'] 			 = 'CASH RECEIPT JOURNAL';
		$params['cashReceipt'] = $this->load->view('admin/accounting/cash-receipt-journal-page', $params, TRUE);	
		$this->adminContainer('admin/crj-transaction', $params);	
	}

	public function viewPacsTransaction(){	
		$params['heading'] 			 = 'PACS';
		$params['pacsTransaction'] = $this->load->view('admin/accounting/pacs-page', $params, TRUE);	
		$this->adminContainer('admin/pacs-transaction', $params);	
	}

	public function viewPostedCheckDisbursement(){
		$params['heading'] 			 = 'POSTED CHECK DISBURSEMENT';
		$params['checkDisbursement'] = $this->load->view('admin/accounting/posted-check-disbursement-page', $params, TRUE);	
		$this->adminContainer('admin/cdj-transaction', $params);	
	}

	public function viewPostedCashReceiptJournal(){	
		$params['heading'] 	= 'POSTED CASH RECEIPT JOURNAL';
		$params['checkDisbursement'] = $this->load->view('admin/accounting/posted-cash-receipt-journal-page', $params, TRUE);	
		$this->adminContainer('admin/cdj-transaction', $params);	
	}

	public function viewPostedGeneralJournal(){	
		$params['heading'] 			 = 'POSTED JOURNAL';
		$params['generalJournal'] = $this->load->view('admin/accounting/posted-general-journal-page', $params, TRUE);	
		$this->adminContainer('admin/gj-transaction', $params);	
	}

	public function getCashGift(){	
		$params['heading'] 			 = 'CASH GIFT';
		$params['cashGift'] = $this->load->view('admin/crud/cash-gift-page', $params, TRUE);	
		$this->adminContainer('admin/cash-gift', $params);	
	}

	public function officialReceipt(){	
		$params['heading'] 			 = 'OFFICIAL RECEIPT';
		$params['officialReceipt'] = $this->load->view('admin/crud/official-receipt-page', $params, TRUE);	
		$this->adminContainer('admin/official-receipt', $params);
	}

	public function viewPostedPacs(){	
		$params['heading'] 			 = 'POSTED PACS';
		$params['pacsTransaction'] = $this->load->view('admin/accounting/posted-pacs-page', $params, TRUE);	
		$this->adminContainer('admin/pacs-transaction', $params);	

	}
	public function viewGeneralLedger(){	
		$params['heading'] 			 = 'GENERAL LEDGER';
		$params['generalLedger'] = $this->load->view('admin/accounting/general-ledger-page', $params, TRUE);	
		$this->adminContainer('admin/general-ledger', $params);	
	}

	public function viewTrialBalance(){	
		$params['heading'] 			= 'TRIAL BALANCE';
		$sd											=	date('Y-m-01');
		$ed											=	date('Y-m-t');
		$params['data']					= $this->AdminMod->getTrialBalance($sd, $ed);
		$params['trialBalance'] = $this->load->view('admin/accounting/trial-balance-page', $params, TRUE);	
		$this->adminContainer('admin/trial-balance', $params);	
	}

	public function viewBalanceSheet(){	
		$params['heading'] 			= 'BALANCE SHEET';
		$sd											=	date('Y-m-01');
		$ed											=	date('Y-m-t');
		$params['assets']					= $this->AdminMod->getBsAssets($sd, $ed);
		$params['liabilities']					= $this->AdminMod->getBsLiabilities($sd, $ed);
		$params['balanceSheet'] = $this->load->view('admin/accounting/balance-sheet-page', $params, TRUE);	
		$this->adminContainer('admin/balance-sheet', $params);	
	}

	public function viewIncomeStatement(){	
		$params['heading'] 			= 'INCOME STATEMENT';
		$sd											=	date('Y-m-01');
		$ed											=	date('Y-m-t');
		$params['income_expense']					= $this->AdminMod->getIsIncomeExpense($sd, $ed);
		$params['incomeStatement'] = $this->load->view('admin/accounting/income-statement-page', $params, TRUE);	
		$this->adminContainer('admin/income-statement', $params);	
	}

	public function searchTrialBalance(){
		$sd=$this->input->post('sd');
		$ed=$this->input->post('ed');
		$params['data']					= $this->AdminMod->getTrialBalance($sd, $ed);
		$this->load->view('admin/accounting/search-trial-balance', $params);	
	}

	public function tblGjPage(){	
		$params['heading'] 			 = 'GENERAL JOURNAL';
		$this->load->view('admin/accounting/general-journal-page', $params);	
	}	

	public function tblCrjPage(){	
		$params['heading'] 			 = 'CASH RECEIPT JOURNAL';
		$this->load->view('admin/accounting/cash-receipt-journal-page', $params);	
	}

	public function tblCdjPage(){	
		$params['heading'] 			 = 'CHECK DISBURSEMENT';
		$this->load->view('admin/accounting/check-disbursement-page', $params);	
	}

	public function tblPacsPage(){	
		$params['heading'] 			 = 'PACS';
		$this->load->view('admin/accounting/pacs-page', $params);	
	}

	public function process_benefit_claim(){
		$members_id 	  	 			= $this->input->get('data');
		$params['data'] 	 			= $this->AdminMod->getMembersRecord($members_id);
		$params['claimBenefit'] = $this->db->order_by('claim_all','desc')->join('benefit_type', 'benefit_type.benefit_type_id = claim_benefit.benefit_type_id', 'left')->get_where('claim_benefit', array('members_id' => $members_id))->result();
		$params['benefit_type'] = $this->db->get_where('benefit_type', array('is_deleted' => 0))->result();
		$params['balance']			= $this->db->get_where('v_balance', array('members_id'=>$members_id))->result();
		$this->load->view('admin/crud/process-benefit-claim', $params);
	}

	public function view_settings_page(){
		$params['heading'] = 'SETTINGS';
		$this->load->view('admin/crud/setting-page', $params);	
	}

	public function view_chart_of_accounts(){
		$params['coaData'] = $this->db->order_by('1, 2')->get_where('v_acct_chart', array('is_deleted' => 0))->result();
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

	public function getFrmBenefitClaim(){
		$is_multi_claim=$this->input->post('multi_claim');
		$m_id=$this->input->post('m_id');
		$benefitType=$this->db->get_where('benefit_type', array('benefit_type_id' => $is_multi_claim))->row();
		$params['data']=$this->AdminMod->getMembersRecord($m_id);
		$params['balance']=$this->db->get_where('v_balance', array('members_id'=>$m_id))->result();
		$params['accumContribution']=$this->db->select('sum(coalesce(deduction,0)) - sum(coalesce(balance,0)) as total')
																->from('contributions')
																->where('members_id', $m_id)->get()->row();
		$params['benefitType'] = $benefitType;

		if ($this->input->post('claimed_id')) {
			$params['claimedData'] = $this->db->get_where('claim_benefit', array('claimed_benefit_id'=>$this->input->post('claimed_id')))->row();
		}

		if ($benefitType->multi_claim == 0) {
			$this->load->view('admin/crud/not-multi-claim', $params);
		} else {
			$params['benefitSettings']=$this->db->get('benefit_settings')->row();
			$params['prevClaimedBenefit']=$this->db->get_where('v_benefit_claimed_by_member', array('members_id'=>$m_id, 'is_deleted' => 0,'claim_all'=>0))->result();
			$this->load->view('admin/crud/multi-claim', $params);
		}
	}

	public function show_add_loans(){
		$id = $this->input->get('id');
		if ($id) {
			$params['loanSettingsData'] = $this->db->get_where('loan_settings', array('loan_settings_id' => $id, 'is_deleted' => 0))->row();	
		}
		$params['loanCode'] = $this->db->get_where('loan_code', array('is_deleted' => 0))->result();
		$this->load->view('admin/crud/frm-add-loans', $params);
	}

	public function show_add_cash_gift(){
		$id 									 = $this->input->get('id');
		$params['data'] 			 = $this->db->get_where('cash_gift', array('cash_gift_id'=>$id))->row();
		$params['membersData'] = $this->db->get('members')->result();
		$params['officeManagement'] 		 = $this->db->query("SELECT om.*, d.contribution_rate, d.cash_gift_rate FROM office_management om left join departments d on d.departments_id = om.departments_id")->result();
		$this->load->view('admin/crud/add-cash-gift', $params);
	}

	public function show_add_cash_gift_per_region(){
		$id 									 = $this->input->get('id');
		$params['data'] 			 = $this->db->get_where('cash_gift', array('cash_gift_id'=>$id))->row();
		$params['officeManagement'] 		 = $this->db->query("SELECT DISTINCT d.departments_id, d.region, d.contribution_rate, d.cash_gift_rate FROM office_management om left join departments d on d.departments_id = om.departments_id")->result();
		$this->load->view('admin/crud/add-cash-gift-per-region', $params);
	}

	public function show_official_receipt(){
		$id 									 = $this->input->get('id');
		$params['region'] 		 = $this->db->get("departments")->result();
		$params['officialReceipt'] 		 = $this->db->get_where("official_receipt", array('official_receipt_id' => $id))->row();
		$this->load->view('admin/crud/add-official-receipt', $params);
	}

	public function computeOthBenefit(){
		$percent=$this->input->post('percent');
		$loanSettings=$this->db->get('benefit_settings')->row();
		$data['sickness']=number_format($loanSettings->sickness * ($percent/100),2);
		$data['doif']=number_format($loanSettings->doif * ($percent/100),2);
		$data['accident']=number_format($loanSettings->accident * ($percent/100),2);
		$data['calamity']=number_format($loanSettings->calamity * ($percent/100),2);
		echo json_encode($data);
		
	}

	public function saveBenefitClaim(){
		$benefitType 							 		 = $this->db->get_where('benefit_type', array('benefit_type_id'=>$this->input->post('benefit_type')))->row();
		$data 										 		 = [];
		$data['members_id']    		 		 = $this->input->post('members_id');
		$data['benefit_type_id']   		 = $this->input->post('benefit_type');
		$data['claim_date'] 			 		 = $this->input->post('claim_date');
		$data['accum_contrib']     		 = str_replace(',', '', $this->input->post('accum_mem_cont'));
		$data['share'] 						 		 = str_replace(',', '', $this->input->post('share'));
		$data['tot_share_contrib'] 		 = str_replace(',', '', $this->input->post('total_contrib'));
		$data['other_benefit']     		 = str_replace(',', '', $this->input->post('other_benefit'));
		$data['clmd_sickness'] 		 		 = str_replace(',', '', $this->input->post('sickness'));
		$data['clmd_dif'] 				 		 = str_replace(',', '', $this->input->post('doif'));
		$data['clmd_accident'] 		 		 = str_replace(',', '', $this->input->post('accident')); 
		$data['clmd_calamity'] 		 		 = str_replace(',', '', $this->input->post('calamity'));
		$data['lri_from_loan_balance'] = $this->input->post('lri_from_loan_balance');
		$data['total_claim'] 			 		 = $this->input->post('amnt_claim') ? str_replace(',', '', $this->input->post('amnt_claim')) 
																																			: str_replace(',', '', $this->input->post('total_claim'));
		$data['claim_all'] 				 		 = $benefitType->multi_claim;
		$data['users_id'] 				 		 = $this->session->users_id;
		$data['entry_date'] 			 		 = date('Y-m-d');

		if ($benefitType->multi_claim == 1) {
			$this->db->update('members', array('retired_date' => date('Y-m-d', strtotime($this->input->post('claim_date'))),
																					'benefit_type' => $benefitType->benefit_type_id), 
																		array('members_id'=>$this->input->post('members_id')));	
		}
		if ($this->input->post('has_update')!='') {
			$q = $this->db->update('claim_benefit',	$data, array('claimed_benefit_id'=>$this->input->post('has_update')));	
		}	else {
			$q = $this->db->insert('claim_benefit',	$data);
		}
		
			
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
	}

	public function show_schedule_list(){
		$loan_computation_id = $this->input->get('id');
		$params['loanSched'] = $this->db->query("SELECT * FROM v_loan_sched_choices 
																							WHERE loan_computation_id = $loan_computation_id
																							AND (coalesce(monthly_amortization,0) - coalesce(amnt_paid,0)) > 0")->result();
		$this->load->view('admin/crud/tbl-select-payment-sched', $params);
	}
	
	public function show_edit_payment_list(){
		$loan_computation_id = $this->input->get('id');
		$params['loanSched'] = $this->db->query("SELECT
																								lr.orno,
																								lr.loan_receipt_id,
																								ls.payment_schedule,
																								ls.principal,
																								ls.monthly_interest,
																								lr.amnt_paid,
																								lr.interest_paid,
																								lr.date_paid
																						from cpfidb.loan_receipt lr
																						left join cpfidb.loan_schedule ls on lr.loan_schedule_id = ls.loan_schedule_id
																						where ls.loan_computation_id = $loan_computation_id
																						order by ls.payment_schedule")->result();
		$this->load->view('admin/crud/tbl-select-edit-payments', $params);
	}

	public function save_update_payments(){
		$orno = $this->input->post('orno');
		$amnt_paid = $this->input->post('amnt_paid');
		$interest_paid = $this->input->post('interest_paid');
		$lr_id = explode(',', $this->input->post('lr_id'));
		$dataToSave = array();
		if (is_array($orno)) {
			for ($i=0; $i < count($orno); $i++) { 
				array_push($dataToSave, array(
					'orno'            => $orno[$i],
					'loan_receipt_id' => $lr_id[$i],
					'amnt_paid' 			=> str_replace(',', '', $amnt_paid[$i]),
					'interest_paid' 	=> str_replace(',', '', $interest_paid[$i])
				));
			}
		}
		$q = $this->db->update_batch('loan_receipt', $dataToSave, 'loan_receipt_id');
		$res = array();
		if ($q) {
			$res['param1'] = 'Success!';
			$res['param2'] = 'Thank you! your payment is updated!';
			$res['param3'] = 'success';
		} else {
			$res['param1'] = 'Opps!';
			$res['param2'] = 'Error Encountered Saved';
			$res['param3'] = 'warning';
		}
		echo json_encode($res);
	}

	public function getOtherBenefitForm(){
		$m_id=$this->input->post('m_id');
		$params['prevClaimedBenefit']=$this->db->get_where('v_benefit_claimed_by_member', array('members_id'=>$m_id, 'is_deleted' => 0,'claim_all'=>0))->result();
		$this->load->view('admin/crud/other-benefit-form', $params);
	}

	public function show_add_payments(){
		$loan_computation_id           = $this->input->get('id');
		$params['loan_computation_id'] = $loan_computation_id;
		// if ($id) {
		// 	$params['loanSettingsData'] = $this->db->get_where('loan_settings', array('loan_settings_id' => $id))->row();	
		// }
		$this->load->view('admin/crud/frm-add-payments', $params);
	}
	
	public function show_loan_request_attachments(){
		$loan_request_id           = $this->input->get('id');
		$params['attachments'] = $this->db->get_where('portal_uploads', array('loan_request_id' => $loan_request_id))->result();	
		$this->load->view('admin/crud/show-loan-req-attachments', $params);
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
		$params['acctGroups'] = $this->db->get_where('account_groups', array('is_deleted' => 0))->result();
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

	public function getCgAmntPerMember(){
		$members_id = $this->input->post('m_id');
		$mData 			= $this->db->query("SELECT m.*, d.cash_gift_rate, d.contribution_rate FROM members m
																		LEFT JOIN office_management om ON om.office_management_id = m.office_management_id
																		LEFT JOIN departments d ON d.departments_id = om.departments_id WHERE m.members_id = '$members_id'")->row();
		// $cgRate 		= $this->db->get('contribution_rate')->row();
		if(strtotime($mData->date_of_effectivity) < strtotime('-1 year')){
			$amnt 		= floatval(str_replace(',', '', $mData->monthly_salary)) * (floatval(str_replace(',', '', $mData->cash_gift_rate))/100);
		} else {
			$amnt 		= 0;
		}
		echo json_encode(array(
											'amnt'=>str_replace(', ', '', $amnt)
										));
	}

	public function getCgAmntPerRegion(){
		$departments_id = $this->input->post('departments_id');
		$date_applied = $this->input->post('date_applied');
		$remarks = $this->input->post('remarks');
		$officeManagement = $this->db->get_where('office_management', array('departments_id' => $departments_id))->result();
		$membersOfficeID=array();
		foreach ($officeManagement as $row) {
			array_push($membersOfficeID, $row->office_management_id);
		}

		$mData 			= $this->db->query("SELECT m.*, sum(c.deduction) as tot_contribution, d.cash_gift_rate, d.contribution_rate FROM members m
																		LEFT JOIN office_management om ON om.office_management_id = m.office_management_id
																		LEFT JOIN departments d ON d.departments_id = om.departments_id 
																		LEFT JOIN contributions c on c.members_id =  m.members_id
																		WHERE m.office_management_id IN (".implode(',', $membersOfficeID).") group by m.members_id")->result();
		if (!$mData) {
			$res['param1'] = 'Opps!';
			$res['param2'] = 'This region has no members';
			$res['param3'] = 'danger';
		} else {
			$cgData = array();
			foreach ($mData as $row) {
				array_push($cgData, array(
					'members_id'=>$row->members_id,
					'amount'=>floatval(str_replace(',', '', $row->tot_contribution))*(floatval(str_replace(',', '', $row->cash_gift_rate))/100),
					'rate'=>floatval(str_replace(',', '', $row->cash_gift_rate)),
					'date_applied'=>date('Y-m-d', strtotime($date_applied)),
					'entry_date'=>date('Y-m-d'),
					'remarks'=>$remarks,
					'tot_contribution'=>$row->tot_contribution
				));
			}
			
			$res = array();
			$maxDate = $this->db->query("SELECT max(cg.date_applied) AS date_applied 
																		FROM cash_gift cg 
																		LEFT JOIN members m on m.members_id = cg.members_id 
																		LEFT JOIN office_management om ON om.office_management_id = m.office_management_id 
																		LEFT JOIN departments d ON d.departments_id = om.departments_id WHERE d.departments_id = $departments_id")->row();
			

			if (strtotime($date_applied) < strtotime($maxDate->date_applied)) {
				$res['param1'] = 'Opps!';
				$res['param2'] = 'Invalid Date please input more than ' . date('F Y', strtotime($maxDate->date_applied));
				$res['param3'] = 'danger';
			} else {
				$q = $this->db->insert_batch('cash_gift', $cgData);
				if ($q) {
					$res['param1'] = 'Success!';
					$res['param2'] = 'Cash Gift Successfully Generated!';
					$res['param3'] = 'success';
				} else {
					$res['param1'] = 'Opps!';
					$res['param2'] = 'Error Encountered Saved';
					$res['param3'] = 'warning';
				}

			}
		}
		
		echo json_encode($res);
		// // $cgRate 		= $this->db->get('contribution_rate')->row();
		// if(strtotime($mData->date_of_effectivity) < strtotime('-1 year')){
		// 	$amnt 		= floatval(str_replace(',', '', $mData->monthly_salary)) * (floatval(str_replace(',', '', $mData->cash_gift_rate))/100);
		// } else {
		// 	$amnt 		= 0;
		// }
		// echo json_encode(array(
		// 									'amnt'=>str_replace(', ', '', $amnt)
		// 								));
	}

	public function save_cash_gift(){
		// str_pad($value, 8, '0', STR_PAD_LEFT);
		$data = array(
			'members_id' => $this->input->post('members_id'),
			'amount'  				=> str_replace(',', '', $this->input->post('amount')),
			'date_applied' 		=> date('Y-m-d', strtotime($this->input->post('date_applied'))),
			'entry_date' 			=> date('Y-m-d'),
			'remarks'	 				=> $this->input->post('remarks')
		);
		if ($this->input->post('has_update'))
			$q = $this->db->update('cash_gift',	$data, array('cash_gift_id' =>  $this->input->post('has_update')));
		else
			$q = $this->db->insert('cash_gift',	$data);
		
		
		$res = array();
		if ($q) {
			$res['param1'] = 'Success!';
			$res['param2'] = 'Cash Gift Successfully Added!';
			$res['param3'] = 'success';
		} else {
			$res['param1'] = 'Opps!';
			$res['param2'] = 'Error Encountered Saved';
			$res['param3'] = 'warning';
		}
		echo json_encode($res);
		// print_r($_POST);
	}

	public function saveOfficialReceipt(){
		// str_pad($value, 8, '0', STR_PAD_LEFT);
		$data = array(
			'departments_id'  			=> $this->input->post('departments_id'),
			'orno'  								=> $this->input->post('orno'),
			'date_applied'  				=> date('Y-m-d', strtotime($this->input->post('date_applied'))),
			'address' 							=> $this->input->post('address'),
			'senior_citizen_tin' 		=> $this->input->post('senior_citizen_tin'),
			'osca_pwd_citizen_tin' 	=> $this->input->post('osca_pwd_citizen_tin'),
			'contribution' 					=> str_replace(',', '', $this->input->post('contribution')),
			'gpln' 									=> str_replace(',', '', $this->input->post('gpln')),
			'emln' 									=> str_replace(',', '', $this->input->post('emln')),
			'slmv' 									=> str_replace(',', '', $this->input->post('slmv')),
			'others' 								=> str_replace(',', '', $this->input->post('others')),
			'remarks' 							=> $this->input->post('remarks'),
			'amount_type' 					=> $this->input->post('amount_type'),
			'entry_date' 						=> date('Y-m-d'),
			'remarks'	 							=> $this->input->post('remarks'),
			'business_style'				=> $this->input->post('business_style'),
			'sc_pw_discount'				=> str_replace(',', '', $this->input->post('sc_pw_discount')),
			'total_due'							=> str_replace(',', '', $this->input->post('total_due')),
			'withholding_tax'				=> str_replace(',', '', $this->input->post('withholding_tax')),
			'payment_due'						=> str_replace(',', '', $this->input->post('payment_due')),
			'total'									=> str_replace(',', '', $this->input->post('total'))
		);
		$id='';
		if ($this->input->post('has_update')) {
			$q = $this->db->update('official_receipt',	$data, array('official_receipt_id' =>  $this->input->post('has_update')));
		} else {
			$q = $this->db->insert('official_receipt',	$data);
			$id = $this->db->insert_id();
		}

		//update orno in contributions every update or insert official receipt
		$orno 	= $this->input->post('orno');
		$ordate = date('Y-m', strtotime($this->input->post('date_applied')));
		$this->db->query("UPDATE contributions SET orno = '$orno' WHERE DATE_FORMAT(date_applied,'%Y-%m') = '$ordate'");

		$res = array();
		if ($q) {
			$res['param1'] = 'Success!';
			$res['param2'] = 'OR Successfully Added!';
			$res['param3'] = 'success';
			$res['param4'] = $id;
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
   		// $data[] = '<input type="checkbox" id="chk-const-list-tbl" value="'.$row->members_id.'" name="chk-const-list-tbl">';
   		$data[] = $row->id_no;
   		$data[] = strtoupper($row->last_name);
   		$data[] = strtoupper($row->first_name);
   		$data[] = strtoupper($row->middle_name);
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
   		 					<a href="javascript:void(0);" id="loadPage" data-placement="top" data-toggle="tooltip" title="Add Contribution" data-link="view-contribution" 
   		 						data-ind="'.$row->members_id.'" data-cls="cont-tbl-contribution" data-badge-head="CONTRIBUTION - '.strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name).'"><i class="fas fa-hand-holding-usd"></i></a> |
   		 					<a href="javascript:void(0);" id="remove-lgu-const-list" data-placement="top" data-toggle="tooltip" title="Remove" data-id="'.$row->members_id.'"><i class="fas fa-trash"></i></a> ';
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


	public function server_tbl_repayments(){
		$result 	= $this->AdminMod->get_output_repayments();
		// $this->output->enable_profiler(true);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name);
   		$data[] = number_format($row->principal, 2);
			$data[] = number_format($row->monthly_interest, 2);
			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->AdminMod->count_all_repayments(),
			'recordsFiltered' => $this->AdminMod->count_filter_repayments(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function server_tbl_contribution(){
		$result 	= $this->Table->getOutput('contributions', 
																					['contributions_id', 'members_id', 'total', 'balance', 'deduction', 'orno', 'date_applied', 'is_deleted', 'entry_date'], 
																					['contributions_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		$viewPage = $this->input->post('page');

		foreach ($result as $row) {
			$membersData = $this->db->get_where('members', array('members_id' => $row->members_id))->row();
			$data = array();
			$no++;
   		$data[] = $membersData->id_no;
   		$data[] = $row->total;
   		$data[] = $row->balance;
   		$data[] = $row->deduction;
   		$data[] = $row->orno;
   		$data[] = date('Y-m-d', strtotime($row->date_applied));
 			$data[] = '<a href="javascript:void(0);" id="add-contribution" data-placement="top" data-cont-id="'.$row->contributions_id.'" data-toggle="tooltip" title="EDIT" data-m-id="'.$row->members_id.'">
   								<i class="fas fa-edit"></i></a>';

			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->Table->countAllTbl(),
			'recordsFiltered' => $this->Table->countFilterTbl(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function server_gj_entry(){
		$result 	= $this->Table->getOutput('j_master', 
																					['j_master_id', 'j_type_id', 'payee_members_id', 'journal_date', 'balance', 'check_voucher_no', 'check_no', 
																						'reference_no', 'payee', 'is_deleted', 'entry_date', 'date_posted'], 
																					['j_master_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		$viewPage = $this->input->post('page');

		foreach ($result as $row) {
			$membersData = $this->db->get_where('members', array('members_id' => $row->payee_members_id))->row();
			$data = array();
			$no++;
   		$data[] = '<input type="checkbox" class="chk-row-input-to-post" value="'.$row->j_master_id.'" id="">';
   		$data[] = $row->journal_date;
   		$data[] = $row->particulars;
   		$data[] = $row->reference_no;
   		$data[] = !empty($membersData) ? strtoupper($membersData->last_name .', '.$membersData->first_name) : $row->payee;
 			$data[] = '<a href="javascript:void(0);" id="loadPage" data-badge-head="EDIT REF No.'.$row->reference_no.'" data-link="add-gj-entry" 
 										data-ind="'.$row->j_master_id.'" data-cls="cont-gj-entry" title="View/Edit"><i class="fas fa-edit"></i></a> '.
 										($row->date_posted==''?'| <a href="javascript:void(0);" id="postAcctgEntry" title="Post" data-id="'.$row->j_master_id.'"><i class="fas fa-paper-plane"></i></a>':'') . ' | <a href="javascript:void(0);" onclick="removeJournal(this)" data-id="'.$row->j_master_id.'"><i class="fa fa-trash"></i></a>';

			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->Table->countAllTbl(),
			'recordsFiltered' => $this->Table->countFilterTbl(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function server_cdj_entry(){
		$result 	= $this->Table->getOutput('j_master', 
																					['j_master_id', 'j_type_id', 'journal_date', 'balance', 'check_voucher_no', 'check_no', 
																						'reference_no', 'payee', 'is_deleted', 'entry_date', 'date_posted'], 
																					['j_master_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		$viewPage = $this->input->post('page');

		foreach ($result as $row) {
			// $membersData = $this->db->get_where('members', array('members_id' => $row->members_id))->row();
			$data = array();
			$no++;
			$data[] = '<input type="checkbox" class="chk-row-input-to-post" value="'.$row->j_master_id.'" id="">';
   		$data[] = $row->journal_date;
   		$data[] = $row->check_voucher_no;
   		$data[] = $row->check_no;
   		$data[] = $row->reference_no;
   		$data[] = $row->payee;
 			$data[] = '<a href="javascript:void(0);" id="loadPage" data-badge-head="EDIT '.$row->check_voucher_no.'" data-link="add-cdj-entry" 
 										data-ind="'.$row->j_master_id.'" data-cls="cont-cdj-entry" title="View/Edit"><i class="fas fa-edit"></i></a> '. 
 								($row->date_posted==''?'| <a href="javascript:void(0);" id="postAcctgEntry" title="Post" data-id="'.$row->j_master_id.'"><i class="fas fa-paper-plane"></i></a>':'') . ' | <a href="javascript:void(0);" onclick="removeJournal(this)" data-id="'.$row->j_master_id.'"><i class="fa fa-trash"></i></a>';

			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->Table->countAllTbl(),
			'recordsFiltered' => $this->Table->countFilterTbl(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function server_crj_entry(){
		$result 	= $this->Table->getOutput('j_master', 
																					['j_master_id', 'j_type_id', 'journal_date', 'balance', 'check_voucher_no', 'check_no', 
																						'reference_no', 'payee', 'is_deleted', 'entry_date', 'date_posted'], 
																					['j_master_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		$viewPage = $this->input->post('page');

		foreach ($result as $row) {
			// $membersData = $this->db->get_where('members', array('members_id' => $row->members_id))->row();
			$data = array();
			$no++;
			$data[] = '<input type="checkbox" class="chk-row-input-to-post" value="'.$row->j_master_id.'" id="">';
   		$data[] = $row->journal_date;
   		$data[] = $row->account_no;
   		$data[] = $row->reference_no;
   		$data[] = $row->payee;
 			$data[] = '<a href="javascript:void(0);" id="loadPage" data-badge-head="EDIT REF No.'.$row->reference_no.'" data-link="add-crj-entry" 
 										data-ind="'.$row->j_master_id.'" data-cls="cont-crj-entry" title="View/Edit"><i class="fas fa-edit"></i></a> '. 
 								($row->date_posted==''?'| <a href="javascript:void(0);" id="postAcctgEntry" title="Post" data-id="'.$row->j_master_id.'"><i class="fas fa-paper-plane"></i></a>':'') . ' | <a href="javascript:void(0);" onclick="removeJournal(this)" data-id="'.$row->j_master_id.'"><i class="fa fa-trash"></i></a>';

			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->Table->countAllTbl(),
			'recordsFiltered' => $this->Table->countFilterTbl(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function server_pacs_entry(){
		$result 	= $this->Table->getOutput('j_master', 
																					['j_master_id', 'j_type_id', 'journal_date', 'balance', 'check_voucher_no', 'check_no', 
																						'reference_no', 'payee', 'is_deleted', 'entry_date', 'date_posted'], 
																					['j_master_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		$viewPage = $this->input->post('page');

		foreach ($result as $row) {
			// $membersData = $this->db->get_where('members', array('members_id' => $row->members_id))->row();
			$data = array();
			$no++;
			$data[] = '<input type="checkbox" class="chk-row-input-to-post" value="'.$row->j_master_id.'" id="">';
   		$data[] = $row->journal_date;
   		$data[] = $row->account_no;
   		$data[] = $row->reference_no;
   		$data[] = $row->payee;
 			$data[] = '<a href="javascript:void(0);" id="loadPage" data-badge-head="EDIT '.$row->check_voucher_no.'" data-link="add-cdj-entry" 
 										data-ind="'.$row->j_master_id.'" data-cls="cont-cdj-entry" title="View/Edit"><i class="fas fa-edit"></i></a> '. 
 								($row->date_posted==''?'| <a href="javascript:void(0);" id="postAcctgEntry" title="Post" data-id="'.$row->j_master_id.'"><i class="fas fa-paper-plane"></i></a>':'') . ' | <a href="javascript:void(0);" onclick="removeJournal(this)" data-id="'.$row->j_master_id.'"><i class="fa fa-trash"></i></a>';

			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->Table->countAllTbl(),
			'recordsFiltered' => $this->Table->countFilterTbl(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function serverGeneralLedger(){
		$result 	= $this->Table->getOutput('v_general_ledger', 
																					['journal_ref', 'particulars', 'debit', 'credit', 'balance', 'date_posted'], 
																					['date_posted' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		$viewPage = $this->input->post('page');

		foreach ($result as $row) {
			// $membersData = $this->db->get_where('members', array('members_id' => $row->members_id))->row();
			$data = array();
			$no++;
   		$data[] = $row->date_posted;
   		$data[] = $row->particulars;
   		$data[] = number_format($row->debit, 2);
   		$data[] = number_format($row->credit, 2);
   		$data[] = number_format($row->balance, 2);

			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->Table->countAllTbl(),
			'recordsFiltered' => $this->Table->countFilterTbl(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function serverCashGift(){
		$result 	= $this->Table->getOutput('v_cash_gift', 
																					['cash_gift_id', 'office_name', 'amount', 'last_name', 'first_name', 'middle_name', 'date_applied', 'date_of_effectivity', 'remarks'], 
																					['date_applied' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		$viewPage = $this->input->post('page');

		foreach ($result as $row) {
			// $membersData = $this->db->get_where('members', array('members_id' => $row->members_id))->row();
			$data = array();
			$no++;
   		$data[] = strtoupper($row->last_name . ',' . $row->first_name . ' ' . $row->middle_name);
   		$data[] = number_format($row->amount, 2);
   		$data[] = $row->office_name;
   		$data[] = date('m/d/Y', strtotime($row->date_applied));
   		$data[] = $row->remarks;
   		$data[] = '<a href="javascript:void(0);" title="Update" id="btn-cash-gift" data-field="UPDATE" data-id="'.$row->cash_gift_id.'"><i class="fas fa-edit"></i></a>';
			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->Table->countAllTbl(),
			'recordsFiltered' => $this->Table->countFilterTbl(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function serverOfficialReceipt(){
		$result 	= $this->Table->getOutput('v_official_receipt', 
																					['official_receipt_id', 'region', 'orno', 'contribution', 'gpln', 'emln', 'slmv', 'others', 'date_applied', 'amount_type', 'total'], 
																					['date_applied' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		$viewPage = $this->input->post('page');

		foreach ($result as $row) {
			// $membersData = $this->db->get_where('members', array('members_id' => $row->members_id))->row();
			$data = array();
			$no++;
   		$data[] = strtoupper($row->region);
   		$data[] = $row->orno;
   		$data[] = number_format(floatval(str_replace(',', '', $row->total)));
   		$data[] = date('m/d/Y', strtotime($row->date_applied));
   		if ($row->amount_type == 1) {
   			$data[] = 'Cash';
   		} elseif($row->amount_type == 2){
   			$data[] = 'Check';
   		} else{
   			$data[] = 'Bank';
   		}
   		$data[] = '<a href="javascript:void(0);" title="Update" id="btn-or-per-region" data-field="UPDATE" data-id="'.$row->official_receipt_id.'"><i class="fas fa-edit"></i></a> | 
   							<a href="javascript:void(0);" title="Print" onclick="window.open(' . "'" . base_url('print-official-receipt/'.$row->official_receipt_id) . "'" . ')" data-id="'.$row->official_receipt_id.'"><i class="fas fa-print"></i></a> | 
   							<a href="javascript:void(0);" title="Remove" onclick="removeData(this)" data-tbl="official_receipt" data-field="official_receipt_id" data-id="'.$row->official_receipt_id.'"><i class="fas fa-trash"></i></a>';
			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->Table->countAllTbl(),
			'recordsFiltered' => $this->Table->countFilterTbl(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function showChooseDatePost(){
		$id=$this->input->post('id');
		if (is_array($id)) {
			$params['id']=implode(',', $this->input->post('id'));
		} else {
			$params['id']=$this->input->post('id');
		}
		$this->load->view('admin/accounting/choose-date-posted', $params);
	}

	public function showChooseRegionType(){
		$this->load->view('admin/accounting/choose-region-type');
	}

	public function postAcctEntry(){
		$date = $this->input->post('date');
		$id 	= explode(',', $this->input->post('id'));
		$q=false;
		for ($i=0; $i < count($id); $i++) { 
			$q=$this->db->update('j_master',array('date_posted'=>date('Y-m-d', strtotime($date))), array('j_master_id'=>$id[$i]));
		}
		if ($q) {
			$res['param1'] 		 = 'Success!';
			$res['param2'] 		 = 'Entry is Posted!';
			$res['param3'] 		 = 'success';
		} else {
			$res['param1']     = 'Opps!';
			$res['param2']     = 'Error Encountered in Posting';
			$res['param3']     = 'warning';
		}
		echo json_encode($res);
	}

	public function server_benefit_claim_by_member(){	
		$this->db->where('members_id', $this->input->post('members_id'));
		$result 	= $this->Table->getOutput('v_benefit_claimed_by_member', 
																				['claimed_benefit_id', 'members_id', 'type_of_benefit', 'name', 'total_claim', 'claim_date', 'claim_all', 'retired_date', 'is_deleted', 'entry_date'], 
																				['claimed_benefit_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->type_of_benefit;
   		$data[] = strtoupper($row->name);
   		$data[] = number_format($row->total_claim, 2);
   		$data[] = date('Y-m-d', strtotime($row->claim_date));
   		$control_btn = ['<a href="javascript:void(0);" 
											class="font-12" id="loadPage" 
											data-link="process-claim-benefit" 
											data-ind="'.$row->members_id.'" 
											data-badge-head="BENEFIT CLAIM - '.strtoupper($row->name).'" 
											data-cls="cont-process-benefit-claim-by-member" data-placement="top" data-toggle="tooltip" title="View"
											data-id="'.$row->members_id.'"><i class="fas fa-search"></i></a>',
											'<a href="javascript:void(0);" 
													id="removeClaim" 	
													data-id="'.$row->claimed_benefit_id.'" 
													data-claim-all="'.$row->claim_all.'" 
													data-member-id="'.$row->members_id.'"
													class="font-12" 
													data-placement="left" 
													data-toggle="tooltip" 
													title="'.($row->claim_all==1?'Remove':'Remove').'"><i class="fas fa-trash"></i></a>',
											'<a href="javascript:void(0);" 
													id="editClaim" 	
													data-id="'.$row->claimed_benefit_id.'" 
													data-claim-date="'.$row->claim_date.'" 
													data-benefit-id="'.$row->benefit_type_id.'"
													data-member-id="'.$row->members_id.'"
													class="font-12" 
													data-placement="left" 
													data-toggle="tooltip" 
													title="Edit"><i class="fas fa-edit"></i></a>'];
			if ($row->retired_date !== null && $row->claim_all == 0) {
				$data[] = $control_btn[0];
			} else {
				$data[] = $control_btn[0] . ' | ' . $control_btn[2] . ' | ' . $control_btn[1];
			}	
			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->Table->countAllTbl(),
			'recordsFiltered' => $this->Table->countFilterTbl(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function removeBenefitClaim(){
		$id 			 = $this->input->post('id');
		$claim_all = $this->input->post('claim_all');
		$members_id = $this->input->post('members_id');
		if ($claim_all == 1) {
			$this->db->update('members', array('retired_date'=>null,'benefit_type'=>null), array('members_id'=>$members_id));
			$q=$this->db->delete('claim_benefit', array('claimed_benefit_id' => $id));	
		} else {
			$q=$this->db->delete('claim_benefit', array('claimed_benefit_id' => $id));	
		}
		if ($q) {
			$res['param1'] 		 = 'Success!';
			$res['param2'] 		 = 'Claimed is Deleted!';
			$res['param3'] 		 = 'success';
		} else {
			$res['param1']     = 'Opps!';
			$res['param2']     = 'Error Encountered Saved';
			$res['param3']     = 'warning';
		}
		echo json_encode($res);
	}

	public function server_tbl_claim_benefit_members(){
		$result 	= $this->AdminMod->get_output_members();
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		$viewPage = $this->input->post('page');

		foreach ($result as $row) {
			$hashed_id = $this->encdec($row->members_id, 'e');
			$data = array();
			$no++;	
   		$data[] = strtoupper($row->last_name . ', ' . $row->first_name. ' '.$row->middle_name);
			$data[] = date('Y-m-d', strtotime($row->date_of_effectivity));
			if ($row->retired_date != '') {
				$data[] = '<span class="badge badge-success text-light font-12">'.strtoupper($row->type_of_benefit).'</span>';
			} else {
				$data[] = '';
			}
			$data[] = '<a href="javascript:void(0);" id="loadPage" data-link="process-claim-benefit" data-ind="'.$row->members_id.'" 
										data-badge-head="BENEFIT CLAIM - '.strtoupper($row->last_name . ', ' . $row->first_name . ' ' . $row->middle_name).'" 
										data-cls="cont-process-benefit-claim-by-member" data-placement="top" data-toggle="tooltip" title="Claim Benefits"
										data-id="'.$row->members_id.'"><i class="fas fa-hand-holding-usd"></i></a>';
   		

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
   		$data[] = $row->fname;
   		$data[] = $row->col_period_start;
   		$data[] = $row->col_period_end ;
   		$data[] = number_format($row->amnt_of_loan, 2);
   		$data[] = number_format($row->payment, 2);
 
			 $data[] = '<a href="javascript:void(0);" id="btn-add-payments" data-field="ADD" 
											 data-id="'.$row->loan_computation_id.'" data-placement="top" data-toggle="tooltip" 
											 title="Pay Now" data-id="'.$row->loan_computation_id.'"><i class="fas fa-receipt"></i></a> | 
									<a href="javascript:void(0);" id="btn-edit-payments" 
											data-comp-id="'.$row->loan_computation_id.'" data-placement="top" data-toggle="tooltip" 
											title="Edit Payments"><i class="fas fa-edit"></i></a>';
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

	public function get_message_form(){
		$params['msg'] = $this->db->get_where('loan_req_msg', array('loan_request_id' => $this->input->get('id')))->result();
		$params['id'] = $this->input->get('id');
		$this->load->view('admin/crud/frm-feedback-msg', $params);
	}
	
	public function get_message_simultaneous(){
		$params['msg'] = $this->db->get_where('loan_req_msg', array('loan_request_id' => $this->input->post('id')))->result();
		$this->load->view('admin/crud/msg-list-feedback', $params);
	}
	
	public function save_msg_feedback_admin(){
		$this->db->insert('loan_req_msg', 
			array(
				'loan_request_id'  => $this->input->post('id'),
				'msg' 						 => $this->input->post('msg'),
				'transaction_date' => date('Y-m-d')
			)
		);
		$params['msg'] = $this->db->get_where('loan_req_msg', array('loan_request_id' => $this->input->post('id')))->result();
		$this->load->view('admin/crud/msg-list-feedback', $params);
	}
	
	public function server_loans_by_request(){
		$result 	= $this->AdminMod->get_output_loan_by_request();
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		$status = array('<span class="badge badge-warning">Pending</span>', '<span class="badge badge-success">Approved</span>', '<span class="badge badge-danger">Disapproved</span>');
		foreach ($result as $row) {
			$data = array();
			$no++;

   		$data[] = $row->entry_date;
   		$data[] = $row->first_name;
   		$data[] = $row->last_name;
   		$data[] = $row->middle_name;
   		$data[] = $row->loan_code;
   		$data[] = $status[$row->status];
			$data[] = '<a href="javascript:void(0);" id="btn-show-ln-req-attmnt" data-field="ADD" 
											 data-id="'.$row->loan_request_id.'" data-placement="top" data-toggle="tooltip" 
											 title="View Attachments" data-id="'.$row->loan_request_id.'"><i class="fas fa-paperclip"></i></a> |
								<a href="javascript:void(0);" id="btn-show-ln-req-attmnt" data-field="ADD" 
											 data-id="'.$row->loan_request_id.'" data-placement="top" data-toggle="tooltip" 
											 title="Approve" data-id="'.$row->loan_request_id.'"><i class="fas fa-check-square"></i></a> |
								<a href="javascript:void(0);" id="btn-comment-ln-request" data-field="ADD" 
											 data-id="'.$row->loan_request_id.'" data-placement="top" data-toggle="tooltip" 
											 title="Feedback Message" data-id="'.$row->loan_request_id.'"><i class="fas fa-comments"></i></a>';
			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->AdminMod->count_all_loan_by_request(),
			'recordsFiltered' => $this->AdminMod->count_filter_loan_by_request(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}
	
	public function server_portal_loans_request(){
		$result 	= $this->AdminMod->get_output_loan_by_request();
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		$status = array('<span class="badge badge-warning">Pending</span>', '<span class="badge badge-success">Approved</span>', '<span class="badge badge-danger">Disapproved</span>');
		foreach ($result as $row) {
			$data = array();
			$no++;

   		$data[] = $row->loan_request_id;
   		$data[] = date('Y-m-d', strtotime($row->entry_date));
   		$data[] = $row->loan_code;
   		$data[] = $status[$row->status];
			$data[] = '<a href="javascript:void(0);" class="btn btn-info btn-sm" id="btn-view-attachment" data-field="ADD" 
											 data-id="'.$row->loan_request_id.'" data-placement="top" data-toggle="tooltip" 
											 title="View Attachment" data-id="'.$row->loan_request_id.'"><i class="fas fa-paperclip"></i></a> |
								<a href="javascript:void(0);" class="btn btn-success btn-sm" id="btn-view-comment" data-field="ADD" 
											 data-id="'.$row->loan_request_id.'" data-placement="top" data-toggle="tooltip" 
											 title="View Comment" data-id="'.$row->loan_request_id.'"><i class="fas fa-comments"></i></a>';
			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->AdminMod->count_all_loan_by_request(),
			'recordsFiltered' => $this->AdminMod->count_filter_loan_by_request(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}
	
	public function server_portal_loan_req_attmnt(){
		$result 	= $this->AdminMod->get_output_loan_attmnt_request();
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		foreach ($result as $row) {
			$data = array();
			$no++;

   		$data[] = $row->file_name;
			$data[] = '<a href="javascript:void(0);" class="btn btn-info btn-sm" id="btn-process-request-loan" data-field="ADD" 
											 data-id="'.$row->loan_request_id.'" data-placement="top" data-toggle="tooltip" 
											 title="Process NOW" data-id="'.$row->loan_request_id.'"><i class="fas fa-search"></i></a>';
			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->AdminMod->count_all_loan_attmnt_request(),
			'recordsFiltered' => $this->AdminMod->count_filter_loan_attmnt_request(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}
	
	public function server_co_maker(){
		$result 	= $this->AdminMod->get_output_co_maker();
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;


		foreach ($result as $row) {
			$co_maker = $this->db->get_where('members', array('members_id' => $row->co_maker_members_id))->row();
			$data = array();
			$no++;
   		$data[] = !empty($co_maker) ? $row->co_maker_members_id : $row->co_maker_id;
   		$data[] = !empty($co_maker) ? strtoupper($co_maker->last_name) : $row->last_name;
   		$data[] = !empty($co_maker) ? strtoupper($co_maker->first_name) : $row->first_name;
 
 			$data[] = '<a href="javascript:void(0);" id="removeCoMaker" 
 										data-id="'.$row->co_maker_id.'" data-placement="top" 
 										data-toggle="tooltip" title="Remove Co-Maker"><i class="fas fa-trash"></i></a>';
			$res[] = $data;
		}

		$output = array (
			'draw' 						=> isset($_POST['draw']) ? $_POST['draw'] : null,
			'recordsTotal' 		=> $this->AdminMod->count_all_co_maker(),
			'recordsFiltered' => $this->AdminMod->count_filter_co_maker(),
			'data' 						=> $res
		);

		echo json_encode($output);
	}

	public function server_co_maker_members_list(){
		$result 					= $this->AdminMod->get_output_members();
		// $this->output->enable_profiler(true);
		$res 							= array();
		$no 							= isset($_POST['start']) ? $_POST['start'] : 0;
		$co_makers_mem_id = $this->input->post('co_makers_mem_id');

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->members_id;
   		$data[] = strtoupper($row->last_name);
   		$data[] = strtoupper($row->first_name);
 
 			$data[] = '<a href="javascript:void(0);" id="addMembersToCoMaker" 
 										data-id="'.$row->members_id.'" data-mem-id="'.$co_makers_mem_id.'" data-placement="top" 
 										data-toggle="tooltip" title="Add to Co-Maker"><i class="fas fa-plus"></i></a>';
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

	public function insert_co_maker(){
		$members_id = $this->input->post('id');
		$curr_members_id = $this->input->post('member_id');
		$this->db->insert('co_maker', array(
																		'members_id' => $curr_members_id, 
																		'co_maker_members_id' => $members_id, 
																		'entry_date' => date('Y-m-d')));
	}

	public function save_co_maker(){
		$this->db->insert('co_maker', array(
																		'members_id' => $this->input->post('co_members_id_hddn'),
																		'last_name' => $this->input->post('last_name'), 
																		'first_name' => $this->input->post('first_name'), 
																		'entry_date' => date('Y-m-d')));
	}

	public function remove_co_maker(){
		$co_maker_id = $this->input->post('id');
		$this->db->delete('co_maker', array('co_maker_id' => $co_maker_id));
	}

	public function add_member(){
		$params['civilStatus'] = $this->db->get_where('civil_status', array('is_deleted' => 0))->result();
		$params['ofcMngmt'] 	 = $this->db->get_where('office_management', array('is_deleted' => 0))->result();
		$params['memberType']  = $this->db->get_where('member_type', array('is_deleted' => 0))->result();
		$this->load->view('admin/crud/add-member', $params);	
	}

	public function addCdjEntry(){
		$params['has_update']=$this->input->get('data');
		$params['master']=$this->db->get_where('j_master', array('j_master_id'=>$this->input->get('data')))->row();
		$params['details']=$this->db->get_where('j_details', array('j_master_id'=>$this->input->get('data')))->result();
		$params['mainAcct']=function($code){ return $this->db->get_where('v_acct_chart', array('code'=>$code))->row(); };
		$params['subAcct']=function($sub_code){ return $this->db->get_where('account_subsidiary', array('sub_code'=>$sub_code))->row(); };
		$this->load->view('admin/accounting/cdj-entry', $params);	
	}

	public function addCrjEntry(){
		$params['has_update']=$this->input->get('data');
		$params['master']=$this->db->get_where('j_master', array('j_master_id'=>$this->input->get('data')))->row();
		$params['details']=$this->db->get_where('j_details', array('j_master_id'=>$this->input->get('data')))->result();
		$params['mainAcct']=function($code){ return $this->db->get_where('v_acct_chart', array('code'=>$code))->row(); };
		$params['subAcct']=function($sub_code){ return $this->db->get_where('account_subsidiary', array('sub_code'=>$sub_code))->row(); };
		$this->load->view('admin/accounting/crj-entry', $params);	
	}

	public function addGjEntry(){
		$params['has_update']=$this->input->get('data');
		$params['master']=$this->db->get_where('j_master', array('j_master_id'=>$this->input->get('data')))->row();
		$params['details']=$this->db->get_where('j_details', array('j_master_id'=>$this->input->get('data')))->result();
		$params['mainAcct']=function($code){ return $this->db->get_where('v_acct_chart', array('code'=>$code))->row(); };
		$params['subAcct']=function($sub_code){ return $this->db->get_where('account_subsidiary', array('sub_code'=>$sub_code))->row(); };
		$this->load->view('admin/accounting/gj-entry', $params);	
	}

	public function addPacsEntry(){
		$params['has_update']=$this->input->get('data');
		$params['master']=$this->db->get_where('j_master', array('j_master_id'=>$this->input->get('data')))->row();
		$params['details']=$this->db->get_where('j_details', array('j_master_id'=>$this->input->get('data')))->result();
		$params['mainAcct']=function($code){ return $this->db->get_where('v_acct_chart', array('code'=>$code))->row(); };
		$params['subAcct']=function($sub_code){ return $this->db->get_where('account_subsidiary', array('sub_code'=>$sub_code))->row(); };
		$this->load->view('admin/accounting/pacs-entry', $params);	
	}

	public function getChartOfAccounts(){
		$result=array();
		$q = $this->input->get('q');
		$result['account_title'] = $this->db->query("SELECT * FROM v_acct_chart 
																									WHERE code != '' AND lower(main_desc) LIKE lower('%$q%') 
																									OR lower(code) LIKE lower('%$q%') AND is_deleted = 0")->result();
		echo json_encode($result);
	}

	public function getSubsidiaryAccounts(){
		$result=array();
		$q 		= $this->input->get('q');
		$code = $this->input->get('code');
		$result['account_title'] = $this->db->query("SELECT * FROM account_subsidiary 
																									WHERE code = $code AND (lower(employee_id) LIKE lower('%$q%') 
																									OR lower(name) LIKE lower('%$q%')) and is_deleted = 0")->result();
		echo json_encode($result);
	}

	public function getPayeeType(){
		$val=$this->input->post('val');
		$params['members']  	 = $this->db->get_where('members', array('is_deleted' => 0))->result();
		$params['has_update']=$this->input->post('has_update');
		if ($val==1) {
			$this->load->view('admin/accounting/select-payee-member', $params);
		} else {
			$this->load->view('admin/accounting/input-payee-others', $params);
		}
	}

	public function process_a_loan(){
		$members_id 			 		 	= $this->input->get('data');
		$params['membersData'] 	= $this->db->get_where('v_members', array('members_id' => $members_id))->row();
		$params['loanTypes']	 	= $this->db->get_where('loan_code', array('is_deleted'=>0))->result();
		$params['loanSettings'] = $this->db->get('v_loan_settings')->result();

		
		$params['members_id'] 	= $members_id;
		$this->load->view('admin/crud/process-a-loan', $params);	
	}

	public function getPreviousLoan(){
		$ref_no 		= $this->input->post('ref_no');
		$members_id = $this->input->post('memberId');
		$q = $this->db->query("SELECT 
														lc.ref_no,
														v.loan_computation_id,
														lc.gross_amnt,
														lc.breakdown_ma_total,
														min(v.payment_schedule) AS f_date,
														max(v.payment_schedule) AS l_date,
														sum(v.monthly_amortization) AS totl_amnt_to_pay, 
														sum(coalesce(v.amnt_paid, 0)) AS totl_paid, 
														(sum(coalesce(v.monthly_amortization, 0)) - sum(coalesce(v.amnt_paid, 0))) AS balance,
														lc.total_amnt_to_be_amort,
														lc.is_posted
														FROM v_loan_sched_choices v
														LEFT JOIN loan_computation lc ON v.loan_computation_id = lc.loan_computation_id
														WHERE lc.ref_no = '$ref_no' AND lc.members_id = '$members_id' AND (coalesce(v.monthly_amortization,0) - coalesce(v.amnt_paid,0)) > 0
														GROUP BY v.loan_computation_id")->row();
		echo json_encode($q);
	}

	public function edit_process_a_loan(){
		$loan_computation_id 			 		 = $this->input->get('data');
		$params['loanComputation'] 		 = $this->db->get_where('loan_computation', array('loan_computation_id' => $loan_computation_id))->row();
		$params['membersData'] 		 		 = $this->db->get_where('v_members', array('members_id' => $params['loanComputation']->members_id))->row();
		$loan_code_id 								 = $this->db->get_where('loan_settings', array('loan_settings_id' => $params['loanComputation']->loan_settings_id))->row();
		$params['loanTypes']	 		 		 = $this->db->get_where('loan_code', array('is_deleted'=>0))->result();
		$params['loanSettings'] 	 		 = $this->db->get('v_loan_settings')->result();
		$params['members_id'] 		 		 = $params['loanComputation']->members_id;
		$params['loan_code_id'] 		 	 = $loan_code_id;

		$prevOR 											 = $params['loanComputation']->current_orno;

		$prevLoanPaidSchedID = [];
		$totalPaidOnPrevLoan=0;
		$datePaidSched=[];
		$totalBalance=0;
		if ($prevOR) {
			if ($params['loanComputation']->is_posted == '1') {
				$prevPayment 									 = $this->db->get_where('loan_receipt', array('orno' => $prevOR))->result();
				foreach ($prevPayment as $row) {
					$prevLoanPaidSchedID[] = $row->loan_schedule_id;
					$totalPaidOnPrevLoan+=$row->amnt_paid;
				}	
			} else {
				$prevPayment 									 = $this->db->get_where('loan_receipt_temp', array('orno' => $prevOR))->result();
				foreach ($prevPayment as $row) {
					$prevLoanPaidSchedID[] = $row->loan_schedule_id;
					$totalPaidOnPrevLoan+=$row->amnt_paid;
				}
			}	
		}

		$prevLoanPaid 							 	 = $this->db->get_where('loan_computation', 
																														array('loan_computation_id' => $params['loanComputation']->prev_loan_computation_id)
																													)->row();
		if ($prevLoanPaid) {
			$prevLoanComputationID 				 = $prevLoanPaid->loan_computation_id;
			$getTotalBalance 							 = $this->db->query("SELECT 
																														loan_schedule_id,
																														(coalesce(monthly_amortization) - coalesce(amnt_paid,0)) as ma_bal, 
																														(coalesce(monthly_interest) - coalesce(interest_paid,0)) as int_bal 
																													FROM v_loan_sched_choices WHERE loan_computation_id = $prevLoanComputationID")->result();
			$getAmountPaid=array();
			if (count($prevLoanPaidSchedID) > 0) {
				$getAmountPaid 							 = $this->db->query("SELECT 
																														payment_schedule,
																														loan_schedule_id,
																														(coalesce(monthly_amortization) - coalesce(amnt_paid,0)) as ma_bal, 
																														(coalesce(monthly_interest) - coalesce(interest_paid,0)) as int_bal 
																													FROM v_loan_sched_choices WHERE loan_computation_id = $prevLoanComputationID AND loan_schedule_id in (".implode(',', $prevLoanPaidSchedID).")")->result();
			}
			foreach ($getTotalBalance as $row) {
				$totalBalance+=$row->ma_bal;
			}
			$amnt_on_tmp_check_if_zero = 0;
			if ($getAmountPaid) {
				foreach ($getAmountPaid as $row) {
					$datePaidSched[]=$row->payment_schedule;
					$amnt_on_tmp_check_if_zero+=$row->ma_bal;
				}	
				$params['datePaidPrevLoanSchedID'] = $datePaidSched;
				$params['totalBalance']            = $amnt_on_tmp_check_if_zero == 0 ? ($totalBalance + $totalPaidOnPrevLoan) : $totalBalance;//73006.92;//
			}
			
			$params['totalPaidOnPrevLoan']     = $totalPaidOnPrevLoan;
			$params['prevOR']     						 = $prevOR;
			$params['schedID'] 			 		 			 = implode('|', $prevLoanPaidSchedID);
			$params['renewed_refno'] 			 		 = $prevLoanPaid->ref_no;
		}
		
		$params['loan_computation_id'] 		 = $loan_computation_id;

		$this->load->view('admin/crud/edit-process-a-loan', $params);	

	}

	public function getSettingsCode(){
		$loan_code = $this->input->post('loan_code');
		$q = $this->db->get_where('loan_settings', array('loan_code_id' => $loan_code,'is_deleted'=>0))->result();
		echo json_encode($q);
	}

	public function getPrintLoanComp(){
		$data=json_encode($this->input->post());
		$encrptSerArr = $this->encdec($data, 'e');
		echo json_encode(array('data' => $encrptSerArr));
	}

	public function postLoanComp(){
		$loan_computation_id = $this->input->post('id');
		$currLoanComp 			 = $this->db->get_where('loan_computation', array('loan_computation_id' => $loan_computation_id))->row();
		$prevLoanComp 			 = $this->db->get_where('loan_receipt_temp', array('orno' => $currLoanComp->current_orno))->result();
		
		if ($prevLoanComp) {
			$postPaymentArr = [];
			foreach ($prevLoanComp as $row) {
				array_push($postPaymentArr, array(
					'loan_schedule_id' => $row->loan_schedule_id,
					'orno' 						 => $row->orno,
					'amnt_paid'				 => $row->amnt_paid,
					'interest_paid'		 => $row->interest_paid,
					'date_paid'				 => $row->date_paid
				));
			}
			$this->db->insert_batch('loan_receipt', $postPaymentArr);
			$this->db->delete('loan_receipt_temp', array('orno' => $currLoanComp->current_orno));
		}

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
		$params['loanSettings'] = $this->db->get('v_loan_settings')->result();
		$params['members_id'] 	= $members_id;
		$this->load->view('admin/crud/v-loans-list-by-member-id', $params);	
	}

	public function showLoansByMember(){
		$members_id 			 		 	= $this->input->get('data');
		$params['membersData'] 	= $this->db->get_where('v_members', array('members_id' => $members_id))->row();
		$params['loanSettings'] = $this->db->get('v_loan_settings')->result();
		$params['members_id'] 	= $members_id;
		$this->load->view('admin/crud/v-loans-by-member', $params);	
	}

	public function computeLoans(){
		//loan_settings_id
		$members_id					 		= $this->input->post('m_id');
		$loanSettingsID 		 		= $this->input->post('no_mos_applied');
		
		$prevLoanTotalAmntToPay = floatval(str_replace(',', '', $this->input->post('prev_loan_tot_amnt')));
		$prevLoanTotalAmntPaid 	= floatval(str_replace(',', '', $this->input->post('prev_loan_tot_pymnts')));
		
		$dateProcessed 			 		= $this->input->post('date_processed');
		$loanSettingsDetails 		= $this->AdminMod->getLoanSettings($loanSettingsID);
		$monthlySalary 			 		= floatval(str_replace(',', '', $this->input->post('monthly_salary'))) * $loanSettingsDetails->number_of_month;
		$dataName 					 		= array();

		//collection period date
		/**
		 * IF HAS PREVIOUS LOAN BALANCE SMLV then 12 multiply to repayment period else 12; 
		 */
		$oneYr = 12*$loanSettingsDetails->repymnt_period;
		$pD = date('Y-m-d', strtotime($dateProcessed));
		$arrPD = array();
		for($i = 1; $i <= $oneYr; $i++){
		 $arrPD[$i] = date('Y-m', strtotime("+".$i."months", strtotime($pD)));
		}

		$dataName['m_id'] 								= $members_id;

		if ($loanSettingsDetails->loan_code=='SLMV') {
			$dataName['interest_per_annum'] 	= floatval($loanSettingsDetails->int_per_annum);
			$dataName['amnt_of_loan_applied'] = $monthlySalary;
			$dataName['add_interest'] 				= $monthlySalary * ($loanSettingsDetails->int_per_annum / 100) * $loanSettingsDetails->repymnt_period;
			$dataName['gross_amnt_of_loan'] 	= $monthlySalary + $dataName['add_interest'];
			$dataName['first_yr_int_ded'] 		= $monthlySalary * ($loanSettingsDetails->int_per_annum / 100);
			

			// $dataName['ded_interest'] 				= $dataName['first_yr_int_ded'];
			$dataName['loan_red_ins'] 				= $monthlySalary * ($loanSettingsDetails->lri / 100);
			$dataName['service_charge'] 			= floatval($loanSettingsDetails->svc);
			$dataName['previous_loan'] 				= $prevLoanTotalAmntToPay;//floatval(83066.94);
			$dataName['prev_loans_pymnts'] 		= $prevLoanTotalAmntPaid;//floatval(55377.96);
			$dataName['balance_on_prev_loan'] = $prevLoanTotalAmntToPay - $prevLoanTotalAmntPaid;//floatval(27688.98);
			$dataName['total_deductions'] 		= $dataName['balance_on_prev_loan'];//$dataName['loan_red_ins'] + $dataName['service_charge'] + $dataName['balance_on_prev_loan'];
			$dataName['net_proceeds'] 				= $monthlySalary - $dataName['total_deductions'];
			$dataName['collection_prd_start'] = $arrPD[1];
			$dataName['collection_prd_end'] 	= end($arrPD);
			$dataName['tot_amnt_tobe_amort'] 	= $dataName['gross_amnt_of_loan'] + $dataName['loan_red_ins'] + $dataName['service_charge'];// - + $dataName['total_deductions'] $dataName['first_yr_int_ded'];

			// if( $loanSettingsDetails->number_of_month == 1){
			// 	$dataName['monthly_amort'] 				= $dataName['tot_amnt_tobe_amort'] / $loanSettingsDetails->repymnt_period / 12;
			// } else {
				$dataName['monthly_amort'] 				= $dataName['tot_amnt_tobe_amort'] / $loanSettingsDetails->repymnt_period / 12 + 0.005;
			// }

			$dataName['bma_principal'] 	      = $dataName['monthly_amort'] / $loanSettingsDetails->monthly_interest;
			$dataName['bma_interest'] 	      = $dataName['monthly_amort'] - $dataName['bma_principal'];
			$dataName['bma_total'] 	      		= $dataName['bma_principal'] + $dataName['bma_interest'];
		} else {
			// echo '<pre>';
			// echo json_encode($dataName, JSON_PRETTY_PRINT);
			// echo '</pre>';
			// die();
			$dataName['interest_per_annum'] 	= floatval($loanSettingsDetails->int_per_annum);
			$dataName['amnt_of_loan_applied'] = $monthlySalary;
			$dataName['add_interest'] 				= $monthlySalary * ($loanSettingsDetails->int_per_annum / 100) * $loanSettingsDetails->repymnt_period;
			$dataName['gross_amnt_of_loan'] 	= $monthlySalary + $dataName['add_interest'];
			$dataName['first_yr_int_ded'] 		= $monthlySalary * ($loanSettingsDetails->int_per_annum / 100);
			$dataName['tot_amnt_tobe_amort'] 	= $dataName['gross_amnt_of_loan'] - $dataName['first_yr_int_ded'];

			if( $loanSettingsDetails->number_of_month == 1){
			  $dataName['monthly_amort'] 				= $dataName['tot_amnt_tobe_amort'] / $loanSettingsDetails->repymnt_period / 12;
			}else{
			  $dataName['monthly_amort'] 				= $dataName['tot_amnt_tobe_amort'] / $loanSettingsDetails->repymnt_period / 12 + 0.005;
			}
			
			$dataName['ded_interest'] 				= $dataName['first_yr_int_ded'];
			$dataName['loan_red_ins'] 				= $monthlySalary * ($loanSettingsDetails->lri / 100);
			$dataName['service_charge'] 			= floatval($loanSettingsDetails->svc);
			$dataName['previous_loan'] 				= $prevLoanTotalAmntToPay;//floatval(83066.94);
			$dataName['prev_loans_pymnts'] 		= $prevLoanTotalAmntPaid;//floatval(55377.96);
			$dataName['balance_on_prev_loan'] = $prevLoanTotalAmntToPay - $prevLoanTotalAmntPaid;//floatval(27688.98);
			$dataName['total_deductions'] 		= $dataName['ded_interest'] + $dataName['loan_red_ins'] + $dataName['service_charge'] + $dataName['balance_on_prev_loan'];
			$dataName['net_proceeds'] 				= $monthlySalary - $dataName['total_deductions'];
			$dataName['collection_prd_start'] = $arrPD[1];
			$dataName['collection_prd_end'] 	= end($arrPD);
			$dataName['bma_principal'] 	      = $dataName['monthly_amort'] / $loanSettingsDetails->monthly_interest;
			$dataName['bma_interest'] 	      = $dataName['monthly_amort'] - $dataName['bma_principal'];
			$dataName['bma_total'] 	      		= $dataName['bma_principal'] + $dataName['bma_interest'];
		}
		echo json_encode($dataName, JSON_PRETTY_PRINT);

	}

	public function saveLoanComp(){
		$prevLoanComp = $this->db->get_where('loan_computation', array('ref_no' => $this->input->post('prev_ref_no')))->row();
		
		$dataLoanComp = array(
			'members_id' 							 => $this->input->post('m_id'),
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
			'current_orno' 					 	 => $this->input->post('prev_loan_orno'),
			'prev_loan_computation_id' => !empty($prevLoanComp) ? $prevLoanComp->loan_computation_id : null,
			// 'is_posted' 							 => $this->input->post('m_id'),
			// 'is_deleted' 							 => $this->input->post('m_id'),
			'entry_date' 							 => date('Y-m-d'),
			'users_id'								 => $this->session->users_id
		);

		//save payment for previous loan
		$arrLoanSchedID = explode('|', $this->input->post('loanSchedID'));
		$loanReceiptField = array();
		
		if ($this->input->post('loanSchedID')!='') {
			if (!empty($prevLoanComp)) {
				$prevLoanCompID = $prevLoanComp->loan_computation_id;
				$getAmortizationBalance = $this->db->query("SELECT 
																											loan_schedule_id,
																											(coalesce(monthly_amortization) - coalesce(amnt_paid,0)) as ma_bal, 
																											(coalesce(monthly_interest) - coalesce(interest_paid,0)) as int_bal 
																										FROM v_loan_sched_choices 
																										WHERE loan_computation_id = $prevLoanCompID AND loan_schedule_id in (".implode(',', $arrLoanSchedID).")
																										AND (coalesce(monthly_amortization,0) - coalesce(amnt_paid,0)) > 0")->result();

				foreach ($getAmortizationBalance as $row) {
					array_push($loanReceiptField, array(
						'loan_schedule_id' => $row->loan_schedule_id,
						'orno' 						 => $this->input->post('prev_loan_orno'),
						'amnt_paid' 			 => $row->ma_bal,
						'interest_paid' 	 => $row->int_bal,
						'date_paid' 			 => date('Y-m-d', strtotime($this->input->post('date_processed'))),
					));
				}
			}
		}

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
					'loan_computation_id'  => $this->input->post('has_update'),
					'payment_schedule' 		 => $dt->format("Y-m"),
					'monthly_amortization' => $dataLoanComp['breakdown_ma_total'],
					'principal'						 => $dataLoanComp['breakdown_ma_principal'],
					'monthly_interest' 		 => $dataLoanComp['breakdown_ma_interest'],	
					'entry_date'					 => date('Y-m-d')
				));	
				$ctr++;
			}
			//FOR UPDATE => DELETE BEFORE INSERT "BECAUSE SOMETIMES MORE THAN SCHEDULE OF NUMBER NEED TO ADD DATES"
			$this->db->delete('loan_schedule', array('loan_computation_id' => $this->input->post('has_update')));
			$q1 = $this->db->update('loan_computation', $dataLoanComp, array('loan_computation_id' => $this->input->post('has_update')));
			$q2 = $this->db->insert_batch('loan_schedule', $dataLoanSchedule);

			// update loan_receipt table
			if ($loanReceiptField) {
				$this->db->delete('loan_receipt_temp', array('orno' => $this->input->post('prev_loan_orno')));
				$q3 = $this->db->insert_batch('loan_receipt_temp', $loanReceiptField);
			}
			if ($q1 || $q2 || $q3) {
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
			if ($loanReceiptField) {
				$this->db->insert_batch('loan_receipt_temp', $loanReceiptField);
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
		$decVal = json_decode($this->encdec($this->uri->segment(2), 'd'));
		$ls = $this->db->get_where('loan_settings', array('loan_settings_id' => $decVal->repayment_period))->row();
		$lc = $this->db->get_where('loan_code', array('loan_code_id' => $ls->loan_code_id))->row();
		$md = $this->db->get_where('members', array('members_id' => $decVal->m_id))->row();
		$cm = $this->db->join('members m', 'm.members_id = cm.co_maker_members_id', 'left')
										->select('cm.*, m.last_name, m.first_name, m.monthly_salary, m.designation')
										->from('co_maker cm')
										->where('cm.members_id', $decVal->m_id)->get()->result();
		$decVal->repayment_period = $ls->repymnt_period;
		$params['result'] = $decVal;
		$params['members'] = $md;
		$params['co_maker'] = $cm;
		$params['loan_code'] = $lc;
		$params['loan_settings'] = $ls;
		$html = $this->load->view('admin/reports/loan-computation', $params, TRUE);
		$this->AdminMod->pdf($html, 'Loan Computation', false, 'LEGAL', false, false, false, 'Loan Computation', '');
	}

	public function getMembersPrintToPDF(){
		$m_id = $this->uri->segment(2);
		$type_to_print = $this->uri->segment(3);
		$office_id = $this->uri->segment(4);
		$startDate = $this->uri->segment(5);
		$endDate = $this->uri->segment(6);
		$params['data']=$this->AdminMod->getMembersContribution($startDate, $endDate, $m_id);
		$params['sd']=$startDate;
		$params['ed']=$endDate;
		if ($type_to_print==1) {
			$html = $this->load->view('admin/reports/members-contribution-pdf', $params, TRUE);
		} else {
			$html = $this->load->view('admin/reports/office-contribution-pdf', $params, TRUE);
		}
		$this->AdminMod->pdf($html, 'Contribution Report', false, 'LEGAL', false, false, false, 'Contribution Report', '');
	}

	public function edit_member(){
		$members_id 			 		 = $this->input->get('data');
		$params['uploads'] 		 = $this->db->get_where('uploads', array('members_id' => $members_id))->row();
		$params['membersData'] = $this->db->get_where('members', array('members_id' => $members_id))->row();
		$params['civilStatus'] = $this->db->get_where('civil_status', array('is_deleted'=>0))->result();
		$params['ofcMngmt'] 	 = $this->db->get_where('office_management', array('is_deleted'=>0))->result();
		$params['memberType']  = $this->db->get_where('member_type', array('is_deleted'=>0))->result();
		$this->load->view('admin/crud/edit-member', $params);
	}

	public function view_contribution(){
		$params['members_id']=$this->input->get('data');
		$this->load->view('admin/crud/view-contribution', $params);
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
				$genPw  = $this->generateKey(6);
				$hashPw = password_hash($genPw, PASSWORD_BCRYPT);
				$dataField['username'] 		 = strtolower(str_replace(' ', '', $this->input->post('first_name')[0]) . str_replace(' ', '', $this->input->post('last_name')));
				$dataField['password'] 		 = $hashPw;
				$dataField['password_txt'] = $genPw;

				// $from    		 = "manage_account@cpfi-webapp.com";
				$from    		 = "no-reply@cpfi-webapp.com";
				$to    	 		 = strtolower($this->input->post('email'));
				$title    	 = "CPFI | Account Created";
				$subject  	 = "New Member Created";
				$message     = "Dear " . strtoupper($this->input->post('first_name')) . ", <br><br> 
												Congratulations you already created you account below is your login credentials <br><br> Usename: " .
												$dataField['username'] . " <br> Password: " . $dataField['password_txt'] . " <br><br> Thank you!";
				$this->sendEmail($from, $to, $subject, $message, $title);
				
				$this->db->insert('members', $dataField);
				$errors['members_id'] 	 	 = $dataField['members_id'];
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

	public function showComaker(){
		$params['id'] = $this->input->post('id');
		$this->load->view('admin/crud/show-co-maker', $params);
	}

	public function updateData(){
		$tbl 				  = $this->input->post('tbl');
		$update_data = $this->input->post('update_data');
		$field_where 	= $this->input->post('field_where');
		$where_val 	  = $this->input->post('where_val');
		if ($field_where == 'group_code' && array_key_exists('is_deleted', $update_data)) {
			//delete all children
			$this->db->update('account_main', $update_data, array($field_where => $where_val));
		}
		$q = $this->db->update($tbl, $update_data, array($field_where => $where_val));
		$res = array();
		if ($q) {
			$res['param1'] = 'Success!';
			$res['param2'] = 'Updated!';
			$res['param3'] = 'success';
		} else {
			$res['param1'] = 'Opps!';
			$res['param2'] = 'Error Encountered Saved';
			$res['param3'] = 'warning';
		}
		echo json_encode($res);
	}

	public function printMembersDocx(){
		$params['members'] = $this->db->get_where('members', array('is_deleted' => 0))->result();
		$params['office_management'] = $this->db->get_where('office_management', array('is_deleted' => 0))->result();
		$this->load->view('admin/crud/print-members-docs', $params);
	}

	public function printCashGiftDocx(){
		$params['members'] = $this->db->get_where('members', array('is_deleted' => 0))->result();
		$params['office_management'] = $this->db->get_where('office_management', array('is_deleted' => 0))->result();
		$this->load->view('admin/crud/print-cash-gift-docs', $params);
	}

	public function getMembersPrintToExcel(){
		$m_id = $this->input->post('m_id');
		$type_to_print = $this->input->post('type_to_print');
		$office_id = $this->input->post('office_to_print');
		$startDate = explode(' ', $this->input->post('date'))[0];
		$endDate = explode(' ', $this->input->post('date'))[1];

		if ($type_to_print==1) {
			$params['data']=$this->AdminMod->getMembersContribution($startDate, $endDate, $m_id);
			$params['sd']=$startDate;
			$params['ed']=$endDate;
			$this->load->view('admin/reports/members-contribution-excel', $params);
		} elseif ($type_to_print==2){
			$params['data']=$this->AdminMod->getOfficeContribution($startDate, $endDate, $office_id);
			$params['sd']=$startDate;
			$params['ed']=$endDate;
			$this->load->view('admin/reports/office-contribution-excel', $params);
		} else {
			$params['data']=$this->AdminMod->getLoansPayment($startDate, $endDate, $m_id);
			$params['sd']=$startDate;
			$params['ed']=$endDate;
			$this->load->view('admin/reports/loans-payments-excel', $params);
		}
	}

	public function getCashiGiftPrintToExcel(){
		$m_id = $this->input->post('m_id');
		$office_id = $this->input->post('office_to_print');
		$remarks = $this->input->post('remarks');
		$place = str_replace('%20', '', $this->input->post('type'));
		$startDate = explode(' ', $this->input->post('date'))[0];
		$endDate = explode(' ', $this->input->post('date'))[1];
		$type_to_print = $this->input->post('type_to_print');
		if ($type_to_print==1) {
			$params['data']=$this->AdminMod->getCashGiftOfficePrint($startDate, $endDate, $office_id);
			$params['sd']=$startDate;
			$params['ed']=$endDate;
			$params['remarks']=$remarks;
			$this->load->view('admin/reports/office-cash-gift-excel', $params);	
		} elseif($type_to_print==2){
			$params['data']=$this->AdminMod->getCashGiftMembersPrint($startDate, $endDate, $m_id);
			$params['sd']=$startDate;
			$params['ed']=$endDate;
			$this->load->view('admin/reports/members-cash-gift-excel', $params);	
		}else {
			$params['data']=$this->AdminMod->getCashGiftDeptPrint($startDate, $endDate, $place);
			$params['sd']=$startDate;
			$params['ed']=$endDate;
			$params['remarks']=$remarks;
			$params['place']=$place;
			$this->load->view('admin/reports/office-cash-gift-excel', $params);
		}
	}

	public function getTotalContributionPerRegion(){
		$departments_id = $this->input->post('departments_id');
		$date 					= date('Y-m', strtotime($this->input->post('date')));
		$contribution = $this->AdminMod->getTotalContributionByRegion($departments_id, $date);
		echo json_encode(array('total' => (!empty($contribution) ? ($contribution->total=='' ? 0 : $contribution->total) : 0)));
	}

}
