<div class="navbar-header">	          
	<h1 class="navbar-brand"><?php echo Kohana::$config->load('config')->get('site_name'); ?></h1>
	<p id='logado_como'>Logado como <?php echo $nome_usuario; ?>: <strong><?php echo $tipo_usuario; ?></strong></p>
	<div class="btn-group" id='collapse_container'> <button id="collapse-sidebar" class="btn btn-primary">MENU</button> </div>
	
	<?php
		if(isset($empresas))
			foreach ($empresas as $empresa) {
				
				echo '<div class="block_info_empresa">';
					echo '<span>'.$empresa->Empresa. ' - '.$empresa->Unidade.'</span>';
					echo '<span>Fábrica: '.$empresa->Fabrica.'</span>';
				echo '</div>';

			}
	?>
</div>
<div class="collapse navbar-collapse">	     
	<ul class="nav navbar-nav">
	<?php
		echo "<li id='home'>".html::anchor('', 'Home')."</li>";	
		echo $tipo_menu;
		echo "<li>".html::anchor('usuario/perfil', 'Minha conta' , array("class" => site::active("perfil",2,false), 'id' => 'perfil'  ) );
		echo "<li id='logout'>".html::anchor('usuario/logout', 'Sair')."</li>";	
	?>
	</ul>

	<div id='desenvolvedor'>	
		<p>Copyright © <?php echo Kohana::$config->load('config')->get('site_name'); ?> <?php echo date("Y"); ?> - Todos os Direitos Reservados.</p>		
		<p>Versão <?php echo Kohana::$config->load('config')->get('system_version'); ?></p>
	</div>
</div>