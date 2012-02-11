<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* URI Language Identifier
* 
*/
class MY_User_agent extends CI_User_agent
{
	function css3()
	{
	
		global $RTR;
	
		$browser = $this->browser();
		$version = $this->version();
		
		
/*
		print_r($browser); exit;
		array_key_exists(mixed key, array search)
*/
		
		$browsers = config_item('css3_browsers');
		
		if (array_key_exists($browser, $browsers))
			{
			if ($version >= $browsers[$browser])
				return true;
			}
	
		return false;
	}

	function _compile_data()
	{
		$this->_set_platform();
	
		foreach (array('_set_robot','_set_browser','_set_mobile') as $function)
		{
			if ($this->$function() === TRUE)
			{
				break;
			}
		}	
	}

	    
}    

