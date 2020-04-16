<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminMod extends CI_Model {

	//MEMBERS
	var $tblMembers = 'v_members';
	var $tblMembersCollumn = array('members_id', 'id_no', 'last_name', 'first_name', 
																				'middle_name', 'dob', 'address', 'status', 'date_of_effectivity', 
																				'designation', 'type', 'monthly_salary', 'office_name', 'entry_date', 'is_deleted');
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

	
	//MEMBERS OBJECT
	private function _que_tbl_members(){
		$this->db->from($this->tblMembers);
		$this->db->where('is_deleted', '0');
		$i = 0;
		foreach ($this->tblMembersCollumn as $item) {
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
		}elseif($this->tblMembersOrder){
			$this->db->where('is_deleted', '0');
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

	/**
    * Function print tcpdf
    */
  function pdf($html, $download_filename, $orientation = 'P', $page_format = 'LETTER', $with_full_page_background = false, $image_background = null, $with_page_no = true, $title = '', $font_fam, $hasQr = false, $qrApiLink = null, $formatSize = 'A4', $decIDs = false) {
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

}
