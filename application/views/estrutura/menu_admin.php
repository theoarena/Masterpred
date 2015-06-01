<?php		
	$menu_hide = "hide_menu";
	echo "<li>".html::anchor('#', 'Empresas' , array("class" => 'menu_dropdown', 'onclick' => 'openMenu("menu_empresa")' , 'id' => 'menu_empresa'  ) );
			echo "<ul>";
				if($qtd_usuarios > 0)
					echo "<li>".html::anchor('empresas/pedidos_usuario', 'Pedidos de usuário <span class="badge">'.$qtd_usuarios.'</span>', array("class" => site::active("pedidos_usuario",3,false) ) );

				echo "<li>".html::anchor('empresas/empresas', 'Lista de empresas' , array("class" => site::active("empresas",3,false) ) );
				if(site::selected_empresaatual())
					$menu_hide = "";

					echo "<li>".html::anchor('empresas/areas_setores', 'Áreas e Setores' , array("class" => site::active("areas_setores",3,false).' '.$menu_hide  ) );
					echo "<li>".html::anchor('empresas/equipamentos', 'Equipamentos' , array("class" => site::active("equipamentos",3,false).' '.$menu_hide  ) );				
					echo "<li>".html::anchor('empresas/rotas', 'Rotas' , array("class" => site::active("rotas",3,false).' '.$menu_hide  ) );				
					echo "<li>".html::anchor('empresas/usuarios', 'Usuários', array("class" => site::active("usuarios",3,false).' '.$menu_hide  ) );
				
			echo "</ul>";
		echo "</li>";		

	echo "<li>".html::anchor('#', 'Análise' , array("class" => 'menu_dropdown', 'onclick' => 'openMenu("menu_analise")' , 'id' => 'menu_analise'  ) );
		echo "<ul>";
			echo "<li>".html::anchor('empresas/analiseinspecao', "Análise de Inspeção" , array("class" => site::active("analiseinspecao",3,false).' '.$menu_hide  ) );
			echo "<li>".html::anchor('empresas/grauderisco', "Grau de risco" , array("class" => site::active("grauderisco",3,false).' '.$menu_hide  ) );
		echo "</ul>";
	echo "</li>";

	echo "<li>".html::anchor('#', 'Relatórios' , array("class" => 'menu_dropdown', 'onclick' => 'openMenu("menu_relatorio")' , 'id' => 'menu_relatorio'  ) );
		
	echo "</li>";

	echo "<li>".html::anchor('#', 'Sistema' , array("class" => 'menu_dropdown', 'onclick' => 'openMenu("menu_sistema")' , 'id' => 'menu_sistema'  ) );
		echo "<ul>";
			echo "<li>".html::anchor('sistema/usuarios_sistema', 'Usuários de sistema' , array("class" => site::active("usuarios_sistema",3,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/tecnologias', 'Tecnologias' , array("class" => site::active("tecnologias",3,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/componentes', 'Componentes' , array("class" => site::active("componentes",3,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/anomalias', 'Anomalias' , array("class" => site::active("anomalias",3,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/recomendacoes', 'Recomendações' , array("class" => site::active("recomendacoes",3,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/tipoequipamento', 'Tipos de Equipamento' , array("class" => site::active("tipoequipamento",3,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/condicoes', 'Condições' , array("class" => site::active("condicoes",3,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/tipoinspecao', 'Tipos de Inspeção' , array("class" => site::active("tipoinspecao",3,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/analistas', 'Analistas' , array("class" => site::active("analistas",3,false) ) ). "</li>";	
			echo "<li>".html::anchor('sistema/roles', 'Grupos de Acesso' , array("class" => site::active("roles",3,false) ) ). "</li>";	
			//echo "<li>".html::anchor('sistema/privileges', 'Privilégios' , array("class" => site::active("privileges",3,false) ) ). "</li>";	
		echo "</ul>";	
	echo "</li>";	
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