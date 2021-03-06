<div class="navbar-header">	          
	<h1 class="navbar-brand"><?php echo Kohana::$config->load('config')->get('site_name'); ?></h1>
	<p id='logado_como'>Logado como <?php echo $nome_usuario; ?>: <strong><?php echo $tipo_usuario; ?></strong></p>
	<div class="btn-group" id='collapse_container'> <button id="collapse-sidebar" class="btn btn-primary">MENU</button> </div>
	
	<?php
		if(isset($empresas)){			
			echo "<a id='unidacess' href='javascript:void(0)'>Unidades acessíveis</a>";		
			

	?>
		<script type="text/javascript">

			  $('#unidacess').click(function(e){
	            $.fancybox.open(
	            {
	                href: '<?php echo site::baseUrl() ?>requests/popup_empresas',
	                type: 'ajax',
	                title: 'Unidades acessíveis',
	                padding:20
	            });           
	            e.preventDefault();
	        });
		</script>
    <?php

    	}

	?>
</div>
<div class="collapse navbar-collapse">	     
	<ul class="nav navbar-nav" id="menu_lateral">
	<?php
		echo "<li id='home'>".HTML::anchor('', 'Home')."</li>";	
		echo $tipo_menu;
		if(Usuario::isGrant(array('edit_self_account')))	
			echo "<li>".HTML::anchor('usuario/perfil', 'Minha conta' , array("class" => Site::active("perfil",3,false,''), 'id' => 'perfil'  ) );
		echo "<li id='logout'>".HTML::anchor('usuario/logout', 'Sair')."</li>";	
	?>
	</ul>

	<div id='desenvolvedor'>	
		<p>Copyright © <?php echo Kohana::$config->load('config')->get('site_name'); ?> <?php echo date("Y"); ?> - Todos os Direitos Reservados.</p>		
		<p>Veja os <?php echo HTML::anchor('avisos/termos?show=0','Termos de uso'); ?> do sistema.</p>
		<p>Versão <?php echo Kohana::$config->load('config')->get('system_version'); ?></p>
	</div>
</div>