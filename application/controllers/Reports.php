<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Reports extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function crjSummaryReport(){
		$sd = $this->uri->segment(2);
		$ed = $this->uri->segment(3);

		$params['crjData'] = $this->AdminMod->getJmCrj($sd, $ed);
		$params['ed'] = date('F, Y', strtotime($ed));

		$this->load->view('admin/reports/crj-summary-report', $params);
	}
	
	public function pacsSummaryReport(){
		$sd = $this->uri->segment(2);
		$ed = $this->uri->segment(3);

		$params['pacsData'] = $this->AdminMod->getJmPacs($sd, $ed);
		$params['ed'] = date('F, Y', strtotime($ed));
		$this->load->view('admin/reports/pacs-summary-report', $params);
	}
	
	public function cdjSummaryReport(){
		$sd = $this->uri->segment(2);
		$ed = $this->uri->segment(3);

		$params['cdjData'] = $this->AdminMod->getJmCdj($sd, $ed);
		$params['ed'] = date('F, Y', strtotime($ed));
		$this->load->view('admin/reports/cdj-summary-report', $params);
	}
	
	public function gjSummaryReport(){
		$sd = $this->uri->segment(2);
		$ed = $this->uri->segment(3);

		$params['gjData'] = $this->AdminMod->getJmGj($sd, $ed);
		$params['ed'] = date('F, Y', strtotime($ed));
		$this->load->view('admin/reports/gj-summary-report', $params);
	}

	public function contributionAndPayments(){
		// $sd = $this->uri->segment(2);
		$sd = date('Y-m-01', strtotime($this->uri->segment(3)));
		$ed = date('Y-m-t', strtotime($this->uri->segment(3)));
		$type = str_replace('%20', ' ', $this->uri->segment(4));

		$params['cPData'] = $this->AdminMod->getContLoanPymnts($sd, $ed, $type);
		$params['ed'] = date('F, Y', strtotime($ed));
		$this->load->view('admin/reports/contribution-and-payments', $params);
	}
	
	public function printLoanSummaryReport(){
		// $sd = $this->uri->segment(2);
		$sd = date('Y-m-01', strtotime($this->uri->segment(3)));
		$ed = date('Y-m-t', strtotime($this->uri->segment(3)));
		$type = str_replace('%20', ' ', $this->uri->segment(4));

		$params['cPData'] = $this->AdminMod->getLoansPrintSummary($sd, $ed, $type);
		$params['ed'] = date('F, Y', strtotime($ed));
		$this->load->view('admin/reports/loan-summary-report', $params);
	}

	public function printOR(){
		$or_id = $this->uri->segment(2);
		$params['data'] = $this->AdminMod->getOfficialReceipt($or_id);
		$params['sum_words'] = function($num){ return $this->convertNumber($num); };
		$html = $this->load->view('admin/reports/official-receipt', $params, TRUE);
		$this->AdminMod->pdf($html, 'Official Receipt', false, 'LEGAL', false, false, false, 'OFFICIAL RECEIPT', '');
	}

}