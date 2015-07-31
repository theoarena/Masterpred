<div style='background-color:#f1f1f1;padding:10px;color:#444444;font-family:Verdana'>
	<h2>Masterpred</h2>
	<p style="margin:0">Prezado Sr. <?php echo $nome;?>, segue sua nova senha para utilizar no sistema online da MASTERPRED © .</p>	
	<div style=" background: none repeat scroll 0 0 #428BCA; padding:10px;margin:10px 0">		
		<p style="margin:0;color:#f7f7f7">Sua nova senha é: <?php echo $password; ?></p>
	</div>
	<p style="margin:0"><a href='<?php echo Kohana::$config->load('config')->get('endereco_sistema'); ?>'>Clique aqui</a> para acessar o sistema e desfrutar de todas as suas funcionalidades.</p>
	<p style="margin:0">&nbsp;</p>
	<p style="margin:0">Atenciosamente,</p>
	<p style="margin:0">Equipe MASTERPRED ©</p>
</div>