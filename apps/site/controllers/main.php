<?php

class Main extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->benchmark->mark('code_start');

		$data = "";
		
        $data['content'] = $this->load->view("pages/home",$data,true);
        
        $data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
        
        $this->load->vars($data);
        $this->load->view('default',$data);
        
        $this->minify->html();
	}
	
}