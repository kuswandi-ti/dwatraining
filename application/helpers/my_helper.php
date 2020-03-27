<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('field_set'))
{
	 
	function field_set($field_value, $format_type = 's', $custom = '-', $format_date = 'd-m-Y', $format_time = 'H:i:s', $format_date_time = 'd-m-Y H:i:s') {
		/*
			n = number
			d = date
			s = string
			c = custom
		*/
		
		if ($format_type == 'n') {
			$result = (is_null($field_value) || $field_value == '' ? '0' : $field_value);
			
		} else if ($format_type == 'd') {
			$result = ((is_null($field_value) || ($field_value == '0000-00-00') || ($field_value == '0000-00-00 00:00:00')) ? $custom : date($format_date, strtotime($field_value)));
			
		} else if ($format_type == 's') {
			$result = (is_null($field_value) || $field_value == '' ? $custom : $field_value);
			
		} else {
			$result = (is_null($field_value) || $field_value == '' ? '' : $field_value);
		}
		
		return $result;
	}
}

if ( ! function_exists('image_exists'))
{
	function image_exists($path)
	{
		$CI =& get_instance();
		if (file_exists($path)) {
			return $path;
		} else {
			return $CI->config->item('PATH_ASSET_IMAGE').'no-image.png';
		}
	}
}

if ( ! function_exists('set_to_nama_bulan_indonesia'))
{
	 
	function set_to_nama_bulan_indonesia($bulan_angka) {
		switch ($bulan_angka) {
			case '1':
				$result = 'Januari';
				break;

			case '2':
				$result = 'Februari';
				break;

			case '3':
				$result = 'Maret';
				break;

			case '4':
				$result = 'April';
				break;

			case '5':
				$result = 'Mei';
				break;

			case '6':
				$result = 'Juni';
				break;

			case '7':
				$result = 'Juli';
				break;

			case '8':
				$result = 'Agustus';
				break;

			case '9':
				$result = 'September';
				break;

			case '10':
				$result = 'Oktober';
				break;

			case '11':
				$result = 'November';
				break;

			case '12':
				$result = 'Desember';
				break;
			
			default:
				$result = '';
				break;
		}
		
		return $result;
	}
}

if ( ! function_exists('set_to_nama_hari_indonesia'))
{
	 
	function set_to_nama_hari_indonesia($tanggal) {
		$daftar_hari = array(
 			'Sunday' 	=> 'Minggu',
 			'Monday' 	=> 'Senin',
 			'Tuesday' 	=> 'Selasa',
 			'Wednesday' => 'Rabu',
 			'Thursday' 	=> 'Kamis',
 			'Friday' 	=> 'Jumat',
 			'Saturday' 	=> 'Sabtu'
		);
		$namahari = date('l', strtotime($tanggal));

		return $daftar_hari[$namahari];
	}
}

if ( ! function_exists('image_exists'))
{
	function image_exists($path)
	{
		$CI =& get_instance();
		if (file_exists($path)) {
			return $path;
		} else {
			return $CI->config->item('PATH_ASSET_IMAGE').'no-image.png';
		}
	}
}

if ( ! function_exists('set_server_gedung_local'))
{
	 
	function set_server_gedung_local($gedung) {
		switch ($gedung) {
			case 'A':
				$result = 'atd1';
				break;

			case 'B':
				$result = 'atd2';
				break;

			case 'C':
				$result = 'atd3';
				break;

			case 'D':
				$result = 'atd5';
				break;

			case 'E':
				$result = 'atd5';
				break;

			case 'H':
				$result = 'atd6';
				break;

			case 'P':
				$result = 'atd7';
				break;
			
			default:
				$result = '';
				break;
		}
		
		return $result;
	}
}

/* https://code.tutsplus.com/tutorials/generate-random-alphanumeric-strings-in-php--cms-32132 */
if ( ! function_exists('generate_random_string'))
{
	 
	function generate_random_string() {
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle($permitted_chars), 0, 5);
	}
}

/* https://helloacm.com/left-and-right-function-in-php/ */
if ( ! function_exists('func_left'))
{
	 
	function func_left($str, $length) {
     	return substr($str, 0, $length);
	}
}

if ( ! function_exists('func_right'))
{
	 
	function func_right($str, $length) {
     	return substr($str, -$length);
	}
}