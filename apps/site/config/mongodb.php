<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(strpos(config_item('base_url'),'jingcleovil.com'))
{
$config['mongo_host'] = "localhost";
$config['mongo_port'] = 27017;
$config['mongo_db'] = "ejobs";
$config['mongo_user'] = "hives";
$config['mongo_pass'] = "eagfwb";
$config['mongo_persist'] = TRUE;
$config['mongo_persist_key'] = 'ci_mongo_persist';
$config['mongo_return'] = 'array'; // Set to object
$config['mongo_query_safety'] = 'safe';
$config['mongo_supress_connect_error'] = TRUE;
$config['host_db_flag'] = FALSE;
} else {
$config['mongo_host'] = "127.0.0.1";
$config['mongo_port'] = 27017;
$config['mongo_db'] = "ejobs";
$config['mongo_user'] = "";
$config['mongo_pass'] = "";
$config['mongo_persist'] = TRUE;
$config['mongo_persist_key'] = 'ci_mongo_persist';
$config['mongo_return'] = 'array'; // Set to object
$config['mongo_query_safety'] = 'safe';
$config['mongo_supress_connect_error'] = TRUE;
$config['host_db_flag'] = FALSE;
}
