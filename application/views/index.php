<!DOCTYPE html>
<head>
	
	<title><?php echo Kohana::$config->load('config')->get('site_name'); ?></title>

	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<meta name="robots" content="noindex" />

	<!-- Le styles -->
	<link rel='stylesheet' type='text/css' href='<?php echo Site::mediaUrl(); ?>css/metro-bootstrap.css'>
	<link href='<?php echo Site::mediaUrl(); ?>css/main.css' rel='stylesheet' type='text/css' />	
	<link href='<?php echo Site::mediaUrl(); ?>css/fancybox.css' rel='stylesheet' type='text/css' />	
	<script src='<?php echo Site::mediaUrl(); ?>js/jquery.js'></script>
	<script src='<?php echo Site::mediaUrl(); ?>js/fancybox.js'></script>		
	
	<?php if(Session::instance()->get('usuario_system',false) == 1) { ?>
		<link href='<?php echo Site::mediaUrl(); ?>css/footable.core.css' rel='stylesheet' type='text/css' />
		<script src='<?php echo Site::mediaUrl(); ?>js/footable.js'></script>	
		<script src='<?php echo Site::mediaUrl(); ?>js/footable.sort.js'></script>
		<script src='<?php echo Site::mediaUrl(); ?>js/footable.filter.js'></script>
		<script src='<?php echo Site::mediaUrl(); ?>js/footable.paginate.js'></script>		
	<?php } ?>

	<?php if(Session::instance()->get('usuario_system',false) == 0) { ?>
		<link href='<?php echo Site::mediaUrl(); ?>css/historico.css' rel='stylesheet' type='text/css' />	
		<script src='<?php echo Site::mediaUrl(); ?>js/amcharts.js'></script>	
		<script src='<?php echo Site::mediaUrl(); ?>js/gauge.js'></script>	
	<?php } ?>


	<script src='<?php echo Site::mediaUrl(); ?>js/functions.js'></script>
	<script src='<?php echo Site::mediaUrl(); ?>js/validate.js'></script>

</head>

<body id='<?php echo Site::segment(1,null);?>' class='<?php echo Site::segment(2,null);?>'>

	<div id='wrapper'>	  
	  	<div class='navbar navbar-side navbar-inverse navbar-fixed-top' role='navigation'>
	  		<?php
  			 if(Kohana::$config->load('config')->get('aviso_manutencao'))
  			 	echo '<div id="aviso_manutencao"><p>'.Kohana::message('admin', 'aviso_manutencao').'</p></div>';


	  		 if(Usuario::logado()) echo $menu_lateral; //se está logado,mostra o menu lateral 
	  			else echo '<div class="navbar-header"><h1 class="navbar-brand">MasterPred</h1></div>';		?>		            
	    </div>
		<div id='wrapper-container'>
		    <div class='container'>
		    	<?php // if(Site::logado()) echo $menu_topo; //se está logado,mostra o menu lateral ?>		
		      <div class='starter-template'>
		      	<?php 
		      		if(Session::instance()->get('usuario_system',false) == 1) //se o tipo de usuario for de sistema
		      			echo Usuario::avatar_empresaatual(); //mostra se alguma empresa está ativa
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