<?php if(count($objs) > 0) { ?>

<table class="footable table" data-page-navigation=".pagination">
	<thead>
		<tr>
			<th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo site::getTituloCampos("codigo"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("nome"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("cor"); ?></h3></th>		
			<th><h3><?php echo site::getTituloCampos("tecnologia"); ?></h3></th>		
			<th data-sort-ignore="true" id='col_actions'><h3><?php echo site::getTituloCampos("acoes"); ?></h3></th>		
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($objs as $o) {				
				echo "<tr>";
					echo "<td>".$o->CodCondicao."</td>";
					echo "<td>".$o->Condicao."</td>";	

					$config = Kohana::$config->load('config')->get('cores_condicao');
					
					echo "<td>". $config[$o->Cor]."</td>";
					echo "<td>".$o->tecnologia->Tecnologia."</td>";
					echo "<td><div class='btn-group btn-group-lg'>";
						echo html::anchor("sistema/edit_condicoes/".$o->CodCondicao,"EDITAR", array("class"=>"btn btn-info"));						
						echo "<button type='button' class='btn btn-danger' id='ask_".$o->CodCondicao."' onclick='askDelete(\"$o->CodCondicao\")'>REMOVER</button>";

						echo "<button type='button' class='btn btn-success confirm_hidden' id='confirm_".$o->CodCondicao."' onclick='deleteRow(\"$o->CodCondicao\")'>S</button>";						
						echo "<button type='button' class='btn btn-danger confirm_hidden' id='cancel_".$o->CodCondicao."' onclick='askDelete(\"$o->CodCondicao\")'>N</button>";						
					echo "</div></td>";
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

<?php } else echo "<div class='alert alert-warning tabela_vazia'>Nenhuma condição encontrada.</div>"; ?>

<script type="text/javascript">
	$(function () {
	    $('.footable').footable();
	});

	
	function deleteRow(id)
	{
		$.ajax({
			url : "<?php echo site::baseUrl() ?>sistema/delete_condicoes",
			type: "POST",  
  			data: { id: id},
			success : function(data) {
				if(data == 1)	
				{						    
				    var footable = $('table').data('footable');			    
				    var row = $("#confirm_"+id).parents('tr:first');
				    footable.removeRow(row);
				}
			}
		});
	}

</script>