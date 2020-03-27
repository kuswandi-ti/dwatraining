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

        <title><?php echo $this->config->item('WEB_TITLE'); ?> - Trainer</title>

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
	        <div class="login-register" style="background-image:url(<?php echo $this->config->item('PATH_ASSET_IMAGE'); ?>background/login-register.jpg);">				
	            <div class="login-box card">
	                <div class="card-body">
	                	<img src="<?php echo $this->config->item('PATH_ASSET_IMAGE'); ?>logo/logo.png" style="display: block; margin-left: auto; margin-right: auto; width: 80%">
	                    <form class="form-horizontal" id="form_start_trainer" action="#">
	                        <h4 class="box-title text-center"><br />Generate Training Session (for Trainer)</h4>

	                        <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home2" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Generate</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile2" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Result</span></a> </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="home2" role="tabpanel">
                                    <div class="p-20">
                                        <div class="row">
			                            	<div class="col-md-12">
			                            		<div class="form-group">
				                            		<div class="input-group">
				                            			<div class="input-group-prepend">
					                                        <span class="input-group-text" id="basic-addon1">
					                                            <i class="fas fa-street-view"></i>
					                                        </span>
					                                    </div>
					                                    <input type="text" class="form-control" id="trainer" name="trainer" placeholder="Trainer" readonly>
					                                    <input type="hidden" class="form-control" id="sysid_trainer" name="sysid_trainer">
					                                    <input type="hidden" class="form-control" id="kode_trainer" name="kode_trainer">
					                                    <input type="hidden" class="form-control" id="initial_trainer" name="initial_trainer">
					                                    <div class="input-group-append">
				                                            <button class="btn btn-info" id="browse_trainer" type="button">Browse</button>
				                                        </div>
				                            		</div>
				                            	</div>
			                            	</div>
			                            </div>

			                            <div class="row">
			                            	<div class="col-md-12">
			                            		<div class="form-group">
				                            		<div class="input-group">
				                            			<div class="input-group-prepend">
					                                        <span class="input-group-text" id="basic-addon1">
					                                            <i class="fas fa-book"></i>
					                                        </span>
					                                    </div>
					                                    <input type="text" class="form-control" id="materi" name="materi" placeholder="Materi" readonly>
					                                    <input type="hidden" class="form-control" id="sysid_training" name="sysid_training">
					                                    <input type="hidden" class="form-control" id="kode_training" name="kode_training">
					                                    <input type="hidden" class="form-control" id="nama_training" name="nama_training">
					                                    <input type="hidden" class="form-control" id="sysid_materi" name="sysid_materi">
					                                    <input type="hidden" class="form-control" id="kode_materi" name="kode_materi">
					                                    <div class="input-group-append">
				                                            <button class="btn btn-info" id="browse_materi" type="button">Browse</button>
				                                        </div>
				                            		</div>
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
					                                    <input type="text" class="form-control" id="soal" name="soal" placeholder="Soal" readonly>
					                                    <input type="hidden" class="form-control" id="sysid_soal" name="sysid_soal">
					                                    <input type="hidden" class="form-control" id="kode_soal" name="kode_soal">
					                                    <input type="hidden" class="form-control" id="description_soal" name="description_soal">
					                                    <input type="hidden" class="form-control" id="waktu_soal" name="waktu_soal">
					                                    <div class="input-group-append">
				                                            <button class="btn btn-info" id="browse_soal" type="button">Browse</button>
				                                        </div>
				                            		</div>
				                            	</div>
			                            	</div>
			                            </div>

			                            <div class="row">
			                            	<div class="col-md-7">
			                            		<div class="form-group">
				                            		<div class="input-group">
				                            			<div class="input-group-prepend">
					                                        <span class="input-group-text" id="basic-addon1">
					                                            <i class="fas fa-calendar-alt"></i>
					                                        </span>
					                                    </div>
					                                    <input type="text" class="form-control date" id="tanggal" name="tanggal" placeholder="Tanggal" readonly>
				                            		</div>
				                            	</div>
			                            	</div>
			                            	<div class="col-md-5">
			                            		<div class="form-group">
				                            		<div class="input-group">
				                            			<div class="input-group-prepend">
					                                        <span class="input-group-text" id="basic-addon1">
					                                            <i class="fas fa-clock"></i>
					                                        </span>
					                                    </div>
					                                    <input type="text" class="form-control clock" id="jam" name="jam" placeholder="Jam" readonly>
				                            		</div>
				                            	</div>
			                            	</div>
			                            </div>
										
			                            <div class="row">
				                            <div class="col-md-12">
				                                <button class="btn btn-danger btn-md btn-block waves-effect waves-light" id="btn_generate" type="submit">Generate</button>
				                            </div>
				                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane  p-20" id="profile2" role="tabpanel">
                                	<div class="row">
		                            	<div class="col-md-12">
		                            		<div class="form-group">
			                            		<div class="input-group">
			                            			<div class="input-group-prepend">
				                                        <span class="input-group-text" id="basic-addon1">
				                                            <i class="far fa-file-code"></i>
				                                        </span>
				                                    </div>
				                                    <input type="text" class="form-control" id="initial_trainer2" name="initial_trainer2" placeholder="Masukkan Initial Trainer">
			                            		</div>
			                            	</div>
		                            	</div>
		                            </div>
										
		                            <div class="row">
			                            <div class="col-md-12">
			                                <button class="btn btn-info btn-md btn-block waves-effect waves-light" id="btn_browse_training" type="submit">Browse Training</button>
			                            </div>
			                        </div>
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

	<!-- Pop Up Browse Trainer -->
    <div id="modal_browse_trainer" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    	<div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title">Browse Data Trainer</h4>
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            </div>
	            <div class="modal-body" style="overflow: hidden;">
	            	<div class="row">
	                    <div class="col-md-12">
	                    	<div class="table-responsive">
				                <table id="tbl_browse_trainer" class="table table-striped dt-responsive" width="100%">
				                    <thead>
				                        <tr>
				                        	<th class="text-center" style="width:5%">No.</th>
				                            <th class="text-center" style="width:20%">Kode Trainer</th>
				                            <th class="text-left" style="width:55%">Nama Trainer</th>
				                            <th class="text-left" style="width:55%">Initial Trainer</th>
				                            <th class="text-center" style="width:20%">Action</th>
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

	<!-- Pop Up Browse Materi -->
    <div id="modal_browse_materi" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    	<div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title">Browse Data Materi</h4>
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            </div>
	            <div class="modal-body" style="overflow: hidden;">
	            	<div class="row">
	                    <div class="col-md-12">
	                    	<div class="table-responsive">
				                <table id="tbl_browse_materi" class="table table-striped dt-responsive" width="100%">
				                    <thead>
				                        <tr>
				                        	<th class="text-center" style="width:5%">No.</th>
				                            <th class="text-center" style="width:20%">Nama Training</th>
				                            <th class="text-center" style="width:10%">Kode Materi</th>
				                            <th class="text-left" style="width:45%">Nama Materi</th>
				                            <th class="text-center" style="width:20%">Action</th>
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

	<!-- Pop Up Browse Soal -->
    <div id="modal_browse_soal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    	<div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title">Browse Data Soal</h4>
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            </div>
	            <div class="modal-body" style="overflow: hidden;">
	            	<div class="row">
	                    <div class="col-md-12">
	                    	<div class="table-responsive">
				                <table id="tbl_browse_soal" class="table table-striped dt-responsive" width="100%">
				                    <thead>
				                        <tr>
				                        	<th class="text-center" style="width:5%">No.</th>
				                            <th class="text-center" style="width:10%">Kode Soal</th>
				                            <th class="text-left" style="width:65%">Deskripsi Soal</th>
				                            <th class="text-center" style="width:20%">Action</th>
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
</html>