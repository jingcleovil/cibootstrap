<?php if(!isset($title)) $title = config_item('site_title')?>
<?php if(!isset($description)) $description = "";?>
<?php if(!isset($keyword)) $keyword = "";?>
<?php if(!isset($author)) $author = "";?>
<!DOCTYPE html>
        <!--[if lt IE 7]> <html class="no-js ie ie6" lang="en"> <![endif]-->
        <!--[if IE 7]>    <html class="no-js ie ie7" lang="en"> <![endif]-->
        <!--[if IE 8]>    <html class="no-js ie8" lang="en"> <![endif]-->
        <!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
        <!--[if IE 10]>    <html class="no-js ie10" lang="en"> <![endif]-->
        <!--[if gt IE 10]><!--><html class="no-js" lang="en"><!--<![endif]-->
        <head>
        <meta charset="utf-8">
        
        <title><?=$title?></title>  
		
        <meta name="description" content="<?=$description?>">
        <meta name="keywords" content="<?=$keyword?>">
        <meta name="author" content="<?=$author?>">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

		
		
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" href="/apple-touch-icon.ico">

        <script type="text/javascript">
            var root = '<?=base_url()?>';
  
            <?php if(isset($user)) {?>
			var id = '<?=$user['id']?>'; 
			<? } ?> 
        </script> 

        <?php
            if(!isset($cssgroup)) $cssgroup = "default";
            
            $links = array(
                'href'=>site_url("mini/css/{$cssgroup}/".mtime('css',$cssgroup)).".css",
                'rel'=>'stylesheet',
            );
            echo link_tag($links);
        ?>
    </head>
