<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class start_peserta extends CI_Controller {

	private $table_tmp_session_training_dtl;

	public function __construct() {
		parent::__construct();

		$this->auth->restrict_all();

		$this->load->model('m_start_peserta');

		$this->table_tmp_session_training_dtl   = $this->config->item('TABLE_TMP_SESSION_TRAINING_DTL');
	}

	public function index() {
		$data = array(
			'title' 					=> 'Peserta Training',
			'page_title' 				=> 'Peserta Training',
			'breadcrumb' 				=> '',
			'get_data_department' 		=> $this->m_start_peserta->get_data_department(),
			'get_data_jabatan_training'	=> $this->m_start_peserta->get_data_jabatan_training(),
			'custom_scripts' 			=> "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."start_peserta.js type='text/javascript'></script>"
		);
		$this->load->view('v_start_peserta', $data);
	}

	function get_data_karyawan_aktif($dept_id) {
		$this->m_start_peserta->get_data_karyawan_aktif($dept_id);
	}

	public function start_training_peserta() {
		$nik 			= $this->input->post('nik_karyawan');
		$kode_training 	= $this->input->post('kode_training');
		$source_test 	= $this->input->post('source_test');

		// 1. cek, apakah kode training terdaftar di database ?		
		$query = $this->m_start_peserta->cek_kode_training($kode_training);
		if ($query == false) {
			echo json_encode(['kodetraining_notexist'=>'Kode training tidak terdaftar / sudah close']);
			return false;
		}

		// 2. cek, apakah pre / post sudah pernah ?
		$query = $this->m_start_peserta->cek_session_training($nik, $kode_training, $source_test);
		if ($query->num_rows() > 0) {
			echo json_encode(['training_exist'=>'Training ini untuk '.strtoupper($source_test).' TEST sudah pernah diikuti']);
			return false;
		}

		// simpan ke tabel
		$initial_peserta = $this->input->post('initial_trainer');
        $data = array(
            'session_code'      	=> $this->input->post('kode_training'),
            'pre_post'           	=> $this->input->post('source_test'),
            'sysid_karyawan'        => $this->input->post('sysid_karyawan'),
            'nik'     				=> $this->input->post('nik_karyawan'),
            'sysid_department'     	=> $this->input->post('sysid_department'),
            'init_department'     	=> $this->input->post('init_department'),
            'sysid_jabatan'     	=> $this->input->post('sysid_jabatan'),
            'nama_jabatan'     		=> $this->input->post('nama_jabatan'),
            'nilai_minimum'     	=> $this->input->post('nilai_minimum'),
            'rec_create_user'       => $nik,
            'rec_create_datetime'   => $this->config->item('FORMAT_NOW_DATETIME_TO_INSERT'),
            'rec_update_user'       => $nik,
            'rec_update_datetime'   => $this->config->item('FORMAT_NOW_DATETIME_TO_INSERT'),
        );
        $result = $this->db->insert($this->table_tmp_session_training_dtl, $data);
        if ($result == 1) {
        	// simpan session
			$session_data = array(
	            'sess_status_training'          				=> 'peserta',
	            'sess_source_test_forpeserta_training'          => $this->input->post('source_test'),
	            'sess_sysid_department_forpeserta_training'   	=> $this->input->post('sysid_department'),
	            'sess_initial_department_forpeserta_training'   => $this->input->post('init_department'),
	            'sess_sysid_karyawan_forpeserta_training' 		=> $this->input->post('sysid_karyawan'),
	            'sess_nik_karyawan_forpeserta_training'    		=> $this->input->post('nik_karyawan'),
	            'sess_jabatan_karyawan_forpeserta_training'    	=> $this->input->post('nama_jabatan'),
	            'sess_kode_training_forpeserta_training'    	=> $this->input->post('kode_training'),
	        );
	        $this->session->set_userdata($session_data);
			echo json_encode(['success'=>'Sukses registrasi training']);
        } else {
        	echo json_encode(['error_insert_tmp'=>'Kesalahan di prosedur INSERT DATA. Silahkan hubungi administrator']);
        }
	}

}
