<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	function valid_phone($str)
	{
		return ( ! preg_match("/^(\([2-9]\d{2}\))?[ ]?([0-9]+[- .]?[0-9]+)+$/i", $str)) ? FALSE : TRUE;
	}

	function valid_country_code($str)
	{
		return ( ! preg_match("/^[+]?([0-9]{1,})$/i", $str)) ? FALSE : TRUE;
	}

	function valid_card($str)
	{
		return ( ! preg_match("/^((4\d{3})|(5[1-5]\d{2})|(6011))(-?|\040?)(\d{4}(-?|\040?)){3}|^(3[4,7]\d{2})(-?|\040?)\d{6}(-?|\040?)\d{5}$/i", $str)) ? FALSE : TRUE;
	}	

}