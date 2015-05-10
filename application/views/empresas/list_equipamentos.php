<?php 

	if(site::selected_empresaatual()) {
		
		if(count($objs) > 0) { 

		echo "<br/>";
		echo "<div id='select_areas'>";
		echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>Área</span>". form::select('area',$objs,$area,array("id"=>"area"))."</div>";
		echo "<div class='input-group input-group-lg second'> <span class='input-group-addon'>Setores</span>". form::select('setor',null,null,array("id"=>"setor"))."</div>";
		echo "</div>";
?>

<br/>
<table class="footable table" data-page-navigation=".pagination">
	<thead>
		<tr>
			<th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo site::getTituloCampos("codigo"); ?></h3></th>				
			<th data-sort-ignore="true"><h3><?php echo site::getTituloCampos("tag"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("equipamento"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("tipo_equipamento"); ?></h3></th>			
			<th data-sort-ignore="true" id='col_actions'><h3><?php echo site::getTituloCampos("acoes"); ?></h3></th>		
		</tr>
	</thead>
	<tbody>
		
	</tbody>
	<tfoot class="hide-if-no-paging">
		<tr>
			<td colspan="5">
				<ul class="pagination pagination-centered"></ul>
			</td>
		</tr>
	</tfoot>

</table>

<?php
	 } 	else echo "<div class='alert alert-warning tabela_vazia'>Nenhuma área disponível.</div>"; 
	} else echo "<div class='alert alert-warning tabela_vazia'>Ative uma empresa para visualizar seus dados.</div>"; 
?>

<script type="text/javascript">
	
	function deleteRow(id)
	{
		$("*").css("cursor", "progress");
		$.ajax({
			url : "<?php echo site::baseUrl() ?>empresas/delete_equipamentos",
			type: "POST",  
  			data: { id: id},
			success : function(data) {
				if(data == 1)	
				{				
					$("*").css("cursor", "default");		    
				    var footable = $('table').data('footable');			    
				    var row = $("#confirm_"+id).parents('tr:first');
				    footable.removeRow(row);
				}
			}
		});

	}


	$( "select#area" ).change(function () {
		$(".footable tbody").html("");
		$( "#btn_adicionar" ).addClass("disabled");
		var selected = $( "select#area option:selected" ).val(); //pega a area selecionada
		$('select#setor').empty();
		$.ajax({
			url : "<?php echo site::baseUrl() ?>empresas/carrega_setores/?a=1",
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
		$(".footable tbody").html("<span id='loading'><img src='<?php echo site::baseUrl() ?>images/loading.gif'></span>");

		var selected = $( "select#setor option:selected" ).val(); //pega o setor selecionado
		var area = $( "select#area option:selected" ).val(); //pega a area selecionado
		$( "#btn_adicionar" ).removeClass("disabled");
		$( "#btn_adicionar a" ).attr("href", "<?php echo site::baseUrl() ?>empresas/edit_equipamentos/0/"+selected+"/"+area );
		$.ajax({
			url : "<?php echo site::baseUrl() ?>empresas/carrega_equipamentos",
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
				    	colunas += "<a href='<?php echo site::baseUrl() ?>empresas/edit_equipamentos/"+equipamento["CodEquipamento"]+"/"+equipamento["codSetor"]+"/"+area+"' class='btn btn-info'>EDITAR</a>";
						colunas += "<button type='button' class='btn btn-danger' id='ask_"+equipamento["CodEquipamento"]+"' onclick='askDelete(\""+cod+"\")'>REMOVER</button>";
						colunas += "<button type='button' class='btn btn-success confirm_hidden' id='confirm_"+equipamento['CodEquipamento']+"' onclick='deleteRow(\""+cod+"\")'>S</button>";						
						colunas += "<button type='button' class='btn btn-danger confirm_hidden' id='cancel_"+equipamento['CodEquipamento']+"' onclick='askDelete(\""+cod+"\")'>N</button>";						
						colunas += "</div></td></tr>";
				   		$(".footable tbody").append(colunas);				    	
					}
					
					
				}
				else
				{					
					$(".footable tbody").append("<tr><td colspan='5'><div class='alert alert-warning tabela_vazia'>Nenhum item encontrado.</div></td></tr>");	
					$(".footable thead").hide();
				}

				$('.footable').footable();	
				
			    
			}
		});
		
	});

	

</script>