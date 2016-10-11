<?php
	$resultado = $gr->resultado;
	$equipamentoinspecionado = $gr->equipamentoinspecionado;
	$equipamento = $equipamentoinspecionado->equipamento;
	$empresa = $equipamento->setor->area->empresa;
	$cor = $equipamentoinspecionado->condicao->Cor;
	$cor = ($cor!=null)?("class='".$cor."'"):("");
	$base = Kohana::$config->load('config')->get('endereco_sistema').'/'.Kohana::$config->load('config')->get('upload_directory_gr');

?>

<div id='Info'>

	<div id='dados_osp'>	
		<p><strong>Empresa:</strong> <?php echo $empresa->Empresa; ?> </p>
		<p><strong>Área:</strong> <?php echo $equipamento->setor->Setor; ?> </p>
		<p><strong>Setor:</strong> <?php echo $equipamento->setor->area->Area; ?> </p>
		<p><strong>Data:</strong> <?php echo site::datahora_BR($equipamentoinspecionado->Data); ?> </p>
		<p><strong>Tag:</strong> <?php echo $equipamentoinspecionado->equipamento->Tag ;?></p>
		<p><strong>Analista:</strong> <?php echo $equipamentoinspecionado->analista->Analista; ?> </p>
		<p><strong>Equipamento:</strong> <?php echo $equipamentoinspecionado->equipamento->Equipamento; ?> </p>
		<p><strong>Componente:</strong> <?php echo $gr->componente->Componente." ".$gr->Componente; ?> </p>
		<p><strong>Detalhe:</strong> <?php echo $gr->Detalhe; ?> </p>
		<p><strong>Anomalia:</strong> <?php echo $gr->anomalia->Anomalia." ".$gr->Anomalia; ?> </p>
	</div>
	<div id='tipo_gr'>
		<p id='numero_gr'>O.S.P nº: <?php echo $gr->NumeroGR ?> / <?php echo $gr->CodGR ?> </p>
		<p>Grau de risco</p>		
		<h1 <?php echo $cor ?>><?php echo $equipamentoinspecionado->condicao->Condicao; ?></h1>
		<p><?php echo $equipamentoinspecionado->condicao->Descricao ?></p>
	</div>

</div>

<div id='Fotos'>
	
	<table>
		<tr>
			<td>
				 <?php
				 	if($gr->ImagemTermica != null)
				 		echo "<img src='".$base.$gr->ImagemTermica."' width='320px' height='240px' />"	 ?>
			</td>
			<td> <?php
				 	if($gr->ImagemReal != null)
				 		echo "<img src='".$base.$gr->ImagemReal."'  width='320px' height='240px'/>"	 ?>
			</td>
		</tr>
	</table>

</div>

<div id='Resultados'>
	<p id='recomendacoes'><strong>Recomendação:</strong> <?php echo $gr->Recomendacao; ?> </p>
	<p id='recomendacoes'><strong>Observação:</strong> <?php echo $gr->Obs; ?> </p>

	<table id="tabela_resultados">
		<tr>
			<td class="coluna_esquerda"><p><strong>Temp. Medida:</strong> <?php echo  Site::formata_numerodecimal($gr->TemperaturaMed); ?> </p></td>
			<td class="coluna_centro"><p><strong>I(R):</strong> <?php echo  Site::formata_numerodecimal($gr->Ir); ?> </p></td>
			<td class="coluna_direita"><p><strong>% Carga:</strong> <?php echo Site::formata_numerodecimal($carga); ?> </p></td>
		</tr>

		<tr>
			<td class="coluna_esquerda"><p><strong>Temp. Referência:</strong> <?php echo  Site::formata_numerodecimal($gr->TemperaturaRef); ?> </p></td>
			<td class="coluna_centro"><p><strong>I(S):</strong> <?php echo  Site::formata_numerodecimal($gr->Is); ?> </p></td>
			<td class="coluna_direita" class="coluna_direita"><p><strong>T. Medida Corrigida:</strong> <?php echo  Site::formata_numerodecimal($medcor); ?> </p></td>
		</tr>

		<tr>
			<td class="coluna_esquerda"><p><strong>Temp. Delta:</strong> <?php echo  Site::formata_numerodecimal( ($gr->TemperaturaMed - $gr->TemperaturaRef) ); ?> </p></td>
			<td class="coluna_centro"><p><strong>I(T):</strong> <?php echo  Site::formata_numerodecimal($gr->It); ?> </p></td>
			<td class="coluna_direita"><p><strong>T. Delta Corrigida:</strong> <?php echo  Site::formata_numerodecimal($deltacor); ?> </p></td>
		</tr>

		<tr>
			<td class="coluna_esquerda"></td>
			<td class="coluna_centro"><p><strong>I(N):</strong> <?php echo  Site::formata_numerodecimal($gr->In); ?> </p></td>
			<td class="coluna_direita"></td>
		</tr>

	</table>

</div>
