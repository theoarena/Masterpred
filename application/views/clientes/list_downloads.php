<?php 
$encrypt = Encrypt::instance('relatorios');
	
if(count($objs) > 0) { ?>

<table class="footable table" data-page-navigation=".pagination">
	<thead>
		<tr>
			<th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo Site::getTituloCampos("sequencial"); ?></h3></th>			
			<th><h3><?php echo Site::getTituloCampos("tecnologia"); ?></h3></th>
			<th><h3><?php echo Site::getTituloCampos("data"); ?></h3></th>		
			<th><h3><?php echo Site::getTituloCampos("obs"); ?></h3></th>		
			<th data-sort-ignore="true" id='col_actions'><h3><?php echo Site::getTituloCampos("acoes"); ?></h3></th>		
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($objs as $o) {				
				echo "<tr>";					
					echo "<td>".$o->Sequencial."</td>";
					echo "<td>".$o->tecnologia->Tecnologia."</td>";
					echo "<td>".Site::data_BR($o->Data)."</td>";
					echo "<td>".$o->Obs."</td>";
					echo "<td><div class='btn-group btn-group-lg'>";						
						echo HTML::anchor("clientes/downloads/?id=".( $encrypt->encode($o->CodArquivoRelatorio) ),"Download", array("class"=>"btn btn-info","target"=>"parent"));												
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