<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Settings extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function deleteData(){
		$tbl 	= $this->input->post('tbl');
		$fld 	= $this->input->post('w');
		$id 	= $this->input->post('v');
		$this->db->update($tbl, array('is_deleted' => 1), array($fld => $id));
	}

	public function addData(){
		$tbl 	= $this->input->post('tbl');
		$id 	= $this->input->post('has_update');
		$mustUnique 	= $this->input->post('unique');
		$data = array();
		foreach ($this->input->post() as $key => $value) {
			if ($key!='tbl'&&$key!='has_update'&&$key!='pk_key'&&$key!='unique'&&$key!='original_val') {
				$data[$key] = $value;	
			}
		}
		$errors = [];
		$res = array();

		$checkIsDeleted = $this->db->get_where($tbl, array($mustUnique => $_POST[$mustUnique], 'is_deleted' => 0))->row();
		//ignore validate if value is existing for update
		if ($_POST[$mustUnique] != $this->input->post('original_val') && $checkIsDeleted) {
			$this->form_validation->set_rules($mustUnique, 
																				strtoupper(str_replace('_', ' ', $mustUnique)),
																				'trim|required|is_unique['.$tbl.'.'.$mustUnique.']');
		} 
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			if (!empty($errors)) {
				$res['param1'] = 'Opps!';
				$res['param2'] = $errors[$mustUnique] . '! changes not updated';
				$res['param3'] = 'warning';	
			} else {
				if ($this->input->post('has_update')!='') {
					$q = $this->db->update($tbl, $data, array($this->input->post('pk_key') => $this->input->post('has_update')));
				} else {
					$q = $this->db->insert($tbl, $data);
				}
				if ($q) {
					$res['param1'] = 'Success!';
					$res['param2'] = 'Successfully Saved!';
					$res['param3'] = 'success';
				} else {
					$res['param1'] = 'Opps!';
					$res['param2'] = 'Error Encountered Saved';
					$res['param3'] = 'warning';
				}
			}
		} else {
			if ($this->input->post('has_update')!='') {
				$q = $this->db->update($tbl, $data, array($this->input->post('pk_key') => $this->input->post('has_update')));
			} else {
				$q = $this->db->insert($tbl, $data);
			}
			if ($q) {
				$res['param1'] = 'Success!';
				$res['param2'] = 'Successfully Saved!';
				$res['param3'] = 'success';
			} else {
				$res['param1'] = 'Opps!';
				$res['param2'] = 'Error Encountered Saved';
				$res['param3'] = 'warning';
			}
		}
		echo json_encode($res);
	}

	public function view_users(){
		$params['coaUsers'] = $this->db->get_where('users', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/view-users', $params);
	}

	public function server_users(){
		$result 	= $this->Table->getOutput('users', ['users_id', 'screen_name', 'username', 'password', 'txt_password', 'trans_date', 'trans_desc', 'is_deleted', 'last_name', 'first_name', 'middle_name', 'level'], ['users_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->screen_name;
   		$data[] = $row->username;
   		$data[] = $row->last_name . ', ' . $row->first_name . ' ' . ($row->middle_name ?? '');
   		$data[] = $this->AdminMod->getUserType($row->level);
 			$data[] = '<a href="javascript:void(0);" id="loadSidePage" data-link="get-users-frm" data-id="'.$row->users_id.'" data-title="EDIT - '.strtoupper($row->screen_name).'"><i class="fas fa-edit"></i></a> | <a href="javascript:void(0);" id="loadSidePage" data-link="get-users-frm-fp" data-id="'.$row->users_id.'" data-title="UPDATE PASSWORD - '.strtoupper($row->screen_name).'"><i class="fas fa-key"></i></a> | <a href="javascript:void(0);" onclick="removeData(this)" data-tbl="users" data-field="users_id" data-id="'.$row->users_id.'"><i class="fas fa-trash"></i></a>';
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

	public function server_signatory(){
		$result 	= $this->Table->getOutput('signatory', ['signatory_id', 'signatory_name', 'designation', 'is_deleted'], ['signatory_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->signatory_name;
   		$data[] = $row->designation;
 			$data[] = '<a href="javascript:void(0);" id="loadSidePage" data-link="get-signatory-frm" data-id="'.$row->signatory_id.'" data-title="EDIT - '.strtoupper($row->signatory_name).'"><i class="fas fa-edit"></i></a> | <a href="javascript:void(0);" onclick="removeData(this)" data-tbl="signatory" data-field="signatory_id" data-id="'.$row->signatory_id.'"><i class="fas fa-trash"></i></a>';
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

	public function server_subsidiary(){
		$result 	= $this->Table->getOutput('v_subsidiary', ['account_subsidiary_id', 'sub_code', 'code', 'employee_id', 'name', 'main_desc', 'users_id', 'is_deleted'], ['account_subsidiary_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->sub_code;
   		$data[] = $row->main_desc;
   		$data[] = $row->employee_id;
   		$data[] = $row->name;
 			$data[] = '<a href="javascript:void(0);" id="loadSidePage" data-link="get-subsidiary-frm" data-id="'.$row->account_subsidiary_id.'" data-title="EDIT - '.strtoupper($row->name).'"><i class="fas fa-edit"></i></a> | <a href="javascript:void(0);" onclick="removeData(this)" data-tbl="account_subsidiary" data-field="account_subsidiary_id" data-id="'.$row->account_subsidiary_id.'"><i class="fas fa-trash"></i></a>';
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

	public function server_office(){
		$result 	= $this->Table->getOutput('office_management', ['office_management_id', 'office_code', 'office_name', 'entry_date', 'is_deleted'], ['office_management_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->office_code;
   		$data[] = $row->office_name;
 			$data[] = '<a href="javascript:void(0);" id="loadSidePage" data-link="get-office-frm" data-id="'.$row->office_management_id.'" data-title="EDIT - '.strtoupper($row->office_code).'"><i class="fas fa-edit"></i></a> | <a href="javascript:void(0);" onclick="removeData(this)" data-tbl="office_management" data-field="office_management_id" data-id="'.$row->office_management_id.'"><i class="fas fa-trash"></i></a>';
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



	public function server_member_type(){
		$result 	= $this->Table->getOutput('member_type', ['member_type_id', 'type', 'entry_date', 'is_deleted'], ['member_type_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->type;
 			$data[] = '<a href="javascript:void(0);" id="loadSidePage" data-link="get-member-type-frm" data-id="'.$row->member_type_id.'" data-title="EDIT - '.strtoupper($row->type).'"><i class="fas fa-edit"></i></a> | <a href="javascript:void(0);" onclick="removeData(this)" data-tbl="member_type" data-field="member_type_id" data-id="'.$row->member_type_id.'"><i class="fas fa-trash"></i></a>';
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

	public function server_civil_status(){
		$result 	= $this->Table->getOutput('civil_status', ['civil_status_id', 'status', 'entry_date', 'is_deleted'], ['civil_status_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->status;
 			$data[] = '<a href="javascript:void(0);" id="loadSidePage" data-link="get-civil-status-frm" data-id="'.$row->civil_status_id.'" data-title="EDIT - '.strtoupper($row->status).'"><i class="fas fa-edit"></i></a> | <a href="javascript:void(0);" onclick="removeData(this)" data-tbl="civil_status" data-field="civil_status_id" data-id="'.$row->civil_status_id.'"><i class="fas fa-trash"></i></a>';
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

	public function server_departments(){
		$result 	= $this->Table->getOutput('departments', ['departments_id', 'region', 'short', 'place', 'entry_date', 'is_deleted'], ['departments_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->region;
   		$data[] = $row->place;
 			$data[] = '<a href="javascript:void(0);" id="loadSidePage" data-link="get-departments-frm" data-id="'.$row->departments_id.'" data-title="EDIT - '.strtoupper($row->short).'"><i class="fas fa-edit"></i></a> | <a href="javascript:void(0);" onclick="removeData(this)" data-tbl="departments" data-field="departments_id" data-id="'.$row->departments_id.'"><i class="fas fa-trash"></i></a>';
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

	public function server_contribution_rate(){
		$result 	= $this->Table->getOutput('contribution_rate', ['contribution_rate_id', 'rate', 'entry_date', 'is_deleted'], ['contribution_rate_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->rate;
   		$data[] = $row->cash_gift;
 			$data[] = '<a href="javascript:void(0);" id="updateContributionRate" title="Update Rate" data-id="'.$row->contribution_rate_id.'"><i class="fas fa-edit"></i></a>';
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
	
	public function server_process_contribution(){
		$result 	= $this->Table->getOutput('contributions', 
																						['contributions_id', 'members_id', 'total', 'balance', 'deduction', 'orno', 'entry_date', 'is_deleted', 'date_applied', 'status', 'adjusted_amnt', 'remarks'], 
																								['contributions_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;
		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->total;
   		$data[] = $row->balance;
   		$data[] = $row->deduction;
   		$data[] = $row->adjusted_amnt;
   		$data[] = $row->entry_date;
   		$data[] = $row->date_applied;
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

	public function server_relationship_type(){
		$result 	= $this->Table->getOutput('relationship_type', ['relationship_type_id', 'rel_type', 'entry_date', 'is_deleted'], ['relationship_type_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->rel_type;
 			$data[] = '<a href="javascript:void(0);" id="loadSidePage" data-link="get-relationship-type-frm" data-id="'.$row->relationship_type_id.'" data-title="EDIT - '.strtoupper($row->rel_type).'"><i class="fas fa-edit"></i></a> | <a href="javascript:void(0);" onclick="removeData(this)" data-tbl="relationship_type" data-field="relationship_type_id" data-id="'.$row->relationship_type_id.'"><i class="fas fa-trash"></i></a>';
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

	public function server_beneficiaries(){
		$this->db->where('members_id', $this->input->post('id'));
		$result 	= $this->Table->getOutput('v_beneficiaries', ['beneficiaries_id', 'members_id', 'rel_type', 'last_name', 'first_name', 'entry_date', 'is_deleted', 'relationship_name', 'relationship_type_id'], ['beneficiaries_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = strtoupper($row->relationship_name);
 			$data[] = '<a href="javascript:void(0);" id="loadSidePage" data-fn="edit" data-link="get-beneficiaries-frm" data-id="'.$row->beneficiaries_id.'" data-title="EDIT - '.strtoupper($row->relationship_name).'"><i class="fas fa-edit"></i></a> | <a href="javascript:void(0);" onclick="removeData(this)" data-tbl="beneficiaries" data-field="beneficiaries_id" data-id="'.$row->beneficiaries_id.'"><i class="fas fa-trash"></i></a>';
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

	public function server_members_beneficiaries(){
		$result 	= $this->Table->getOutput('members', ['members_id', 'last_name', 'first_name', 'entry_date', 'is_deleted'], ['members_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->members_id;
   		$data[] = strtoupper($row->last_name);
   		$data[] = strtoupper($row->first_name);
 			$data[] = '<a href="javascript:void(0);" id="loadPage" data-link="get-beneficiaries-members" data-ind="'.$row->members_id.'" 
   								data-badge-head="BENEFICIARIES - ' . strtoupper($row->last_name . ', ' . $row->first_name).'" data-cls="cont-view-beneficiaries-relationship"><i class="fas fa-edit"></i></a>';
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

	public function server_members_immediate_family(){
		$result 	= $this->Table->getOutput('members', ['members_id', 'last_name', 'first_name', 'entry_date', 'is_deleted'], ['members_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->members_id;
   		$data[] = strtoupper($row->last_name);
   		$data[] = strtoupper($row->first_name);
 			$data[] = '<a href="javascript:void(0);" id="loadPage" data-link="get-immediate-family" data-ind="'.$row->members_id.'" 
   								data-badge-head="IMMEDIATE FAMILY - ' . strtoupper($row->last_name . ', ' . $row->first_name).'" data-cls="cont-view-immediate-family-relation"><i class="fas fa-edit"></i></a>';
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

	public function server_immediate_family(){
		$result 	= $this->Table->getOutput('v_immediate_family', ['immediate_family_id', 'members_id', 'rel_type', 'last_name', 'first_name', 'relationship_name', 'entry_date', 'is_deleted', 'relationship_type_id'], ['immediate_family_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = strtoupper($row->relationship_name);
 			$data[] = '<a href="javascript:void(0);" id="loadSidePage" data-fn="edit" data-link="get-immediate-family-frm" data-id="'.$row->immediate_family_id.'" data-title="EDIT - '.strtoupper($row->relationship_name).'"><i class="fas fa-edit"></i></a> | <a href="javascript:void(0);" onclick="removeData(this)" data-tbl="immediate_family" data-field="immediate_family_id" data-id="'.$row->immediate_family_id.'"><i class="fas fa-trash"></i></a>';
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

	public function server_loan_type(){
		$result 	= $this->Table->getOutput('loan_code', ['loan_code_id', 'loan_code', 'loan_type_name', 'is_deleted', 'entry_date'], ['loan_code_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->loan_code;
   		$data[] = $row->loan_type_name;
 			$data[] = '<a href="javascript:void(0);" id="loadSidePage" data-link="get-loan-types-frm" data-id="'.$row->loan_code_id.'" data-title="EDIT - '.strtoupper($row->loan_code).'"><i class="fas fa-edit"></i></a> | <a href="javascript:void(0);" onclick="removeData(this)" data-tbl="loan_code" data-field="loan_code_id" data-id="'.$row->loan_code_id.'"><i class="fas fa-trash"></i></a>';
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

	public function server_benefit_type(){
		$result 	= $this->Table->getOutput('benefit_type', ['benefit_type_id', 'type_of_benefit', 'min_amnt', 'multi_claim', 'is_deleted', 'entry_date'], ['benefit_type_id' => 'desc']);
		$res 			= array();
		$no 			= isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($result as $row) {
			$data = array();
			$no++;
   		$data[] = $row->type_of_benefit;
 			$data[] = '<a href="javascript:void(0);" id="loadSidePage" data-link="get-benefit-type-frm" data-id="'.$row->benefit_type_id.'" data-title="EDIT - '.strtoupper($row->type_of_benefit).'"><i class="fas fa-edit"></i></a> | <a href="javascript:void(0);" onclick="removeData(this)" data-tbl="benefit_type" data-field="benefit_type_id" data-id="'.$row->benefit_type_id.'"><i class="fas fa-trash"></i></a>';
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

	public function getUsersFrm(){
		$params['has_update'] = $this->input->post('id');
		$params['data'] = $this->db->get_where('users', array('is_deleted' => 0, 'users_id' => $this->input->post('id')))->row();
		$this->load->view('admin/settings/forms/frm-users', $params);
	}

	public function getUsersFrmFp(){
		$params['has_update'] = $this->input->post('id');
		$this->load->view('admin/settings/forms/frm-users-fp', $params);
	}

	public function getSignatoryFrm(){
		$params['has_update'] = $this->input->post('id');
		$params['data'] = $this->db->get_where('signatory', array('is_deleted' => 0,'signatory_id' => $this->input->post('id')))->row();
		$this->load->view('admin/settings/forms/frm-signatory', $params);
	}

	public function getSubsidiaryFrm(){
		$params['has_update'] = $this->input->post('id');
		$params['data'] 			= $this->db->get_where('account_subsidiary', array('is_deleted' => 0,'account_subsidiary_id' => $this->input->post('id')))->row();
		$params['mainAccnt'] 	= $this->db->get_where('account_main', array('is_deleted' => 0))->result();
		$params['membersData'] 	= $this->db->get_where('members', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/forms/frm-subsidiary', $params);
	}

	public function getOfficeFrm(){
		$params['has_update'] = $this->input->post('id');
		$params['data'] = $this->db->get_where('office_management', array('is_deleted' => 0,'office_management_id' => $this->input->post('id')))->row();
		$params['dataDepartments'] = $this->db->get_where('departments', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/forms/frm-office', $params);
	}

	public function getLoanTypesFrm(){
		$params['has_update'] = $this->input->post('id');
		$params['data'] = $this->db->get_where('loan_code', array('is_deleted' => 0,'loan_code_id' => $this->input->post('id')))->row();
		$this->load->view('admin/settings/forms/frm-loan-types', $params);
	}

	public function getBenefiTypesFrm(){
		$params['has_update'] = $this->input->post('id');
		$params['data'] = $this->db->get_where('benefit_type', array('is_deleted' => 0,'benefit_type_id' => $this->input->post('id')))->row();
		$this->load->view('admin/settings/forms/frm-benefit-type', $params);
	}

	public function getMemberTypeFrm(){
		$params['has_update'] = $this->input->post('id');
		$params['data'] = $this->db->get_where('member_type', array('is_deleted' => 0,'member_type_id' => $this->input->post('id')))->row();
		$this->load->view('admin/settings/forms/frm-member-type', $params);
	}

	public function getCivilStatusFrm(){
		$params['has_update'] = $this->input->post('id');
		$params['data'] = $this->db->get_where('civil_status', array('is_deleted' => 0,'civil_status_id' => $this->input->post('id')))->row();
		$this->load->view('admin/settings/forms/frm-civil-status', $params);
	}

	public function getDepartmentsFrm(){
		$params['has_update'] = $this->input->post('id');
		$params['data'] = $this->db->get_where('departments', array('is_deleted' => 0,'departments_id' => $this->input->post('id')))->row();
		$this->load->view('admin/settings/forms/frm-departments', $params);
	}

	public function getRelationshipTypeFrm(){
		$params['has_update'] = $this->input->post('id');
		$params['data'] = $this->db->get_where('relationship_type', array('is_deleted' => 0,'relationship_type_id' => $this->input->post('id')))->row();
		$this->load->view('admin/settings/forms/frm-relationship-type', $params);
	}

	public function getBeneficiariesFrm(){
		$fn 									= $this->input->post('fn');
		// $params['has_update'] = $this->input->post('id');
		$params['members_id'] = $this->input->post('id');
		if ($fn=='edit') {
			$params['data'] 			= $this->db->get_where('beneficiaries', array('is_deleted'=>0,'beneficiaries_id'=>$this->input->post('id')))->row();
		}
		$params['rtype'] 			= $this->db->get_where('relationship_type', array('is_deleted'=>0))->result();
		$this->load->view('admin/settings/forms/frm-beneficiaries', $params);
	}

	public function getImmediateFamilyFrm(){
		$fn 									= $this->input->post('fn');
		// $params['has_update'] = $this->input->post('id');
		$params['members_id'] = $this->input->post('id');
		if ($fn=='edit') {
			$params['data'] 			= $this->db->get_where('immediate_family', array('is_deleted'=>0,'immediate_family_id'=>$this->input->post('id')))->row();
		}
		$params['rtype'] 			= $this->db->get_where('relationship_type', array('is_deleted'=>0))->result();
		$this->load->view('admin/settings/forms/frm-immediate-family', $params);
	}

	public function getContributionRate(){
		$params['cr'] = $this->db->get_where('contribution_rate', array('is_deleted'=>0))->row();
		$this->load->view('admin/settings/forms/frm-contribution-rate', $params);
	}

	public function getBeneficiariesMembers(){
		$params['members_id'] = $this->input->get('data');
		$this->load->view('admin/settings/view-beneficiaries-relationship', $params);
	}

	public function getImmediateFamilyMembers(){
		$params['members_id'] = $this->input->get('data');
		$this->load->view('admin/settings/view-immediate-family-relation', $params);
	}

	public function saveUsersData(){
		if (count($_POST) == 3) {
			$this->form_validation->set_rules('password','Password','required');
			$this->form_validation->set_rules('confirm_password','Confirm Password','required|matches[password]');
		} 
		elseif(count($_POST) > 3 && $this->input->post('has_update')!=''){
			$this->form_validation->set_rules('screen_name','Screen Name','trim|required');
			$this->form_validation->set_rules('last_name','Last Name','trim|required');
			$this->form_validation->set_rules('first_name','First Name','trim|required');
			// $this->form_validation->set_rules('middle_name','Middle Name','trim|required');
			if ($this->input->post('email') != $this->input->post('original_email')) {
				$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[users.email]');
			}
			if ($this->input->post('username') != $this->input->post('original_username')) {
				$this->form_validation->set_rules('username','Username','trim|required|is_unique[users.username]');
			}
			$this->form_validation->set_rules('level','Level','required');
			$this->form_validation->set_rules('designation','Designation','trim|required');
		} else {
			$this->form_validation->set_rules('screen_name','Screen Name','trim|required');
			$this->form_validation->set_rules('last_name','Last Name','trim|required');
			$this->form_validation->set_rules('first_name','First Name','trim|required');
			// $this->form_validation->set_rules('middle_name','Middle Name','trim|required');
			$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('username','Username','trim|required|is_unique[users.username]');
			$this->form_validation->set_rules('password','Password','required');
			$this->form_validation->set_rules('confirm_password','Confirm Password','required|matches[password]');
			$this->form_validation->set_rules('level','Level','required');
			$this->form_validation->set_rules('designation','Designation','trim|required');
		}
		$errors = array();
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$errors['msg'] = 'fail';
		} else {
			if ($this->input->post('has_update')!='') {
				$data=array();
				if (count($_POST) == 3) {
					$password = $this->input->post('password');
					$hashed_password = password_hash($password, PASSWORD_BCRYPT);
					$data = [
						'password'		=> $hashed_password,
						'txt_password'=> $password,
					];
				} else {
					$data = [
						'screen_name' => $this->input->post('screen_name'),
						'username' 		=> $this->input->post('username'),
						'last_name' 	=> $this->input->post('last_name'),
						'first_name' 	=> $this->input->post('first_name'),
						'middle_name' => $this->input->post('middle_name'),
						'email' 			=> $this->input->post('email'),
						'level' 			=> $this->input->post('level'),
						'designation' => $this->input->post('designation'),
						'trans_date'	=> date('Y-m-d')
					];
				}
				$this->db->update('users', $data, array('users_id' => $this->input->post('has_update')));
				$errors['msg']		 	 = 'success';
			} else {
				$password = $this->input->post('password');
				$hashed_password = password_hash($password, PASSWORD_BCRYPT);
				$data = [
						'screen_name' => $this->input->post('screen_name'),
						'username' 		=> $this->input->post('username'),
						'last_name' 	=> $this->input->post('last_name'),
						'first_name' 	=> $this->input->post('first_name'),
						'middle_name' => $this->input->post('middle_name'),
						'email' 			=> $this->input->post('email'),
						'level' 			=> $this->input->post('level'),
						'designation' => $this->input->post('designation'),
						'password'		=> $hashed_password,
						'txt_password'=> $password,
						'trans_date'	=> date('Y-m-d')
				];
				$this->db->insert('users', $data);
				$users_id = $this->db->insert_id();
				$errors['msg']		 	 = 'success';
			}
		}
		echo json_encode($errors);

	}

	public function saveContributionRate(){
		$q = $this->db->update('contribution_rate', array('rate'=>$this->input->post('rate'),'cash_gift'=>$this->input->post('cash_gift')), array('contribution_rate_id'=>$this->input->post('has_update')));
		$res=array();
		if ($q) {
			$res['param1'] = 'Success!';
			$res['param2'] = 'Successfully Updated!';
			$res['param3'] = 'success';
		} else {
			$res['param1'] = 'Opps!';	
			$res['param2'] = 'Error Encountered!';
			$res['param3'] = 'warning';
		}
		echo json_encode($res);
	}
	
	public function save_loan_approval_settings(){
		$result = $this->db->get_where('request_approver', array('type'=>'loans'))->row();
		if (empty($result)) {
			$q = $this->db->insert('request_approver', 
											array(
												'loan_first_approver_users_id' => $this->input->post('loan_first_approver_users_id'),
												// 'loan_second_approver_users_id' => $this->input->post('loan_second_approver_users_id'),
												// 'loan_req_second_approver' => $this->input->post('loan_req_second_approver') ? 1 : 0,
												// 'loan_override_first_approver' => $this->input->post('loan_override_first_approver') ? 1 : 0,
												'type'=>'loans',
												'hour_expiration' => $this->input->post('hour_expiration') ? $this->input->post('hour_expiration') : null
											));
		} else {
			$q = $this->db->update('request_approver', 
											array(
												'loan_first_approver_users_id' => $this->input->post('loan_first_approver_users_id'),
												// 'loan_second_approver_users_id' => $this->input->post('loan_second_approver_users_id'),
												// 'loan_req_second_approver' => $this->input->post('loan_req_second_approver') ? 1 : 0,
												// 'loan_override_first_approver' => $this->input->post('loan_override_first_approver') ? 1 : 0,
												'hour_expiration' => $this->input->post('hour_expiration') ? $this->input->post('hour_expiration') : null
											), array('type'=>'loans'));
		}
		
		$res=array();
		if ($q) {
			$res['param1'] = 'Success!';
			$res['param2'] = 'Successfully Updated!';
			$res['param3'] = 'success';
		} else {
			$res['param1'] = 'Opps!';	
			$res['param2'] = 'Error Encountered!';
			$res['param3'] = 'warning';
		}
		echo json_encode($res);
	}
	
	public function save_benefit_approval_settings(){
		$result = $this->db->get_where('request_approver', array('type'=>'benefit'))->row();
		if (empty($result)) {
			$q = $this->db->insert('request_approver', 
											array(
												'benefit_first_approver_users_id' 	=> $this->input->post('benefit_first_approver_users_id'),
												// 'loan_second_approver_users_id' => $this->input->post('loan_second_approver_users_id'),
												// 'loan_req_second_approver' 			=> $this->input->post('loan_req_second_approver') ? 1 : 0,
												// 'loan_override_first_approver' 	=> $this->input->post('loan_override_first_approver') ? 1 : 0,
												'hour_expiration' 						 	=> $this->input->post('hour_expiration') ? $this->input->post('hour_expiration') : null,
												'type'=>'benefit'
											));
		} else {
			$q = $this->db->update('request_approver', 
											array(
												'benefit_first_approver_users_id' 	=> $this->input->post('benefit_first_approver_users_id'),
												// 'loan_second_approver_users_id' => $this->input->post('loan_second_approver_users_id'),
												// 'loan_req_second_approver' 			=> $this->input->post('loan_req_second_approver') ? 1 : 0,
												// 'loan_override_first_approver' 	=> $this->input->post('loan_override_first_approver') ? 1 : 0,
												'hour_expiration' 							=> $this->input->post('hour_expiration') ? $this->input->post('hour_expiration') : null
											), array('type'=>'benefit'));
		}
		
		$res=array();
		if ($q) {
			$res['param1'] = 'Success!';
			$res['param2'] = 'Successfully Updated!';
			$res['param3'] = 'success';
		} else {
			$res['param1'] = 'Opps!';	
			$res['param2'] = 'Error Encountered!';
			$res['param3'] = 'warning';
		}
		echo json_encode($res);
	}

	public function view_signatory(){
		$params['settSignatory'] = $this->db->get_where('signatory', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/view-signatory', $params);
	}

	public function view_subidiary(){
		$params['settSubsidiary'] = $this->db->get_where('account_subsidiary', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/view-subsidiary', $params);
	}

	public function view_office(){
		$params['settOffcMngmnt'] = $this->db->get_where('office_management', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/view-office', $params);
	}

	public function view_member_type(){
		$params['settMemType'] = $this->db->get_where('member_type', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/view-member-type', $params);
	}

	public function view_civil_status(){
		$params['settCivilStatus'] = $this->db->get_where('civil_status', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/view-civil-status', $params);
	}

	public function view_departments(){
		$params['settDepartments'] = $this->db->get_where('departments', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/view-departments', $params);
	}

	public function view_relationship_type(){
		$params['settCivilStatus'] = $this->db->get_where('relationship_type', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/view-relationship-type', $params);
	}

	public function view_beneficiaries(){
		$params['settBeneficiaries'] = $this->db->get_where('beneficiaries', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/view-beneficiaries', $params);
	}

	public function view_immediate_family(){
		$params['settImmediteFamily'] = $this->db->get_where('immediate_family', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/view-immediate-family', $params);
	}

	public function view_contribution_rate(){
		$params['settContributionRate'] = $this->db->get_where('contribution_rate', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/view-contribution-rate', $params);
	}

	public function view_loan_type(){
		$params['settLoanTypes'] = $this->db->get_where('loan_types', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/view-loan-type', $params);
	}

	public function view_benefit_type(){
		$params['settBenefitType'] = $this->db->get_where('benefit_type', array('is_deleted' => 0))->result();
		$this->load->view('admin/settings/view-benefit-type', $params);
	}
	
	public function view_approval_settings(){
		$params['users'] 					 = $this->db->get_where('users', array('is_deleted' => 0))->result();
		$params['loanApprover'] 	 = $this->db->get_where('request_approver', array('type' => 'loans'))->row();
		$params['benefitApprover'] = $this->db->get_where('request_approver', array('type' => 'benefit'))->row();
		$this->load->view('admin/settings/view-approval-settings', $params);
	}


}



