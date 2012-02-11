<?php

$ci =& get_instance();

$action = $ci->input->post('action');

if($action == "member")
{

	$config['signup/post'] = array(
		array('field' => 'firstname','label' => 'First Name','rules' => 'required'),
		array('field' => 'middlename','label' => 'Middle Name','rules' => 'required'),
		array('field' => 'lastname','label' => 'Last Name','rules' => 'required'),
		array('field' => 'mobilenumber','label' => 'Mobile Number','rules' => 'required|integer|exact_length[11]'),
		array('field' => 'email','label' => 'Email Address','rules' => 'required|valid_email|callback__check_email'),
		array('field' => 'password','label' => 'password','rules' => 'required'),
		array('field' => 'position','label' => 'position','rules' => 'required'),
		array('field' => 'agreement','label' => 'Agreement','rules' => 'required'),

	);
		
} else if($action == "employer") {
	$config['signup/post'] = array(
		array('field' => 'agencyname','label' => 'Agency Name','rules' => 'required'),
		array('field' => 'license_no','label' => 'License Name','rules' => 'required'),
		array('field' => 'corp_email','label' => 'Email','rules' => 'required|valid_email|callback__check_email'),
		array('field' => 'corp_password','label' => 'Password','rules' => 'required'),
		array('field' => 'corp_address','label' => 'Address','rules' => 'required'),
	
	);
}