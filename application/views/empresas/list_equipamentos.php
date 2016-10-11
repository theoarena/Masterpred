<?php 

	if(Usuario::selected_empresaatual()) {
		
		echo "<div id='select_areas'>";
		echo "<div class='input-group input-group-lg full_50'> <span class='input-group-addon'>Área</span>". Form::select('area',$objs,$area,array("id"=>"area"))."</div>";
		echo "<div class='input-group input-group-lg full_50'> <span class='input-group-addon'>Setores</span>". Form::select('setor',null,null,array("id"=>"setor"))."</div>";
		echo "</div>";
?>

<br/>
<table class="footable table" data-page-navigation=".pagination" data-filter=#campobusca>
	<thead>
		<tr>
			<th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo Site::getTituloCampos("codigo"); ?></h3></th>				
			<th ><h3><?php echo Site::getTituloCampos("tag"); ?></h3></th>
			<th><h3><?php echo Site::getTituloCampos("equipamento"); ?></h3></th>
			<th><h3><?php echo Site::getTituloCampos("tipo_equipamento"); ?></h3></th>			
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

	$(document).ready(function(){
		$("#search_box").hide();
	});

	$( "select#area" ).change(function () {
		$(".footable tbody").html("");
		$( "#btn_adicionar" ).addClass("disabled");
		$("#search_box").hide();
		var selected = $( "select#area option:selected" ).val(); //pega a area selecionada
		$('select#setor').empty();
		$.ajax({
			url : "<?php echo Site::baseUrl() ?>empresas/carrega_setores/?a=1",
			type: "POST",  
			dataType: "json",
  			data: { id: selected},
			success : function(dados) {		
				
				$('select#setor').append($('<option>').text("-- Selecione um Setor --").attr('value', ""));

				$.each(dados, function(index, value) {

				     $('select#setor').append($('<option>').text(value).attr('value', index));
				});


				<?php 
					if($setor != null)
					{
						?>	$("select#setor").val(<?php echo $setor; ?>).change().prop('selected', true); <?php
					}
				?>


			}
		});
		
	}).change();


	$( "select#setor" ).change(function () {
		$(".footable tbody").html("<span id='loading'><img src='<?php echo Site::mediaUrl() ?>images/loading.gif'></span>");

		var selected = $( "select#setor option:selected" ).val(); //pega o setor selecionado
		var area = $( "select#area option:selected" ).val(); //pega a area selecionado
		$( "#btn_adicionar" ).removeClass("disabled");
		$("#search_box").show();
		$( "#btn_adicionar a" ).attr("href", "<?php echo Site::baseUrl() ?>empresas/edit_equipamentos/0/"+selected+"/"+area );
		$.ajax({
			url : "<?php echo Site::baseUrl() ?>empresas/carrega_equipamentos",
			type: "POST",  
			dataType: "json",
  			data: { setor: selected},
			success : function(dados) {	

				
				$(".footable tbody").html("");
				$(".footable thead").show();

				if(dados.length > 0) //se tem equipamentos
				{
					for(var i=0;i < dados.length ;i++)
					{
						var equipamento = dados[i];					
	   					var colunas = "<tr>";
	   					var cod = equipamento["CodEquipamento"];
				    	colunas += "<td>"+cod+"</td>";				    					    	
				    	colunas += "<td>"+equipamento["Tag"]+"</td>";
				    	colunas += "<td>"+equipamento["Equipamento"]+"</td>";
				    	colunas += "<td>"+equipamento["TipoEquipamento"]+"</td>";				    	
				    	colunas += "<td><div class='btn-group btn-group-lg'>";
				    	<?php if(Usuario::isGrant(array('edit_equipamentos'))) { ?>			
				    		colunas += "<a href='<?php echo Site::baseUrl() ?>empresas/edit_equipamentos/"+equipamento["CodEquipamento"]+"/"+equipamento["codSetor"]+"/"+area+"' class='btn btn-info'>EDITAR</a>";
				    	<?php } ?>
				    	<?php if(Usuario::isGrant(array('remove_equipamentos'))) { ?>	
							colunas += "<button type='button' class='btn btn-danger' id='ask_"+equipamento["CodEquipamento"]+"' onclick='askDelete(\""+cod+"\")'>REMOVER</button>";
							colunas += "<button type='button' class='btn btn-success confirm_hidden' id='confirm_"+equipamento['CodEquipamento']+"' onclick='deleteRow(\""+cod+"\")'>S</button>";						
							colunas += "<button type='button' class='btn btn-danger confirm_hidden' id='cancel_"+equipamento['CodEquipamento']+"' onclick='askDelete(\""+cod+"\")'>N</button>";						
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


<?php if(Usuario::isGrant(array('remove_empresas'))) echo Site::generateDelete('Equipamento'); ?>