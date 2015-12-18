<?php 

	if(Site::selected_empresaatual()) {
	
		if(count($objs) > 0) { 
	
?>

<table class="footable table" data-page-navigation=".pagination">
	<thead>
		<tr>
			<th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo Site::getTituloCampos("codigo"); ?></h3></th>
			<th><h3><?php echo Site::getTituloCampos("nome"); ?></h3></th>
			
			<th data-sort-ignore="true" id='col_actions'><h3><?php echo Site::getTituloCampos("acoes"); ?></h3></th>		
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($objs as $o) {				
				echo "<tr>";
					echo "<td>".$o->CodRota."</td>";
					echo "<td>".$o->Rota."</td>";				
					echo "<td><div class='btn-group btn-group-lg'>";
						if(Site::isGrant(array('edit_rotas')))
							echo HTML::anchor("empresas/edit_rotas/".$o->CodRota,"EDITAR", array("class"=>"btn btn-info"));						

						if(Site::isGrant(array('remove_rotas')))
						{
							echo "<button type='button' class='btn btn-danger' id='ask_".$o->CodRota."' onclick='askDelete(\"$o->CodRota\")'>REMOVER</button>";
							echo "<button type='button' class='btn btn-success confirm_hidden' id='confirm_".$o->CodRota."' onclick='deleteRow(\"$o->CodRota\")'>S</button>";						
							echo "<button type='button' class='btn btn-danger confirm_hidden' id='cancel_".$o->CodRota."' onclick='askDelete(\"$o->CodRota\")'>N</button>";						
						}
					echo "</div></td>";
				echo "</tr>";
			}	
		?>	
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
	 } 	else echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'nenhum_item')."</div>"; 
	} else echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'ative_empresa')."</div>"; 
?>

<script type="text/javascript">
	$(function () {
	    $('.footable').footable();
	});

	

</script>

<?php if(Site::isGrant(array('remove_rotas'))) echo Site::generateDelete('Rota'); ?>