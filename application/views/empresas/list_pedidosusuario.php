<?php 
		
		if(count($objs) > 0) { 
	
?>

<h4>Abaixo estão os usuários que estão aguardando a ativação de seus perfis.</h4>

<table class="footable table" data-page-navigation=".pagination">
	<thead>
		<tr>
			<th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo site::getTituloCampos("codigo"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("nome"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("telefone"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("email"); ?></h3></th>			
			<th data-sort-ignore="true" id='col_actions'><h3><?php echo site::getTituloCampos("acoes"); ?></h3></th>		
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($objs as $o) {				
				echo "<tr>";
					echo "<td>".$o->id."</td>";
					echo "<td>".$o->nome."</td>";				
					echo "<td>".$o->telefone."</td>";				
					echo "<td>".$o->email."</td>";				
					echo "<td><div class='btn-group btn-group-lg'>";
						echo html::anchor("empresas/edit_pedidos_usuario/".$o->id,"EDITAR", array("class"=>"btn btn-info"));						
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

<?php
	 } 	else echo "<div class='alert alert-warning tabela_vazia'>Nenhum usuário encontrado.</div>"; 	
?>

<script type="text/javascript">
	$(function () {
	    $('.footable').footable();
	});

	function deleteRow(id)
	{
		$("*").css("cursor", "progress");
		$.ajax({
			url : "<?php echo site::baseUrl() ?>empresas/delete_pedidos_usuario",
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