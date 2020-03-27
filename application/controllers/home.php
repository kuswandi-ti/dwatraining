<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {

	private $table_mst_soal_hdr;
	private $table_mst_soal_dtl;
	private $table_mst_training_hdr;
	private $table_mst_training_dtl;
	private $table_tmp_session_training_dtl;
	private $table_tmp_session_training_dtl_sub;

	private $view_tmp_session_training;

	private $sess_status_training;
	private $sess_nik_training;
	private $sess_code_training;
	private $sess_source_test;

	private $session_info;

	private $sysid_training;
	private $kode_training;
	private $nama_training;
	private $sysid_soal;
	private $waktu_soal;
	private $target_soal;
	private $kode_materi;

	public function __construct() {
		parent::__construct();

		$this->auth->restrict();
		
		$this->table_mst_soal_hdr 					= $this->config->item('TABLE_MST_SOAL_HDR');
		$this->table_mst_soal_dtl 					= $this->config->item('TABLE_MST_SOAL_DTL');
		$this->table_mst_training_hdr 				= $this->config->item('TABLE_TRX_TRAINING_HDR');
		$this->table_mst_training_dtl 				= $this->config->item('TABLE_TRX_TRAINING_DTL');
		$this->table_tmp_session_training_dtl 		= $this->config->item('TABLE_TMP_SESSION_TRAINING_DTL');
		$this->table_tmp_session_training_dtl_sub 	= $this->config->item('TABLE_TMP_SESSION_TRAINING_DTL_SUB');

		$this->view_tmp_session_training 			= $this->config->item('QUERY_TMP_SESSION_INFO');

		$this->sess_status_training = ucfirst($this->session->userdata('sess_status_training'));
		$this->sess_nik_training 	= $this->session->userdata('sess_nik_karyawan_forpeserta_training');
		$this->sess_code_training 	= $this->session->userdata('sess_kode_training_forpeserta_training');
		$this->sess_source_test 	= $this->session->userdata('sess_source_test_forpeserta_training');

		$this->load->model('m_home');
	}

	public function index() {
    	$data = array(
			'title' 			=> $this->sess_status_training,
			'page_title' 		=> $this->sess_status_training,
			'breadcrumb' 		=> '',
			'custom_scripts' 	=> "<script src=".$this->config->item('PATH_ASSET_CUSTOM_SCRIPTS')."home.js type='text/javascript'></script>"
		);
    	if ($this->sess_status_training == 'Peserta') {
    		$this->session_info = $this->m_home->row_data('*', $this->view_tmp_session_training, array('session_code'=>$this->sess_code_training, 'nik'=>$this->sess_nik_training));
    		$data['data_info_session_training'] = $this->session_info;
    		$this->sysid_soal = (isset($this->session_info)) ? $this->session_info['sysid_soal']  : '';
    		$this->kode_materi = (isset($this->session_info)) ? $this->session_info['kode_materi']  : '';
    		$this->sysid_training = (isset($this->session_info)) ? $this->session_info['sysid_training']  : '';
    		$this->kode_training = (isset($this->session_info)) ? $this->session_info['kode_training']  : '';
    		$this->nama_training = (isset($this->session_info)) ? $this->session_info['nama_training']  : '';
    		$data['soal'] = $this->show_soal($this->sysid_soal, $this->kode_materi);
    		$data['jumlah_soal'] = $this->m_home->total_data($this->table_mst_soal_dtl, array('sysid_hdr'=>$this->sysid_soal, 'parent_id'=>0));
    		$data['waktu_soal'] = (isset($this->session_info)) ? $this->session_info['waktu']  : 0;
    		$data['nilai_minimum'] = $this->m_home->single_field('nilai_minimum', $this->table_tmp_session_training_dtl, array('session_code'=>$this->sess_code_training, 'nik'=>$this->sess_nik_training, 'pre_post'=>'pre'));

    	} else if ($this->sess_status_training == 'Trainer') {

    	}
		$this->template->view('v_home', $data);
	}

	public function datatable_list_peserta() {
		$initial_trainer = $this->session->userdata('sess_initial_trainer_fortrainer_training');
        $lists 	= $this->m_home->get_datatables_list_peserta($initial_trainer);
        $data 	= array();
        $no 	= $_POST['start'];
        foreach ($lists as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->session_code;
            $row[] = date_format(new DateTime($list->tanggal), $this->config->item('FORMAT_DATE_TO_DISPLAY')).' - '.$list->jam;
            $row[] = $list->kode_nama_trainer;
            $row[] = $list->kode_training.' - '.$list->nama_training;
            $row[] = $list->kode_soal.' - '.$list->description_soal;
            $row[] = $list->waktu;
            $row[] = ($list->closed == '0') ? '<span id="status" class="badge badge-info">Open</span>' : '<span id="status" class="badge badge-danger">Closed</span>';
			$row[] = '<a href="javascript:void(0)" 
			             id="select_detail" 
			             data-toggle="tooltip" 
			             title="Select Detail" 
			             data-session-code="'.$list->session_code.'" 
			             data-original-title="Select Detail" 
			             class="btn waves-effect waves-light btn-xs btn-success">
			             	<i class="fas fa-align-justify"></i> Detail
			          </a>
			          <a href="javascript:void(0)" 
			             id="edit_training" 
			             data-toggle="tooltip" 
			             title="Edit Training" 
			             data-session-code="'.$list->session_code.'" 
			             data-original-title="Edit Training" 
			             class="btn waves-effect waves-light btn-xs btn-warning">
			             	<i class="fas fa-edit"></i> Edit
			          </a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->m_home->count_all_list_peserta($initial_trainer),
                        "recordsFiltered" => $this->m_home->count_filtered_list_peserta($initial_trainer),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function datatable_detail_nilai_peserta() {
    	$session_code = $this->input->post('session_code');
        $lists 	= $this->m_home->get_datatables_detail_nilai_peserta($session_code);
        $data 	= array();
        $no 	= $_POST['start'];
        foreach ($lists as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nik;
            $row[] = $list->nama;
            $row[] = $list->kode_nama_materi;
            $row[] = $list->nilai_pre;
            $row[] = $list->nilai_post;
            $row[] = $list->nilai_total;
            $row[] = $list->nilai_minimum;
            $row[] = $list->status_lulus;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->m_home->count_all_detail_nilai_peserta($session_code),
                        "recordsFiltered" => $this->m_home->count_filtered_detail_nilai_peserta($session_code),
                        "data" => $data,
                );
        echo json_encode($output);
    }

	public function show_soal($sysid_soal_hdr, $kode_materi) {
		if ($this->sess_source_test == 'pre') {
			$sort_by_soal = 'sysid';
		} else {
			$sort_by_soal = 'description_soal_pilihan';
		}
		$soal 	= $this->m_home->detail_data('*', $this->table_mst_soal_dtl, array('sysid_hdr'=>$sysid_soal_hdr, 'parent_id'=>0), $sort_by_soal);
		$no 	= 0;
		$result = '';

		$result .= "<div class='row'>";
        $result .= 		"<div class='col-12'>";
        $result .= 			"<div class='card'>";
        $result .= 				"<div class='card-body wizard-content'>";
        $result .= 					"<h4 class='card-title'>".strtoupper($this->sess_source_test).' TEST'."</h4>";
        $result .= 					"<h6 class='card-subtitle'>Jawablah dengan tepat pertanyaan di bawah ini, dengan melingkari / O pilihan jawaban di bawahnya</a></h6>";
        $result .= 					"<div class='row'>";
	    $result .= 						"<div class='col-12'>";
	    $result .= 							"<div class='card'>";
	    $result .= 								"<div class='card-body'>";
	    $result .= 									"<div class='row'>";
	    $result .= 										"<div class='col-md-12 timer'>";
	    $result .= 											"<h1 class='box-title text-center text-danger font-bold'></h1>";
	    $result .= 										"</div>";
	    $result .= 									"</div>";
	    $result .= 									"<div class='row'>";
	    $result .= 										"<div class='col-md-12'>";
	    $result .= 											"<button type='button' id='btn_timer' name='btn_timer' class='btn waves-effect waves-light btn-lg btn-danger btn-block'><i class='fas fa-play-circle'></i> &nbsp;Start</button>";
	    $result .= 										"</div>";
	    $result .= 									"</div>";
	    $result .= 								"</div>";
	    $result .= 							"</div>";
	    $result .= 						"</div>";
		$result .= 					"</div>";
        $result .= 					"<form id='form_detail' action='#' class='tab-wizard wizard-circle'>";
        							foreach($soal as $val) {
										$no++;
										$sysid_parent 	= $val['sysid'];
										$text_soal 		= $val['description_soal_pilihan'];
										$kode_jawaban 	= $val['kode_jawaban'];
		$result .= 						"<h6>&nbsp;</h6>";
		$result .=						"<section>";
		$result .=							"<div class='row'>";
		$result .= 								"<div class='col-md-12'>";
		$result .= 									"<h4>".$no.'. &nbsp;&nbsp;'.$text_soal."</h4>";
		$result .= 								"</div>";
		$result .= 							"</div>";		
											$pilihan_jawaban = $this->m_home->detail_data('*', $this->table_mst_soal_dtl, array('parent_id'=>$sysid_parent), 'kode_soal_pilihan');
											foreach($pilihan_jawaban as $value) {
												$jawaban_id 			= "jawaban_".$value['sysid'];
												$jawaban_name1 			= "no_".func_right("0000".$no, 3)."_soal_id_000".func_right("0000000000".$sysid_parent, 10);
												$jawaban_name 			= "radio[$jawaban_name1]";
												$tipe_soal  			= $value['tipe_soal'];
												$text_pilihan_jawaban	= $value['description_soal_pilihan'];
												$huruf_jawaban 			= $value['kode_soal_pilihan'];
												$value_input 			= 'k'.$kode_jawaban.'j'.$huruf_jawaban;
												if ($tipe_soal == 'T') {
													$show_jawaban = $text_pilihan_jawaban;
												} else if ($tipe_soal == 'I') {
													$show_jawaban = "<img src='assets/img/soal/$kode_materi/$text_pilihan_jawaban'>";
												}

		$result .= 								"<div class='row'>";
		$result .=									"<div class='col-md-12'>";
		$result .= 										"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$result .=										"<input type='radio' class='check required' id='".$jawaban_id."' name='".$jawaban_name."' value='".$value_input."'><label for='$jawaban_id'>&nbsp;&nbsp;".$huruf_jawaban.'.&nbsp;&nbsp;'.$show_jawaban."&nbsp;&nbsp;&nbsp;</label>";
		$result .= 										"<br>";
		$result .=									"</div>";
		$result .= 								"</div>";
											}
			$result .=					"</section>";												
									}
        $result .=					"</form>";
        $result .=				"</div>";
        $result .=			"</div>";
        $result .=		"</div>";
        $result .=	"</div>";

		return $result;
	}

	public function proses_training_peserta() {
		/* https://www.daniweb.com/programming/web-development/threads/428425/how-to-get-the-value-of-a-radio-button-with-dynamic-name */
		// no_001_soal_id_0000000000051 - kDjD
		$total_soal 	= $this->input->post('total_soal');

		$answers 		= isset($_POST['radio']) ? $_POST['radio'] : array();
		$answers_keys 	= array_keys($answers); // untuk menampung keys & value array
		$total_jawaban 	= count($answers);
		
		$jawaban_key	= '';		
		$no_urut_soal 	= '';
		$sysid_soal_dtl = '';
		$jawaban_val 	= '';
		$kunci_huruf	= '';
		$jawaban_huruf	= '';
		$hasil_soal 	= '';
		$jawaban_benar  = 0;

		$result_sum 	= 0;

		// https://www.tutorialrepublic.com/php-tutorial/php-loops.php
		// https://stackoverflow.com/questions/1951690/how-to-loop-through-an-associative-array-and-get-the-key		
		for ($x=0; $x<$total_jawaban; $x++) { // looping sebanyak total soal
			$jawaban_key 	= isset($answers_keys[$x]) ? $answers_keys[$x] : 'no_000_soal_id_0000000000000';
			$no_urut_soal	= (int)substr($jawaban_key, 3, 3); // no_[000]_soal_id_0000000000000
			$sysid_soal_dtl	= (int)func_right($jawaban_key, 10); // no_000_soal_id_[0000000000000]
			$jawaban_val 	= isset($answers[$answers_keys[$x]]) ? $answers[$answers_keys[$x]] : 'kXjY';
			$kunci_huruf 	= substr($jawaban_val, 1, 1); // k[X]jY
			$jawaban_huruf 	= substr($jawaban_val, 3, 1); // kXj[Y]
			if ($kunci_huruf == $jawaban_huruf) { // jika soal & jawaban benar, nilai ditambah 1
				$hasil_soal = '1';
				$jawaban_benar = $jawaban_benar + 1;
			} else {
				$hasil_soal = '0';
				$jawaban_benar = $jawaban_benar;
			}

			// insert ke tabel detail sub
			$data = array(
	            'session_code'      	=> $this->sess_code_training,
	            'pre_post'        		=> $this->session->userdata('sess_source_test_forpeserta_training'),
	            'sysid_karyawan'        => $this->input->post('sysid_karyawan'),
	            'nik'        			=> $this->input->post('nik'),
	            'sysid_soal_dtl'        => $sysid_soal_dtl,
	            'kunci_huruf'        	=> $kunci_huruf,
	            'jawaban_huruf'        	=> $jawaban_huruf,
	            'hasil'        			=> $hasil_soal,
	            'rec_create_user'       => $this->input->post('nik'),
	            'rec_create_datetime'   => $this->config->item('FORMAT_NOW_DATETIME_TO_INSERT'),
	            'rec_update_user'       => $this->input->post('nik'),
	            'rec_update_datetime'   => $this->config->item('FORMAT_NOW_DATETIME_TO_INSERT'),
	        );
	        $result = $this->db->insert($this->table_tmp_session_training_dtl_sub, $data);
	        if ($result == 1) {
	        	$result_sum = $result_sum + 1;
	        }
		}

		// https://www.w3resource.com/php/statement/foreach.php

		if ($result_sum > 0) { // Jika ada lebih dari sama dengan 1
			if ($this->sess_source_test == 'pre') {
				$session_data = array(
		            'sess_nilai_pre_forpeserta_training' => $jawaban_benar,
		        );
		        $this->session->set_userdata($session_data);
			}

			if ($this->sess_source_test == 'post') { // Jika post test, insert ke tabel transaksi header & detail
				/* 	Generate Doc No
					Karena proses submit hampir dilakukan bersamaan, maka kemungkinan nomer sama mungkin terjadi.
				 	Untuk menghindari itu, maka (sementara?) docno diganti dengan session code
				*/
				// 1. Insert ke tabel header
				$data = array(
		            'SysId_CodeTRN'     => $this->input->post('kode_training'),
		            'Ket_CodeTRN'       => $this->input->post('nama_training'),
		            'DocNo'        		=> $this->sess_code_training,
		            'DocDate'        	=> $this->config->item('FORMAT_NOW_DATE_TO_INSERT'),
		            'Status'        	=> 'Internal',
		            'Penyelenggara'     => 'DWA',
		            'Waktu_Dari'       	=> $this->config->item('FORMAT_NOW_DATE_TO_INSERT'),
		            'Waktu_Sampai'      => $this->config->item('FORMAT_NOW_DATE_TO_INSERT'),
		            'Durasi'        	=> $this->input->post('waktu_soal'),
		            'TempatKota'        => 'DWA',
		            'Kode_Materi'       => $this->input->post('kode_materi'),
		            'Materi'        	=> $this->input->post('nama_materi'),
		            'Trainer'        	=> $this->input->post('nama_trainer'),
		            'Sertifikat'        => '0',
		            'Sifat'        		=> 'O',
		            'Levels'        	=> '0',
		            'Rec_UserId'       	=> $this->input->post('nik'),
		            'Rec_LastDateTime'  => $this->config->item('FORMAT_NOW_DATETIME_TO_INSERT'),
		        );
		        $this->db->insert($this->table_mst_training_hdr, $data);
		        $sysid_hdr = $this->db->insert_id();

		        // 2. Insert ke tabel detail
		        $data = array(
		            'SysId_Hdr'     	=> $sysid_hdr,
		            'SysId_Karyawan'    => $this->input->post('sysid_karyawan'),
		            'NIK'        		=> $this->input->post('nik'),
		            'Target'        	=> $this->input->post('nilai_minimum'),
		            'Pre_Test'        	=> (int)$this->session->userdata('sess_nilai_pre_forpeserta_training') * 10,
		            'Post_Test'     	=> $jawaban_benar * 10,
		            'Kehadiran'       	=> 0,
		            'Rec_UserId'       	=> $this->input->post('nik'),
		            'Rec_LastDateTime'  => $this->config->item('FORMAT_NOW_DATETIME_TO_INSERT'),
		        );
		        $this->db->insert($this->table_mst_training_dtl, $data);
			}

			$this->close_session_training();
			echo json_encode(['success' => "Sukses submit training<br/><br/>Dari total soal ".$total_soal.", anda menjawab sebanyak ".$total_jawaban."<br/>Jabawan yang benar sebanyak ".$jawaban_benar]);
		} else {
			echo json_encode(['error' => "Gagal submit training"]);
		}
	}

	public function edit_data_training($session_code) {
        $data = $this->m_home->edit_data_training($session_code);
        echo json_encode($data);
    }

    public function update_data_training() {
        $session_code 	= $this->input->post('session_code_edit');
        $open_close 	= $this->input->post('open_close');

        return $this->m_home->update_data_training($session_code, $open_close);
    }

	public function get_waktu_soal() {
		$this->session_info = $this->m_home->row_data('*', $this->view_tmp_session_training, array('session_code'=>$this->sess_code_training, 'nik'=>$this->sess_nik_training));
		$sysidsoal = (isset($this->session_info)) ? $this->session_info['sysid_soal']  : '';
    	$data = $this->m_home->single_field('waktu', $this->table_mst_soal_hdr, array('sysid'=>$sysidsoal));
    	echo json_encode(['result' => $data]);
    }

	public function close_session_training() {
		$sess_status_training = $this->session->userdata('sess_status_training');
        if ($sess_status_training == 'trainer') {
        	$array_items = array('sess_status_training', 'sess_code_fortrainer_training', 'sess_sysid_trainer_fortrainer_training', 'sess_kode_trainer_fortrainer_training', 'sess_initial_trainer_fortrainer_training', 'sess_sysid_training_fortrainer_training', 'sess_kode_training_fortrainer_training', 'sess_nama_training_fortrainer_training', 'sess_sysid_materi_fortrainer_training', 'sess_kode_materi_fortrainer_training', 'sess_sysid_soal_fortrainer_training', 'sess_kode_soal_fortrainer_training', 'sess_tanggal_fortrainer_training', 'sess_jam_fortrainer_training');

		} else if ($sess_status_training == 'peserta') {
        	$array_items = array('sess_status_training', 'sess_source_test_forpeserta_training', 'sess_sysid_department_forpeserta_training', 'sess_initial_department_forpeserta_training', 'sess_sysid_karyawan_forpeserta_training', 'sess_nik_karyawan_forpeserta_training', 'sess_kode_training_forpeserta_training');
		}

        $this->session->unset_userdata($array_items);
    }

}