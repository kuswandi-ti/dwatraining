$(document).ready(function() {

	$('.date').datepicker({
		autoclose		: true,
		todayHighlight	: true,
		format			: 'dd-mm-yyyy',		
	});

	$('.clock').clockpicker({
        placement: 'top',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });

    $('#tanggal').val(moment().format('DD-MM-YYYY'));

    var table_browse_trainer = $('#tbl_browse_trainer').DataTable({
    	"processing"	: true,
        "serverSide"	: true,
        "order"			: [[ 2, "asc" ]],
        "iDisplayLength": 10,
        "ajax"			: {
            "url"		: "start_trainer/datatable_trainer_list",
            "type"		: "POST"
        },
        "columnDefs"	: [
        	{ "className": "text-center", "targets": [0, 1, 3, 4] },
        ],
    });

    $('#browse_trainer').click(function () {
		$('#modal_browse_trainer').modal('show');
	});

	$('body').on('click', '#select_trainer', function (e) {
		var sysid_trainer 		= $(this).data('sysid-trainer');
		var kode_trainer 		= $(this).data('kode-trainer');
		var initial_trainer 	= $(this).data('initial-trainer');
		var nama_trainer 		= $(this).data('nama-trainer');
		var trainer 			= kode_trainer+' - '+nama_trainer;

		$('#trainer').val(trainer);
		$('#sysid_trainer').val(sysid_trainer);
		$('#kode_trainer').val(kode_trainer);
		$('#initial_trainer').val(initial_trainer);

		$('#modal_browse_trainer').modal('hide');
    });

    var table_browse_materi = $('#tbl_browse_materi').DataTable({
    	"processing"	: true,
        "serverSide"	: true,
        "order"			: [[ 2, "asc" ], [ 3, "asc" ]],
        "iDisplayLength": 10,
        "ajax"			: {
            "url"		: "start_trainer/datatable_materi_list",
            "type"		: "POST"
        },
        "columnDefs"	: [
        	{ "className": "text-center", "targets": [0, 2, 4] },
        ],
    });

    $('#browse_materi').click(function () {
		$('#modal_browse_materi').modal('show');
	});

	$('body').on('click', '#select_materi', function (e) {
		var sysid_training 		= $(this).data('sysid-training');
		var kode_training 		= $(this).data('kode-training');
		var nama_training 		= $(this).data('nama-training');
		var sysid_materi 		= $(this).data('sysid-materi');
		var kode_materi 		= $(this).data('kode-materi');
		var nama_materi 		= $(this).data('nama-materi');
		var materi 				= kode_materi+' - '+nama_materi;

		$('#materi').val(materi);
		$('#sysid_training').val(sysid_training);
		$('#kode_training').val(kode_training);
		$('#nama_training').val(nama_training);
		$('#sysid_materi').val(sysid_materi);
		$('#kode_materi').val(kode_materi);

		$('#modal_browse_materi').modal('hide');
    });

	function browse_table_soal() {
		var sysid_materi = $("#sysid_materi").val();
		var table_browse_soal = $('#tbl_browse_soal').DataTable();
		table_browse_soal.clear(); // https://datatables.net/reference/api/clear()
    	table_browse_soal = $('#tbl_browse_soal').DataTable({
    		"destroy" 		: true,
	    	"processing"	: true,
	        "serverSide"	: true,
	        "order"			: [[ 2, "asc" ], [ 3, "asc" ]],
	        "iDisplayLength": 10,
	        "ajax"			: {
	            "url"		: "start_trainer/datatable_soal_list",
	            "type"		: "POST",
	            "data"		: {
	            	"sysid_materi" 	: sysid_materi,
	            }
	        },
	        "columnDefs"	: [
	        	{ "className": "text-center", "targets": [0, 1, 3] },
	        ],
	    });
    }

    $("body").on("click", "#browse_soal", function() {
    	var sysid_materi = $('#sysid_materi').val();
    	if(sysid_materi.length == 0) {
			$.toast({
	        	heading				: 'Error',
	            text				: 'Materi belum dipilih !!!',
	            showHideTransition	: 'slide',
	            position			: 'top-center',
	            loaderBg			: '#ff6849',
	            icon				: 'error',
	            hideAfter			: 5000            
	    	});
			Swal.fire({
				type 		: 'error',
			  	title 		: '<strong>Error</strong>',
			    html 		: '<u>Kemungkinan error :</u> <br>'+
			                  'Materi belum dipilih !!!',
			});
			return false;
		}

		browse_table_soal();
		$('#modal_browse_soal').modal('show');
    });

    $('body').on('click', '#select_soal', function (e) {
		var sysid_soal 			= $(this).data('sysid-soal');
		var kode_soal 			= $(this).data('kode-soal');
		var description_soal	= $(this).data('description-soal');
		var waktu_soal			= $(this).data('waktu-soal');
		var soal 				= kode_soal+' - '+description_soal;

		$('#soal').val(soal);
		$('#sysid_soal').val(sysid_soal);
		$('#kode_soal').val(kode_soal);
		$('#description_soal').val(description_soal);
		$('#waktu_soal').val(waktu_soal);

		$('#modal_browse_soal').modal('hide');
    });

    $('body').on('click', '#btn_generate', function(e) {
    	e.preventDefault();

    	var trainer = $('#sysid_trainer').val();
    	var materi 	= $('#sysid_materi').val();
    	var soal 	= $('#sysid_soal').val();
    	var tanggal = $('#tanggal').val();
    	var jam 	= $('#jam').val();

    	if(trainer.length == 0) {
			$.toast({
	        	heading				: 'Error',
	            text				: 'Trainer belum dipilih !!!',
	            showHideTransition	: 'slide',
	            position			: 'top-center',
	            loaderBg			: '#ff6849',
	            icon				: 'error',
	            hideAfter			: 5000            
	    	});
			Swal.fire({
				type 		: 'error',
			  	title 		: '<strong>Error</strong>',
			    html 		: '<u>Kemungkinan error :</u> <br>'+
			                  'Trainer belum dipilih !!!',
			});
			return false;
		}
		if(materi.length == 0) {
			$.toast({
	        	heading				: 'Error',
	            text				: 'Materi belum dipilih !!!',
	            showHideTransition	: 'slide',
	            position			: 'top-center',
	            loaderBg			: '#ff6849',
	            icon				: 'error',
	            hideAfter			: 5000            
	    	});
			Swal.fire({
				type 		: 'error',
			  	title 		: '<strong>Error</strong>',
			    html 		: '<u>Kemungkinan error :</u> <br>'+
			                  'Materi belum dipilih !!!',
			});
			return false;
		}
		if(soal.length == 0) {
			$.toast({
	        	heading				: 'Error',
	            text				: 'Soal belum dipilih !!!',
	            showHideTransition	: 'slide',
	            position			: 'top-center',
	            loaderBg			: '#ff6849',
	            icon				: 'error',
	            hideAfter			: 5000            
	    	});
			Swal.fire({
				type 		: 'error',
			  	title 		: '<strong>Error</strong>',
			    html 		: '<u>Kemungkinan error :</u> <br>'+
			                  'Soal belum dipilih !!!',
			});
			return false;
		}
		if(tanggal.length == 0) {
			$.toast({
	        	heading				: 'Error',
	            text				: 'Tanggal belum dipilih !!!',
	            showHideTransition	: 'slide',
	            position			: 'top-center',
	            loaderBg			: '#ff6849',
	            icon				: 'error',
	            hideAfter			: 5000            
	    	});
			Swal.fire({
				type 		: 'error',
			  	title 		: '<strong>Error</strong>',
			    html 		: '<u>Kemungkinan error :</u> <br>'+
			                  'Tanggal belum dipilih !!!',
			});
			return false;
		}
		if(jam.length == 0) {
			$.toast({
	        	heading				: 'Error',
	            text				: 'Jam belum dipilih !!!',
	            showHideTransition	: 'slide',
	            position			: 'top-center',
	            loaderBg			: '#ff6849',
	            icon				: 'error',
	            hideAfter			: 5000            
	    	});
			Swal.fire({
				type 		: 'error',
			  	title 		: '<strong>Error</strong>',
			    html 		: '<u>Kemungkinan error :</u> <br>'+
			                  'Jam belum dipilih !!!',
			});
			return false;
		}

		swal({
            title               : 'Generate data training ?',
            text                : "Yakin akan melanjutkan proses ? Data yang lama akan direplace",
            type                : 'question',
            showCancelButton    : true,
            confirmButtonText   : 'Yes',
            cancelButtonText    : "No",
            confirmButtonClass  : "btn-warning",
            showLoaderOnConfirm : true,
            preConfirm          : function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url     	: 'start_trainer/generate_session_training',
                        type    	: 'POST',
                        dataType 	: 'json',
                        async 		: false,
                        data 		: $('#form_start_trainer').serialize(),
                    })
                    .done(function(response) {
                        if (response.success) {
							$.toast({
					        	heading				: 'Successfully',
					            text				: response.success+ '<br />' +response.success_training_code,
					            showHideTransition	: 'slide',
					            position			: 'top-center',
					            loaderBg			: '#ff6849',
					            icon				: 'success',
					            hideAfter			: 5000            
					    	});
					    	// https://inneka.com/programming/ajax/how-reload-a-page-after-clicked-ok-using-sweetalert/
					    	Swal.fire({
								type 		: 'success',
							  	title 		: '<strong>Successfully</strong>',
							    html 		: response.success+ '<br />' +response.success_training_code
							}).then(function() { window.location.href = 'home'; });
						}
                    })
                    .fail(function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText
                        Swal.fire({
                            type        : 'error',
                            title       : '<strong>Error</strong>',
                            text        : errorMessage,
                        });
                    });
                });
            },
            allowOutsideClick: false     
        });
	});
	
	$('body').on('click', '#btn_browse_training', function(e) {
		e.preventDefault();
		var initial_trainer = $('#initial_trainer2').val();
    	if(initial_trainer.length == 0) {
			$.toast({
	        	heading				: 'Error',
	            text				: 'Initial trainer belum ditentukan !!!',
	            showHideTransition	: 'slide',
	            position			: 'top-center',
	            loaderBg			: '#ff6849',
	            icon				: 'error',
	            hideAfter			: 5000            
	    	});
			Swal.fire({
				type 		: 'error',
			  	title 		: '<strong>Error</strong>',
			    html 		: '<u>Kemungkinan error :</u> <br>'+
			                  'Initial trainer belum ditentukan !!!',
			});
			return false;
		}

		$.ajax({
			type: 'POST',
			url: 'start_trainer/cek_trainer',
			dataType: 'json',
			data: {
				'initial_trainer': initial_trainer
			},
			success : function(response) {
				if(response.row_not_found) {
					$.toast({
			        	heading				: 'Error',
			            text				: response.row_not_found,
			            showHideTransition	: 'slide',
			            position			: 'top-center',
			            loaderBg			: '#ff6849',
			            icon				: 'error',
			            hideAfter			: 5000            
			    	});
			    	Swal.fire({
						type 		: 'error',
					  	title 		: '<strong>Error</strong>',
					    html 		: response.row_not_found
					});
				} else if(response.success) {
					$.toast({
			        	heading				: 'Successfully',
			            text				: response.success,
			            showHideTransition	: 'slide',
			            position			: 'top-center',
			            loaderBg			: '#ff6849',
			            icon				: 'success',
			            hideAfter			: 5000            
			    	});
			    	Swal.fire({
						type 		: 'success',
					  	title 		: '<strong>Successfully</strong>',
					    html 		: response.success
					}).then(function() { window.location.href = 'home'; });
				}
			},
     		error: function(xhr, status, error) {
         		var errorMessage = xhr.status + ': ' + xhr.statusText
         		$.toast({
		        	heading				: 'Error',
		            text				: errorMessage,
		            showHideTransition	: 'slide',
		            position			: 'top-center',
		            loaderBg			: '#ff6849',
		            icon				: 'error',
		            hideAfter			: 5000
		    	});
		    	Swal.fire({
					type 		: 'error',
				  	title 		: '<strong>Error</strong>',
				    text 		: errorMessage,
				});
     		}
		});
    });
	
});