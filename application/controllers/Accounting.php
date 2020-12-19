<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Accounting extends MY_Controller {

	function __construct(){
		parent::__construct();
	}

	public function saveAcctgEntry(){
		$j_type_id 				= $this->input->post('j_type_id');
		$data_j_type			= $this->db->get_where('j_type', array('j_type_id'=>$j_type_id))->row();

		$journal_ref			= $data_j_type->type.'-'.$data_j_type->ref;
		$check_no 				= $this->input->post('check_no');
		$ref_no 					= $this->input->post('ref_no');
		$account_no 			= $this->input->post('account_no');
		$payee_type 			= $this->input->post('payee_type');
		$payee_members_id = $this->input->post('payee_members_id');
		$payee 						= $this->input->post('payee');
		$particulars 			= $this->input->post('particulars');
		$journal_date 		= $this->input->post('journal_date');
		$users_id					= $this->session->users_id;
		$entry_date 			= date('Y-m-d');
		$main_code 				= $this->input->post('main_code');
		$sub_code 				= $this->input->post('sub_code');
		$debit 						= $this->input->post('debit');
		$credit 					= $this->input->post('credit');

		if ($this->input->post('has_update')=='') {

			$master = array(
			'j_type_id'=>$j_type_id,
			//if 3 = check voucher
			'check_voucher_no'=>$j_type_id==3||$j_type_id==6?$data_j_type->ref:null,
			'journal_ref'=>$journal_ref,
			'check_no'=>$j_type_id==3||$j_type_id==6?$check_no:null,
			'account_no'=>$j_type_id==4||$j_type_id==6?$account_no:null,
			'reference_no'=>$ref_no,
			'payee_type'=>$payee_type,
			'payee_members_id'=>$payee_members_id,
			'payee'=>$payee,
			'particulars'=>$particulars,
			'journal_date'=>date('Y-m-d', strtotime($journal_date)),
			'users_id'=>$users_id,
			'entry_date'=>date('Y-m-d', strtotime($entry_date))
		);

			$jmaster=$this->db->insert('j_master', $master);
			$j_master_id      = $this->db->insert_id();
			$details = array();
			for ($i=0; $i < count($main_code); $i++) { 
				array_push($details, array(
					'j_master_id'=>$j_master_id,
					'acct_code'=>$main_code[$i],
					'subsidiary'=>$sub_code[$i]==''?null:$sub_code[$i],
					'debit'=>floatval(str_replace(',', '', $debit[$i])),
					'credit'=>floatval(str_replace(',', '', $credit[$i]))
				));
			}
			$curRef=intval($data_j_type->ref) + 1;
			$newRef=str_pad($curRef, 8, '0', STR_PAD_LEFT);
			$this->db->update('j_type', array('ref'=>$newRef), array('j_type_id'=>$j_type_id));
			$q=$this->db->insert_batch('j_details', $details);
		} else {

			$master_update = array(
			'j_type_id'=>$j_type_id,
			//if 3 = check voucher
			// 'check_voucher_no'=>$j_type_id==3||$j_type_id==6?$data_j_type->ref:null,
			// 'journal_ref'=>$journal_ref,
			'check_no'=>$j_type_id==3||$j_type_id==6?$check_no:null,
			'account_no'=>$j_type_id==4||$j_type_id==6?$account_no:null,
			'reference_no'=>$ref_no,
			'payee_type'=>$payee_type,
			'payee_members_id'=>$payee_members_id,
			'payee'=>$payee,
			'particulars'=>$particulars,
			'journal_date'=>date('Y-m-d', strtotime($journal_date)),
			'users_id'=>$users_id,
			'entry_date'=>date('Y-m-d', strtotime($entry_date))
		);

			$this->db->delete('j_details', array('j_master_id'=>$this->input->post('has_update')));
			$details = array();
			for ($i=0; $i < count($main_code); $i++) { 
				array_push($details, array(
					'j_master_id'=>$this->input->post('has_update'),
					'acct_code'=>$main_code[$i],
					'subsidiary'=>$sub_code[$i]==''?null:$sub_code[$i],
					'debit'=>floatval(str_replace(',', '', $debit[$i])),
					'credit'=>floatval(str_replace(',', '', $credit[$i]))
				));
			}
			$jmaster=$this->db->update('j_master', $master_update, array('j_master_id'=>$this->input->post('has_update')));
			$q=$this->db->insert_batch('j_details', $details);	
		}
	
		$res=array();
		if ($q) {
			$res['param1']='Success!';
			$res['param2']='Thank you! successfully saved!';
			$res['param3']='success';
		} else {
			$res['param1']='Opps!';
			$res['param2']='Error Encountered Saved';
			$res['param3']='warning';
		}
		echo json_encode($res);
	}

	public function deleteJournal(){
		$j_master_id=$this->input->post('id');
		$this->db->delete('j_details', array('j_master_id'=>$j_master_id));
		$q=$this->db->delete('j_master', array('j_master_id'=>$j_master_id));
		$res=array();
		if ($q) {
			$res['param1']='Success!';
			$res['param2']='Thank you! successfully Deleted!';
			$res['param3']='success';
		} else {
			$res['param1']='Opps!';
			$res['param2']='Error Encountered Saved';
			$res['param3']='warning';
		}
		echo json_encode($res);
	}


}

