<table class='table_fancybox'>
<tr class='trhead'> 
	<td class='tdsm'>Sequencial</td> 
	<td class='tdmd'>Data</td> 
	<td class='tdmd'>Tecnologia	</td> 
	<td class='tdmd'>Rota</td>
	<td class='tdmd'>Analista</td> 
</tr>


<?php
	if(count($objs)> 0)
		foreach ($objs as $obj) {
			echo "<tr> <td>".$obj->CodRelatorio."</td>";
			echo "<td>".Site::data_BR($obj->Data)."</td>";
			echo "<td>".$obj->tecnologia->Tecnologia."</td>";
			echo "<td>".$obj->rota->Rota."</td>";
			echo "<td>".$obj->analista->Analista."</td>";
			
			echo "<td><button class='btn_selecionar' value='".$obj->CodRelatorio."'>selecionar</button></td></tr>";
		}
	else
		echo "<tr><td colspan='5'>Nenhum relatório anterior foi encontrado.</td></tr>";
?>

</table>

<script type="text/javascript">
	$(document).ready(function(){
		$(".btn_selecionar").click(function(){
			$("input[name='codigo_relatorio']").val($(this).attr('value'));
			$.fancybox.close();
		});
	});
</script>