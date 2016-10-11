<?php if(count($objs) > 0) {?>

<table class="footable table" data-page-navigation=".pagination" data-filter=#campobusca>
	<thead>
		<tr>
			<th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo Site::getTituloCampos("codigo"); ?></h3></th>
			<th><h3><?php echo Site::getTituloCampos("nome"); ?></h3></th>
			<th><h3><?php echo Site::getTituloCampos("tecnologia"); ?></h3></th>		
			<th data-sort-ignore="true" id='col_actions'><h3><?php echo Site::getTituloCampos("acoes"); ?></h3></th>		
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($objs as $o) {				
				echo "<tr>";
					echo "<td>".$o->CodAnomalia."</td>";
					echo "<td>".$o->Anomalia."</td>";					
					echo "<td>".$o->tecnologia->Tecnologia."</td>";
					echo "<td><div class='btn-group btn-group-lg'>";
						if(Usuario::isGrant(array('edit_anomalias')))
							echo HTML::anchor("sistema/edit_anomalias/".$o->CodAnomalia,"EDITAR", array("class"=>"btn btn-info"));						

						if(Usuario::isGrant(array('remove_anomalias')))
						{
							echo "<button type='button' class='btn btn-danger' id='ask_".$o->CodAnomalia."' onclick='askDelete(\"$o->CodAnomalia\")'>REMOVER</button>";
							echo "<button type='button' class='btn btn-success confirm_hidden' id='confirm_".$o->CodAnomalia."' onclick='deleteRow(\"$o->CodAnomalia\")'>S</button>";						
							echo "<button type='button' class='btn btn-danger confirm_hidden' id='cancel_".$o->CodAnomalia."' onclick='askDelete(\"$o->CodAnomalia\")'>N</button>";						
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

<?php } else echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'nenhum_item')."</div>"; ?>

<script type="text/javascript">
	$(document).ready(function () {
	    $('.footable').footable();		            
	});

</script>


<?php if(Usuario::isGrant(array('remove_anomalias'))) echo Site::generateDelete('Anomalia'); ?>