<?php 
	
	if($tipo != 'empresa' || Usuario::selected_empresaatual()) {
	
		if(count($objs) > 0) { 
		
?>

<table class="footable table" data-page-navigation=".pagination">
	<thead>
		<tr>
			<th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo Site::getTituloCampos("codigo"); ?></h3></th>	
			<th><h3><?php echo Site::getTituloCampos("nome"); ?></h3></th>
			<th><h3><?php echo Site::getTituloCampos("tipo_usuario"); ?></h3></th>
			
			<th data-sort-ignore="true" id='col_actions'><h3><?php echo Site::getTituloCampos("acoes"); ?></h3></th>		
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($objs as $o) {		
				//mudar isso, talvez
				$roles = $o->roles->find_all()->as_array('id','nickname');				
				end($roles);         
				$key = key($roles);	

				echo "<tr>";
					echo "<td>".$o->id."</td>";					
					echo "<td>".$o->nome."</td>";				
					echo "<td>".@$roles[$key]."</td>";				
					
					echo "<td><div class='btn-group btn-group-lg'>";
						echo HTML::anchor($link_edit."/".$o->id,"EDITAR", array("class"=>"btn btn-info"));						
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
	} else echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'ative_empresa')."</div>"; 
?>

<script type="text/javascript">
	$(function () {
	    $('.footable').footable();
	});	

</script>

<?php echo Site::generateDelete('User'); ?>