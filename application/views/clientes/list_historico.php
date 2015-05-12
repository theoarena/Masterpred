<link href="<?php echo site::mediaUrl(); ?>css/ui.fancytree.css" rel="stylesheet" type="text/css" />
<script src="<?php echo site::mediaUrl(); ?>js/jquery-ui.custom.js"></script>
<script src="<?php echo site::mediaUrl(); ?>js/jquery.fancytree.js"></script>

<script type="text/javascript">	
	
	$(document).ready(function(){
		//$('#btn_buscar').click();
		var de = "<?php echo $de ?>"; 
		var ate =  "<?php echo $ate ?>"; 
		var sp = "<?php echo $sp ?>"; 
		var pe = "<?php echo $pe ?>"; 
		var fi = "<?php echo $fi ?>"; 

		$("#tree").fancytree({ autoCollapse: true,icons: false,				 
			 lazyload: function(e, data){						 	
		        data.result = $.ajax({
		          url:"<?php echo site::baseUrl() ?>clientes/load_historico?id="+data.node.key
		          +"&de="+de+"&ate="+ate+"&sp="+sp+"&pe="+pe+"&fi="+fi,
		          dataType: "json"			                  	         
		        });
		      }/*,
		      click: function(event, data){
 				   var node = data.node;
 				   alert(node.key);
			  }*/
		});

	});

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

	echo form::open( site::segment(1)."/".site::segment(2),array("id" => "form_edit" , 'method' => 'get') );	

	echo "<div id='select_data'>";
		echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>De</span>". form::input('de', $de , array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" , 'placeholder' => 'Data Inicial' )) ."</div>";	
		echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Até</span>". form::input('ate', $ate , array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" , 'placeholder' => 'Data Inicial' )) ."</div>";		
		echo "<div class='input-group input-group-lg'> ". form::submit('submit', "Buscar", array('class' => 'btn btn-primary btn-lg','id'=>'btn_buscar') ) ."</div>";		
		

	echo '</div>';	 

	echo "<div id='historico_check'>";
		echo "<label class='control checkbox chk_equip'> ".form::checkbox('sem_planejamento',1,($sp==1)?true:false)." <span class='checkbox-label'>Sem Planejamento</span></label>";   
		echo "<label class='control checkbox chk_equip'> ".form::checkbox('pendentes',1,($pe==1)?true:false)." <span class='checkbox-label'>Pendentes</span></label>";   
		echo "<label class='control checkbox chk_equip'> ".form::checkbox('finalizadas',1,($fi==1)?true:false)." <span class='checkbox-label'>Finalizadas</span></label>";   
	echo '</div>';	 	

	echo "</form>";
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