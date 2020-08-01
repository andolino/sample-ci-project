<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Table extends CI_Model {

	protected $tbl;
	protected $tblColumn = [];
	protected $tblOrder = [];

	public function whereFnc(){
		if ($this->input->post('members_id')) {
			$this->db->where('members_id', $this->input->post('members_id'));
		}
		if ($this->input->post('tlb_cont_members_id')) {
			$this->db->where('members_id', $this->input->post('tlb_cont_members_id'));
		}

		//gj
		if ($this->input->post('tbl_acctg_page')=='gj-entry') {
			$this->db->where('j_type_id = 5 AND date_posted is null');
		}
		if ($this->input->post('tbl_acctg_page')=='gj-posted-entry') {
			$this->db->where('j_type_id = 5 AND date_posted is not null');
			if ($this->input->post('sd')) {
				$sd = $this->input->post('sd');
				$ed = $this->input->post('ed');
				$this->db->where("journal_date between '$sd' AND '$ed'");
			} else {
				$sd = date('Y-01-01');
				$ed = date('Y-m-t');
				$this->db->where("journal_date between '$sd' AND '$ed'");
				
			}
		}

		//crj
		if ($this->input->post('tbl_acctg_page')=='crj-entry') {
			$this->db->where('j_type_id = 6 AND date_posted is null');
		}
		if ($this->input->post('tbl_acctg_page')=='crj-posted-entry') {
			$this->db->where('j_type_id = 6 AND date_posted is not null');
			if ($this->input->post('sd')) {
				$sd = $this->input->post('sd');
				$ed = $this->input->post('ed');
				$this->db->where("journal_date between '$sd' AND '$ed'");
			} else {
				$sd = date('Y-01-01');
				$ed = date('Y-m-t');
				$this->db->where("journal_date between '$sd' AND '$ed'");
				
			}
		}

		//cdj
		if ($this->input->post('tbl_acctg_page')=='cdj-entry') {
			$this->db->where('j_type_id = 3 AND date_posted is null');
		}
		if ($this->input->post('tbl_acctg_page')=='cdj-posted-entry') {
			$this->db->where('j_type_id = 3 AND date_posted is not null');
			if ($this->input->post('sd')) {
				$sd = $this->input->post('sd');
				$ed = $this->input->post('ed');
				$this->db->where("journal_date between '$sd' AND '$ed'");
			} else {
				$sd = date('Y-01-01');
				$ed = date('Y-m-t');
				$this->db->where("journal_date between '$sd' AND '$ed'");
				
			}
		}

		//pacs
		if ($this->input->post('tbl_acctg_page')=='pacs-entry') {
			$this->db->where('j_type_id = 4 AND date_posted is null');
		}
		if ($this->input->post('tbl_acctg_page')=='pacs-posted-entry') {
			$this->db->where('j_type_id = 4 AND date_posted is not null');
			if ($this->input->post('sd')) {
				$sd = $this->input->post('sd');
				$ed = $this->input->post('ed');
				$this->db->where("journal_date between '$sd' AND '$ed'");
			} else {
				$sd = date('Y-01-01');
				$ed = date('Y-m-t');
				$this->db->where("journal_date between '$sd' AND '$ed'");
			}
		}

		//pacs
		if ($this->input->post('tbl_acctg_page')=='tbl-gl') {
			$sd=$this->input->post('sd');
			$ed=$this->input->post('ed');
			$this->db->where("date_posted between '$sd' AND '$ed'");
		}

	} 

	private function _que_tbl(){
		$this->db->from($this->tbl);
		$this->db->where('is_deleted', '0');

		$this->whereFnc();
		$i = 0;
		foreach ($this->tblColumn as $item) {
			if (!empty($_POST['search']['value'])) {
				if ($i === 0) {
					$this->db->where('is_deleted', '0');
					$this->db->like($item, strtolower($_POST['search']['value']));
				} else {
					$this->db->where('is_deleted', '0');					
					$this->db->or_like($item, strtolower($_POST['search']['value']));
				}

				$this->whereFnc();
			}
			$column[$i] = $item;
			$i++;
		}
		if (isset($_POST['order'])) {
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}elseif($this->tblOrder){
			$order = $this->tblOrder;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$this->db->order_by(key($this->tblOrder), $this->tblOrder[key($this->tblOrder)]);
	}

	public function getOutput($tbl, $tblColumn=array(), $tblOrder=array()){
		$this->tbl = $tbl; 
		$this->tblColumn = $tblColumn; 
		$this->tblOrder = $tblOrder; 
		$this->_que_tbl();
		if (!empty($_POST['length']))
			if ($_POST['length'] < 0) {} else {
				$this->db->limit($_POST['length'], $_POST['start']);
			}
		$query = $this->db->get();
		return $query->result();
	}

	public function countAllTbl(){
		$this->db->where('is_deleted', '0');
		$this->db->from($this->tbl);
		return $this->db->count_all_results();
	}

	public function countFilterTbl(){
		$this->_que_tbl();
		$query = $this->db->get();
		return $query->num_rows();
	}


}
