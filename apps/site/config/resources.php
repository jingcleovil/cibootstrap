<?php defined('BASEPATH') OR exit('No direct script access allowed');  

$config['expires'] = 60*60*24*14;
$config['html_expires'] = 0;
$config['resource_folder'] = 'resources/live/';
$config['photos'] = 'resources/';

$config['static_url'] = $url;
$config['css_url'] = $url;

$config['css']['default'] = array(
    array('path'=>'css/','file'=>'bootstrap.min.css'),
    array('path'=>'css/','file'=>'bootstrap-responsive.min.css'),
    array('path'=>'css/','file'=>'style.css')
    );
    
$config['js']['default'] = array(
    array('path'=>'js/','file'=>'jquery.min.js'), 
    array('path'=>'js/','file'=>'bootstrap.min.js'), 
    array('path'=>'js/','file'=>'script.js'), 
    );
  
$config['css3_browsers'] = array(
    "Internet Explorer" => 7
    ,"Firefox" => 3.5
    ,"Opera" => 9
    ,"Safari" => 4
    ,"Chrome" => 4
);