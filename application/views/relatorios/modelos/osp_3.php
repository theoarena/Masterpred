<div id='Final'>

	<?php
		if($resultado->Obs != "" and $resultado->Obs != NULL){
	?>
		<p id='tit_acoes'>Ações executadas para correção da falha</p>
		<p id="txt_obs"><?php echo $resultado->Obs; ?></p>
	<?php } ?>
	<table >
		<thead>
			<tr>
				<td id="col_final1"></td>
				<td id="col_data"><p>Data</p></td>
				<td id="col_resp"><p>Responsável</p></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><p>Planejamento</p></td>
				<td class="col_data"><?php echo Site::datahora_BR($resultado->DataPlanejamento); ?></td>
				<td class="col_resp"><?php echo $resultado->RespPlanejamento; ?></td>
			</tr>
			<tr>
				<td><p>Corretiva</p></td>
				<td class="col_data"><?php echo Site::datahora_BR($resultado->DataCorretiva); ?></td>
				<td class="col_resp"><?php echo $resultado->RespCorretiva; ?></td>
			</tr>
			<tr>
				<td><p>Finalização</p></td>
				<td class="col_data"><?php echo Site::datahora_BR($resultado->DataFinalizacao); ?></td>
				<td class="col_resp"><?php echo $resultado->RespFinalizacao; ?></td>
			</tr>
		</tbody>
	</table>

	<?php
		if($resultado->CodCliente != "" and $resultado->CodCliente != NULL){
	?>
		<div id="div_codcliente">
			<p>Ordem de serviço: <?php echo $resultado->CodCliente; ?></p>
		</div>
	<?php } ?>
</div>
