<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
	$sess_status_training = $this->session->userdata('sess_status_training');
	if ($sess_status_training == 'trainer') {
?>
		<div class="card">
			<div class="card-header" id="headingOne">
  				<h5 class="mb-0">Daftar Peserta Training</h5>
			</div>
			<div class="card-body">
				<div class="row">
		            <div class="col-md-12">
		            	<div class="table-responsive">
			                <table id="tbl_list_peserta" class="table table-striped dt-responsive" width="100%">
			                    <thead>
			                        <tr>
			                        	<th class="text-center">No.</th>
			                            <th class="text-center">Session Code</th>
			                            <th class="text-center">Tgl - jam</th>
			                            <th class="text-left">Nama Trainer</th>
			                            <th class="text-left">Nama Materi</th>
			                            <th class="text-left">Soal Training</th>
			                            <th class="text-center">Waktu (menit)</th>
			                            <th class="text-center">Status</th>
			                            <th class="text-center">Action</th>
			                        </tr>
			                    </thead>
			                    <tbody></tbody>
			                </table>
			            </div>
		            </div>
		        </div>
		    </div>
		</div>


<?php
	} else if ($sess_status_training == 'peserta') {
?>
	<form id="form_header">
		<div class="accordion" id="accordionExample">
  			<div class="card">
    			<div class="card-header" id="headingOne">
      				<h5 class="mb-0">
        				<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Informasi Peserta Test&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down"></i>
        				</button>
      				</h5>
    			</div>

    			<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      				<div class="card-body">
        				<div class="row">
							<div class="col-lg-12">
							    <div class="form-group row">
							        <label for="materi_training" class="control-label col-sm-3">Materi Training</label>
							        <div class="col-sm-9">
							          	<input type="text" class="form-control" name="materi_training" id="materi_training" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['kode_nama_materi'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="sysid_materi" id="sysid_materi" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['sysid_materi'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="kode_materi" id="kode_materi" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['kode_materi'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="nama_materi" id="nama_materi" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['nama_materi'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="total_soal" id="total_soal" readonly value="<?php echo $jumlah_soal; ?>">
							          	<input type="hidden" class="form-control" name="sysid_training" id="sysid_training" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['sysid_training'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="kode_training" id="kode_training" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['kode_training'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="nama_training" id="nama_training" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['nama_training'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="waktu_soal" id="waktu_soal" readonly value="<?php echo $waktu_soal; ?>">
							          	<input type="hidden" class="form-control" name="nilai_minimum" id="nilai_minimum" readonly value="<?php echo $nilai_minimum; ?>">
							        </div>
							    </div>
							    <div class="form-group row">
							        <label for="penyelenggara_training" class="control-label col-sm-3">Penyelenggara Training</label>
							        <div class="col-sm-9">
							          	<input type="text" class="form-control" name="penyelenggara_training" id="penyelenggara_training" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['kode_nama_trainer'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="nama_trainer" id="nama_trainer" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['nama_trainer'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="sysid_trainer" id="sysid_trainer" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['sysid_trainer'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="kode_trainer" id="kode_trainer" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['kode_trainer'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="initial_trainer" id="initial_trainer" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['initial_trainer'] : ''; ?>">
							        </div>
							    </div>
							    <div class="form-group row">
							        <label for="penyelenggara_training" class="control-label col-sm-3">Hari / Tanggal</label>
							        <div class="col-sm-6">
							          	<input type="text" class="form-control" name="hari" id="hari" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['hari'] : ''; ?>">
							        </div>
							        <div class="col-sm-3">
							          	<input type="text" class="form-control" name="tanggal" id="tanggal" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['tanggal'] : ''; ?>">
							        </div>
							    </div>
							    <div class="form-group row">
							        <label for="penyelenggara_training" class="control-label col-sm-3">NIK</label>
							        <div class="col-sm-9">
							          	<input type="text" class="form-control" name="nik" id="nik" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['nik'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="sysid_karyawan" id="sysid_karyawan" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['sysid_karyawan'] : ''; ?>">
							        </div>
							    </div>
							    <div class="form-group row">
							        <label for="penyelenggara_training" class="control-label col-sm-3">Nama Peserta</label>
							        <div class="col-sm-9">
							          	<input type="text" class="form-control" name="nama_peserta" id="nama_peserta" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['nama'] : ''; ?>">
							        </div>
							    </div>
							    <div class="form-group row">
							        <label for="penyelenggara_training" class="control-label col-sm-3">Dept. / Sect.</label>
							        <div class="col-sm-9">
							          	<input type="text" class="form-control" name="dept_sect" id="dept_sect" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['dept_sect'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="dept_id" id="dept_id" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['dept_id'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="dept_code" id="dept_code" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['dept_code'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="dept_alias" id="dept_alias" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['dept_alias'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="sect_id" id="sect_id" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['sect_id'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="sect_code" id="sect_code" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['sect_code'] : ''; ?>">
							          	<input type="hidden" class="form-control" name="sect_alias" id="sect_alias" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['sect_alias'] : ''; ?>">
							        </div>
							    </div>
							    <div class="form-group row">
							        <label for="penyelenggara_training" class="control-label col-sm-3">Jabatan</label>
							        <div class="col-sm-9">
							          	<input type="text" class="form-control" name="jabatan" id="jabatan" readonly value="<?php echo isset($data_info_session_training) ? $data_info_session_training['jabatan'] : ''; ?>">
							        </div>
							    </div>
							</div>
						</div>
      				</div>
    			</div>
  			</div>
  		</div>
  	</form>

  	<?php echo $soal; ?>

		
<?php
	}
?>

<!-- Pop Up Browse Nilai Peserta -->
<div id="modal_detail_nilai_peserta" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Nilai Peserta Training</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="overflow: hidden;">
            	<div class="row">
                    <div class="col-md-12">
                    	<div class="table-responsive">
			                <table id="tbl_detail_nilai_peserta" class="table table-striped dt-responsive" width="100%">
			                    <thead>
			                        <tr>
			                        	<th class="text-center">No.</th>
			                            <th class="text-center">NIK</th>
			                            <th class="text-left">Nama</th>
			                            <th class="text-left">Materi Training</th>
			                            <th class="text-center">Nilai Pre Test</th>
			                            <th class="text-center">Nilai Post Test</th>
			                            <th class="text-center">Nilai Total Test</th>
			                            <th class="text-center">Nilai Minimum Test</th>
			                            <th class="text-center">Lulus / Tidak Lulus</th>
			                        </tr>
			                    </thead>
			                    <tbody></tbody>
			                </table>
			            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class="btn-label"><i class="ti-power-off "></i></span> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Pop Up Edit Training -->
<div id="modal_edit_training" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Training</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="overflow: hidden;">
            	<div class="row">
                    <div class="col-md-12">
                    	<form class="form-horizontal" id="form_training" name="form_training">
	                    	<input type="hidden" class="form-control" name="session_code_edit" id="session_code_edit" readonly>
	                    	<div class="form-group">
	                    		<input type="radio" id="rdo_open" name="open_close" value="0" required>&nbsp;
	                    		<label for="rdo_open">Open Training</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" id="rdo_close" name="open_close" value="1" required>&nbsp;
								<label for="rdo_close">Close Training</label>
	                    	</div>
	                    </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-info" id="btn_save_training" name="btn_save_training">
                    <span class="btn-label"><i class="ti-save "></i></span> Save
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class="btn-label"><i class="ti-power-off "></i></span> Close
                </button>
            </div>
        </div>
    </div>
</div>
