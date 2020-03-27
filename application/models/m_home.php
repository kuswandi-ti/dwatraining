<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_home extends CI_Model {

	private $table_tmp_session_training_hdr;

	private $view_tmp_session_training_hdr;
	private $view_tmp_detail_nilai_peserta;

	var $column_order_session_training_hdr 	= array(null, 'sysid', 'session_code', 'tanggal', 'jam', 'sysid_trainer', 'kode_trainer', 'initial_trainer', 'sysid_training', 'kode_training', 'nama_training', 'sysid_materi', 'kode_materi', 'sysid_soal', 'description_soal', 'waktu', 'closed');
    var $column_search_session_training_hdr	= array('sysid', 'session_code', 'tanggal', 'jam', 'sysid_trainer', 'kode_trainer', 'initial_trainer', 'sysid_training', 'kode_training', 'nama_training', 'sysid_materi', 'kode_materi', 'sysid_soal', 'description_soal', 'waktu', 'closed');
    var $order_session_training_hdr 		= array('initial_trainer' => 'asc');

    var $column_order_detail_nilai_peserta 	= array(null, 'session_code', 'nik', 'nama', 'kode_nama_materi', 'nilai_pre', 'nilai_post', 'nilai_total', 'nilai_minimum', 'status_lulus');
    var $column_search_detail_nilai_peserta	= array('session_code', 'nik', 'nama', 'kode_nama_materi', 'nilai_pre', 'nilai_post', 'nilai_total', 'nilai_minimum', 'status_lulus');
    var $order_detail_nilai_peserta 		= array('session_code' => 'asc');
		
	function __construct() {
		parent::__construct();

		$this->table_tmp_session_training_hdr 	= $this->config->item('TABLE_TMP_SESSION_TRAINING_HDR');

		$this->view_tmp_session_training_hdr 	= $this->config->item('QUERY_TMP_SESSION_INFO_HDR');
		$this->view_tmp_detail_nilai_peserta 	= $this->config->item('QUERY_TMP_DETAIL_NILAI_PESERTA');
	}

	public function total_data($table, $where) {
		$query = $this->db->get_where($table, $where); 
		if ($query->num_rows() > 0) {
			$count_rows = $query->num_rows(); 
		} else {
			$count_rows = 0; 
		} 
		return $count_rows; 
	}

	/* https://stackoverflow.com/questions/13812196/return-empty-array-in-php */
	public function detail_data($select, $table, $where = null, $order = null, $limit = null) {
		if ($order != null) {
			$this->db->order_by($order, 'ASC'); 
		}
		if ($limit != null) {
			$this->db->limit($limit);
		}

		$query = $this->db->select($select)->get_where($table, $where); 
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row; 
			}
			return $data;
		} else {
			return [];
		} 
	}

	public function row_data($select, $table, $where = null, $order = null, $limit = null) {
		if ($order != null) {
			$this->db->order_by($order, 'ASC'); 
		}
		if ($limit != null) {
			$this->db->limit($limit);
		}

		$query = $this->db->select($select)->get_where($table, $where);
		return $query->row_array();
	}

	public function single_field($field, $table, $where) {
		// https://stackoverflow.com/questions/16954107/getting-the-value-of-the-single-field-output-using-the-codeigniter-active-record
		return $this->db->get_where($table, $where)->row()->$field;
	}

	/* DataTable List Peserta */
	private function _get_datatables_query_list_peserta($initial_trainer) {
		$this->db->where(array('initial_trainer' => $initial_trainer));
        $this->db->from($this->view_tmp_session_training_hdr); 
        $i = 0;     
        foreach ($this->column_search_session_training_hdr as $item) {
            if($_POST['search']['value']) {                 
                if($i===0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search_session_training_hdr) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->db->order_by($this->column_search_session_training_hdr[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_list_peserta($initial_trainer) {
        $this->_get_datatables_query_list_peserta($initial_trainer);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_list_peserta($initial_trainer) {
        $this->_get_datatables_query_list_peserta($initial_trainer);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_list_peserta($initial_trainer) {
    	$this->db->where(array('initial_trainer' => $initial_trainer));
        $this->db->from($this->view_tmp_session_training_hdr);
        return $this->db->count_all_results();
    }
	/* DataTable List Peserta */

	/* DataTable Detail Peserta */
	private function _get_datatables_detail_nilai_peserta($session_code) {
        $this->db->where(array('session_code' => $session_code));
        $this->db->from($this->view_tmp_detail_nilai_peserta); 
        $i = 0;     
        foreach ($this->column_search_detail_nilai_peserta as $item) {
            if($_POST['search']['value']) {                 
                if($i===0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search_detail_nilai_peserta) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->db->order_by($this->column_search_detail_nilai_peserta[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_detail_nilai_peserta($session_code) {
        $this->_get_datatables_detail_nilai_peserta($session_code);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_detail_nilai_peserta($session_code) {
        $this->_get_datatables_detail_nilai_peserta($session_code);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_detail_nilai_peserta($session_code) {
        $this->db->where(array('session_code' => $session_code));
        $this->db->from($this->view_tmp_detail_nilai_peserta);
        return $this->db->count_all_results();
    }
	/* DataTable Detail Peserta */

	function edit_data_training($session_code) {
    	$this->db->from($this->table_tmp_session_training_hdr);
        $this->db->where('session_code', $session_code);
        $query = $this->db->get(); 
        return $query->row();
    }

    function update_data_training($session_code, $open_close) {
    	$data = array(
    		'closed' => $open_close,
    	);
    	$this->db->where('session_code', $session_code); 
    	$res_update = $this->db->update($this->table_tmp_session_training_hdr, $data);

    	if ($res_update == 1) {
    		echo json_encode(['success_update' => 'Sukses update data training']);
    	} else {
    		echo json_encode(['failed_update' => 'Error proses update data training']);
    	}
    }

}
