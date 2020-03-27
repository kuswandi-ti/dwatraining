<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth {

	var $CI = NULL;
	
	function __construct() {
		// get CI's object
		$this->CI =& get_instance();
	}
	
	// untuk validasi di setiap halaman yang mengharuskan authentikasi
	function restrict() {
		$sess_status_training = $this->CI->session->userdata('sess_status_training');
		if (empty($sess_status_training) || $sess_status_training == '') {
			redirect('start_peserta');
		}
	}

	function restrict_all() {
		$sess_status_training = $this->CI->session->userdata('sess_status_training');
		if (!empty($sess_status_training) || $sess_status_training != '') {
			redirect('home');
		}
	}
	
}

/* End of file auth.php */
/* Location: ./application/libraries/auth.php */