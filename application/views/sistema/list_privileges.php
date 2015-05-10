<?php if( count($obj) > 0) { ?>
<div class="alert alert-danger"><p>Os itens abaixo dizem respeito ao funcionamento interno do sistema e não devem ser modificados a menos que você saiba o que está fazendo</p></div>
<table class="footable table" data-page-navigation=".pagination">
	<thead>
		<tr>
			<th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo site::getTituloCampos("id"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("codigo"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("desc"); ?></h3></th>		
			<th data-sort-ignore="true" id='col_actions'><h3><?php echo site::getTituloCampos("acoes"); ?></h3></th>		
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($obj as $o) {				
				echo "<tr>";
					echo "<td>".$o->id."</td>";
					echo "<td>".$o->name."</td>";					
					echo "<td>".$o->description."</td>";
					echo "<td><div class='btn-group btn-group-lg'>";
						echo html::anchor("sistema/edit_privileges/".$o->id,"EDITAR", array("class"=>"btn btn-info"));						
						echo "<button type='button' class='btn btn-danger' id='ask_".$o->id."' onclick='askDelete(\"$o->id\")'>REMOVER</button>";

						echo "<button type='button' class='btn btn-success confirm_hidden' id='confirm_".$o->id."' onclick='deleteRow(\"$o->id\")'>S</button>";						
						echo "<button type='button' class='btn btn-danger confirm_hidden' id='cancel_".$o->id."' onclick='askDelete(\"$o->id\")'>N</button>";						
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

<?php } else echo "<div class='alert alert-warning tabela_vazia'>Nenhum privilégio encontrado.</div>"; ?>

<script type="text/javascript">
	$(function () {
	    $('.footable').footable();
	});

	
	function deleteRow(id)
	{
		$.ajax({
			url : "<?php echo site::baseUrl() ?>sistema/delete_privileges",
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