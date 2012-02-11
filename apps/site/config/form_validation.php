<?php defined('BASEPATH') OR exit('No direct script access allowed');  

if ($handle = opendir(APPPATH."config/forms")) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            include APPPATH."config/forms/$file";
        }
    }
    closedir($handle);
}