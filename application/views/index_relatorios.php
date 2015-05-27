<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
	<title><?php Kohana::$config->load('config')->get('site_name'); ?></title>

	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>

	<!-- Le styles -->
	
	<link href='<?php echo site::mediaUrl(); ?>css/print.css' rel='stylesheet' type='text/css' />	
	
</head>

<body id='<?php echo site::segment('relatorios',null); ?>'>
	<div class="no-print" id="bar_print">		
		<a href="javascript:history.back(-1)" id="voltar">Voltar</a>
		<a href="javascript:self.print()" id="imprimir">Imprimir</a>
	</div>
	<?php echo $content; ?>	
</body>

</html>