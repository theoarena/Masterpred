<h1 id="btn_adicionar" class="inline">		
			<?php 
				if(Usuario::selected_empresaatual())
				{
					echo HTML::anchor(Site::segment(1)."/edit_".Site::segment("empresas")."_novo"," +", array("class" => "label-success btn" ));
					
					echo "<a href='javascript:void(0)' class='btn label-primary' id='btn_transferir' onclick='confirmar()'>Transferir</a>";
					echo "<a href='javascript:void(0)' class='btn label-danger' id='btn_nao' onclick='confirmar()'>Cancelar</a>";
					echo "<a href='javascript:void(0)' class='btn label-primary' id='btn_sim' onclick='transferir()'>Confirmar</a>";
					echo "<a href='javascript:void(0)' class='btn label-warning' id='btn_limpar' onclick='confirmar_limpar()'>Apagar todos</a>";
					echo "<a href='javascript:void(0)' class='btn label-danger' id='btn_nao_limpar' onclick='confirmar_limpar()'>Cancelar</a>";
					echo "<a href='javascript:void(0)' class='btn label-primary' id='btn_sim_limpar' onclick='limpar()'>Confirmar</a>";
					
				}
			?>
		</h1>
		
	<?php

		echo "<div id='select_data'>";
			echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Tecnologia</span>". 
				Form::select('tecnologia',$tecnologias, Arr::get($_GET, 'tec', 'padrao') , array('class' => 'form-control'));
			echo "</div>";							
			echo "<div class='input-group input-group-lg div_filtrar'><h1 id='btn_filtrar'>". HTML::anchor('#','Filtrar', array('class' => 'btn btn-primary' )) ."</h1></div>";	
		echo '</div>';	

	?>
		
	<div class="alert alert-danger alert-dismissable naotemrisco">	 	
		Não é possível analisar este item, <strong>ele não está definido como risco.</strong>  
	</div>
	<div class="alert alert-danger alert-dismissable naoprossegue">	 	
		Você não definiu o grau de risco de alguns itens. <strong>Por favor, defina-os.</strong>  
	</div>

<?php 

	if(!Usuario::selected_empresaatual())		
		echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'ative_empresa')."</div>"; 	
	else
	{ //se há rotas cadastradas nessa empresa
		echo '<table class="footable table" data-page-navigation=".pagination" data-filter=#campobusca>';
			echo '<thead>';
				echo '<tr>';
					echo "<th id='col_id' data-type='numeric' data-sort-initial='true'><h3>".Site::getTituloCampos('codigo')."</h3></th>";
					echo "<th><h3>".Site::getTituloCampos('area')."</h3></th>";
					echo "<th><h3>".Site::getTituloCampos('setor')."</h3></th>";
					echo "<th><h3>".Site::getTituloCampos('tag')."</h3></th>";
					echo "<th><h3>".Site::getTituloCampos('equipamento')."</h3></th>";
					echo "<th><h3>".Site::getTituloCampos('tipo_equipamento')."</h3></th>";
					echo "<th><h3>".Site::getTituloCampos('data')."</h3></th>";
					echo "<th  id='col_id' data-sort-ignore='true'><h3>".Site::getTituloCampos('condicao')."</h3></th>";
					echo "<th data-sort-ignore='true' id='col_actions'><h3>".Site::getTituloCampos("acoes")."</h3></th>";
				echo "</tr>";
			echo "</thead>";

			echo "<tbody>";
			
			foreach ($objs as $o)
			{	
				//echo "rota: ".$areas->CodRota." - equipamento: ".$equipamento->CodEquipamento." - equipinsp: ".$o->CodEquipamentoInspAnalise."<br>";
				$equip = $o->equipamento;
				$condicoes = $o->tecnologia->condicoes->find_all()->as_array("CodCondicao","Condicao"); //condicoes da tecnlogia deste equipamento
				
				$condicoes[0] = "";
				
				//$grHabilitada = (Site::inspecaoGraudeRisco($o->Condicao,$condicoes))?(""):("hide");

				echo "<tr class='item_insp' id='inspecao_".$o->CodEquipamentoInspAnalise."'>";
					echo "<td>".$o->CodEquipamentoInspAnalise."</td>";
					echo "<td>".$equip->setor->area->Area."</td>";					
					echo "<td>".$equip->setor->Setor."</td>";
					echo "<td>".$equip->Tag."</td>";
					echo "<td>".$equip->Equipamento."</td>";
					echo "<td>".$equip->tipoequipamento->TipoEquipamento."</td>";
					echo "<td>".Site::datahora_BR($o->Data)."</td>";
					echo "<td>";										
						echo "<div class='input-group input-group-lg drop_condicao'>". Form::select('Condicao'.$o->CodEquipamentoInspAnalise,$condicoes,($o->Condicao)?($o->Condicao):(0), array('class'=> 'form-control select_condicao', 'onchange' => "mudacondicao('".$o->CodEquipamentoInspAnalise."')" )) ."</div>"; 
					echo "</td>";
					echo "<td><div class='btn-group btn-group-lg'>";
						echo Form::hidden("inspecao_".$o->CodEquipamentoInspAnalise,$condicoes[ ($o->Condicao!=null)?($o->Condicao):0 ]);
						echo '<div id="first_edit_row">';
							echo "<button type='button' id='analise_".$o->CodEquipamentoInspAnalise."' class='btn btn-info btn_plusa' onclick=\"linkinspecao('".$o->CodEquipamentoInspAnalise."')\" >+A</button>";								
							echo "<button type='button' id='duplicar_".$o->CodEquipamentoInspAnalise."' class='btn btn-primary btn_plusl' onclick=\"duplicarinspecao('".$o->CodEquipamentoInspAnalise."')\" >+L</button>";								
						echo '</div>';
						echo "<button type='button' class='btn btn-danger btn_removeanalise' id='ask_".$o->CodEquipamentoInspAnalise."' onclick='askDelete(\"$o->CodEquipamentoInspAnalise\")'>REMOVER</button>";								
						echo "<button type='button' class='btn btn-success confirm_hidden' id='confirm_".$o->CodEquipamentoInspAnalise."' onclick='deleteRow(\"$o->CodEquipamentoInspAnalise\")'>S</button>";														
						echo "<button type='button' class='btn btn-danger confirm_hidden' id='cancel_".$o->CodEquipamentoInspAnalise."' onclick='askDelete(\"$o->CodEquipamentoInspAnalise\")'>N</button>";						
					echo "</div></td>";
				echo "</tr>";	
			}
				
			echo "</tbody>";

		?>
			<tfoot class="hide-if-no-paging">
				<tr>
					<td colspan="100">
						<ul class="pagination pagination-centered"></ul>
					</td>
				</tr>
			</tfoot>
		<?php
		
		echo '</table>';
	} 	
		
?>

<script type="text/javascript">

	var condicoes =	"<?php echo Site::inspecaoGraudeRisco(null,null,true);?>";
			condicoes = condicoes.split(",");

	$(function () {
	    $('.footable').footable();	   

	    var qtd = $('.item_insp').length;
	    if(qtd == 0)	
	    {
	    	$('#btn_transferir').hide();
	    	$('#btn_limpar').hide();
	    	$('.footable ').remove();
	    	$('section#list').append("<div class='alert alert-warning tabela_vazia'><?php echo Kohana::message('admin', 'nenhum_equipinsp'); ?></div>");
	    }
	});

	function mudacondicao(id)
	{
		$("*").css("cursor", "progress");
		var c = $("#inspecao_"+id+" select").val();
		var txt = $("#inspecao_"+id+" select option:selected").text();		
		$.ajax({
			url : "<?php echo Site::baseUrl() ?>empresas/mudacondicao",
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
		 $('#btn_sim').toggleClass('confirm_margin');
		 $('#btn_nao').toggleClass('confirm_margin');
	}

	function confirmar_limpar()
	{
		 $('#btn_limpar').toggle();
		 $('#btn_sim_limpar').toggle();
		 $('#btn_nao_limpar').toggle();
		 $('#btn_sim_limpar').toggleClass('confirm_margin');
		 $('#btn_nao_limpar').toggleClass('confirm_margin');
	}

	function limpar()
	{
		$(".footable tbody").html("<tr><td colspan='9'><span id='loading'><img src='<?php echo Site::mediaUrl() ?>images/loading.gif'></span></td></tr>");
		$.ajax({
			url : "<?php echo Site::baseUrl() ?>empresas/delete_analiseinspecao?todos=1",			
			success : function(data) {
				if(data == 1)	
				{			
					hidebtn();

					$(".footable thead").hide();
					$(".footable tbody").html("<tr><td colspan='9'><div class='alert alert-sucess tabela_vazia'><?php echo Kohana::message('admin', 'analises_removidas'); ?></div></td></tr>");
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
		var tec = $( "select[name='tecnologia'] option:selected" ).val(); //pega a tec seleciona
		if(jQuery.inArray(value,condicoes) >= 0)
			window.location.href = '<?php echo Site::baseUrl() ?>empresas/edit_analiseinspecao/'+id+'?tec='+tec;
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
			$(".footable tbody").html("<tr><td colspan='9'><span id='loading'><img src='<?php echo Site::mediaUrl() ?>images/loading.gif'></span></td></tr>");
			$.ajax({
				url : "<?php echo Site::baseUrl() ?>empresas/transferir_analiseinspecao",
				type: "POST",  
  				data: { tec: <?php echo ( isset($_GET['tec']) )?( $_GET['tec'] ):(1) ?>},			
				success : function(data) {
					if(data == 1)	
					{			
						hidebtn();

						$(".footable thead").hide();
						$(".footable tbody").html("<tr><td colspan='9'><div class='alert alert-sucess tabela_vazia'><?php echo Kohana::message('admin', 'analises_removidas_sucesso'); ?></div></td></tr>");
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
			url : "<?php echo Site::baseUrl() ?>empresas/duplicate_analiseinspecao",
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

	$( "#btn_filtrar" ).click(function () {		

		var tec = $( "select[name='tecnologia'] option:selected" ).val(); //pega a tec seleciona
		var link = "<?php echo Site::baseUrl() ?>empresas/analiseinspecao/?tec="+tec;
        window.open(link,"_self");    

	});

	function deleteRow(id)
	{
		$("*").css("cursor", "progress");
		$.ajax({
			url : "<?php echo Site::baseUrl() ?>empresas/delete_analiseinspecao",
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

<?php echo Site::generateDelete('AnaliseEquipamentoInspecionado'); ?>
