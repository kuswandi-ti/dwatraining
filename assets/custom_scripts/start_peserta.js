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

    $('.select2').select2();

    // https://stackoverflow.com/questions/22261209/get-custom-data-attribute-in-select2-with-select
    $("body").on("change", "#cbodepartment_all", function() {
    	var sysid_department 	= $('#cbodepartment_all option:selected').val();
    	var init_department 	= $('#cbodepartment_all option:selected').attr('dept_alias');

    	$('#sysid_department').val(sysid_department);
    	$('#init_department').val(init_department);

    	var opt = '<option selected hidden value="0">Pilih Karyawan</option>';
    	$.ajax({
			url: 'start_peserta/get_data_karyawan_aktif/'+sysid_department,
			dataType: 'json',
			type: 'get',
			success: function(json) {
				$.each(json, function(i, obj) {
					opt += "<option value='"+obj.SysId+"' nik='"+obj.NIK+"'>"+obj.NIK_Nama+"</option>";
				});
				$("#cbokaryawan").html(opt);
			}
		});
    });

    $("body").on("change", "#cbokaryawan", function() {
    	var sysid_karyawan 	= $('#cbokaryawan option:selected').val();
    	var nik_karyawan 	= $('#cbokaryawan option:selected').attr('nik');

    	$('#sysid_karyawan').val(sysid_karyawan);
    	$('#nik_karyawan').val(nik_karyawan);
    });

    $("body").on("change", "#cbojabatan", function() {
    	var sysid_jabatan 	= $('#cbojabatan option:selected').val();
    	var nama_jabatan 	= $('select[name=cbojabatan] option:selected').text();
    	var nilai_minimum 	= $('#cbojabatan option:selected').attr('data_nilai_minimum');

    	$('#sysid_jabatan').val(sysid_jabatan);
    	$('#nama_jabatan').val(nama_jabatan);
    	$('#nilai_minimum').val(nilai_minimum);
    });

    $('body').on('click', '#btn_mulai', function(e) {
    	e.preventDefault();

    	var department 		= $('#cbodepartment_all option:selected').val();
    	var karyawan 		= $('#cbokaryawan option:selected').val();
    	var kode_training	= $('#kode_training').val();

    	if(department == 0) {
			$.toast({
	        	heading				: 'Error',
	            text				: 'Departemen belum dipilih !!!',
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
			                  'Departemen belum dipilih !!!',
			});
			return false;
		}
		if(karyawan == 0) {
			$.toast({
	        	heading				: 'Error',
	            text				: 'Karyawan belum dipilih !!!',
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
			                  'Karyawan belum dipilih !!!',
			});
			return false;
		}
		if(kode_training.length == 0) {
			$.toast({
	        	heading				: 'Error',
	            text				: 'Kode Training belum diinput !!!',
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
			                  'Kode Training belum diinput !!!',
			});
			return false;
		}

		swal({
            title               : 'Mulai training ?',
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
                        url     	: 'start_peserta/start_training_peserta',
                        type    	: 'POST',
                        dataType 	: 'json',
                        async 		: false,
                        data 		: $('#form_start_peserta').serialize(),
                    })
                    .done(function(response) {
                    	if (response.success) {
							$.toast({
					        	heading				: 'Successfully',
					            text				: response.success,
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
							    html 		: response.success
							}).then(function() { window.location.href = 'home'; });
						}
						if (response.kodetraining_notexist) {
							$.toast({
					        	heading				: 'Error',
					            text				: response.kodetraining_notexist,
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
							                  response.kodetraining_notexist,
							});
							return false;
						}
						if (response.training_exist) {
							$.toast({
					        	heading				: 'Error',
					            text				: response.training_exist,
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
							                  response.training_exist,
							});
							return false;
						}
						if (response.error_insert_tmp) {
							$.toast({
					        	heading				: 'Error',
					            text				: response.error_insert_tmp,
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
							                  response.error_insert_tmp,
							});
							return false;
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
	
});