<div id='Final'>

	<p id='tit_acoes'>Ações executadas para correção da falha</p>
	<p><?php echo $resultado->Obs; ?></p>
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
				<td class="col_data"><?php echo site::datahora_BR($resultado->DataPlanejamento); ?></td>
				<td class="col_resp"><?php echo $resultado->RespPlanejamento; ?></td>
			</tr>
			<tr>
				<td><p>Corretiva</p></td>
				<td class="col_data"><?php echo site::datahora_BR($resultado->DataCorretiva); ?></td>
				<td class="col_resp"><?php echo $resultado->RespCorretiva; ?></td>
			</tr>
			<tr>
				<td><p>Finalização</p></td>
				<td class="col_data"><?php echo site::datahora_BR($resultado->DataFinalizacao); ?></td>
				<td class="col_resp"><?php echo $resultado->RespFinalizacao; ?></td>
			</tr>
		</tbody>
	</table>
</div>
