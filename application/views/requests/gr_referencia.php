<table class='table_fancybox'>
<tr class='trhead'> 
	<td class='tdsm'>Código</td> 
	<td class='tdmd'>Anomalia</td> 
	<td class='tdmd'>Tipo de Anomalia</td> 
	<td class='tdmd'>Data</td>
	<td class='tdmd'>Ações</td> 
</tr>


<?php
	if(count($objs)> 0)
		foreach ($objs as $obj) {
			echo "<tr> <td>".$obj->CodGR."</td>";
			echo "<td>".$obj->Anomalia."</td>";
			echo "<td>".$obj->anomalia->Anomalia."</td>";
			echo "<td>".site::data_BR($obj->equipamentoinspecionado->Data)."</td>";
			echo "<td><button class='btn_selecionar' value='".$obj->NumeroGR."/".$obj->CodGR."'>selecionar</button></td></tr>";
		}
	else
		echo "<tr><td colspan='5'>Nenhuma GR anterior foi encontrada.</td></tr>";
?>

</table>

<script type="text/javascript">
	$(document).ready(function(){
		$(".btn_selecionar").click(function(){
			$("input[name='GRReferencia']").val($(this).attr('value'));
			$.fancybox.close();
		});
	});
</script>