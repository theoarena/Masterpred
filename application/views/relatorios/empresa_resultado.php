<?php
	$gr = $resultado->gr;	
	$equipamentoinspecionado = $gr->equipamentoinspecionado;
	$equipamento = $equipamentoinspecionado->equipamento;
	$empresa = $equipamento->setor->area->empresa;
	$cor = $equipamentoinspecionado->condicao->Cor;
	$cor = ($cor!=null)?("class='".$cor."'"):("");
	$base = Kohana::$config->load('config')->get('upload_directory');
?>

<header>
	<img src="<?php echo site::mediaUrl(); ?>images/logo.jpg" id='logo'>
	<h3>Seção D - Ordem de Serviço</h3>
</header>

<section id='Info'>
	
	<p><strong>Empresa:</strong> <?php echo $empresa->Empresa; ?> </p>
	<p><strong>Área:</strong> <?php echo $equipamento->setor->Setor; ?> </p>
	<p><strong>Setor:</strong> <?php echo $equipamento->setor->area->Area; ?> </p>
	<p><strong>Data:</strong> <?php echo site::datahora_BR($equipamentoinspecionado->Data); ?> </p>
	<p><strong>Analista:</strong> <?php echo $equipamentoinspecionado->analista->Analista; ?> </p>
	<p><strong>Equipamento:</strong> <?php echo $equipamentoinspecionado->equipamento->Equipamento; ?> </p>
	<p><strong>Componente:</strong> <?php echo $gr->componente->Componente; ?> </p>
	<p><strong>Detalhe:</strong> <?php echo $gr->Detalhe; ?> </p>
	<p><strong>Anomalia:</strong> <?php echo $gr->anomalia->Anomalia; ?> </p>

	<div id='tipo_gr'>
		<p id='numero_gr'>O.S.P nº: <?php echo $gr->NumeroGR ?> / <?php echo $gr->CodGR ?> </p>
		<p>Grau de risco</p>		
		<h1 <?php echo $cor ?>><?php echo $equipamentoinspecionado->condicao->Condicao; ?></h1>
		<p><?php echo $equipamentoinspecionado->condicao->Descricao ?></p>
	</div>

</section>

<section id='Fotos'>
	
	<table>
		<tr>
			<td>
				 <?php
				 	if($gr->ImagemTermica != null)
				 		echo "<img src='".$base.$gr->ImagemTermica."'/>"	 ?>
			</td>
			<td> <?php
				 	if($gr->ImagemReal != null)
				 		echo "<img src='".$base.$gr->ImagemReal."'/>"	 ?>
			</td>
		</tr>
	</table>

</section>

<section id='Resultados'>
	<p><strong>Recomendação:</strong> <?php echo $gr->Recomendacao; ?> </p>

	<table id="tabela_resultados">
		<tr>
			<td class="coluna_esquerda"><p><strong>Temp. Medida:</strong> <?php echo $gr->TemperaturaMed; ?> </p></td>
			<td class="coluna_centro"><p><strong>I(R):</strong> <?php echo $gr->Ir; ?> </p></td>
			<td class="coluna_direita"><p><strong>% Carga:</strong> <?php echo ""; ?> </p></td>
		</tr>

		<tr>
			<td class="coluna_esquerda"><p><strong>Temp. Referência:</strong> <?php echo $gr->TemperaturaMed; ?> </p></td>
			<td class="coluna_centro"><p><strong>I(S):</strong> <?php echo $gr->Is; ?> </p></td>
			<td class="coluna_direita" class="coluna_direita"><p><strong>T. Medida Corrigida:</strong> <?php echo ""; ?> </p></td>
		</tr>

		<tr>
			<td class="coluna_esquerda"><p><strong>Temp. Delta:</strong> <?php echo $gr->TemperaturaMed; ?> </p></td>
			<td class="coluna_centro"><p><strong>I(T):</strong> <?php echo $gr->It; ?> </p></td>
			<td class="coluna_direita"><p><strong>T. Delta Corrigida:</strong> <?php echo ""; ?> </p></td>
		</tr>

		<tr>
			<td class="coluna_esquerda"></td>
			<td class="coluna_centro"><p><strong>I(N):</strong> <?php echo $gr->In; ?> </p></td>
			<td class="coluna_direita"></td>
		</tr>

	</table>

</section>

<section id='Avaliacao'>
	<h2>Avaliação de Resultados</h2>


	<table>
		<thead>		
			<tr>
				<td></td>
				<td colspan="2" class="title">Man. Orientada Preditiva</td>   
				<td colspan="2" class="title">Manut. Convencional</td>
				<td colspan="2" class="title">Retorno de Investimento</td>
			</tr>	
			<tr>
				<td class="primeira"></td>
				<td>Qtde</td>
				<td>Valor</td>  
				<td>Qtde</td>
				<td>Valor</td>  
				<td>Resultados</td>			
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="primeira">Mão de Obra (h):</td>
				<td> <?php echo $resultado->PreMOHora ;?></span> </td>
				<td> <?php echo site::formata_moeda_input($resultado->PreMOPreco,"R$",",") ;?> </td>
				<td> <?php echo $resultado->ConvMOHora ;?> </td>
				<td> <?php echo site::formata_moeda_input($resultado->ConvMOPreco,"R$",",") ;?> </td>
				<td> <?php echo site::formata_moeda_input( ($resultado->ConvMOPreco*$resultado->ConvMOHora)+($resultado->PreMOPreco*$resultado->PreMOHora) ,"R$",",") ;?> </td>
			</tr>

			<tr>
				<td class="primeira">Serv. Terceirizado (h):</td>
				<td> <?php echo $resultado->PredTercHora ;?> </td>
				<td> <?php echo site::formata_moeda_input($resultado->PredTercPreco,"R$",",") ;?> </td>
				<td> <?php echo $resultado->ConvTercHora ;?> </td>
				<td> <?php echo site::formata_moeda_input($resultado->ConvTercPreco,"R$",",") ;?> </td>
				<td> <?php echo site::formata_moeda_input( ($resultado->ConvTercPreco*$resultado->ConvTercHora)+($resultado->PredTercPreco*$resultado->PredTercHora) ,"R$",",") ;?> </td>
			</tr>

			<tr>
				<td class="primeira">Material Reparo ($):</td>
				<td> - </td>
				<td> <?php echo site::formata_moeda_input($resultado->PredMatPreco,"R$",",") ;?> </td>
				<td> - </td>
				<td> <?php echo site::formata_moeda_input($resultado->ConvMatPreco,"R$",",") ;?> </td>
				<td> <?php echo site::formata_moeda_input($resultado->ConvMatPreco+$resultado->PredMatPreco,"R$",",") ;?> </td>
			</tr>

			<tr>
				<td class="primeira">Produção (h\ton):</td>
				<td> <?php echo $resultado->PreProdHora ;?> </td>
				<td> <?php echo site::formata_moeda_input($resultado->PreProdPreco,"R$",",") ;?> </td>
				<td> <?php echo $resultado->ConvProdHora ;?> </td>
				<td> <?php echo site::formata_moeda_input($resultado->ConvProdPreco,"R$",",") ;?> </td>
				<td> <?php echo site::formata_moeda_input( ( $resultado->ConvProdPreco*$resultado->ConvProdHora )+( $resultado->PreProdPreco*$resultado->PreProdHora )  ,"R$",",") ;?> </td>
			</tr>

			<tr>
				<td class="primeira">Outros ($):</td>
				<td> - </td>
				<td> <?php echo site::formata_moeda_input($resultado->PredOutrPreco,"R$",",") ;?> </td>
				<td> - </td>
				<td> <?php echo site::formata_moeda_input($resultado->ConvOutrPreco,"R$",",") ;?> </td>
				<td> <?php echo site::formata_moeda_input( ($resultado->ConvOutrPreco+$resultado->PredOutrPreco ) ,"R$",",") ;?> </td>
			</tr>
		</tbody>

	</table>

</section>

<section id='Final'>

	<strong>Ações executadas para correção da falha</strong>
	<p><?php echo $resultado->Obs ;?></p>

	<table>
		<thead>
			<tr>
				<td></td>
				<td class="col_data"><strong>Data</strong></td>
				<td class="col_resp"><strong>Responsável</strong></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><strong>Planejamento</strong></td>
				<td class="col_data"<?php echo site::datahora_BR($resultado->DataPlanejamento); ?></td>
				<td class="col_resp"><?php echo $resultado->RespPlanejamento; ?></td>
			</tr>
			<tr>
				<td><strong>Corretiva</strong></td>
				<td class="col_data"><?php echo site::datahora_BR($resultado->DataCorretiva); ?></td>
				<td class="col_resp"><?php echo $resultado->RespCorretiva; ?></td>
			</tr>
			<tr>
				<td><strong>Finalização</strong></td>
				<td class="col_data"><?php echo site::datahora_BR($resultado->DataFinalizacao); ?></td>
				<td class="col_resp"><?php echo $resultado->RespFinalizacao; ?></td>
			</tr>
		</tbody>
	</table>

</section>

<footer>
	<p><?php echo Kohana::$config->load('config')->get('endereco'); ?></p>
	<p><?php echo Kohana::$config->load('config')->get('telefone'); ?></p>
</footer>
