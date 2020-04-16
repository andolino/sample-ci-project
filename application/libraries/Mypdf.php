<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Mypdf extends TCPDF {
	/**
    * Overwrite Header() method.
    * @public
    */
  /*  function __construct(){
        $ci =& get_instance();
        $ci->load->helper('yc');
    }*/
    function __construct(){
        parent::__construct();
        //$CI =& get_instance();
        //$CI->load->helper('url');
    }

	public function Header() {
        // if ($this->tocpage) or
        
        if ($this->page == 1) {
            // *** replace the following parent::Header() with your code for TOC/page you want page
            // parent::Header();
            // this will add logo and text to first page
            $this->Image(base_url('assets/images/fuerte-logo.png'), 68, 5, 70, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->SetFont('helvetica', 'B', 14);
            //$this->Cell(0, 15, 'First page header text', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        } else {
            // *** replace the following parent::Header() with your code for other pages
            //parent::Header();
            // following will add your own logo ant text to other pages
            /*$this->Image('http://2.bp.blogspot.com/-e8mXGyl5xEU/Vk-5Xtd6frI/AAAAAAAAOPU/4a9zgB7s6xA/s1600/FB-f-Logo__white.png', 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->SetFont('helvetica', 'B', 14);
            $this->Cell(0, 15, 'Other pages header text', 0, false, 'C', 0, '', 0, false, 'M', 'M');*/
        }
    }
}
