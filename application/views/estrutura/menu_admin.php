<?php		
	$menu_hide = "hide_menu";
	if(Usuario::isGrant(array('access_empresa')))
	{	
		echo "<li>".HTML::anchor('#', 'Empresas' , array("class" => 'menu_dropdown', 'onclick' => 'openMenu("menu_empresa")' , 'id' => 'menu_empresa'  ) );
			echo "<ul>";
				if(Usuario::isGrant(array('access_usuarios_empresa')))
					if($qtd_usuarios > 0)
						echo "<li>".HTML::anchor('empresas/pedidos_usuario', 'Pedidos de usuário <span class="badge">'.$qtd_usuarios.'</span>', array("class" => Site::active("pedidos_usuario",3,false) ) ). "</li>";

				if(Usuario::isGrant(array('access_list_empresas')))
					echo "<li>".HTML::anchor('empresas/empresas', 'Lista de empresas' , array("class" => Site::active("empresas",3,false) ) ). "</li>";
				if(Usuario::selected_empresaatual())
					$menu_hide = "";

				if(Usuario::isGrant(array('access_areassetores')))
					echo "<li>".HTML::anchor('empresas/areas_setores', 'Áreas e Setores' , array("class" => Site::active("areas_setores",3,false).' '.$menu_hide  ) ). "</li>";
				if(Usuario::isGrant(array('access_equipamentos')))
					echo "<li>".HTML::anchor('empresas/equipamentos', 'Equipamentos' , array("class" => Site::active("equipamentos",3,false).' '.$menu_hide  ) ). "</li>";				
				if(Usuario::isGrant(array('access_rotas')))
					echo "<li>".HTML::anchor('empresas/rotas', 'Rotas' , array("class" => Site::active("rotas",3,false).' '.$menu_hide  ) ). "</li>";				
				if(Usuario::isGrant(array('access_usuarios_empresa')))
					echo "<li>".HTML::anchor('empresas/usuarios', 'Usuários', array("class" => Site::active("usuarios",3,false).' '.$menu_hide  ) ). "</li>";
				
			echo "</ul>";
		echo "</li>";		
	}
	if(Usuario::isGrant(array('access_analise')))
	{	
		echo "<li>".HTML::anchor('#', 'Análise' , array("class" => 'menu_dropdown', 'onclick' => 'openMenu("menu_analise")' , 'id' => 'menu_analise'  ) );
			echo "<ul>";
				//if(Usuario::isGrant(array('access_inspecao'))) nao tem um privilegio necessario pra isso existir
					echo "<li>".HTML::anchor('empresas/analiseinspecao', "Análise de Inspeção" , array("class" => Site::active("analiseinspecao",3,false).' '.$menu_hide  ) ). "</li>";
				//if(Usuario::isGrant(array('access_grauderisco'))) idem
					echo "<li>".HTML::anchor('empresas/grauderisco', "Grau de risco" , array("class" => Site::active("grauderisco",3,false).' '.$menu_hide  ) ). "</li>";
			echo "</ul>";
		echo "</li>";
	}
	if(Usuario::isGrant(array('access_relatorios')))
	{	
			echo "<li>".HTML::anchor('#', 'Relatórios' , array("class" => 'menu_dropdown', 'onclick' => 'openMenu("menu_relatorio")' , 'id' => 'menu_relatorio'  ) );
				echo "<ul>";							
					echo "<li>".HTML::anchor('relatorios/relatorios', "Gerar Relatórios" , array("class" => Site::active("relatorio_gerar",3,false) ) ). "</li>";					
					echo "<li>".HTML::anchor('relatorios/uploads', "Upload de Relatórios" , array("class" => Site::active("relatorio_upload",3,false) ) ). "</li>";					
				echo "</ul>";
			echo "</li>";
	}

	if(Usuario::isGrant(array('access_sistema')))
	{	
		echo "<li>".HTML::anchor('#', 'Sistema' , array("class" => 'menu_dropdown', 'onclick' => 'openMenu("menu_sistema")' , 'id' => 'menu_sistema'  ) );
			echo "<ul>";
				if(Usuario::isGrant(array('access_analistas')))
					echo "<li>".HTML::anchor('sistema/analistas', 'Analistas' , array("class" => Site::active("analistas",3,false) ) ). "</li>";	

				if(Usuario::isGrant(array('access_anomalias')))
					echo "<li>".HTML::anchor('sistema/anomalias', 'Anomalias' , array("class" => Site::active("anomalias",3,false) ) ). "</li>";

				if(Usuario::isGrant(array('access_componentes')))
					echo "<li>".HTML::anchor('sistema/componentes', 'Componentes' , array("class" => Site::active("componentes",3,false) ) ). "</li>";

				if(Usuario::isGrant(array('access_condicoes')))
					echo "<li>".HTML::anchor('sistema/condicoes', 'Condições' , array("class" => Site::active("condicoes",3,false) ) ). "</li>";

				if(Usuario::isGrant(array('access_roles')))
					echo "<li>".HTML::anchor('sistema/roles', 'Grupos de Acesso' , array("class" => Site::active("roles",3,false) ) ). "</li>";	

				echo "<li>".HTML::anchor('sistema/instrumentacao', 'Instrumentação' , array("class" => Site::active("instrumentacao",3,false) ) ). "</li>";

				echo "<li>".HTML::anchor('sistema/normas', 'Normas' , array("class" => Site::active("normas",3,false) ) ). "</li>";

				if(Usuario::isGrant(array('access_recomendacoes')))
					echo "<li>".HTML::anchor('sistema/recomendacoes', 'Recomendações' , array("class" => Site::active("recomendacoes",3,false) ) ). "</li>";				
				
				if(Usuario::isGrant(array('access_tecnologias')))
					echo "<li>".HTML::anchor('sistema/tecnologias', 'Tecnologias' , array("class" => Site::active("tecnologias",3,false) ) ). "</li>";				
				
				if(Usuario::isGrant(array('access_tipos_equipamento')))
					echo "<li>".HTML::anchor('sistema/tipoequipamento', 'Tipos de Equipamento' , array("class" => Site::active("tipoequipamento",3,false) ) ). "</li>";
				
				if(Usuario::isGrant(array('access_tipos_inspecao')))
					echo "<li>".HTML::anchor('sistema/tipoinspecao', 'Tipos de Inspeção' , array("class" => Site::active("tipoinspecao",3,false) ) ). "</li>";

				if(Usuario::isGrant(array('access_usuarios_sistema')))
					echo "<li>".HTML::anchor('sistema/usuarios_sistema', 'Usuários de sistema' , array("class" => Site::active("usuarios_sistema",3,false) ) ). "</li>";
				
				
				//echo "<li>".HTML::anchor('sistema/privileges', 'Privilégios' , array("class" => Site::active("privileges",3,false) ) ). "</li>";	
			echo "</ul>";	
		echo "</li>";	
	}
?>

<script type='text/javascript'>
	
	function openMenu(id) //any menu opener
	{
		$('#'+id+'+ ul').slideToggle();
		$('.menu_dropdown').each(function(){
			if( $(this).attr('id') != id )
				$(this).parent().find('ul').slideUp();
		})
	}

     $(document).ready(function(){
     		$('#menu_lateral').find('li a.drop.active').parent().parent().parent().find('a.menu_dropdown').addClass('active');
     })

</script>