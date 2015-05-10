<link href="<?php echo site::mediaUrl(); ?>css/ui.fancytree.css" rel="stylesheet" type="text/css" />
<script src="<?php echo site::mediaUrl(); ?>js/jquery-ui.custom.js"></script>
<script src="<?php echo site::mediaUrl(); ?>js/jquery.fancytree.js"></script>

<script type="text/javascript">	
	
	$(document).ready(function(){
		$('#btn_buscar').click();
	});

	function carregar_dados()
	{
		var de = $( "input[name='de']" ).val(); 
		var ate = $( "input[name='ate']" ).val(); 
		var sp = $( "input[name='sem_planejamento']" ).val();
		var pe = $( "input[name='pendentes']" ).val(); 
		var fi = $( "input[name='finalizadas']" ).val();
				
		$("#tree").fancytree({ autoCollapse: true,icons: false,				 
			 lazyload: function(e, data){				 	
		        data.result = $.ajax({
		          url:"<?php echo site::baseUrl() ?>clientes/load_historico?id="+data.node.key,
		          dataType: "json"			                  	         
		        });
		      }/*,
		      click: function(event, data){
 				   var node = data.node;
 				   alert(node.key);
			  }*/
		});
		
	}

	function fechar()
	{
		$("#tree").fancytree("getRootNode").visit(function(node){
        		node.setExpanded(false);
      		});
	}
</script>

<h1 id='btn_adicionar'>		
	<a href='javascript:void(0)' class='label label-info' onclick='fechar()'>Fechar árvore</a>		
</h1>


<?php
	
	$date_start = "01/".date('m')."/".date('Y');
	$date_end = date('d/m/Y');

	echo "<div id='select_data'>";
		echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>De</span>". form::input('de', Arr::get($_GET, 'de', $date_start) , array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" , 'placeholder' => 'Data Inicial' )) ."</div>";	
		echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Até</span>". form::input('ate', Arr::get($_GET, 'ate', $date_end) , array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" , 'placeholder' => 'Data Inicial' )) ."</div>";		
		echo "<div class='input-group input-group-lg div_filtrar'><h1 id='btn_filtrar'>". html::anchor('#','Buscar', array('class' => 'label label-primary','id'=>'btn_buscar'), 'onclick' => 'carregar_dados()') ."</h1></div>";	
	echo '</div>';	 

	echo "<div id='historico_check'>";
		echo "<label class='control checkbox chk_equip'> ".form::checkbox('sem_planejamento',1, true )." <span class='checkbox-label'>Sem Planejamento</span></label>";   
		echo "<label class='control checkbox chk_equip'> ".form::checkbox('pendentes',1, true )." <span class='checkbox-label'>Pendentes</span></label>";   
		echo "<label class='control checkbox chk_equip'> ".form::checkbox('finalizadas',1, false )." <span class='checkbox-label'>Finalizadas</span></label>";   
	echo '</div>';	 	

	if(count($objs) > 0) //se há pelo menos uma empresa
	{
		echo "<div id='tree'>";
			echo "<ul id='treeData' style='display: none;'>";
				foreach ($objs as $empresa)
				{
					echo "<li class='lazy' id='empresa_".$empresa->CodEmpresa."'>Empresa # ".$empresa->Empresa.' | '.$empresa->Unidade.' | '.$empresa->Fabrica;
					
				}	
			echo '</ul>';
		echo '</div>';	
	} 
	else echo "<div class='alert alert-warning tabela_vazia'>Nenhuma empresa encontrada.</div>"; 
	
?>