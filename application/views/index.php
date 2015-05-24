<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
	<title>.:: Masterpred ::.</title>

	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>

	<!-- Le styles -->
	<link rel='stylesheet' type='text/css' href='<?php echo site::mediaUrl(); ?>css/metro-bootstrap.css'>
	<link href='<?php echo site::mediaUrl(); ?>css/main.css' rel='stylesheet' type='text/css' />	
	<script src='<?php echo site::mediaUrl(); ?>js/jquery.js'></script>
	
	<?php if(site::getTipoUsuario('admin')) { ?>
		<link href='<?php echo site::mediaUrl(); ?>css/footable.core.css' rel='stylesheet' type='text/css' />
		<script src='<?php echo site::mediaUrl(); ?>js/footable.js'></script>	
		<script src='<?php echo site::mediaUrl(); ?>js/footable.sort.js'></script>
		<script src='<?php echo site::mediaUrl(); ?>js/footable.filter.js'></script>
		<script src='<?php echo site::mediaUrl(); ?>js/footable.paginate.js'></script>		
	<?php } ?>

	<?php if(site::getTipoUsuario('cliente')) { ?>
		<link href='<?php echo site::mediaUrl(); ?>css/historico.css' rel='stylesheet' type='text/css' />	
		<script src='<?php echo site::mediaUrl(); ?>js/amcharts.js'></script>	
		<script src='<?php echo site::mediaUrl(); ?>js/gauge.js'></script>	
	<?php } ?>


	<script src='<?php echo site::mediaUrl(); ?>js/functions.js'></script>
	<script src='<?php echo site::mediaUrl(); ?>js/validate.js'></script>

</head>

<body id='<?php echo site::segment(1,null);?>' class='<?php echo site::segment(2,null);?>'>

	<div id='wrapper'>	  
	  	<div class='navbar navbar-side navbar-inverse navbar-fixed-top' role='navigation'>
	  		<?php if(site::logado()) echo $menu_lateral; //se está logado,mostra o menu lateral 
	  			else echo '<div class="navbar-header"><h1 class="navbar-brand">MasterPred</h1></div>';		?>		            
	    </div>
		<div id='wrapper-container'>
		    <div class='container'>
		    	<?php // if(site::logado()) echo $menu_topo; //se está logado,mostra o menu lateral ?>		
		      <div class='starter-template'>
		      	<?php 
		      		if(site::logado() and site::getTipoUsuario('admin')) //se estiver logado e o tipo de usuario for admin
		      			echo site::avatar_empresaatual(); //mostra se alguma empresa está ativa
		      		echo $content;
		      	 ?>	
		      </div>

		    </div><!-- /.container -->
		</div>
	</div>

	<script type='text/javascript'>
	
	  $('#collapse-sidebar').click(function()
	  {		
		$('.navbar-collapse').slideToggle('fast');			
	  });
	</script>

</body>

</html>