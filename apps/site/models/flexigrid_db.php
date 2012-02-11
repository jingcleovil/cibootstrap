<?php
class Flexigrid_db extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getList()
    {
        $item = $this->input->post('item');
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');

		if (!$sortname) $sortname = 'id';
		if (!$sortorder) $sortorder = 'ASC';
		
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;        
				
		$start = (($page-1) * $rp);  
		       
		$this->db2->from('users');
		$num = $this->db2->count_all_results();
		
		if ($start>$num) 
			{
			$start = 0; 
			$page = 1;
			}    
	
		$query = $this->db2->get('users');
	
		$data['db'] = $query->result_array();        
		$data['page'] = $page;
		$data['total'] = $num;
		return $data;
	}
}