<?php if(count($objs) > 0) { 

echo "<div id='select_data' class='inline'>";
	echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>Busca:</span>". form::input('nome', null , array('class' => 'form-control', 'maxlength' => '30', 'id' => 'campobusca')) ."</div>";		
	echo '</div>';	
?>
<table class="footable table" data-page-navigation=".pagination" data-filter=#campobusca data-filter-minimum="1">
	<thead>
		<tr>
			<th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo site::getTituloCampos("codigo"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("nome"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("unidade"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("fabrica"); ?></h3></th>			
			<th data-sort-ignore="true" id='col_actions'><h3><?php echo site::getTituloCampos("acoes"); ?></h3></th>		
			<th data-sort-ignore="true" id='col_actions'><h3><?php echo site::getTituloCampos("ativada"); ?></h3></th>		
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($objs as $o) {	
				$ativada = (site::get_empresaatual() == $o->CodEmpresa)?("ativada"):("");
				echo "<tr>";
					echo "<td>".$o->CodEmpresa."</td>";
					echo "<td>".$o->Empresa."</td>";
					echo "<td>".$o->Unidade."</td>";
					echo "<td>".$o->Fabrica."</td>";
					echo "<td><div class='btn-group btn-group-lg'>";
						echo html::anchor("empresas/edit_empresas/".$o->CodEmpresa,"EDITAR", array("class"=>"btn btn-info"));						
						echo "<button type='button' class='btn btn-danger' id='ask_".$o->CodEmpresa."' onclick='askDelete(\"$o->CodEmpresa\")'>REMOVER</button>";

						echo "<button type='button' class='btn btn-success confirm_hidden' id='confirm_".$o->CodEmpresa."' onclick='deleteRow(\"$o->CodEmpresa\")'>S</button>";						
						echo "<button type='button' class='btn btn-danger confirm_hidden' id='cancel_".$o->CodEmpresa."' onclick='askDelete(\"$o->CodEmpresa\")'>N</button>";						
					echo "</div></td>";
					echo "<td> <button type='button' id='ativarempresa_".$o->CodEmpresa."' class='btn btn-danger btn_ativada ".$ativada."' onclick='toggle_empresas(\"$o->CodEmpresa\",\"$o->Empresa\")' /></button></td>";
				echo "</tr>";
			}	
		?>	
	</tbody>
	<tfoot class="hide-if-no-paging">
		<tr>
			<td colspan="5">
				<ul class="pagination pagination-centered"></ul>
			</td>
		</tr>
	</tfoot>

</table>

<?php } else echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'nenhum_item')."</div>"; ?>

<script type="text/javascript">
	$(function () {
	    $('.footable').footable();

	    $('#campobusca').change(function(){
	    		var footableFilter = $('.footable').data('footable-filter');			  
			    footableFilter.filter($(this).val());
	    });

	});

	function toggle_empresas(e,nome)
	{
		$(".btn_ativada").removeClass("ativada");
		//$("*").css("cursor", "progress");
		$.ajax({
			url : "<?php echo site::baseUrl() ?>empresas/toggle_empresas",
			type: "POST",  
  			data: { id: e,nome:nome},
			success : function(data) {				
				$("#ativarempresa_"+e).addClass("ativada");
				$(".hide_menu").removeClass("hide_menu");
				//$("*").css("cursor", "default");
			}
		});
	}

</script>


<?php echo site::generateDelete('Empresa'); ?>