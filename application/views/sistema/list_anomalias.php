<?php if(count($objs) > 0) { 

	echo "<div id='search_empresas' class='inline'>";
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Busca:</span>". form::input('nome', null , array('class' => 'form-control', 'maxlength' => '30', 'id' => 'campobusca')) ."</div>";		
	echo '</div>';

?>

<table class="footable table" data-page-navigation=".pagination" data-filter=#campobusca>
	<thead>
		<tr>
			<th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo site::getTituloCampos("codigo"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("nome"); ?></h3></th>
			<th><h3><?php echo site::getTituloCampos("tecnologia"); ?></h3></th>		
			<th data-sort-ignore="true" id='col_actions'><h3><?php echo site::getTituloCampos("acoes"); ?></h3></th>		
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
						if(site::isGrant(array('edit_anomalias')))
							echo html::anchor("sistema/edit_anomalias/".$o->CodAnomalia,"EDITAR", array("class"=>"btn btn-info"));						

						if(site::isGrant(array('remove_anomalias')))
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

	     $('#campobusca').change(function(){
	    		var footableFilter = $('.footable').data('footable-filter');			  
			    footableFilter.filter($(this).val());
	    });   	           
	});

</script>


<?php if(site::isGrant(array('remove_anomalias'))) echo site::generateDelete('Anomalia'); ?>