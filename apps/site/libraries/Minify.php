<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Minify {

	var $CI;

	function Minify()
	{
		$this->CI =& get_instance();

		require_once('Minify_HTML.php');
		require_once('Minify_CSS.php');
		require_once('Minify_JS.php');

	}

	public function js($js)
	{
		$min = new JSMin();

		//return $js;

		return $min->minify($js);
	}

 	public function css($css,$options = array())
 	{

 		$min = new Minify_CSS();

		return $min->minify($css,$options);
 	}


 	public function html($html = false)
 	{
		//return $html;

		//return $html;

 		$min = new Minify_HTML();

 		if (!$html)
 			{
 			$exp = $this->CI->config->item('html_expires');
 			if (!$exp) $exp = 0;

 			$html = $this->CI->output->get_output();
 			$this->set_output('text/html',$min->minify($html),0,$exp);
 			return true;
 			}

 		return $min->minify($html);
 	}

 	function greater($x,$y)
 	{
 		if ($x>$y)
 			return $x;
 		else
 			return $y;
 	}



 	function gfiles($type,$id)
	{


		$rpath = $this->CI->config->item('resource_folder');
		$files = $this->CI->config->item($type);
		$lang = $this->CI->config->item('language');

		if (!isset($files[$id])) show_error("Resource $id invalid.");

		$files = $files[$id];

		$url = $this->CI->config->item('static_url');

		$browser = strtolower($this->CI->agent->browser());
		if ($browser == "internetexplorer") $browser = "ie";
		if ($browser == "internet explorer") $browser = "ie";

		$version = floor($this->CI->agent->version());

		$rfiles = array();

		if (!$files) show_error("Resource $id invalid.");

		foreach ($files as $f)
		{

			//handle remote files
			if (substr($f['path'],0,4)=='http') continue;

			//load default
			$target = $rpath.$f['path'].$f['file'];
			$upath = $url.$rpath.$f['path'];

			if (file_exists($target)) $rfiles[] = array('path'=>$upath,'file'=>$target);

			//load brower specific
			$target = str_replace(".$type",".".$browser.".".$type,$target);

			if (file_exists($target)) $rfiles[] = array('path'=>$upath,'file'=>$target);

			//load browser and version specific
			$target = str_replace(".$type",".".$version.".".$type,$target);

			if (file_exists($target)) $rfiles[] = array('path'=>$upath,'file'=>$target);

			//load language specific
			$target = $rpath.$f['path'].$f['file'];
			$target = str_replace(".$type","_$lang.".$type,$target);

			if (file_exists($target)) $rfiles[] = array('path'=>$upath,'file'=>$target);

			//load css3 specific
			if ($this->CI->agent->css3() && $type =='css')
				{
				$target = $rpath.$f['path'].$f['file'];
				$target = str_replace(".$type",".css3.".$type,$target);

				if (file_exists($target)) $rfiles[] = array('path'=>$upath,'file'=>$target);

				}


		}


		return $rfiles;


	}

 	function mtime($type,$id)
	{


		$files = $this->gfiles($type,$id);

		//print_r($files); exit;

		$ltime = 0;

		if (!$files) show_error("Resource $id invalid.");

		foreach ($files as $f)
		{

			$ltime = $this->greater($ltime,filemtime($f['file']));

		}

		//echo $ltime; exit;

		return $ltime;


	}

	public function outputByGroup($type,$id)
	{

		$this->CI->benchmark->mark("$type-$id"."_start");

		$content = "";

		$files = $this->gfiles($type,$id);

		if (!$files) show_error("Resource $id invalid.");


		//identify unique cached file
		$m = md5(serialize($files));
		$t = $this->mtime($type,$id);

		//echo $m; exit;

		$fn = config_item("cache_path")."static/$id-$m-$t.$type";

		//if exists load
		if (file_exists($fn))
			{
			$content = file_get_contents($fn);
			}


		if ($content == "")
		{

		foreach ($files as $f)
		{

			$string = file_get_contents($f['file']);

			if ($type=='css')
				{
				$content .= $this->css($string,array('prependRelativePath'=>$f['path']));
				}
			else if ($type=='js')
				{
				$content .= $this->js($string);
				}

		} /* end for */


			//write cache

			$this->CI->load->helper('file');

			//store in a subfolder in cache to avoid long processing
			$dir = config_item("cache_path")."static";
            

			//check if folder exists make if not
			if (!is_dir($dir))
				mkdir($dir,0777);

			//delete previous versions
			foreach (glob("$dir/$id-$m-*.$type") as $fd) unlink($fd);

			write_file($fn,$content);



		} /* end if */

		$this->CI->benchmark->mark("$type-$id"."_end");

		//Display benchmark
		//$content = "/* $fn ".$this->CI->benchmark->elapsed_time()." ".$this->CI->benchmark->memory_usage()." */ ".$content;

		if ($type=='css')
			{
			$this->set_output("text/".$type,$content);
			}
		else if ($type=='js')
			{
			$this->set_output("application/x-javascript",$content);
			}

	}


	private function set_output($type="",$content="",$time = false,$expires = false)
	{

		if (!$time) $time = time();

		$last_modified_time = $time;
		$etag = md5($content);

		$this->CI->output->set_header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");
		$this->CI->output->set_header("Etag: $etag");

		if ($expires===false)
			$expires = $this->CI->config->item('expires');

		$this->CI->output->set_header("Content-type: $type; charset=utf-8");
		$this->CI->output->set_header("Pragma: public");
		$this->CI->output->set_header("Cache-Control: maxage=".$expires);
		$this->CI->output->set_header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
		$this->CI->output->set_output($content);

		//return true;
	}

}

function mtime($type,$id)
{

	$min = new Minify();

	return $min->mtime($type,$id);

}

function minifyCSS($css,$options = array())
{

	$min = new Minify();

	return $min->css($css,$options);
}

function minifyJS($js)
{

		//return $js;

		$min = new Minify();

		return $min->js($js);
}


?>