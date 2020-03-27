<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_start_peserta extends CI_Model {

    private $table_mst_department;
    private $table_mst_jabatan_training;
    private $table_tmp_session_training_hdr;
    private $table_tmp_session_training_dtl;

    private $query_mst_karyawan_aktif;

    function __construct() {
        parent::__construct();

        $this->table_mst_department             = $this->config->item('TABLE_MST_DEPARTMENT');        
        $this->table_mst_jabatan_training       = $this->config->item('TABLE_MST_JABATAN_TRAINING');
        $this->table_tmp_session_training_hdr   = $this->config->item('TABLE_TMP_SESSION_TRAINING_HDR');
        $this->table_tmp_session_training_dtl   = $this->config->item('TABLE_TMP_SESSION_TRAINING_DTL');

        $this->query_mst_karyawan_aktif         = $this->config->item('QUERY_MST_KARYAWAN_AKTIF');
    }

    function get_data_department() {
        $this->db->order_by('Dept_Alias', 'asc');
        return $this->db->get($this->table_mst_department);
    }

    function get_data_jabatan_training() {
        $this->db->order_by('nama_jabatan', 'asc');
        return $this->db->get($this->table_mst_jabatan_training);
    }

    function get_data_karyawan_aktif($dept_id) {
        $this->db->select("SysId, NIK, concat_ws('  -  ', NIK, Nama) as NIK_Nama")
                 ->from($this->query_mst_karyawan_aktif)
                 ->where('Dept_Id', $dept_id)
                 ->order_by('Nama', 'ASC');
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // https://stackoverflow.com/questions/16954107/getting-the-value-of-the-single-field-output-using-the-codeigniter-active-record
    function cek_kode_training($kode_training) {
        $this->db->select('session_code')->from($this->table_tmp_session_training_hdr)->where(array('session_code' => $kode_training, 'closed' => 0));
        $row = $this->db->get()->row();
        if (isset($row)) {
            return $row->session_code;
        } else {
            return false;
        }
    }

    function cek_session_training($nik, $kode_training, $source_test) {
        return $this->db->get_where($this->table_tmp_session_training_dtl, array('nik' => $nik, 'session_code' => $kode_training, 'pre_post' => $source_test));
    }

}
