<div class="jumbotron" id="termos">
  <h1 class="center">Termos de Uso</h1>
 
  <p class="center">

	Declaro estar ciente das disposições legais deste país referentes a segurança, sigilo, privacidade,
	imagem e confidencialidade de ambiente web privativo. Sendo assim, concordo com o uso do Sistema Web <strong>MasterPred®</strong>.
  </p> 
  <p class="center">
	Comprometo-me a utilizar o sistema de acordo com os fins previstos na legislação, sob pena de assumir
	responsabilidades civil e criminal. Todo conteúdo deste sistema contém informações privilegiadas entre a
	<strong>MasterPred®</strong> e seus Clientes e, portanto, deve-se manter os dados de acesso sob sigilo absoluto, não fornecendo os mesmos a ninguém
	, pois o mesmo é pessoal e intransferível, bem como quaisquer informações referentes ao sistema.</p>
	<p class="center">
	É proibido compartilhar tais informações sem autorização por escrito da <strong>MasterPred®</strong> e dos responsáveis pela Contratante. 
  </p> 
  <p class="center">
	Nunca devo me ausentar do terminal sem antes encerrar a sessão; impedindo, desta forma, o uso indevido do meu login 
	por pessoas não autorizadas. Estou ciente de que este sistema está dotado de <strong>rastreabilidade de acesso 
	através de IP e número do terminal</strong>. Quando houver sensibilidade de alternâncias no meu login,
	o mesmo poderá ser bloqueado por motivos de segurança.
  </p> 

  <br>
  <div class="center">
	<?php if( !isset($_GET['show']) ) { ?>
	    <h2 class="inline">		
				<?php echo HTML::anchor('avisos/aceitar',"Aceitar", array("class" => "label label-success" )); ?>
		</h2>
		<h2 class="inline">		
				<?php echo HTML::anchor('avisos/logout',"Recusar", array("class" => "label label-danger" )); ?>
		</h2>
		
	<?php } else { ?>
		 <h2 class="inline">		
		 	<a class="label label-success" onclick="javascript:history.back(-1)" href="javascript:void(0)">Voltar</a>				
		</h2>
	<?php } ?>
	</div>
</div>
