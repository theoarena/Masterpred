<h1 id="btn_adicionar">		
			<?php 
				if(site::selected_empresaatual())
				{
					echo html::anchor(site::segment(1)."/edit_".site::segment("empresas")."_novo","Adicionar +", array("class" => "label label-success" ));
					
					echo "<a href='javascript:void(0)' class='label label-primary' id='btn_transferir' onclick='confirmar()'>Transferir</a>";
					echo "<a href='javascript:void(0)' class='label label-danger' id='btn_nao' onclick='confirmar()'>Cancelar</a>";
					echo "<a href='javascript:void(0)' class='label label-primary' id='btn_sim' onclick='transferir()'>Confirmar</a>";
					echo "<a href='javascript:void(0)' class='label label-warning' id='btn_limpar' onclick='confirmar_limpar()'>Apagar todos</a>";
					echo "<a href='javascript:void(0)' class='label label-danger' id='btn_nao_limpar' onclick='confirmar_limpar()'>Cancelar</a>";
					echo "<a href='javascript:void(0)' class='label label-primary' id='btn_sim_limpar' onclick='limpar()'>Confirmar</a>";
				
				}
			?>
		</h1>
		
	<div class="alert alert-danger alert-dismissable naotemrisco">	 	
		Não é possível analisar este item, <strong>ele não está definido como risco.</strong>  
	</div>
	<div class="alert alert-danger alert-dismissable naoprossegue">	 	
		Você não definiu o grau de risco de alguns itens. <strong>Por favor, defina-os.</strong>  
	</div>

<?php 

	if(count($objs) > 0) 
	{ //se há rotas cadastradas nessa empresa
		echo '<table class="footable table" data-page-navigation=".pagination">';
			echo '<thead>';
				echo '<tr>';
					echo "<th id='col_id' data-type='numeric' data-sort-initial='true'><h3>".site::getTituloCampos('codigo')."</h3></th>";
					echo "<th><h3>".site::getTituloCampos('area')."</h3></th>";
					echo "<th><h3>".site::getTituloCampos('setor')."</h3></th>";
					echo "<th><h3>".site::getTituloCampos('tag')."</h3></th>";
					echo "<th><h3>".site::getTituloCampos('equipamento')."</h3></th>";
					echo "<th><h3>".site::getTituloCampos('tipo_equipamento')."</h3></th>";
					echo "<th><h3>".site::getTituloCampos('data')."</h3></th>";
					echo "<th  id='col_id' data-sort-ignore='true'><h3>".site::getTituloCampos('condicao')."</h3></th>";
					echo "<th data-sort-ignore='true' id='col_actions'><h3>".site::getTituloCampos("acoes")."</h3></th>";
				echo "</tr>";
			echo "</thead>";

			echo "<tbody>";
			foreach ($objs as $rotas) //para cada rota
			{
				foreach ($rotas->equipamentos->find_all() as $equipamento) //para cada equipamento
				{
					foreach ($equipamento->analiseequipamentoinspecionados->find_all() as $o)
					{	

						$condicoes = $o->tecnologia->condicoes->find_all()->as_array("CodCondicao","Condicao"); //condicoes da tecnlogia deste equipamento
						
						$condicoes[0] = "";
						
						//$grHabilitada = (site::inspecaoGraudeRisco($o->Condicao,$condicoes))?(""):("hide");

						echo "<tr class='item_insp' id='inspecao_".$o->CodEquipamentoInspAnalise."'>";
							echo "<td>".$o->CodEquipamentoInspAnalise."</td>";
							echo "<td>".$equipamento->setor->area->Area."</td>";					
							echo "<td>".$equipamento->setor->Setor."</td>";
							echo "<td>".$equipamento->Tag."</td>";
							echo "<td>".$equipamento->Equipamento."</td>";
							echo "<td>".$equipamento->tipoequipamento->TipoEquipamento."</td>";
							echo "<td>".site::datahora_BR($o->Data)."</td>";
							echo "<td>";										
								echo "<div class='input-group input-group-lg drop_condicao'>". form::select('Condicao'.$o->CodEquipamentoInspAnalise,$condicoes,($o->Condicao)?($o->Condicao):(0), array('class'=> 'form-control select_condicao', 'onchange' => "mudacondicao('".$o->CodEquipamentoInspAnalise."')" )) ."</div>"; 
							echo "</td>";
							echo "<td><div class='btn-group btn-group-lg'>";
								echo form::hidden("inspecao_".$o->CodEquipamentoInspAnalise,$condicoes[ ($o->Condicao!=null)?($o->Condicao):0 ]);
								echo "<button type='button' id='analise_".$o->CodEquipamentoInspAnalise."' class='btn btn-info' onclick=\"linkinspecao('".$o->CodEquipamentoInspAnalise."')\" >ANÁLISE</button>";								
								echo "<button type='button' id='duplicar_".$o->CodEquipamentoInspAnalise."' class='btn btn-primary' onclick=\"duplicarinspecao('".$o->CodEquipamentoInspAnalise."')\" >+</button>";								
								echo "<button type='button' class='btn btn-danger' id='ask_".$o->CodEquipamentoInspAnalise."' onclick='askDelete(\"$o->CodEquipamentoInspAnalise\")'>REMOVER</button>";

								echo "<button type='button' class='btn btn-success confirm_hidden' id='confirm_".$o->CodEquipamentoInspAnalise."' onclick='deleteRow(\"$o->CodEquipamentoInspAnalise\")'>S</button>";														
								echo "<button type='button' class='btn btn-danger confirm_hidden' id='cancel_".$o->CodEquipamentoInspAnalise."' onclick='askDelete(\"$o->CodEquipamentoInspAnalise\")'>N</button>";						
							echo "</div></td>";
						echo "</tr>";								
					}
				}
			}			
			echo "</tbody>";

		?>
			<tfoot class="hide-if-no-paging">
				<tr>
					<td colspan="5">
						<ul class="pagination pagination-centered"></ul>
					</td>
				</tr>
			</tfoot>
		<?php
		
		echo '</table>';
	} 
	elseif(!site::selected_empresaatual())		
		echo "<div class='alert alert-warning tabela_vazia'>Nenhuma empresa selecionada.</div>"; 
	else
		echo "<div class='alert alert-warning tabela_vazia'>Nenhuma rota encontrada.</div>"; 
?>

<script type="text/javascript">

	var condicoes =	"<?php echo site::inspecaoGraudeRisco(null,null,true);?>";
			condicoes = condicoes.split(",");

	$(function () {
	    $('.footable').footable();

	    var qtd = $('.item_insp').length;
	    if(qtd == 0)	
	    {
	    	$('#btn_transferir').hide();
	    	$('#btn_limpar').hide();
	    	$('.footable ').remove();
	    	$('section#list').append("<div class='alert alert-warning tabela_vazia'>Nenhum equipamento em inspeção.</div>");
	    }
	});

	function mudacondicao(id)
	{
		$("*").css("cursor", "progress");
		var c = $("#inspecao_"+id+" select").val();
		var txt = $("#inspecao_"+id+" select option:selected").text();		
		$.ajax({
			url : "<?php echo site::baseUrl() ?>empresas/mudacondicao",
			type: "POST",  
  			data: { id: id, condicao: c},
			success : function(data) {
				if(data == 1)	
				{
					$("input:hidden[name='inspecao_"+id+"']").val(txt);					
					$("*").css("cursor", "default");				    				
				}
			}
		});
		
	}

	function confirmar()
	{
		 $('#btn_transferir').toggle();
		 $('#btn_sim').toggle();
		 $('#btn_nao').toggle();
	}

	function confirmar_limpar()
	{
		 $('#btn_limpar').toggle();
		 $('#btn_sim_limpar').toggle();
		 $('#btn_nao_limpar').toggle();
	}

	function limpar()
	{
		$(".footable tbody").html("<tr><td colspan='9'><span id='loading'><img src='<?php echo site::mediaUrl() ?>images/loading.gif'></span></td></tr>");
		$.ajax({
			url : "<?php echo site::baseUrl() ?>empresas/delete_analiseinspecao?todos=1",			
			success : function(data) {
				if(data == 1)	
				{			
					hidebtn();

					$(".footable thead").hide();
					$(".footable tbody").html("<tr><td colspan='9'><div class='alert alert-sucess tabela_vazia'>Todas as análises foram <strong>removidas.</strong></div></td></tr>");
					$(".footable tfoot").hide();	
				}
			}
		});
	}

	function hidebtn()
	{
		$('#btn_limpar').hide();
		$('#btn_sim_limpar').hide();
		$('#btn_nao_limpar').hide();

		$('#btn_transferir').hide();
		$('#btn_sim').hide();
		$('#btn_nao').hide();
	}

	function linkinspecao(id) //verifica se o item está marcado com condição de risco, se tiver manda pro link, se nao tiver, avisa
	{	
		
		var value = $("input:hidden[name='inspecao_"+id+"']").val(); //tipo da condicao
		if(jQuery.inArray(value,condicoes) >= 0)
			window.location.href = '<?php echo site::baseUrl() ?>empresas/edit_analiseinspecao/'+id;
		else
		{
			$('.naotemrisco').show().delay(4000).fadeOut('slow');  //tira quaisquer alertas depois de 4 segundos
		}


	}
	
	function transferir()
	{

		var entra = true;
		$(".select_condicao").each(function(index){
			if($(this).val() == 0)
				entra = false;
		});

		if(entra)
		{
			$(".footable tbody").html("<tr><td colspan='9'><span id='loading'><img src='<?php echo site::mediaUrl() ?>images/loading.gif'></span></td></tr>");
			$.ajax({
				url : "<?php echo site::baseUrl() ?>empresas/transferir_analiseinspecao",			
				success : function(data) {
					if(data == 1)	
					{			
						hidebtn();

						$(".footable thead").hide();
						$(".footable tbody").html("<tr><td colspan='9'><div class='alert alert-sucess tabela_vazia'>Todas as análises foram transferidas <strong>com sucesso!</strong></div></td></tr>");
						$(".footable tfoot").hide();	
					}
				}
			});
		}
		else
			$('.naoprossegue').show().delay(4000).fadeOut('slow');  //tira quaisquer alertas depois de 4 segundos}
	}

	function duplicarinspecao(id)
	{
		$("*").css("cursor", "progress");
		$.ajax({
			url : "<?php echo site::baseUrl() ?>empresas/duplicate_analiseinspecao",
			type: "POST",  
  			data: { id: id},
			success : function(data) {
				if(data == 1)	
				{	
					location.reload();	
					//$("*").css("cursor", "default");				    
				    // var footable = $('table').data('footable');			    
				    // var row = $("#confirm_"+id).parents('tr:first');
				    // footable.removeRow(row);
				}
			}
		});
	}

	function deleteRow(id)
	{
		$("*").css("cursor", "progress");
		$.ajax({
			url : "<?php echo site::baseUrl() ?>empresas/delete_analiseinspecao",
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

</script>