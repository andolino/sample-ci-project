<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminMod extends CI_Model {
	protected $userType=[];

	//MEMBERS
	var $tblMembers = 'v_members';
	var $tblMembersCollumn = array('members_id', 'id_no', 'last_name', 'first_name', 
																				'middle_name', 'dob', 'address', 'status', 'date_of_effectivity', 
																				'designation', 'type', 'monthly_salary', 'office_name', 'entry_date', 'is_deleted', 'retired_date', 'type_of_benefit');
	var $tblMembersOrder = array('members_id' => 'desc');

	//LOAN SETTINGS
	var $tblLoanSettings = 'v_loan_settings';
	var $tblLoanSettingsCollumn = array('loan_settings_id', 'loan_code', 'number_of_month', 
																	'int_per_annum', 'lri', 'svc', 'repymnt_period', 'monthly_interest', 
																	'entry_date', 'is_deleted');
	var $tblLoanSettingsOrder = array('loan_settings_id' => 'desc');

	//LOAN LIST
	var $tblLoanList = 'v_loans_list';
	var $tblLoanListCollumn = array('loan_computation_id', 'ref_no', 'date_processed', 'fname', 
																	'is_approved', 'is_posted', 'loan_types_id', 'is_deleted', 'is_approved_txt');
	var $tblLoanListOrder = array('loan_computation_id' => 'desc');

	//LOAN BY MEMBER
	var $tblLoanByMember = 'v_loans_by_member';
	var $tblLoanByMemberCollumn = array('members_id', 'fname', 'loan_computation_id', 'type', 'ref_no', 'col_period_start', 
																				'col_period_end', 'amnt_of_loan', 'payment', 'is_approved', 'is_posted', 
																				'loan_types_id', 'is_deleted');
	var $tblLoanByMemberOrder = array('loan_computation_id' => 'desc');

	//LOAN BY REQUEST
	var $tblLoanByRequest = 'v_loans_by_request';
	var $tblLoanByRequestCollumn = array('loan_request_id', 'members_id', 'is_deleted', 'entry_date', 'users_id', 'description', 
																				'first_name', 'last_name', 'middle_name', 'loan_code', 'amnt_of_loan', 'status', 'remarks', 'approved_by', 
																				'approved_date', 'disapproved_by', 'disapproved_date', 'req_remarks');
	var $tblLoanByRequestOrder = array('loan_request_id' => 'desc');
	
	//BENEFIT BY REQUEST
	var $tblBenefitByRequest = 'v_benefit_by_request';
	var $tblBenefitByRequestCollumn = array('benefit_request_id', 'members_id', 'is_deleted', 'entry_date', 'users_id', 'description', 
																						'first_name', 'last_name', 'middle_name', 'status', 'approved_by', 'approved_date', 'disapproved_by', 
																						'disapproved_date', 'type_of_benefit', 'total_claim', 'req_remarks');
	var $tblBenefitByRequestOrder = array('benefit_request_id' => 'desc');
	
	//LOAN REQUEST ATTCHMNT
	var $tblLoanAttchmntRequest = 'portal_uploads';
	var $tblLoanAttchmntRequestCollumn = array('portal_uploads_id', 'file_name', 'transaction_date', );
	var $tblLoanAttchmntRequestOrder = array('portal_uploads_id' => 'desc');
	

	//CO-MAKER
	var $tblLoanByCoMaker = 'co_maker';
	var $tblLoanByCoMakerCollumn = array('co_maker_id', 'members_id', 'co_maker_members_id', 'last_name', 'first_name', 'is_deleted', 'entry_date');
	var $tblLoanByCoMakerOrder = array('co_maker_id' => 'desc');

	//REPAYMENTS MEMBER
	var $tblRepayments = 'members m';
	var $tblRepaymentsCollumn = array('m.members_id', 'm.first_name', 'm.last_name', 'm.middle_name', 'm.is_deleted', 'm.entry_date', 'ls.*');
	var $tblRepaymentsOrder = array('m.members_id' => 'desc');

	public function __construct(){
		parent::__construct();
		$this->userType = [0 => 'Administrator', 1 => 'User - Loans', 2 => 'User - Collections', 3 => 'User - Benefits', 4 => 'Guest'];
	}

	public function getUserType($id){
		return $this->userType[$id];
	}

	//MEMBERS OBJECT
	private function _que_tbl_members(){
		$this->db->from($this->tblMembers);
		$this->db->where('is_deleted', '0');
		if ($this->input->post('co_makers_mem_id')) {
			$this->db->where('members_id <>', $this->input->post('co_makers_mem_id'));
			$this->db->where("members_id NOT IN (SELECT coalesce(co_maker_members_id, '') FROM co_maker)");
		}
		if ($this->input->post('members_id')) {
			$this->db->where('members_id', $this->input->post('members_id'));
		}
		$i = 0;
		foreach ($this->tblMembersCollumn as $item) {
			if (!empty($_POST['search']['value'])) {
				if ($i === 0) {
						$this->db->where('is_deleted', '0');
					if ($this->input->post('co_makers_mem_id')) {
						$this->db->where('members_id <>', $this->input->post('co_makers_mem_id'));
						$this->db->where("members_id NOT IN (SELECT coalesce(co_maker_members_id, '') FROM co_maker)");
					}
					if ($this->input->post('members_id')) {
						$this->db->where('members_id', $this->input->post('members_id'));
					}
					$this->db->like($item, strtolower($_POST['search']['value']));
				} else {
					$this->db->where('is_deleted', '0');
					if ($this->input->post('co_makers_mem_id')) {
						$this->db->where('members_id <>', $this->input->post('co_makers_mem_id'));
						$this->db->where("members_id NOT IN (SELECT coalesce(co_maker_members_id, '') FROM co_maker)");
					}
					if ($this->input->post('members_id')) {
						$this->db->where('members_id', $this->input->post('members_id'));
					}
					$this->db->or_like($item, strtolower($_POST['search']['value']));
				}
			}
			$column[$i] = $item;
			$i++;
		}
		if (isset($_POST['order'])) {
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}elseif($this->tblMembersOrder){
			$order = $this->tblMembersOrder;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$this->db->order_by('members_id', 'DESC');
	}

	public function get_output_members(){
		$this->_que_tbl_members();
		if (!empty($_POST['length']))
		$this->db->limit(($_POST['length'] < 0 ? 0 : $_POST['length']), $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all_members(){
		$this->db->where('is_deleted', '0');
		$this->db->from($this->tblMembers);
		return $this->db->count_all_results();
	}

	public function count_filter_members(){
		$this->_que_tbl_members();
		$query = $this->db->get();
		return $query->num_rows();
	}

	//REPAYMENT OBJECT
	private function _que_tbl_repayments(){
		$office_management_id = $this->input->post('office_management_id');
		$date_applied 				= date('Y-m', strtotime($this->input->post('date_applied')));

		$this->db->from($this->tblRepayments);
		// "SELECT ls.* from members m 
		// 	LEFT JOIN loan_computation lc ON lc.members_id = m.members_id
		// 	LEFT JOIN loan_schedule ls ON ls.loan_computation_id = lc.loan_computation_id
		// 	WHERE m.office_management_id = $office_management_id 
		// 	AND ls.payment_schedule = '$date_applied' 
		// 	AND ls.loan_schedule_id NOT IN (SELECT lr.loan_schedule_id from loan_receipt lr)"
		$this->db->join('loan_computation lc', 'm.members_id = lc.members_id', 'left');
		$this->db->join('loan_schedule ls', 'ls.loan_computation_id = lc.loan_computation_id', 'left');
		$this->db->where('m.is_deleted', '0');
		$this->db->where('m.office_management_id', $office_management_id);
		$this->db->where('ls.payment_schedule', $date_applied);
		$this->db->where('ls.loan_schedule_id NOT IN (SELECT lr.loan_schedule_id from loan_receipt lr)');
		
		$i = 0;
		foreach ($this->tblRepaymentsCollumn as $item) {
			if (!empty($_POST['search']['value'])) {
				if ($i === 0) {
					$this->db->where('m.is_deleted', '0');
					$this->db->like($item, strtolower($_POST['search']['value']));
					$this->db->where('m.office_management_id', $office_management_id);
					$this->db->where('ls.payment_schedule', $date_applied);
				} else {
					$this->db->where('m.is_deleted', '0');
					$this->db->or_like($item, strtolower($_POST['search']['value']));
					$this->db->where('m.office_management_id', $office_management_id);
					$this->db->where('ls.payment_schedule', $date_applied);
				}
			}
			$column[$i] = $item;
			$i++;
		}
		if (isset($_POST['order'])) {
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}elseif($this->tblRepaymentsOrder){
			$order = $this->tblRepaymentsOrder;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$this->db->order_by('m.members_id', 'DESC');
	}

	public function get_output_repayments(){
		$this->_que_tbl_repayments();
		if (!empty($_POST['length']))
		if ($_POST['length'] < 0) {} else {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all_repayments(){
		$this->db->where('m.is_deleted', '0');
		$this->db->from($this->tblRepayments);
		return $this->db->count_all_results();
	}

	public function count_filter_repayments(){
		$this->_que_tbl_members();
		$query = $this->db->get();
		return $query->num_rows();
	}



	//LOAN SETTINGS OBJECT
	private function _que_tbl_loan_settings(){
		$this->db->from($this->tblLoanSettings);
		$this->db->where('is_deleted', '0');
		$i = 0;
		foreach ($this->tblLoanSettingsCollumn as $item) {
			if (!empty($_POST['search']['value'])) {
				if ($i === 0) {
					$this->db->like($item, strtolower($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtolower($_POST['search']['value']));
				}
			}
			$column[$i] = $item;
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->where('is_deleted', '0');
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}elseif($this->tblLoanSettingsOrder){
			$this->db->where('is_deleted', '0');
			$order = $this->tblLoanSettingsOrder;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$this->db->order_by('loan_settings_id', 'DESC');
	}

	public function get_output_loan_settings(){
		$this->_que_tbl_loan_settings();
		if (!empty($_POST['length']))
		$this->db->limit(($_POST['length'] < 0 ? 0 : $_POST['length']), $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all_loan_settings(){
		$this->db->where('is_deleted', '0');
		$this->db->from($this->tblLoanSettings);
		return $this->db->count_all_results();
	}

	public function count_filter_loan_settings(){
		$this->_que_tbl_loan_settings();
		$query = $this->db->get();
		return $query->num_rows();
	}

	//LOAN LIST OBJECT
	private function _que_tbl_loan_list(){
		$this->db->from($this->tblLoanList);
		$this->db->where('is_deleted', '0');
		if ($this->input->post('id')) {
			$this->db->where('members_id', $this->input->post('id'));
		}
		$i = 0;
		foreach ($this->tblLoanListCollumn as $item) {
			if (!empty($_POST['search']['value'])) {
				if ($i === 0) {
					$this->db->like($item, strtolower($_POST['search']['value']));
					if ($this->input->post('id')) {
						$this->db->where('members_id', $this->input->post('id'));
					}
				}else{
					$this->db->or_like($item, strtolower($_POST['search']['value']));
					if ($this->input->post('id')) {
						$this->db->where('members_id', $this->input->post('id'));
					}
				}
			}
			$column[$i] = $item;
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->where('is_deleted', '0');
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}elseif($this->tblLoanListOrder){
			$this->db->where('is_deleted', '0');
			$order = $this->tblLoanListOrder;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$this->db->order_by('loan_computation_id', 'DESC');
	}

	public function get_output_loan_list(){
		$this->_que_tbl_loan_list();
		if (!empty($_POST['length']))
		$this->db->limit(($_POST['length'] < 0 ? 0 : $_POST['length']), $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all_loan_list(){
		$this->db->where('is_deleted', '0');
		$this->db->from($this->tblLoanList);
		return $this->db->count_all_results();
	}

	public function count_filter_loan_list(){
		$this->_que_tbl_loan_list();
		$query = $this->db->get();
		return $query->num_rows();
	}

	//LOAN BY MEMBER
	private function _que_tbl_loan_by_member(){
		$this->db->from($this->tblLoanByMember);
		$this->db->where('is_deleted', '0');
		if ($this->input->post('id')) {
			$this->db->where('members_id', $this->input->post('id'));
		}
		$i = 0;
		foreach ($this->tblLoanByMemberCollumn as $item) {
			if (!empty($_POST['search']['value'])) {
				if ($i === 0) {
					$this->db->like($item, strtolower($_POST['search']['value']));
					if ($this->input->post('id')) {
						$this->db->where('members_id', $this->input->post('id'));
					}
				}else{
					$this->db->or_like($item, strtolower($_POST['search']['value']));
					if ($this->input->post('id')) {
						$this->db->where('members_id', $this->input->post('id'));
					}
				}
			}
			$column[$i] = $item;
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->where('is_deleted', '0');
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}elseif($this->tblLoanByMemberOrder){
			$this->db->where('is_deleted', '0');
			$order = $this->tblLoanByMemberOrder;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$this->db->order_by('loan_computation_id', 'DESC');
	}

	public function get_output_loan_by_member(){
		$this->_que_tbl_loan_by_member();
		if (!empty($_POST['length']))
		$this->db->limit(($_POST['length'] < 0 ? 0 : $_POST['length']), $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all_loan_by_member(){
		$this->db->where('is_deleted', '0');
		$this->db->from($this->tblLoanByMember);
		return $this->db->count_all_results();
	}

	public function count_filter_loan_by_member(){
		$this->_que_tbl_loan_by_member();
		$query = $this->db->get();
		return $query->num_rows();
	}
	

	//LOAN BY REQUEST
	public function _que_tbl_loan_by_request(){
		$this->db->from($this->tblLoanByRequest);
		$this->db->where('is_deleted', '0');
		if ($this->input->post('id')) {
			$this->db->where('members_id', $this->input->post('id'));
		}
		if (isset($_POST['flag'])) {
			$this->db->where('status', $this->input->post('flag'));
		}
		$i = 0;
		foreach ($this->tblLoanByRequestCollumn as $item) {
			if (!empty($_POST['search']['value'])) {
				if ($i === 0) {
					$this->db->like($item, strtolower($_POST['search']['value']));
					if ($this->input->post('id')) {
						$this->db->where('members_id', $this->input->post('id'));
					}
					if (isset($_POST['flag'])) {
						$this->db->where('status', $this->input->post('flag'));
					}
				}else{
					$this->db->or_like($item, strtolower($_POST['search']['value']));
					if ($this->input->post('id')) {
						$this->db->where('members_id', $this->input->post('id'));
					}
					if (isset($_POST['flag'])) {
						$this->db->where('status', $this->input->post('flag'));
					}
				}
			}
			$column[$i] = $item;
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->where('is_deleted', '0');
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}elseif($this->tblLoanByRequestOrder){
			$this->db->where('is_deleted', '0');
			$order = $this->tblLoanByRequestOrder;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$this->db->order_by('loan_request_id', 'DESC');
	}

	public function get_output_loan_by_request(){
		$this->_que_tbl_loan_by_request();
		if (!empty($_POST['length']))
		$this->db->limit(($_POST['length'] < 0 ? 0 : $_POST['length']), $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all_loan_by_request(){
		$this->db->where('is_deleted', '0');
		$this->db->from($this->tblLoanByRequest);
		return $this->db->count_all_results();
	}

	public function count_filter_loan_by_request(){
		$this->_que_tbl_loan_by_request();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	//BENEFIT BY REQUEST
	private function _que_tbl_benefit_by_request(){
		$this->db->from($this->tblBenefitByRequest);
		$this->db->where('is_deleted', '0');
		if ($this->input->post('id')) {
			$this->db->where('members_id', $this->input->post('id'));
		}
		if (isset($_POST['flag'])) {
			$this->db->where('status', $this->input->post('flag'));
		}
		$i = 0;
		foreach ($this->tblBenefitByRequestCollumn as $item) {
			if (!empty($_POST['search']['value'])) {
				if ($i === 0) {
					$this->db->like($item, strtolower($_POST['search']['value']));
					if ($this->input->post('id')) {
						$this->db->where('members_id', $this->input->post('id'));
					}
					if (isset($_POST['flag'])) {
						$this->db->where('status', $this->input->post('flag'));
					}
				}else{
					$this->db->or_like($item, strtolower($_POST['search']['value']));
					if ($this->input->post('id')) {
						$this->db->where('members_id', $this->input->post('id'));
					}
					if (isset($_POST['flag'])) {
						$this->db->where('status', $this->input->post('flag'));
					}
				}
			}
			$column[$i] = $item;
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->where('is_deleted', '0');
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}elseif($this->tblBenefitByRequestOrder){
			$this->db->where('is_deleted', '0');
			$order = $this->tblBenefitByRequestOrder;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$this->db->order_by('benefit_request_id', 'DESC');
	}

	public function get_output_benefit_by_request(){
		$this->_que_tbl_benefit_by_request();
		if (!empty($_POST['length']))
		$this->db->limit(($_POST['length'] < 0 ? 0 : $_POST['length']), $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all_benefit_by_request(){
		$this->db->where('is_deleted', '0');
		$this->db->from($this->tblBenefitByRequest);
		return $this->db->count_all_results();
	}

	public function count_filter_benefit_by_request(){
		$this->_que_tbl_benefit_by_request();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	//LOAN REQUEST ATTCHMNT
	public function _que_tbl_loan_attmnt_request(){
		$this->db->from($this->tblLoanAttchmntRequest);
		if ($this->input->post('loan_req_id')) {
			$this->db->where('loan_request_id', $this->input->post('loan_req_id'));
		}
		if ($this->input->post('benefit_req_id')) {
			$this->db->where('benefit_request_id', $this->input->post('benefit_req_id'));
		}
		$i = 0;
		foreach ($this->tblLoanAttchmntRequestCollumn as $item) {
			if (!empty($_POST['search']['value'])) {
				if ($i === 0) {
					$this->db->like($item, strtolower($_POST['search']['value']));
					if ($this->input->post('loan_req_id')) {
						$this->db->where('loan_request_id', $this->input->post('loan_req_id'));
					}
					if ($this->input->post('benefit_req_id')) {
						$this->db->where('benefit_request_id', $this->input->post('benefit_req_id'));
					}
				}else{
					$this->db->or_like($item, strtolower($_POST['search']['value']));
					if ($this->input->post('loan_req_id')) {
						$this->db->where('loan_request_id', $this->input->post('loan_req_id'));
					}
					if ($this->input->post('benefit_req_id')) {
						$this->db->where('benefit_request_id', $this->input->post('benefit_req_id'));
					}
				}
			}
			$column[$i] = $item;
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}elseif($this->tblLoanAttchmntRequestOrder) {
			$order = $this->tblLoanAttchmntRequestOrder;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$this->db->order_by('portal_uploads_id', 'DESC');
	}

	public function get_output_loan_attmnt_request(){
		$this->_que_tbl_loan_attmnt_request();
		if (!empty($_POST['length']))
		$this->db->limit(($_POST['length'] < 0 ? 0 : $_POST['length']), $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all_loan_attmnt_request(){
		$this->db->from($this->tblLoanAttchmntRequest);
		return $this->db->count_all_results();
	}

	public function count_filter_loan_attmnt_request(){
		$this->_que_tbl_loan_attmnt_request();
		$query = $this->db->get();
		return $query->num_rows();
	}

	//CO-MAKER
	private function _que_tbl_co_maker(){
		$this->db->from($this->tblLoanByCoMaker);
		$this->db->where('is_deleted', '0');
		if ($this->input->post('id')) {
			$this->db->where('members_id', $this->input->post('id'));
		}
		$i = 0;
		foreach ($this->tblLoanByCoMakerCollumn as $item) {
			if (!empty($_POST['search']['value'])) {
				if ($i === 0) {
					$this->db->like($item, strtolower($_POST['search']['value']));
					if ($this->input->post('id')) {
						$this->db->where('members_id', $this->input->post('id'));
					}
				}else{
					$this->db->or_like($item, strtolower($_POST['search']['value']));
					if ($this->input->post('id')) {
						$this->db->where('members_id', $this->input->post('id'));
					}
				}
			}
			$column[$i] = $item;
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->where('is_deleted', '0');
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}elseif($this->tblLoanByCoMakerOrder){
			$this->db->where('is_deleted', '0');
			$order = $this->tblLoanByCoMakerOrder;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$this->db->order_by('members_id', 'DESC');
	}

	public function get_output_co_maker(){
		$this->_que_tbl_co_maker();
		if (!empty($_POST['length']))
		$this->db->limit(($_POST['length'] < 0 ? 0 : $_POST['length']), $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all_co_maker(){
		$this->db->where('is_deleted', '0');
		$this->db->from($this->tblLoanByCoMaker);
		return $this->db->count_all_results();
	}

	public function count_filter_co_maker(){
		$this->_que_tbl_co_maker();
		$query = $this->db->get();
		return $query->num_rows();
	}

	/**
    * Function print tcpdf
    */
  function pdf($html, $download_filename, $orientation = 'P', 
  								$page_format = 'LETTER', $with_full_page_background = false, 
  										$image_background = null, $with_page_no = true, $title = '', $font_fam) {
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $page_format, true, 'UTF-8', false);
    $pdf->pixelsToUnits(8);
    $pdf->setPrintHeader(false);
    // $pdf->setPrintFooter(false);
    $pdf->SetMargins(10, 5, 10, true);
    $pdf->AddPage($orientation);
    $pdf->SetAutoPageBreak(TRUE, 20);
    $pdf->SetFont($font_fam, '', 12, false);
    if ($with_page_no) {
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    }
    $pdf->setFooterFont(array('', '', 15));
    if ($with_full_page_background) {
      // get the current page break margin
      $bMargin = $pdf->getBreakMargin();
      // get current auto-page-break mode
      $auto_page_break = $pdf->getAutoPageBreak();
      // disable auto-page-break
      $pdf->SetAutoPageBreak(false, '');
      // set background image
      // $img_file = base_url($image_background);
      $img_file = $image_background;
      $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
    }
    // $pdf->SetHeaderData(false, false, 'Balance Sheet', false);
    // $pdf->SetTopMargin(55);
    $pdf->setTitle($title);
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->SetY(-15);
    // filename
    $pdf->Output($download_filename.'.pdf', 'I');
  }


	/**
    * Function print tcpdf
    */
  function pdfQR($html, $download_filename, $orientation = 'P', $page_format = 'LETTER', $with_full_page_background = false, $image_background = null, $with_page_no = true, $title = '', $font_fam, $hasQr = false, $qrApiLink = null, $formatSize = 'A4', $decIDs = false) {
  	// require_once('tcpdf_include.php');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $page_format, true, 'UTF-8', false);
    $pdf->pixelsToUnits(8);
    $pdf->setPrintHeader(false);	
    // $pdf->setPrintFooter(false);
    $pdf->SetMargins(2, 5, 10, true);
    
    $pdf->SetAutoPageBreak(TRUE, 20);
    $pdf->SetFont($font_fam, '', 12, false);
    if ($with_page_no) {
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    }
    $pdf->setFooterFont(array('', '', 15));
    if ($with_full_page_background) {
      // get the current page break margin
      $bMargin = $pdf->getBreakMargin();
      // get current auto-page-break mode
      $auto_page_break = $pdf->getAutoPageBreak();
      // disable auto-page-break
      $pdf->SetAutoPageBreak(false, 0);
      // set background image
      // $img_file = base_url($image_background);
      $img_file = $image_background;
      // $pdf->Image($img_file, 0, 0, 0, 0, '', '', '', false, 100, '', false, false, 0);
    }
    // $pdf->SetHeaderData(false, false, 'Balance Sheet', false);
    // $pdf->SetTopMargin(55);
    $pdf->setTitle($title);
    if (is_array($html)) {
    	for ($i=0; $i < count($html); $i++) { 
    		$pdf->AddPage($orientation, $formatSize);
		    $pdf->Image($img_file, 0, 0, 0, 0, '', '', '', false, 100, '', false, false, 0);
		    $pdf->writeHTML($html[$i], true, false, true, false, '');
		    if ($hasQr) {
			    // set style for barcode
					$style = array(
				    'border' 				=> 2,
				    'vpadding' 			=> 'auto',
				    'hpadding' 			=> 'auto',
				    'fgcolor' 			=> array(0,0,0),
				    'bgcolor' 			=> false, //array(255,255,255)
				    'module_width' 	=> 1, // width of a single module in points
				    'module_height' => 1 // height of a single module in points
					);
			    // QRCODE,L : QR-CODE Low error correction
			    $hashedIDs = $this->encdec($decIDs[$i], 'e');
					$pdf->write2DBarcode($hashedIDs, 'QRCODE,L', 110, 50, 70, 100, $style, 'N');
					$pdf->Text(109, 43.7, '');

			  }
    	}
    } else {
    	$pdf->AddPage($orientation, $formatSize);
    	$pdf->Image($img_file, 0, 0, 0, 0, '', '', '', false, 100, '', false, false, 0);
    	$pdf->writeHTML($html, true, false, true, false, '');
    	if ($hasQr) {
		    // set style for barcode
				$style = array(
			    'border' 				=> 2,
			    'vpadding' 			=> 'auto',
			    'hpadding' 			=> 'auto',
			    'fgcolor' 			=> array(0,0,0),
			    'bgcolor' 			=> false, //array(255,255,255)
			    'module_width' 	=> 1, // width of a single module in points
			    'module_height' => 1 // height of a single module in points
				);
		    // QRCODE,L : QR-CODE Low error correction
				$pdf->write2DBarcode($qrApiLink, 'QRCODE,L', 110, 50, 70, 100, $style, 'N');
				$pdf->Text(109, 43.7, '');

		  }
    }
    $pdf->SetY(-15);
    // filename
    $pdf->Output($download_filename.'.pdf', 'I');
  }

  public function getMembersRecord($id){
  	$q = $this->db->query("SELECT * from v_members vm
														WHERE vm.members_id = $id");
  	return $q->result();
  }

  function encdec( $string, $action) {
    // you may change these values to your own
    $secret_key = '5ad44e8a7dc00132ea2c93add9aefadb';
    $secret_iv = '5ad44e8a7dc00132ea2c93add9aefadb';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
    return $output;
  }

  function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}

	public function primaryKey($pkey){
		$q 				 = $this->db->get('identifiers')->row();
		$val 			 = intval($q->$pkey) + 1;
		$resultKey = str_pad($val, 8, '0', STR_PAD_LEFT);
		return $resultKey;
	}

	public function refKey($j_type_id){
		$q 				 = $this->db->get_where('j_type', array('j_type_id'=>$j_type_id))->row();
		$val 			 = intval($q->ref) + 1;
		$resultKey = $q->type . '-' . str_pad($val, 8, '0', STR_PAD_LEFT);
		return $resultKey;
	}

	public function getMembersContributionPortal($members_id){
		$q=$this->db->query("SELECT c.*, m.last_name, m.first_name, m.middle_name, m.office_management_id, m.id_no, om.office_name
													FROM contributions c 
													left join members m on m.members_id = c.members_id
													left join office_management om on om.office_management_id = m.office_management_id
													WHERE c.members_id='$members_id'")->result();
		return $q;
	}
	
	public function getMembersContribution($sd, $ed, $members_id){
		$q=$this->db->query("SELECT c.*, m.last_name, m.first_name, m.middle_name, m.office_management_id, m.id_no, om.office_name
													FROM contributions c 
													left join members m on m.members_id = c.members_id
													left join office_management om on om.office_management_id = m.office_management_id
													WHERE c.members_id='$members_id' AND date_applied BETWEEN CAST('$sd' AS DATE) AND CAST('$ed' AS DATE)")->result();
		return $q;
	}

	public function getOfficeContribution($sd, $ed, $office_management_id){
		$q=$this->db->query("SELECT c.*, m.last_name, m.first_name, m.middle_name, m.office_management_id, m.id_no, om.office_name
													FROM contributions c 
													left join members m on m.members_id = c.members_id
													left join office_management om on om.office_management_id = m.office_management_id
													WHERE m.office_management_id = $office_management_id 
													AND date_applied BETWEEN CAST('$sd' AS DATE) AND CAST('$ed' AS DATE)")->result();
		return $q;
	}

	public function getCashGiftOfficePrint($sd, $ed, $office_management_id){
		$q=$this->db->query("SELECT cg.*, m.last_name, m.first_name, m.middle_name, m.office_management_id, m.id_no, om.office_name, d.region
													FROM cash_gift cg 
													left join members m on m.members_id = cg.members_id
													left join office_management om on om.office_management_id = m.office_management_id
													left join departments d on om.departments_id = d.departments_id
													WHERE m.office_management_id = $office_management_id 
													AND date_applied BETWEEN CAST('$sd' AS DATE) AND CAST('$ed' AS DATE)")->result();
		return $q;
	}

	public function getCashGiftDeptPrint($sd, $ed, $dept_type){
		$q=$this->db->query("SELECT cg.*, m.last_name, m.first_name, m.middle_name, m.office_management_id, m.id_no, om.office_name, d.region
													FROM cash_gift cg 
													left join members m on m.members_id = cg.members_id
													left join office_management om on om.office_management_id = m.office_management_id
													left join departments d on om.departments_id = d.departments_id
													WHERE d.place = '$dept_type' 
													AND date_applied BETWEEN CAST('$sd' AS DATE) AND CAST('$ed' AS DATE)")->result();
		return $q;
	}

	public function getCashGiftMembersPrint($sd, $ed, $members_id){
		$q=$this->db->query("SELECT cg.*, m.last_name, m.first_name, m.middle_name, m.office_management_id, m.id_no, om.office_name, d.region
													FROM cash_gift cg 
													left join members m on m.members_id = cg.members_id
													left join office_management om on om.office_management_id = m.office_management_id
													left join departments d on om.departments_id = d.departments_id
													WHERE m.members_id = '$members_id' 
													AND date_applied BETWEEN CAST('$sd' AS DATE) AND CAST('$ed' AS DATE)")->result();
		return $q;
	}

	public function getLoansPayment($sd, $ed, $members_id){
		$q=$this->db->query("SELECT ls.payment_schedule, lr.date_paid, lr.orno, lr.amnt_paid, 
													(COALESCE(ls.monthly_amortization, 0) - COALESCE(lr.amnt_paid, 0)) as balance,
													m.last_name, m.first_name, m.middle_name, om.office_name, m.id_no
													FROM loan_schedule ls 
													LEFT JOIN loan_receipt lr on lr.loan_schedule_id = ls.loan_schedule_id
													left join loan_computation lc on lc.loan_computation_id = ls.loan_computation_id 
													left join members m on m.members_id = lc.members_id 
													left join office_management om on om.office_management_id = m.office_management_id
													WHERE m.members_id = '$members_id'")->result();
		return $q;
	}

	public function getTotalContributionByRegion($departments_id, $date){
		$q=$this->db->query("SELECT sum(coalesce(c.deduction, 0)) as total
													FROM contributions c 
													left join members m on m.members_id = c.members_id
													left join office_management om on om.office_management_id = m.office_management_id
													left join departments d on om.departments_id = d.departments_id
													WHERE d.departments_id = '$departments_id' 
													AND DATE_FORMAT(c.date_applied,'%Y-%m') = '$date'")->row();
		return $q;
	}

	public function getBalanceByMember($members_id){
		$q=$this->db->query("SELECT members_id, sum(coalesce(amnt_of_loan,0)) - sum(coalesce(tot_amount_paid,0)) as balance 
													FROM v_balance WHERE members_id = '$members_id' group by members_id")->row();
		return $q;
	}

	public function getLoanSettings($loanSettingsID){
		$q=$this->db->query("SELECT ls.*, ld.loan_code FROM loan_settings ls 
													LEFT JOIN loan_code ld ON ld.loan_code_id = ls.loan_code_id 
													WHERE loan_settings_id = $loanSettingsID");
		return $q->row();
	}

	public function getTrialBalance($sd, $ed){
		return $this->db->query("SELECT 
															x.id, 
															x.parent_id, 
															x.class_desc, 
															x.group_desc, 
															x.main_desc, 
															sum(x.debit) AS debit, 
															sum(x.credit) AS credit 
															FROM v_trial_balance  x WHERE x.journal_date BETWEEN '$sd' AND '$ed' OR x.journal_date is NULL 
															GROUP BY x.class_desc, x.main_desc, x.group_desc ORDER BY 1, 2 DESC")->result();
	}

	public function getBsAssets($sd, $ed){
		return $this->db->query("SELECT 
															x.id, 
															x.parent_id, 
															x.class_desc, 
															x.group_desc, 
															x.main_desc, 
															(case when x.normal_bal = 'Dr' then 
																	sum(x.debit - x.credit)
																when x.normal_bal = 'Cr' then
																	sum(x.credit - x.debit)
																else 
																	null
															end) AS amount
															FROM v_bs_assets  x WHERE x.journal_date BETWEEN '$sd' AND '$ed' OR x.journal_date is NULL 
															GROUP BY x.class_desc, x.main_desc, x.group_desc ORDER BY 1, 2 DESC")->result();
	}

	public function getBsLiabilities($sd, $ed){
		return $this->db->query("SELECT 
															x.id, 
															x.parent_id, 
															x.class_desc, 
															x.group_desc, 
															x.main_desc, 
															(case when x.normal_bal = 'Dr' then 
																	sum(x.debit - x.credit)
																when x.normal_bal = 'Cr' then
																	sum(x.credit - x.debit)
																else 
																	null
															end) AS amount
															FROM v_bs_liabilities x WHERE x.journal_date BETWEEN '$sd' AND '$ed' OR x.journal_date is NULL 
															GROUP BY x.class_desc, x.main_desc, x.group_desc ORDER BY 1, 2 DESC")->result();
	}

	public function getIsIncomeExpense($sd, $ed){
		return $this->db->query("SELECT 
															x.id, 
															x.parent_id, 
															x.class_desc, 
															x.group_desc, 
															x.main_desc, 
															(case when x.normal_bal = 'Dr' then 
																	sum(x.debit - x.credit)
																when x.normal_bal = 'Cr' then
																	sum(x.credit - x.debit)
																else 
																	null
															end) AS amount
															FROM v_is_income_expense x WHERE x.journal_date BETWEEN '$sd' AND '$ed' OR x.journal_date is NULL 
															GROUP BY x.class_desc, x.main_desc, x.group_desc ORDER BY 1, 2 DESC")->result();
	}

	public function getJmCrj($sd, $ed){
		return $this->db->query("SELECT * FROM v_crj_report WHERE journal_date between '$sd' AND '$ed'")->result();
	}
	
	public function getJmPacs($sd, $ed){
		return $this->db->query("SELECT
																jm.j_master_id as j_master_id,
																jm.j_type_id as j_type_id,
																m.bank_account as account_no,
																jm.journal_ref as journal_ref,
																jm.check_voucher_no as check_voucher_no,
																jm.check_no as check_no,
																jm.reference_no as reference_no,
																jm.payee_type as payee_type,
																jm.payee_members_id as payee_members_id,
																jm.payee as payee,
																concat(m.last_name, ', ', m.first_name, ' ', m.middle_name) as payee_member,
																om.office_name as official_station,
																lc.col_period_start,
																lc.col_period_end,
																lc.monthly_amortization as monthly_amortization,
																jm.date_posted as date_posted,
																jm.journal_date,
																sum(case when jd.acct_code = '101' then coalesce(jd.credit, 0) else 0 end) as cash_on_hand_credit,
																sum(case when jd.acct_code = '102' then coalesce(jd.credit, 0) else 0 end) as cash_in_bank_lbp_credit,
																sum(case when jd.acct_code = '104' then coalesce(jd.credit, 0) else 0 end) as cash_in_bank_mbtc_credit,
																sum(case when jd.acct_code = '201' then coalesce(jd.credit, 0) else 0 end) as unearned_interest_credit,
																sum(case when jd.acct_code = '500' then coalesce(jd.credit, 0) else 0 end) as interest_income_credit,
																sum(case when jd.acct_code = '200' then coalesce(jd.credit, 0) else 0 end) as deferred_credits_credit,
																sum(case when jd.acct_code = '301' then coalesce(jd.credit, 0) else 0 end) as lri_credit,
																sum(case when jd.acct_code = '108' then coalesce(jd.credit, 0) else 0 end) as loan_receivable_credit,
																sum(case when jd.acct_code = '500' then coalesce(jd.credit, 0) else 0 end) as interest_credit,
																sum(case when jd.acct_code = '501' then coalesce(jd.credit, 0) else 0 end) as service_charge_credit,
																sum(case when jd.acct_code = '108' then coalesce(jd.debit, 0) else 0 end) as loan_receivable_debit,
																sum(case when jd.acct_code = '500' then coalesce(jd.debit, 0) else 0 end) as interest_income_debit,
																sum(case when jd.acct_code = '200' then coalesce(jd.debit, 0) else 0 end) as deferred_credits_debit,
																sum(case when jd.acct_code = '202' then coalesce(jd.debit, 0) else 0 end) as benefit_claim_debit,
																sum(case when jd.acct_code = '300' then coalesce(jd.debit, 0) else 0 end) as members_contribution_debit,
																case
																		when (jd.subsidiary <> ''
																		and coalesce(jd.credit, 0) > 0) then am.main_desc
																		else null
																end as sundry_accounts_credit,
																sum(case when jd.subsidiary <> '' then coalesce(jd.credit, 0) else 0 end) as sundry_amount_credit,
																case
																		when (jd.subsidiary <> ''
																		and coalesce(jd.debit, 0) > 0) then am.main_desc
																		else null
																end as sundry_accounts_debit,
																sum(case when jd.subsidiary <> '' then coalesce(jd.debit, 0) else 0 end) as sundry_amount_debit,
																GROUP_CONCAT(distinct concat(ucase(m2.last_name), ', ', ucase(m2.first_name), ' ', ucase(m2.middle_name)), '|') as comaker,
																jm.particulars as remarks
														from cpfidb.j_master jm 
														left join cpfidb.j_details jd on jd.j_master_id = jm.j_master_id
														left join cpfidb.account_subsidiary asb on asb.sub_code = jd.subsidiary
														left join cpfidb.account_main am on am.code = asb.code
														left join loan_computation lc on lc.ref_no = jm.reference_no
														left join members m on m.members_id = lc.members_id
														left join office_management om on om.office_management_id = m.office_management_id
														left join co_maker cmkr on cmkr.members_id = m.members_id
														left join members m2 on m2.members_id = cmkr.co_maker_members_id
														where jm.j_type_id = 4 and jm.date_posted is not null and jm.journal_date between CAST('$sd' AS DATE) AND CAST('$ed' AS DATE)
														group by jm.journal_ref")->result();
	}
	
	public function getJmCdj($sd, $ed){
		return $this->db->query("SELECT
																jm.j_master_id as j_master_id,
																jm.j_type_id as j_type_id,
																null as account_no,
																jm.journal_ref as journal_ref,
																jm.check_voucher_no as check_voucher_no,
																jm.check_no as check_no,
																jm.reference_no as reference_no,
																jm.payee_type as payee_type,
																jm.payee_members_id as payee_members_id,
																jm.payee as payee,
																null as payee_member,
																null as official_station,
																null as col_period_start,
																null as col_period_end,
																null as monthly_amortization,
																jm.date_posted as date_posted,
																jm.journal_date,
																sum(case when jd.acct_code = '101' then coalesce(jd.credit, 0) else 0 end) as cash_on_hand_credit,
																sum(case when jd.acct_code = '102' then coalesce(jd.credit, 0) else 0 end) as cash_in_bank_lbp_credit,
																sum(case when jd.acct_code = '104' then coalesce(jd.credit, 0) else 0 end) as cash_in_bank_mbtc_credit,
																sum(case when jd.acct_code = '201' then coalesce(jd.credit, 0) else 0 end) as unearned_interest_credit,
																sum(case when jd.acct_code = '500' then coalesce(jd.credit, 0) else 0 end) as interest_income_credit,
																sum(case when jd.acct_code = '200' then coalesce(jd.credit, 0) else 0 end) as deferred_credits_credit,
																sum(case when jd.acct_code = '301' then coalesce(jd.credit, 0) else 0 end) as lri_credit,
																sum(case when jd.acct_code = '108' then coalesce(jd.credit, 0) else 0 end) as loan_receivable_credit,
																sum(case when jd.acct_code = '500' then coalesce(jd.credit, 0) else 0 end) as interest_credit,
																sum(case when jd.acct_code = '501' then coalesce(jd.credit, 0) else 0 end) as service_charge_credit,
																sum(case when jd.acct_code = '108' then coalesce(jd.debit, 0) else 0 end) as loan_receivable_debit,
																sum(case when jd.acct_code = '500' then coalesce(jd.debit, 0) else 0 end) as interest_income_debit,
																sum(case when jd.acct_code = '200' then coalesce(jd.debit, 0) else 0 end) as deferred_credits_debit,
																sum(case when jd.acct_code = '202' then coalesce(jd.debit, 0) else 0 end) as benefit_claim_debit,
																sum(case when jd.acct_code = '300' then coalesce(jd.debit, 0) else 0 end) as members_contribution_debit,
																case
																		when (jd.subsidiary <> ''
																		and coalesce(jd.credit, 0) > 0) then am.main_desc
																		else null
																end as sundry_accounts_credit,
																sum(case when jd.subsidiary <> '' then coalesce(jd.credit, 0) else 0 end) as sundry_amount_credit,
																case
																		when (jd.subsidiary <> ''
																		and coalesce(jd.debit, 0) > 0) then am.main_desc
																		else null
																end as sundry_accounts_debit,
																sum(case when jd.subsidiary <> '' then coalesce(jd.debit, 0) else 0 end) as sundry_amount_debit,
																null as comaker,
																jm.particulars as remarks
														from cpfidb.j_master jm 
														left join cpfidb.j_details jd on jd.j_master_id = jm.j_master_id
														left join cpfidb.account_subsidiary asb on asb.sub_code = jd.subsidiary
														left join cpfidb.account_main am on am.code = asb.code
														left join loan_computation lc on lc.ref_no = jm.reference_no
														left join members m on m.members_id = lc.members_id
														left join office_management om on om.office_management_id = m.office_management_id
														left join co_maker cmkr on cmkr.members_id = m.members_id
														left join members m2 on m2.members_id = cmkr.co_maker_members_id
														where jm.j_type_id = 3 and jm.date_posted is not null and jm.journal_date between CAST('$sd' AS DATE) AND CAST('$ed' AS DATE)
														group by jm.journal_ref")->result();
	}
	
	public function getJmGj($sd, $ed){
		return $this->db->query("SELECT
																jm.j_master_id as j_master_id,
																jm.j_type_id as j_type_id,
																null as account_no,
																jm.journal_ref as journal_ref,
																jm.check_voucher_no as check_voucher_no,
																jm.check_no as check_no,
																jm.reference_no as reference_no,
																jm.payee_type as payee_type,
																jm.payee_members_id as payee_members_id,
																jm.payee as payee,
																null as payee_member,
																null as official_station,
																null as col_period_start,
																null as col_period_end,
																null as monthly_amortization,
																jm.date_posted as date_posted,
																jm.journal_date,
																sum(case when jd.acct_code = '101' then coalesce(jd.credit, 0) else 0 end) as cash_on_hand_credit,
																sum(case when jd.acct_code = '102' then coalesce(jd.credit, 0) else 0 end) as cash_in_bank_lbp_credit,
																sum(case when jd.acct_code = '104' then coalesce(jd.credit, 0) else 0 end) as cash_in_bank_mbtc_credit,
																sum(case when jd.acct_code = '201' then coalesce(jd.credit, 0) else 0 end) as unearned_interest_credit,
																sum(case when jd.acct_code = '500' then coalesce(jd.credit, 0) else 0 end) as interest_income_credit,
																sum(case when jd.acct_code = '200' then coalesce(jd.credit, 0) else 0 end) as deferred_credits_credit,
																sum(case when jd.acct_code = '301' then coalesce(jd.credit, 0) else 0 end) as lri_credit,
																sum(case when jd.acct_code = '108' then coalesce(jd.credit, 0) else 0 end) as loan_receivable_credit,
																sum(case when jd.acct_code = '500' then coalesce(jd.credit, 0) else 0 end) as interest_credit,
																sum(case when jd.acct_code = '501' then coalesce(jd.credit, 0) else 0 end) as service_charge_credit,
																sum(case when jd.acct_code = '108' then coalesce(jd.debit, 0) else 0 end) as loan_receivable_debit,
																sum(case when jd.acct_code = '500' then coalesce(jd.debit, 0) else 0 end) as interest_income_debit,
																sum(case when jd.acct_code = '200' then coalesce(jd.debit, 0) else 0 end) as deferred_credits_debit,
																sum(case when jd.acct_code = '202' then coalesce(jd.debit, 0) else 0 end) as benefit_claim_debit,
																sum(case when jd.acct_code = '300' then coalesce(jd.debit, 0) else 0 end) as members_contribution_debit,
																case
																		when (jd.subsidiary <> ''
																		and coalesce(jd.credit, 0) > 0) then am.main_desc
																		else null
																end as sundry_accounts_credit,
																sum(case when jd.subsidiary <> '' then coalesce(jd.credit, 0) else 0 end) as sundry_amount_credit,
																case
																		when (jd.subsidiary <> ''
																		and coalesce(jd.debit, 0) > 0) then am.main_desc
																		else null
																end as sundry_accounts_debit,
																sum(case when jd.subsidiary <> '' then coalesce(jd.debit, 0) else 0 end) as sundry_amount_debit,
																null as comaker,
																jm.particulars as remarks
														from cpfidb.j_master jm 
														left join cpfidb.j_details jd on jd.j_master_id = jm.j_master_id
														left join cpfidb.account_subsidiary asb on asb.sub_code = jd.subsidiary
														left join cpfidb.account_main am on am.code = asb.code
														left join loan_computation lc on lc.ref_no = jm.reference_no
														left join members m on m.members_id = lc.members_id
														left join office_management om on om.office_management_id = m.office_management_id
														left join co_maker cmkr on cmkr.members_id = m.members_id
														left join members m2 on m2.members_id = cmkr.co_maker_members_id
														where jm.j_type_id = 5 and jm.date_posted is not null and jm.journal_date between CAST('$sd' AS DATE) AND CAST('$ed' AS DATE)
														group by jm.journal_ref")->result();
	}

	public function getContLoanPymnts($sd, $ed, $type){
		// return $this->db->query("SELECT * FROM v_contribution_and_payments WHERE date_applied between '$sd' AND '$ed' OR date_applied is null")->result();
		return $this->db->query("SELECT * FROM (select
																om.office_management_id as ofc_id,
																om.office_name as parent_ofc,
																om.office_name as office_name,
																null as parent_mem,
																null as members_name,
																null as designation,
																null as sg,
																null as monthly_salary,
																null as cont_date,
																null as deduction,
																null as adjusted_amnt,
																null as total_cont,
																null as ref_no,
																null as collection_period,
																null as gpln,
																null as gpln_lr,
																null as gpln_ir,
																null as emln,
																null as emln_lr,
																null as emln_ir,
																null as slmv,
																null as slmv_lr,
																null as slmv_ir,
																null as adj_loans,
																null as total,
																null as total_deduction,
																null as remarks,
																null as date_applied,
																d.place
															from cpfidb.members m
															left join cpfidb.office_management om on m.office_management_id = om.office_management_id
															left join cpfidb.contributions cont on cont.members_id = m.members_id
															left join cpfidb.loan_computation lc on lc.members_id = m.members_id
															left join cpfidb.v_balance vb on vb.loan_computation_id = lc.loan_computation_id
															left join cpfidb.departments d on d.departments_id = om.departments_id
															WHERE cont.date_applied between '$sd' AND '$ed'
															group by lc.ref_no
															union
															select
																om.office_management_id as ofc_id,
																null as parent_ofc,
																om.office_name as office_name,
																concat(m.last_name, ', ', m.first_name, ' ', m.middle_name) as parent_mem,
																concat(m.last_name, ', ', m.first_name, ' ', m.middle_name) as members_name,
																m.designation,
																m.salary_grade as sg,
																null as monthly_salary,
																null as cont_date,
																null as deduction,
																null as adjusted_amnt,
																null as total_cont,
																null as ref_no,
																null as collection_period,
																null as gpln,
																null as gpln_lr,
																null as gpln_ir,
																null as emln,
																null as emln_lr,
																null as emln_ir,
																null as slmv,
																null as slmv_lr,
																null as slmv_ir,
																null as adj_loans,
																null as total,
																null as total_deduction,
																null as remarks,
																null as date_applied,
																d.place
															from cpfidb.members m 
															left join cpfidb.office_management om on m.office_management_id = om.office_management_id
															left join cpfidb.contributions cont on cont.members_id = m.members_id
															left join cpfidb.loan_computation lc on lc.members_id = m.members_id
															left join cpfidb.v_balance vb on vb.loan_computation_id = lc.loan_computation_id
															left join cpfidb.departments d on d.departments_id = om.departments_id
															WHERE cont.date_applied between '$sd' AND '$ed'
															group by lc.ref_no
															union
															select
																om.office_management_id as ofc_id,
																null as parent_ofc,
																om.office_name as office_name,
																concat(m.last_name, ', ', m.first_name, ' ', m.middle_name) as parent_mem,
																null as members_name,
																null as designation,
																null as sg,
																m.monthly_salary as monthly_salary,
																date_format(cont.date_applied, '%Y-%m') as cont_date,
																sum(coalesce(cont.deduction, 0)) as deduction,
																sum(coalesce(cont.adjusted_amnt, 0)) as adjusted_amnt,
																sum(coalesce(cont.deduction, 0)) + sum(coalesce(cont.adjusted_amnt, 0)) as total_cont,
																lc.ref_no as ref_no,
																concat(vb.col_period_start, ' to ', vb.col_period_end) as collection_period,
																case
																		when vb.loan_type_name = 'GPLN' then vb.tot_amount_paid
																		else 0
																end as gpln,
																case
																		when vb.loan_type_name = 'GPLN' then vb.tot_principal - vb.tot_amount_paid
																		else 0
																end as gpln_lr,
																case
																		when vb.loan_type_name = 'GPLN' then vb.tot_monthly_interest - vb.tot_interest_paid
																		else 0
																end as gpln_ir,
																case
																		when vb.loan_type_name = 'EMLN' then vb.tot_amount_paid
																		else 0
																end as emln,
																case
																		when vb.loan_type_name = 'EMLN' then vb.tot_principal - vb.tot_amount_paid
																		else 0
																end as emln_lr,
																case
																		when vb.loan_type_name = 'EMLN' then vb.tot_monthly_interest - vb.tot_interest_paid
																		else 0
																end as emln_ir,
																case
																		when vb.loan_type_name = 'SLMV' then vb.tot_amount_paid
																		else 0
																end as slmv,
																case
																		when vb.loan_type_name = 'SLMV' then vb.tot_principal - vb.tot_amount_paid
																		else 0
																end as slmv_lr,
																case
																		when vb.loan_type_name = 'SLMV' then vb.tot_monthly_interest - vb.tot_interest_paid
																		else 0
																end as slmv_ir,
																null as adj_loans,
																(case
																		when vb.loan_type_name = 'GPLN' then vb.tot_amount_paid
																		else 0
																end) +
																(case
																		when vb.loan_type_name = 'EMLN' then vb.tot_amount_paid
																		else 0
																end) +
																(case
																		when vb.loan_type_name = 'SLMV' then vb.tot_amount_paid
																		else 0
																end) as total,
																sum(coalesce(cont.deduction, 0)) + sum(coalesce(cont.adjusted_amnt, 0)) +
																case
																		when vb.loan_type_name = 'GPLN' then coalesce(vb.tot_amount_paid, 0)
																		else 0
																end +
																case
																		when vb.loan_type_name = 'EMLN' then coalesce(vb.tot_amount_paid, 0)
																		else 0
																end +
																case
																when vb.loan_type_name = 'SLMV' then coalesce(vb.tot_amount_paid, 0)
																		else 0
																end as total_deduction,
																max(cont.remarks) as remarks,
																max(cont.date_applied) as date_applied,
																d.place
															from cpfidb.members m
															left join cpfidb.office_management om on m.office_management_id = om.office_management_id
															left join cpfidb.contributions cont on cont.members_id = m.members_id
															left join cpfidb.loan_computation lc on lc.members_id = m.members_id
															left join cpfidb.v_balance vb on vb.loan_computation_id = lc.loan_computation_id
															left join cpfidb.departments d on d.departments_id = om.departments_id
															WHERE cont.date_applied between '$sd' AND '$ed'
															group by lc.ref_no
															union
															select
																om.office_management_id as ofc_id,
																null as parent_ofc,
																'TOTAL' as office_name,
																null as parent_mem,
																null as members_name,
																null as designation,
																null as sg,
																null as monthly_salary,
																null as cont_date,
																sum(cont.deduction) as deduction,
																sum(cont.adjusted_amnt) as adjusted_amnt,
																sum(coalesce(cont.deduction, 0)) + sum(coalesce(cont.adjusted_amnt, 0)) as total_cont,
																null as ref_no,
																null as collection_period,
																case
																	when vb.loan_type_name = 'GPLN' then (
																	select
																			sum(coalesce(vb2.tot_amount_paid , 0))
																	from
																			cpfidb.v_balance vb2
																	where
																			vb2.loan_type_name = vb.loan_type_name
																			and vb2.office_management_id = m.office_management_id)
																	else 0
																end as gpln,
																case
																	when vb.loan_type_name = 'GPLN' then (
																	select
																			sum(coalesce(vb2.tot_principal, 0)) - sum(coalesce(vb2.tot_amount_paid, 0))
																	from
																			cpfidb.v_balance vb2
																	where
																			vb2.loan_type_name = vb.loan_type_name
																			and vb2.office_management_id = m.office_management_id)
																	else 0
																end as gpln_lr,
																case
																	when vb.loan_type_name = 'GPLN' then (
																	select
																			sum(coalesce(vb2.tot_monthly_interest, 0)) - sum(coalesce(vb2.tot_interest_paid, 0))
																	from
																			cpfidb.v_balance vb2
																	where
																			vb2.loan_type_name = vb.loan_type_name
																			and vb2.office_management_id = m.office_management_id)
																	else 0
																end as gpln_ir,
																case
																	when vb.loan_type_name = 'EMLN' then (
																	select
																			sum(coalesce(vb2.tot_amount_paid, 0))
																	from
																			cpfidb.v_balance vb2
																	where
																			vb2.loan_type_name = vb.loan_type_name
																			and vb2.office_management_id = m.office_management_id)
																	else 0
																end as emln,
																(case
																	when vb.loan_type_name = 'EMLN' then (
																	select
																			sum(coalesce(vb2.tot_principal, 0)) - sum(coalesce(vb2.tot_amount_paid, 0))
																	from
																			cpfidb.v_balance vb2
																	where
																			vb2.loan_type_name = vb.loan_type_name
																			and vb2.office_management_id = m.office_management_id)
																	else 0
																end) as emln_lr,
																(case
																	when vb.loan_type_name = 'EMLN' then (
																	select
																			sum(coalesce(vb2.tot_monthly_interest, 0)) - sum(coalesce(vb2.tot_interest_paid, 0))
																	from
																			cpfidb.v_balance vb2
																	where
																			vb2.loan_type_name = vb.loan_type_name
																			and vb2.office_management_id = m.office_management_id)
																	else 0
																end) as emln_ir,
																case
																when vb.loan_type_name = 'SLMV' then (
																		select
																				sum(coalesce(vb2.tot_amount_paid, 0))
																		from
																				cpfidb.v_balance vb2
																		where
																				vb2.loan_type_name = vb.loan_type_name
																				and vb2.office_management_id = m.office_management_id)
																		else 0
																end as slmv,
																(case
																	when vb.loan_type_name = 'EMLN' then (
																	select
																			sum(coalesce(vb2.tot_principal, 0)) - sum(coalesce(vb2.tot_amount_paid, 0))
																	from
																			cpfidb.v_balance vb2
																	where
																			vb2.loan_type_name = vb.loan_type_name
																			and vb2.office_management_id = m.office_management_id)
																	else 0
																end) as slmv_lr,
																(case
																	when vb.loan_type_name = 'EMLN' then (
																	select
																			sum(coalesce(vb2.tot_monthly_interest, 0)) - sum(coalesce(vb2.tot_interest_paid, 0))
																	from
																			cpfidb.v_balance vb2
																	where
																			vb2.loan_type_name = vb.loan_type_name
																			and vb2.office_management_id = m.office_management_id)
																	else 0
																end) as slmv_ir,
																null as adj_loans,
																(select
																		sum(coalesce(vb2.tot_amount_paid, 0))
																from
																		cpfidb.v_balance vb2
																where
																		vb2.loan_type_name = vb.loan_type_name
																		and vb2.office_management_id = m.office_management_id) as total,
																sum(coalesce(cont.deduction, 0)) + sum(coalesce(cont.adjusted_amnt, 0)) + (
																select
																		sum(coalesce(vb2.tot_amount_paid, 0))
																from
																		cpfidb.v_balance vb2
																where
																		vb2.loan_type_name = vb.loan_type_name
																		and vb2.office_management_id = m.office_management_id) as total_deduction,
																null as remarks,
																max(cont.date_applied) as date_applied,
																d.place
															from cpfidb.members m
															left join cpfidb.office_management om on m.office_management_id = om.office_management_id
															left join cpfidb.contributions cont on cont.members_id = m.members_id
															left join cpfidb.loan_computation lc on lc.members_id = m.members_id
															left join cpfidb.v_balance vb on vb.loan_computation_id = lc.loan_computation_id
															left join cpfidb.departments d on d.departments_id = om.departments_id
															WHERE cont.date_applied between '$sd' AND '$ed'
															group by om.office_management_id
															order by
																	1,
																	3,
																	4) x WHERE x.place = '$type' OR x.date_applied is null")->result();
	}

	public function getOfficialReceipt($id){
		return $this->db->query("SELECT * FROM v_official_receipt where official_receipt_id = $id")->row();
	}

	public function getLoansPrintSummary($sd, $ed, $active){
		return $this->db->query("SELECT * FROM v_loan_summary_report")->result();	
	}


}
