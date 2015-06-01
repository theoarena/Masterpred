<?php 
		
		if(count($objs) > 0) { 
	
?>

<div class="alert alert-warning"><h4>Os usuários abaixo estão aguardando a ativação de seus perfis.</h4></div>

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
	 } 	else echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'nenhum_item')."</div>"; 	
?>

<script type="text/javascript">
	$(function () {
	    $('.footable').footable();
	});	

</script>


<?php echo site::generateDelete('User'); ?>