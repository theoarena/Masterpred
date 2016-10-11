<div class="jumbotron">
  <h1>Olá, <?php echo $nome_usuario; ?></h1>
  <p>Bem Vindo ao Painel de Administração.</p>

  <?php if(Usuario::isGrant(array('access_usuarios_empresa'))) { ?>
	<h2>Notificações</h2>
	<div class="list-group">
		<?php
			$cont = 1;
			if( Site::qtd_pedidosusuario()  > 0) { 
				echo '<a href="'.URL::site("empresas/pedidos_usuario").'" class="list-group-item active">';
		 		echo '<h4 class="list-group-item-heading">'.Site::qtd_pedidosusuario() .' novo(s) pedido(s) de usuário de sistema.</h4>';
		 		echo '<p class="list-group-item-text">Clique aqui para visualizar.</p>';
		 		echo '</a>';
		 		$cont--;
		 	}

		 	//if($cont>0)
		 	//echo '<p class="list-group-item-text">Nenhuma nova notificação.</p>';

	 	?>	
	</div>
	<?php } 


 	echo '<p>As <a href="'.URL::site("sistema/normas").'" class="inline_bold">normas</a> já podem ser inseridas. É necessário, também, vinculá-las com suas respectivas
 	<a href="'.URL::site("sistema/tecnologias").'" class="inline_bold">tecnologias</a>.';

 	echo '<p>O menu <a href="'.URL::site("sistema/tecnologias").'" class="inline_bold">instrumentação</a> também está disponível, bem como

 	os <span class="inline_bold">Softwares</span>, que também podem ser inseridos em cada tecnologia.';

	?>


</div>
