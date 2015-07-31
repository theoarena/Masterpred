<div class="jumbotron">
  <h1>Olá, <?php echo $nome_usuario; ?></h1>
  <p>Bem Vindo ao Painel de Administração.</p>

  <?php if(site::isGrant(array('access_usuarios_empresa'))) { ?>
	<h2>Notificações</h2>
	<div class="list-group">
		<?php
			$cont = 1;
			if( site::qtd_pedidosusuario()  > 0) { 
				echo '<a href="'.URL::site("empresas/pedidos_usuario").'" class="list-group-item active">';
		 		echo '<h4 class="list-group-item-heading">'.site::qtd_pedidosusuario() .' novo(s) pedido(s) de usuário de sistema.</h4>';
		 		echo '<p class="list-group-item-text">Clique aqui para visualizar.</p>';
		 		echo '</a>';
		 		$cont--;
		 	}

		 	if($cont>0)
		 	echo '<p class="list-group-item-text">Nenhuma nova notificação.</p>';

	 	?>	
	</div>
	<?php } ?>

 
</div>
