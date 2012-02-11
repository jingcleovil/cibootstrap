    <footer>
        <p>&copy; Company 2012 <?=$elapse?></p>
    </footer>

    </div> <!-- /container -->
	
<?php if(!isset($jsgroup)) $jsgroup = "default"?>

<script type="text/javascript" src="<?=site_url("mini/js/{$jsgroup}/".mtime('js',$jsgroup).'.js')?>"></script>

</body>
</html>