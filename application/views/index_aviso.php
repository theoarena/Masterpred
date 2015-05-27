<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
	<title><?php echo Kohana::$config->load('config')->get('site_name'); ?></title>

	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>

	<!-- Le styles -->
	<link rel='stylesheet' type='text/css' href='<?php echo site::mediaUrl(); ?>css/metro-bootstrap.css'>
	<link href='<?php echo site::mediaUrl(); ?>css/main.css' rel='stylesheet' type='text/css' />		

</head>

<body id="usuario" class="cadastro">

	<div id='wrapper'>	  
	  	<div class='navbar navbar-side navbar-inverse navbar-fixed-top' role='navigation'>
	  		
	    </div>
		<div id='wrapper-container'>
		    <div class='container'>
		    	
		      <div class='starter-template'>
		      	<?php 
		      		
		      		echo $content;
		      	 ?>	
		      </div>

		    </div><!-- /.container -->
		</div>
	</div>

</body>

</html>