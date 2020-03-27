<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class start_trainer extends CI_Controller {

    private $table_tmp_session_training_hdr;

	public function __construct() {
		parent::__construct();

        $this->auth->restrict_all();

		$this->load->model('m_start_trainer');

        $this->table_tmp_session_training_hdr = $this->config->item('TABLE_TMP_SESSION_TRAINING_HDR');
	}

	public function index() {
		$data = array(
			'title' 			=> 'Trainer',
			'page_title' 		=> 'Trainer',
			'breadcrumb' 		=> '',
			'custom_scripts' 	=> "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."start_trainer.js type='text/javascript'></script>"
		);
		$this->load->view('v_start_trainer', $data);
	}

	public function datatable_trainer_list() {
        $lists 	= $this->m_start_trainer->get_datatables_trainer();
        $data 	= array();
        $no 	= $_POST['start'];
        foreach ($lists as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->kode_trainer;
            $row[] = $list->nama_trainer;
            $row[] = $list->initial_trainer;
            $row[] = '<a href="javascript:void(0)" 
			             id="select_trainer" 
			             data-toggle="tooltip" 
			             title="Select Trainer" 
			             data-sysid-trainer="'.$list->sysid.'" 
			             data-kode-trainer="'.$list->kode_trainer.'" 
			             data-initial-trainer="'.$list->initial_trainer.'"
			             data-nama-trainer="'.$list->nama_trainer.'"
			             data-original-title="Select Trainer" 
			             class="btn waves-effect waves-light btn-xs btn-danger">
			             	Pilih
			          </a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->m_start_trainer->count_all_trainer(),
                        "recordsFiltered" => $this->m_start_trainer->count_filtered_trainer(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function datatable_materi_list() {
        $lists 	= $this->m_start_trainer->get_datatables_materi();
        $data 	= array();
        $no 	= $_POST['start'];
        foreach ($lists as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nama_training;
            $row[] = $list->kode_materi;
            $row[] = $list->nama_materi;
            $row[] = '<a href="javascript:void(0)" 
			             id="select_materi" 
			             data-toggle="tooltip" 
			             title="Select Materi" 
                         data-sysid-training="'.$list->sysid_training.'"
                         data-kode-training="'.$list->kode_training.'"
                         data-nama-training="'.$list->nama_training.'"
			             data-sysid-materi="'.$list->sysid_materi.'"
			             data-kode-materi="'.$list->kode_materi.'"
			             data-nama-materi="'.$list->nama_materi.'" 			              
			             data-original-title="Select Materi" 
			             class="btn waves-effect waves-light btn-xs btn-danger">
			             	Pilih
			          </a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->m_start_trainer->count_all_materi(),
                        "recordsFiltered" => $this->m_start_trainer->count_filtered_materi(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function datatable_soal_list() {
    	$sysid_materi = $this->input->post('sysid_materi');
        $lists 	= $this->m_start_trainer->get_datatables_soal($sysid_materi);
        $data 	= array();
        $no 	= $_POST['start'];
        foreach ($lists as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->kode_soal;
            $row[] = $list->description_soal;
            $row[] = '<a href="javascript:void(0)" 
			             id="select_soal" 
			             data-toggle="tooltip" 
			             title="Select Soal" 
			             data-sysid-soal="'.$list->sysid.'"
			             data-kode-soal="'.$list->kode_soal.'"
			             data-description-soal="'.$list->description_soal.'"
                         data-waktu-soal="'.$list->waktu.'"
			             data-original-title="Select Soal" 
			             class="btn waves-effect waves-light btn-xs btn-danger">
			             	Pilih
			          </a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->m_start_trainer->count_all_soal($sysid_materi),
                        "recordsFiltered" => $this->m_start_trainer->count_filtered_soal($sysid_materi),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function generate_session_training() {
    	$generate_code = generate_random_string();

    	/* 
    	   	cek database, apakah code sudah pernah ada ?
    		kalau sudah ada, generate code yang lain
    		https://www.elated.com/php-recursive-functions/
    	*/
    	$query = $this->m_start_trainer->cek_session_code($generate_code)->num_rows();
    	if ($query == 0) {
            // simpan ke tabel
            $initial_trainer = $this->input->post('initial_trainer');            
            $data = array(
                'session_code'          => $generate_code,
                'tanggal'               => date_format(new DateTime($this->input->post('tanggal')), $this->config->item('FORMAT_DATE_TO_INSERT')),
                'jam'                   => date_format(new DateTime($this->input->post('jam')), $this->config->item('FORMAT_TIME_TO_INSERT')),
                'sysid_trainer'         => $this->input->post('sysid_trainer'),
                'kode_trainer'          => $this->input->post('kode_trainer'),
                'initial_trainer'       => $initial_trainer,
                'sysid_training'        => $this->input->post('sysid_training'),
                'kode_training'         => $this->input->post('kode_training'),
                'nama_training'         => $this->input->post('nama_training'),
                'sysid_materi'          => $this->input->post('sysid_materi'),
                'kode_materi'           => $this->input->post('kode_materi'),
                'sysid_soal'            => $this->input->post('sysid_soal'),
                'kode_soal'             => $this->input->post('kode_soal'),
                'description_soal'      => $this->input->post('description_soal'),
                'waktu'                 => $this->input->post('waktu_soal'),
                'rec_create_user'       => $initial_trainer,
                'rec_create_datetime'   => $this->config->item('FORMAT_NOW_DATETIME_TO_INSERT'),
                'rec_update_user'       => $initial_trainer,
                'rec_update_datetime'   => $this->config->item('FORMAT_NOW_DATETIME_TO_INSERT'),
            );
            $result = $this->db->insert($this->table_tmp_session_training_hdr, $data);
            if ($result == 1) {
                // simpan session
                $session_data = array(
                    'sess_status_training'                     => 'trainer',
                    'sess_code_fortrainer_training'            => $generate_code,
                    'sess_sysid_trainer_fortrainer_training'   => $this->input->post('sysid_trainer'),
                    'sess_kode_trainer_fortrainer_training'    => $this->input->post('kode_trainer'),
                    'sess_initial_trainer_fortrainer_training' => $this->input->post('initial_trainer'),
                    'sess_sysid_training_fortrainer_training'  => $this->input->post('sysid_training'),
                    'sess_kode_training_fortrainer_training'   => $this->input->post('kode_training'),
                    'sess_nama_training_fortrainer_training'   => $this->input->post('nama_training'),
                    'sess_sysid_materi_fortrainer_training'    => $this->input->post('sysid_materi'),
                    'sess_kode_materi_fortrainer_training'     => $this->input->post('kode_materi'),
                    'sess_sysid_soal_fortrainer_training'      => $this->input->post('sysid_soal'),
                    'sess_kode_soal_fortrainer_training'       => $this->input->post('kode_soal'),
                    'sess_tanggal_fortrainer_training'         => $this->input->post('tanggal'),
                    'sess_jam_fortrainer_training'             => $this->input->post('jam'),
                );
                $this->session->set_userdata($session_data);
                echo json_encode(['success'=>'Create Surat Jalan berhasil', 'success_training_code'=>'Training Code : '.$generate_code]);
            } else {
                echo json_encode(['error_insert_tmp'=>'Kesalahan di prosedur INSERT DATA. Silahkan hubungi administrator']);
            }
    	} else {
    		generate_session_training();
    	}
    }

    public function cek_trainer() {
        $initial_trainer = $this->input->post('initial_trainer');
        $query = $this->m_start_trainer->cek_trainer($initial_trainer)->num_rows();
        if ($query > 0) {
            // simpan session
            $session_data = array(
                'sess_status_training'                     => 'trainer',
                'sess_initial_trainer_fortrainer_training' => $initial_trainer,
            );
            $this->session->set_userdata($session_data);
            echo json_encode(['success'=>'Successfully']);
        } else {
            echo json_encode(['row_not_found'=>'Data trainer tidak ada di database !!!']);
        }
    }

}
