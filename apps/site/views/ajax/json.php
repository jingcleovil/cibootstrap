<?php defined('BASEPATH') OR exit('No direct script access allowed');  
$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
$this->output->set_header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
$this->output->set_header("Cache-Control: no-cache, must-revalidate" ); 
$this->output->set_header("Pragma: no-cache" );
$this->output->set_header("Content-type: text/x-json");
echo json_encode($json);