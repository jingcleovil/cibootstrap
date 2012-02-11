<?php defined('BASEPATH') OR exit('No direct script access allowed');  

$ci =& get_instance();

$action = $ci->input->post('action');

switch($action)
{
    case 'update_profile':
    case 'update_basic':
        $config['users/post'] = array(
            array('field' => 'position','label' => 'Position','rules' => 'required'),
            array('field' => 'nickname','label' => 'Nickname','rules' => 'required|callback__check_nickname'),
            array('field' => 'month','label' => 'Month','rules' => 'required'),
            array('field' => 'day','label' => 'Day','rules' => 'required'),
            array('field' => 'year','label' => 'Year','rules' => 'required'),
            array('field' => 'gender','label' => 'Gender','rules' => 'required'),
            array('field' => 'address','label' => 'Address','rules' => 'required'),
            array('field' => 'city','label' => 'City','rules' => 'required'),
			array('field' => 'citizenship','label' => 'Citizenship','rules' => 'required'),
			array('field' => 'religion','label' => 'Religion','rules' => 'required'),
			array('field' => 'alt_email','label' => 'Other Email','rules' => 'valid_email|callback__check_otheremail'),
        );
        break;
    case 'education_background':
        $config['users/post'] = array(
            array('field' => 'degree_course','label' => 'Course','rules' => 'required'),
            array('field' => 'university_name','label' => 'University/Institue Name','rules' => 'required'),
            array('field' => 'qualification','label' => 'Qualification','rules' => 'required'),
			array('field' => 'syfromyear','label' => 'SY From Year','rules' => 'required'),
			array('field' => 'syfrommonth','label' => 'SY From Month','rules' => 'required'),
			array('field' => 'sytoyear','label' => 'SY To Year','rules' => 'required'),
			array('field' => 'sytomonth','label' => 'SY To Month','rules' => 'required'),
			
        );
        break;
    case 'employment':
        $config['users/post'] = array(
            array('field' => 'start_join_year','label' => 'Year (Joined)','rules' => 'required'),
            array('field' => 'start_join_month','label' => 'Month (Joined)','rules' => 'required'),
            array('field' => 'company_name','label' => 'Company Name','rules' => 'required'),
            array('field' => 'position','label' => 'Position','rules' => 'required'),
            array('field' => 'location','label' => 'Location','rules' => 'required'),

        );
		break;
	case 'update_agency':
        $config['users/post'] = array(
            array('field' => 'agencyname','label' => 'Agency Name','rules' => 'required')
        );
		break;
	case 'career_objective':
        $config['users/post'] = array(
            array('field' => 'career_objective','label' => 'Career Objective','rules' => 'required'),

        );
        break;
	case 'license':
		$config['users/post'] = array(
            array('field' => 'license_type','label' => 'License Type','rules' => 'required'),
            array('field' => 'license_number','label' => 'License Number','rules' => 'required'),
            array('field' => 'lic_month','label' => 'License Month','rules' => 'required'),
            array('field' => 'lic_day','label' => 'License Day','rules' => 'required'),
            array('field' => 'lic_year','label' => 'License Year','rules' => 'required'),

        );
		break;
	case 'training':
        $config['users/post'] = array(
            array('field' => 'tdate_month','label' => 'Month','rules' => 'required'),
            array('field' => 'tdate_day','label' => 'Day','rules' => 'required'),
            array('field' => 'tdate_year','label' => 'Year','rules' => 'required'),
            array('field' => 'title','label' => 'Title','rules' => 'required'),
            array('field' => 'remarks','label' => 'Remarks','rules' => 'required'),

        );
        break;
		break;
}
