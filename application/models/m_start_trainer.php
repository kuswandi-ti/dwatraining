<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class m_start_trainer extends CI_Model {

	private $table_mst_trainer;
    private $table_mst_soal_hdr;

    private $table_tmp_session_training_hdr;

    private $view_mst_materi;

	var $column_order_trainer 		= array(null, 'sysid', 'kode_trainer', 'initial_trainer', 'nama_trainer');
    var $column_search_trainer 	    = array('sysid', 'kode_trainer', 'initial_trainer', 'nama_trainer');
    var $order_trainer              = array('nama_trainer' => 'asc');

    var $column_order_materi        = array(null, 'sysid_materi', 'kode_materi', 'nama_materi', 'Nama_Training');
    var $column_search_materi       = array('sysid_materi', 'kode_materi', 'nama_materi', 'Nama_Training');
    var $order_materi               = array('Nama_Training' => 'asc', 'nama_materi' => 'asc');

    var $column_order_soal          = array(null, 'sysid', 'kode_soal', 'description_soal');
    var $column_search_soal         = array('sysid', 'kode_soal', 'description_soal');
    var $order_soal                 = array('kode_soal' => 'asc', 'description_soal' => 'asc');

	function __construct() {
		parent::__construct();

		$this->table_mst_trainer                = $this->config->item('TABLE_MST_TRAINER');
        $this->table_mst_soal_hdr               = $this->config->item('TABLE_MST_SOAL_HDR');

        $this->table_tmp_session_training_hdr   = $this->config->item('TABLE_TMP_SESSION_TRAINING_HDR');

        $this->view_mst_materi                  = $this->config->item('VIEW_MST_MATERI');
	}

	/* DataTable Trainer */
	private function _get_datatables_query_trainer() {         
        $this->db->from($this->table_mst_trainer); 
        $i = 0;     
        foreach ($this->column_search_trainer as $item) {
            if($_POST['search']['value']) {                 
                if($i===0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search_trainer) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->db->order_by($this->column_search_trainer[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_trainer() {
        $this->_get_datatables_query_trainer();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_trainer() {
        $this->_get_datatables_query_trainer();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_trainer() {
        $this->db->from($this->table_mst_trainer);
        return $this->db->count_all_results();
    }
	/* DataTable Trainer */

    /* DataTable Materi */
    private function _get_datatables_query_materi() {         
        $this->db->from($this->view_mst_materi); 
        $i = 0;     
        foreach ($this->column_search_materi as $item) {
            if($_POST['search']['value']) {                 
                if($i===0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search_materi) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->db->order_by($this->column_search_materi[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_materi() {
        $this->_get_datatables_query_materi();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_materi() {
        $this->_get_datatables_query_materi();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_materi() {
        $this->db->from($this->view_mst_materi);
        return $this->db->count_all_results();
    }
    /* DataTable Materi */

    /* DataTable Soal */
    private function _get_datatables_query_soal($sysid_materi) {
        $this->db->where(array('sysid_materi' => $sysid_materi));
        $this->db->from($this->table_mst_soal_hdr); 
        $i = 0;     
        foreach ($this->column_search_soal as $item) {
            if($_POST['search']['value']) {                 
                if($i===0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search_soal) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->db->order_by($this->column_search_soal[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_soal($sysid_materi) {
        $this->_get_datatables_query_soal($sysid_materi);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_soal($sysid_materi) {
        $this->_get_datatables_query_soal($sysid_materi);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_soal($sysid_materi) {
        $this->db->where(array('sysid_materi' => $sysid_materi));
        $this->db->from($this->table_mst_soal_hdr);
        return $this->db->count_all_results();
    }
    /* DataTable Soal */

    function cek_session_code($session_code) {
        return $this->db->get_where($this->table_tmp_session_training_hdr, array('session_code'=>$session_code));
    }

    function cek_trainer($initial_trainer) {
        return $this->db->get_where($this->table_mst_trainer, array('initial_trainer'=>$initial_trainer));
    }

}
