<!DOCTYPE html>
<html lang="en">

	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Favicon icon -->
        <?php require_once('_partials/_favicon.php'); ?>

        <title><?php echo $this->config->item('WEB_TITLE'); ?> - Peserta</title>

        <?php require_once('_partials/_styles.php'); ?>
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

	<body>
	    <?php require_once('_partials/_preloader.php'); ?>

	    <!-- ============================================================== -->
	    <!-- Main wrapper - style you can find in pages.scss -->
	    <!-- ============================================================== -->
	    <section id="wrapper">	    	
	        <div class="login-register" style="background-image:url(<?php echo $this->config->item('PATH_ASSET_IMAGE'); ?>background/login-register.jpg);margin-top:-18px;">
	        	<br />
	            <div class="login-box card">
	                <div class="card-body">
	                	<img src="<?php echo $this->config->item('PATH_ASSET_IMAGE'); ?>logo/logo.png" style="display: block; margin-left: auto; margin-right: auto; width: 80%">
	                    <form class="form-horizontal" id="form_start_peserta" action="#">
	                        <h2 class="box-title m-b-20 text-center"><br />Registrasi Training</h2>

	                        <div class="row">
                            	<div class="col-md-12">
                            		<div class="form-group">
	                            		<input type="radio" id="rdo_pre" name="source_test" value="pre" required checked="true">&nbsp;<label for="rdo_pre">Pre Test</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" id="rdo_post" name="source_test" value="post" required>&nbsp;<label for="rdo_post">Post Test</label>
	                            	</div>
                            	</div>
                            </div>

	                        <div class="row">
                            	<div class="col-md-12">
                            		<div class="form-group">
										<select class="form-control select2" name="cbodepartment_all" id="cbodepartment_all">
											<option selected value="0">Pilih Departemen</option>
											<?php
												if ($get_data_department->num_rows() > 0) {
													foreach ($get_data_department->result() as $row) {
														echo "<option value='".$row->SysId."'
																	  dept_alias='".$row->Dept_Alias."'>".$row->Dept_Alias." - ".$row->Dept_Name."</option>";
													}
												}
											?>
										</select>
										<input type="hidden" class="form-control" id="sysid_department" name="sysid_department" readonly>
										<input type="hidden" class="form-control" id="init_department" name="init_department" readonly>
	                            	</div>
                            	</div>
                            </div>

                            <div class="row">
                            	<div class="col-md-12">
                            		<div class="form-group">
										<select class="form-control select2" name="cbokaryawan" id="cbokaryawan">
											<option selected hidden value="0">Pilih Karyawan</option>
										</select>
										<input type="hidden" class="form-control" id="sysid_karyawan" name="sysid_karyawan" readonly>
										<input type="hidden" class="form-control" id="nik_karyawan" name="nik_karyawan" readonly>
	                            	</div>
                            	</div>
                            </div>

                            <div class="row">
                            	<div class="col-md-12">
                            		<div class="form-group">
										<select class="form-control select2" name="cbojabatan" id="cbojabatan">
											<option selected value="0">Pilih Jabatan Karyawan</option>
											<?php
												if ($get_data_jabatan_training->num_rows() > 0) {
													foreach ($get_data_jabatan_training->result() as $row) {
														echo "<option value='".$row->sysid."' data_nilai_minimum='".$row->nilai_minimum."'>".$row->nama_jabatan."</option>";
													}
												}
											?>
										</select>
										<input type="hidden" class="form-control" id="sysid_jabatan" name="sysid_jabatan" readonly>
										<input type="hidden" class="form-control" id="nama_jabatan" name="nama_jabatan" readonly>
										<input type="hidden" class="form-control" id="nilai_minimum" name="nilai_minimum" readonly>
	                            	</div>
                            	</div>
                            </div>

	                        <div class="row">
                            	<div class="col-md-12">
                            		<div class="form-group">
	                            		<div class="input-group">
	                            			<div class="input-group-prepend">
		                                        <span class="input-group-text" id="basic-addon1">
		                                            <i class="fas fa-sticky-note"></i>
		                                        </span>
		                                    </div>
		                                    <input type="text" class="form-control" id="kode_training" name="kode_training" placeholder="Kode Training">
	                            		</div>
	                            	</div>
                            	</div>
                            </div>

	                        <div class="row">
	                            <div class="col-md-12">
	                                <button class="btn btn-danger btn-block" type="submit" id="btn_mulai"><span class="btn-label"><i class="fas fa-play-circle"></i></span>Start</button>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </section>
    
    	<?php require_once('_partials/_scripts.php'); ?>
        <?php echo $custom_scripts; ?>
	</body>
</html>