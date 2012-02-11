<?php

class Mini extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function index($type='',$group='')
    {
        $this->minify->outputByGroup($type,$group);
    }
}