$(document).ready(function() {

	$('#tanggal').val(moment().format('DD-MM-YYYY'));

	$('body').on('click', '#btn_timer', function() {
		// reset timer
		delete_cookie("cnt");
		$(".timer h1").focus();

		// ajax untuk mencari total waktu tiap soal
		$.ajax({
			type: 'POST',
			url: 'home/get_waktu_soal',
			dataType: 'json',
			success : function(response) {
				if(response.result) {
					cnt = response.result;
					counter();
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

	var table_list_peserta = $('#tbl_list_peserta').DataTable({
    	"processing"	: true,
        "serverSide"	: true,
        "order"			: [[ 2, "asc" ]],
        "iDisplayLength": 10,
        "ajax"			: {
            "url"		: "home/datatable_list_peserta",
            "type"		: "POST"
        },
        "columnDefs"	: [
        	{ "className": "text-center", "targets": [0, 1, 2, 6, 7, 8] },
        ],
    });

    function browse_table_detail_nilai_peserta($session_code) {
		var table_detail_nilai_peserta = $('#tbl_detail_nilai_peserta').DataTable();
		table_detail_nilai_peserta.clear(); // https://datatables.net/reference/api/clear()
    	table_detail_nilai_peserta = $('#tbl_detail_nilai_peserta').DataTable({
    		"destroy" 		: true,
	    	"processing"	: true,
	        "serverSide"	: true,
	        "order"			: [[ 2, "asc" ], [ 3, "asc" ]],
	        "iDisplayLength": 10,
	        "ajax"			: {
	            "url"		: "home/datatable_detail_nilai_peserta",
	            "type"		: "POST",
	            "data"		: {
	            	"session_code" 	: $session_code,
	            }
	        },
	        "columnDefs"	: [
	        	{ "className": "text-center", "targets": [0, 1, 4, 5, 6, 7, 8] },
	        ],
	    });
    }

    $("body").on("click", "#select_detail", function() {
    	var session_code = $(this).data('session-code');
		browse_table_detail_nilai_peserta(session_code);
		$('#modal_detail_nilai_peserta').modal('show');
    });

    $('body').on('click', '#edit_training', function (e) {
		e.preventDefault();
		var session_code = $(this).data('session-code');
		$.ajax({
			url: 'home/edit_data_training/'+session_code,
			type: 'GET',
			data: {
				'session_code': session_code
			},
			dataType: 'json',
			beforeSend: function() {
				$("body").mLoading({
  					text: "Loading...",
				});
			},
			complete: function() {
				$("body").mLoading('hide');
			},
			success: function(data) {
				$('#session_code_edit').val(data.session_code);
				$('input:radio[name="open_close"]').filter('[value="'+data.closed+'"]').attr('checked', true); // https://stackoverflow.com/questions/871063/how-to-set-radio-option-checked-onload-with-jquery
				$('#modal_edit_training').modal('show');				
			}
		});
	});

	$('body').on('click', '#btn_save_training', function() {
		$('#btn_save_training').prop('disabled', true);
		var url = 'home/update_data_training';

		var formData = new FormData($('#form_training')[0]);
		$.ajax({
			type: 'POST',
			url: url,
			dataType: 'json',
			contentType: false,       
		    cache: false,             
		    processData: false,
			data: formData,
			beforeSend : function() {
				$("body").mLoading({
  					text: "Loading...",
				});
			},
			complete : function() {
				$("body").mLoading('hide');
			},
			success : function(response) {
				if(response.success_update) {
					$.toast({
			        	heading				: 'Successfully',
			            text				: response.success_update,
			            showHideTransition	: 'slide',
			            position			: 'top-center',
			            loaderBg			: '#ff6849',
			            icon				: 'success',
			            hideAfter			: 5000            
			    	});
			    	Swal.fire({
						type 		: 'success',
					  	title 		: '<strong>Successfully</strong>',
					    html 		: response.success_update
					});
					$('#modal_edit_training').modal('hide');
					table_list_peserta.ajax.reload(null, false);
				} else {
					$.toast({
			        	heading				: 'Error',
			            text				: response.failed_update,
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
					                  response.failed_update,
					});
				}
				$('#btn_save_training').prop('disabled', false);
			},
     		error: function(xhr, status, error){
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
				$('#btn_save_training').prop('disabled', false);
     		}
		});
	});
	
});

// https://stackoverflow.com/questions/2144386/how-to-delete-a-cookie
function delete_cookie(name) {
  	document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

// http://chandreshrana.blogspot.com/2017/01/how-to-make-counter-not-reset-on-page.html
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

var start = 0;
var cnt = 0;
function counter() {
    if(getCookie("cnt") > 0) {
  		cnt = getCookie("cnt");
 	}
 	cnt -= 1;
 	document.cookie = "cnt="+ cnt;
 	//$(".timer h1").html(getCookie("cnt")); // https://stackoverflow.com/questions/8550251/how-do-i-replace-change-the-heading-text-inside-h3-h3-using-jquery

 	// convert ke jam, menit, detik
 	// https://www.4codev.com/javascript/convert-seconds-to-time-value-hours-minutes-seconds-idpx6943853585885165320.html
 	second = getCookie("cnt");
 	hours   = Math.floor(second / 3600);
 	minutes = Math.floor((second - (hours * 3600)) / 60);
 	seconds = second - (hours * 3600) - (minutes * 60);
 	if (hours   < 10) { hours   = "0"+hours; }
 	if (minutes < 10) { minutes = "0"+minutes; }
 	if (seconds < 10) { seconds = "0"+seconds; }
 	$(".timer h1").html(hours+':'+minutes+':'+seconds);

 	$("#btn_timer").hide();
 
 	if (cnt > 0) {
  		setTimeout(counter, 1000);
  		start = 1;
 	} else if (cnt == 0) {
   		start = 0;
		swal({
            title               : 'Session Timeout',
            text                : "Waktu sudah habis. Silahkan klik OK untuk melanjutkan",
            type                : 'warning',
            showCancelButton    : false,
            confirmButtonText   : 'OK',
            cancelButtonText    : "No",
            confirmButtonClass  : "btn-warning",
            showLoaderOnConfirm : true,
            preConfirm          : function() {
                return new Promise(function(resolve) {
                	proses_submit();
                });
            },
            allowOutsideClick: false     
        });
 	}
}

/* https://github.com/rstaib/jquery-steps/wiki/Settings */
$(".tab-wizard").steps({
    headerTag: "h6",
    bodyTag: "section",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    loadingTemplate: '<span class="spinner"></span> #text#',
    showFinishButtonAlways: true,
    labels: {
        finish: "Submit",
        next: "Selanjutnya",
        previous: "Sebelumnya",
    },
    suppressPaginationOnFocus: true,
    onStepChanging: function (event, currentIndex, newIndex) {	    	
       	if (start == 0) {
       		Swal.fire({
				type 		: 'error',
			  	title 		: '<strong>Error</strong>',
			    html 		: 'Timer belum dijalankan !!!',
			});
			return false;
       	} else {
       		return true;
       	}
    },
    onFinished: function (event, currentIndex) {
    	// cek validasi
    	// https://www.codexworld.com/how-to/check-if-radio-button-in-group-checked-jquery/
       	swal({
            title               : 'Submit Training ?',
            text                : "Sudah yakin dengan jawaban anda ?",
            type                : 'question',
            showCancelButton    : true,
            confirmButtonText   : 'Yes',
            cancelButtonText    : "No",
            confirmButtonClass  : "btn-warning",
            showLoaderOnConfirm : true,
            preConfirm          : function() {
                return new Promise(function(resolve) {
                	proses_submit();
                });
            },
            allowOutsideClick: false     
        });
    }
});

function proses_submit() {
	// https://www.bladephp.co/submit-multiple-form-array-codeigniter-using-ajax
	var formData = new FormData();
	var form_header = $('#form_header').serializeArray();
	$.each(form_header, function (key, input) {
		formData.append(input.name, input.value);
	});

	var form_detail = $('#form_detail').serializeArray();
	$.each(form_detail, function (key, input) {
		formData.append(input.name, input.value);
	});

	$.ajax({
        url     	: 'home/proses_training_peserta',
        type    	: 'POST',
        dataType 	: 'json',
        async 		: false,
        cache 		: false,
        contentType : false,
        processData : false,
        data 		: formData,
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
			}).then(function() { window.location.href = 'start_peserta'; });
		} else if (response.error) {
			$.toast({
	        	heading				: 'Error',
	            text				: response.error,
	            showHideTransition	: 'slide',
	            position			: 'top-center',
	            loaderBg			: '#ff6849',
	            icon				: 'error',
	            hideAfter			: 5000
	    	});
	    	// https://inneka.com/programming/ajax/how-reload-a-page-after-clicked-ok-using-sweetalert/
	    	Swal.fire({
				type 		: 'error',
			  	title 		: '<strong>Error</strong>',
			    html 		: response.error
			});
			$("#btn_timer").show();
			$(".timer h1").show();
		}
	})
	.fail(function(xhr, status, error) {
        var errorMessage = xhr.status + ': ' + xhr.statusText
        Swal.fire({
            type        : 'error',
            title       : '<strong>Error</strong>',
            text        : errorMessage,
        });
        $("#btn_timer").show();
		$(".timer h1").show();
    });
}