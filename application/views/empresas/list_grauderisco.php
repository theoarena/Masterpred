<link href="<?php echo Site::mediaUrl(); ?>css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Site::mediaUrl(); ?>js/datepicker.js"></script>
<?php 
	if(Usuario::selected_empresaatual()) {

	
	
	$tipo = array('sim' => 'Confirmados', 'nao'=>'Não confirmados');
	$hoje = date('d/m/Y');
	$amanha = date('d/m/Y', strtotime("+1 days"));	

	echo "<div id='select_data'>";
	echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>De</span>". Form::input('de', Arr::get($_GET, 'de',$hoje) , array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" , 'placeholder' => 'Data Inicial' )) ."</div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Até</span>". Form::input('ate', Arr::get($_GET, 'ate', $amanha) , array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" , 'placeholder' => 'Data Inicial' )) ."</div>";		
	echo "<div class='input-group input-group-lg div_filtrar'><h1 id='btn_filtrar'>". HTML::anchor('#','Buscar', array('class' => 'btn btn-primary' )) ."</h1></div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Busca:</span>". Form::input('nome', null , array('class' => 'form-control', 'maxlength' => '30', 'id' => 'campobusca')) ."</div>";		
	echo '</div>';		
	echo "<div id='select_data'>";
	echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Tecnologia</span>". Form::select('tecnologia',$tecnologias, Arr::get($_GET, 'tec', 'padrao') , array('class' => 'form-control')) ."</div>";		
	echo "<div class='input-group input-group-lg drop2'> <span class='input-group-addon'>Tipo</span>". Form::select('tipo', $tipo ,Arr::get($_GET, 'tipo', 'nao'), array('class' => 'form-control')) ."</div>";			
	echo '</div>';	

?>

<table class="footable table" data-page-navigation=".pagination"  data-filter=#campobusca>
	<thead>
		<tr>
			<th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo Site::getTituloCampos("codigo"); ?></h3></th>
			<th><h3><?php echo Site::getTituloCampos("numerogr"); ?></h3></th>
			<th><h3><?php echo Site::getTituloCampos("data"); ?></h3></th>
			<th><h3><?php echo Site::getTituloCampos("equipamento"); ?></h3></th>			
			<th><h3><?php echo Site::getTituloCampos("componente"); ?></h3></th>		
			<th data-sort-ignore="true" id='col_actions'><h3><?php echo Site::getTituloCampos("acoes"); ?></h3></th>		
		</tr>
	</thead>
	<tbody>
		
	</tbody>
	<tfoot class="hide-if-no-paging">
		<tr>
			<td colspan="100">
				<ul class="pagination pagination-centered"></ul>
			</td>
		</tr>
	</tfoot>

</table>

<?php
	 
	} else echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'ative_empresa')."</div>"; 
?>

<script type="text/javascript">


	$(function () {
	    //$('.footable').footable();
	    $('input[name="de"]').datepicker({format:'dd/mm/yyyy'});
	    $('input[name="ate"]').datepicker({format:'dd/mm/yyyy'});

	    <?php
	    	if( isset($_GET["de"]) && isset($_GET["tec"]))
	    		echo '$( "#btn_filtrar" ).click();';
	    ?>
	});


	$( "#btn_filtrar" ).click(function () {
		$(".footable tbody").html("<span id='loading'><img src='<?php echo Site::mediaUrl() ?>images/loading.gif'></span>");

		var de = $( "input[name='de']" ).val(); //pega o setor selecionado
		var ate = $( "input[name='ate']" ).val(); //pega a area selecionado
		var tec = $( "select[name='tecnologia'] option:selected" ).val(); //pega a area selecionado
		var tipo = $( "select[name='tipo'] option:selected" ).val(); //pega a area selecionado

		$.ajax({
			url : "<?php echo Site::baseUrl() ?>empresas/carrega_grausderisco",
			type: "POST",  
			dataType: "json",
  			data: { de:de, ate:ate, tecnologia:tec, tipo:tipo},
			success : function(dados) {	
				
				$(".footable tbody").html("");
				$(".footable thead").show();

				if(dados.length > 0) //se tem equipamentos
				{
					for(var i=0;i < dados.length ;i++)
					{
						var gr = dados[i];					
	   					var colunas = "<tr>";
	   					var cod = gr["CodGr"];
				    	colunas += "<td>"+cod+"</td>";				    					    	
				    	colunas += "<td>"+gr["NumeroGr"]+"</td>";
				    	colunas += "<td>"+gr["Data"]+"</td>";				    	
				    	colunas += "<td>"+gr["Equipamento"]+"</td>";				    				    	
				    	colunas += "<td>"+gr["Componente"]+"</td>";				   				    	
				    	colunas += "<td><div class='btn-group btn-group-lg'>";
				    	colunas += "<a href='<?php echo Site::baseUrl() ?>empresas/edit_grauderisco/"+cod+"?de="+de+"&ate="+ate+"&tec="+tec+"&tipo="+tipo+"' class='btn btn-info'>EDITAR</a>";						

				    	<?php if(Usuario::isGrant(array('remove_grauderisco'))) { ?>				    	
				    		colunas += "<button type='button' class='btn btn-danger' id='ask_"+cod+"' onclick='askDelete(\""+cod+"\")'>REMOVER</button>";
							colunas += "<button type='button' class='btn btn-success confirm_hidden' id='confirm_"+cod+"' onclick='deleteRow(\""+cod+"\")'>S</button>";						
							colunas += "<button type='button' class='btn btn-danger confirm_hidden' id='cancel_"+cod+"' onclick='askDelete(\""+cod+"\")'>N</button>";	
						<?php } ?>
						colunas += "</div></td></tr>";
				   		$(".footable tbody").append(colunas);				    	
					}					
					
				}
				else
				{					
					$(".footable tbody").append("<tr><td colspan='5'><div class='alert alert-warning tabela_vazia'><?php echo Kohana::message('admin', 'nenhum_item'); ?></div></td></tr>");	
					$(".footable thead").hide();
				}

				$('.footable').footable();			
			    
			}
		});
		
	});


</script>

<?php if(Usuario::isGrant(array('remove_grauderisco'))) echo Site::generateDelete('Gr'); ?>