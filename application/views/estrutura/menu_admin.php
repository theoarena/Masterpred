<?php		
	echo "<li>".html::anchor('#', 'Empresas' , array("class" => site::active("empresas",1,false).' menu_dropdown' , 'id' => 'menu_empresa'  ) );
			echo "<ul>";
				if($qtd_usuarios > 0)
					echo "<li>".html::anchor('empresas/pedidos_usuario', 'Pedidos de usuário <span class="badge">'.$qtd_usuarios.'</span>', array("class" => site::active("pedidos_usuario",2,false) ) );

				echo "<li>".html::anchor('empresas/empresas', 'Lista de empresas' , array("class" => site::active("empresas",2,false) ) );
				if(site::selected_empresaatual())
				{
					echo "<li>".html::anchor('empresas/analiseinspecao', "Análise de Inspeção" , array("class" => site::active("analiseinspecao",2,false) ) );
					echo "<li>".html::anchor('empresas/grauderisco', "Grau de risco" , array("class" => site::active("grauderisco",2,false) ) );
					echo "<li>".html::anchor('empresas/rotas', 'Rotas' , array("class" => site::active("rotas",2,false) ) );				
					echo "<li>".html::anchor('empresas/usuarios', 'Usuários', array("class" => site::active("usuarios",2,false) ) );
					echo "<li>".html::anchor('empresas/areas_setores', 'Áreas e Setores' , array("class" => site::active("areas_setores",2,false) ) );
					echo "<li>".html::anchor('empresas/equipamentos', 'Equipamentos' , array("class" => site::active("equipamentos",2,false) ) );				
				}
			echo "</ul>";
		echo "</li>";		

	echo "<li>".html::anchor('#', 'Sistema' , array("class" => site::active("sistema",1,false).' menu_dropdown' , 'id' => 'menu_sistema'  ) );
		echo "<ul>";
			echo "<li>".html::anchor('sistema/tecnologias', 'Tecnologias' , array("class" => site::active("tecnologias",2,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/componentes', 'Componentes' , array("class" => site::active("componentes",2,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/anomalias', 'Anomalias' , array("class" => site::active("anomalias",2,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/recomendacoes', 'Recomendações' , array("class" => site::active("recomendacoes",2,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/tipoequipamento', 'Tipos de Equipamento' , array("class" => site::active("tipoequipamento",2,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/condicoes', 'Condições' , array("class" => site::active("condicoes",2,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/tipoinspecao', 'Tipos de Inspeção' , array("class" => site::active("tipoinspecao",2,false) ) ). "</li>";
			echo "<li>".html::anchor('sistema/analistas', 'Analistas' , array("class" => site::active("analistas",2,false) ) ). "</li>";	
			echo "<li>".html::anchor('sistema/roles', 'Grupos de Acesso' , array("class" => site::active("roles",2,false) ) ). "</li>";	
			echo "<li>".html::anchor('sistema/privileges', 'Privilégios' , array("class" => site::active("privileges",2,false) ) ). "</li>";	
		echo "</ul>";	
	echo "</li>";	
?>

<script type='text/javascript'>
	
	  $('#menu_empresa').click(function(e)
	  {		
		$('#menu_empresa + ul').slideToggle();	
		$('#menu_sistema + ul').slideUp();				
		e.preventDefault();
	  });

	   $('#menu_sistema').click(function(e)
	  {		
			$('#menu_empresa + ul').slideUp();	
			$('#menu_sistema + ul').slideToggle();				
		e.preventDefault();
	  });

</script>