<?php if(count($objs) > 0) { ?>

<table class="footable table" data-page-navigation=".pagination" data-filter=#campobusca>
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
					echo "<td>".$o->CodInstrumentacao."</td>";
					echo "<td>".$o->Nome."</td>";					
					echo "<td><div class='btn-group btn-group-lg'>";
						if(Usuario::isGrant(array('edit_instrumentacao')))
							echo HTML::anchor("sistema/edit_instrumentacao/".$o->CodInstrumentacao,"EDITAR", array("class"=>"btn btn-info"));						
						if(Usuario::isGrant(array('remove_instrumentacao')))
						{
							echo "<button type='button' class='btn btn-danger' id='ask_".$o->CodInstrumentacao."' onclick='askDelete(\"$o->CodInstrumentacao\")'>REMOVER</button>";
							echo "<button type='button' class='btn btn-success confirm_hidden' id='confirm_".$o->CodInstrumentacao."' onclick='deleteRow(\"$o->CodInstrumentacao\")'>S</button>";						
							echo "<button type='button' class='btn btn-danger confirm_hidden' id='cancel_".$o->CodInstrumentacao."' onclick='askDelete(\"$o->CodInstrumentacao\")'>N</button>";						
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
	$(function () {
	    $('.footable').footable();
	});	

</script>


<?php echo Site::generateDelete('Instrumentacao'); ?>