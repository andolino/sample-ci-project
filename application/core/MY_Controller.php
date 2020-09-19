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
		$users = $this->db->get_where('users', array('users_id' => $this->session->users_id))->row();
		$param['userPriv']  = $users;
		$this->load->view('partials/adminHdr', $param);
		$this->load->view('partials/adminNav', $param);
		$this->load->view($data, $param, $return);
		$this->load->view('partials/adminFtr');	
	}
    
	public function portalContainer($data, $param = array(), $return = FALSE){
		if(!$this->session->userdata('members_id')){
			redirect('portal-login');
		}
		$this->load->view('partials/portalHdr', $param);
		// $this->load->view('partials/adminNav', $param);
		$this->load->view($data, $param, $return);
		$this->load->view('partials/portalFtr');	
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
	
	public function sendEmail($from, $email, $subject, $message, $title){
    $config = Array(
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.cpfi-webapp.com',
      'smtp_port' => 2083,
      'smtp_user' => 'manage_account@cpfi-webapp.com', 
      'smtp_pass' => 'OuPqjDymP#4V', 
      'mailtype' => 'html',
      'charset' => 'iso-8859-1',
      // 'charset' => 'utf-8',
      'wordwrap' => TRUE
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->set_header('MIME-Version', '1.0; charset=utf-8'); //must add this line
		$this->email->set_header('Content-type', 'text/html'); //must add this line
		$this->email->from($from, $title);
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($message);
		// $this->email->attach('C:\Users\xyz\Desktop\images\abc.png');
		if($this->email->send()){
			// echo 'Email send.';
		} else {
			show_error($this->email->print_debugger());
		}
  }


  function convertIntegerToWords($x) {
        $w = '';
    $nwords = array('ZERO', 'ONE', 'TWO', 'THREE', 'FOUR', 'FIVE', 'SIX', 'SEVEN',
                         'EIGHT', 'NINE', 'TEN', 'ELEVEN', 'TWELVE', 'THIRTEEN',
                         'FOURTEEN', 'FIFTEEN', 'SIXTEEN', 'SEVENTEEN', 'EIGHTEEN',
                         'NINETEEN', 'TWENTY', 30 => 'THIRTY', 40 => 'FORTY',
                         50 => 'FIFTY', 60 => 'SIXTY', 70 => 'SEVENTY', 80 => 'EIGHTY',
                         90 => 'NINETY' );

         if(!is_numeric($x)) {
             $w = '#';
         } else if(fmod($x, 1) != 0) {
             $w = '#';
         } else {
             if($x < 0) {
                 $w = 'MINUS ';
                 $x = -$x;
             } else {
                 $w = '';
             }

             if($x < 21) {
                 $w .= $nwords[$x];
             } else if($x < 100) {
                    $w .= $nwords[10 * floor($x/10)];
                    $r = fmod($x, 10);
                    if($r > 0) {
                      $w .= '-'. $nwords[$r];
                    }
             } else if($x < 1000) {
                 $w .= $nwords[floor($x/100)] .' HUNDRED';
                 $r = fmod($x, 100);
                 if($r > 0) {
                     // $w .= ' and '. $this->convertIntegerToWords($r);
                     $w .= ' '. $this->convertIntegerToWords($r);
                 }
             } else if($x < 1000000) {
                 $w .= $this->convertIntegerToWords(floor($x/1000)) .' THOUSAND';
                 $r = fmod($x, 1000);
                 if($r > 0) {
                     $w .= ' ';
                     if($r < 100) {
                         $w .= 'AND ';
                     }
                     $w .= $this->convertIntegerToWords($r);
                 }
             } else {
                 $w .= $this->convertIntegerToWords(floor($x/1000000)) .' MILLION';
                 $r = fmod($x, 1000000);
                 if($r > 0) {
                        $w .= ' ';
                        if($r < 100) {
                            $word .= 'AND ';
                        }
                        $w .= $this->convertIntegerToWords($r);
                 }
             }
            }
        return $w;
    }

    function convertNumber($number) {
        $out = '';
        $currencylabelsarray = array('PESO/S' => 'PESOS/S', 'CENTAVO/S' => 'CENTAVO/S');
        if(!is_numeric($number)) return false;
        $nums = explode('.', $number);
        $out = $this->convertIntegerToWords($nums[0]) . ' PESO/S';
        if(isset($nums[1])) {
        $out .= ' AND ' . $this->convertIntegerToWords((is_string($nums[1]) ? (int) $nums[1] : $nums[1])) .' CENTAVO/S';
        }
        return ucwords($out);
		}
		function generateKey($length) {
			$key = '';
			for($i = 0; $i < $length; $i ++) {
					$key .= chr(mt_rand(33, 126));
			}
			return $key;
		}

}