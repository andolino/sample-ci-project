<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	
	function __construct(){
		parent::__construct();
	}

	public function adminContainer($data, $param = array(), $return = FALSE){
		if(!$this->session->userdata('users_id')){
		  redirect('login');
		}
        $param['go_logout'] = 'logout';
		$this->load->view('partials/adminHdr', $param);
		$this->load->view('partials/adminNav', $param);
		$this->load->view($data, $param, $return);
		$this->load->view('partials/adminFtr');	
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


    

}