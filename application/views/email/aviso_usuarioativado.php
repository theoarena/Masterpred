<div style='background-color:#f1f1f1;padding:10px;color:#444444;font-family:Verdana'>
	<h2>Masterpred</h2>
	<p style="margin:0">Prezado Sr. <?php echo $nome;?>, seguem os dados para utilizar o sistema online da MASTERPRED © .</p>	
	<div style=" background: none repeat scroll 0 0 #428BCA; padding:10px;margin:10px 0">
		<p style="margin:0;color:#f7f7f7">Usuário: <?php echo $username; ?></p>
		<p style="margin:0;color:#f7f7f7">Senha: <?php echo($password != null)?($password):("não foi mudada"); ?></p>
	</div>
	<p style="margin:0"><a href='<?php echo Kohana::config('config.endereco_sistema'); ?>'>Clique aqui</a> para acessar o sistema e desfrutar de todas as suas funcionalidades.</p>
	<p style="margin:0">&nbsp;</p>
	<p style="margin:0">Atenciosamente,</p>
	<p style="margin:0">Equipe MASTERPRED ©</p>
</div>