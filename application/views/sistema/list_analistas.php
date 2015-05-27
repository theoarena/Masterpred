<?php if(count($objs) > 0) { ?>

<table class="footable table" data-page-navigation=".pagination">
	<thead>
		<tr>
			<th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo site::getTituloCampos("codigo"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("nome"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("funcao"); ?></h3></th>		
			<th data-sort-ignore="true" id='col_actions'><h3><?php echo site::getTituloCampos("acoes"); ?></h3></th>		
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($objs as $o) {				
				echo "<tr>";
					echo "<td>".$o->CodAnalista."</td>";
					echo "<td>".$o->Analista."</td>";					
					echo "<td>".$o->Funcao."</td>";
					echo "<td><div class='btn-group btn-group-lg'>";
						echo html::anchor("sistema/edit_analistas/".$o->CodAnalista,"EDITAR", array("class"=>"btn btn-info"));						
						echo "<button type='button' class='btn btn-danger' id='ask_".$o->CodAnalista."' onclick='askDelete(\"$o->CodAnalista\")'>REMOVER</button>";

						echo "<button type='button' class='btn btn-success confirm_hidden' id='confirm_".$o->CodAnalista."' onclick='deleteRow(\"$o->CodAnalista\")'>S</button>";						
						echo "<button type='button' class='btn btn-danger confirm_hidden' id='cancel_".$o->CodAnalista."' onclick='askDelete(\"$o->CodAnalista\")'>N</button>";						
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

<?php } else echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'nenhum_item')."</div>"; ?>

<script type="text/javascript">
	$(function () {
	    $('.footable').footable();
	});

</script>

<?php echo site::generateDelete('Analista'); ?>