<div id='Avaliacao'>
	<h2>Avaliação de Resultados</h2>


	<table cellpadding="0" cellspacing="0">
		<thead>		
			<tr>
				<td></td>
				<td colspan="2" class="title">Manut. Orientada Preditiva</td>   
				<td colspan="2" class="title">Manut. Emergencial</td>
				<td colspan="2" class="title">Retorno de Investimento</td>
			</tr>	
			<tr>
				<td class="primeira"></td>
				<td>Qtde</td>
				<td>Valor</td>  
				<td>Qtde</td>
				<td>Valor</td>  
				<td colspan="2">Resultados</td>			
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="primeira">Mão de Obra (h):</td>
				<td> <?php echo $resultado->PreMOHora ;?></span> </td>
				<td> <?php echo site::formata_moeda_input($resultado->PreMOPreco,"R$",",") ;?> </td>
				<td> <?php echo $resultado->ConvMOHora ;?> </td>
				<td> <?php echo site::formata_moeda_input($resultado->ConvMOPreco,"R$",",") ;?> </td>
				<td colspan="2"> <?php echo site::formata_moeda_input( ($resultado->ConvMOPreco*$resultado->ConvMOHora)+($resultado->PreMOPreco*$resultado->PreMOHora) ,"R$",",") ;?> </td>
			</tr>

			<tr>
				<td class="primeira">Serv. Terceirizado (h):</td>
				<td> <?php echo $resultado->PredTercHora ;?> </td>
				<td> <?php echo site::formata_moeda_input($resultado->PredTercPreco,"R$",",") ;?> </td>
				<td> <?php echo $resultado->ConvTercHora ;?> </td>
				<td> <?php echo site::formata_moeda_input($resultado->ConvTercPreco,"R$",",") ;?> </td>
				<td colspan="2"> <?php echo site::formata_moeda_input( ($resultado->ConvTercPreco*$resultado->ConvTercHora)+($resultado->PredTercPreco*$resultado->PredTercHora) ,"R$",",") ;?> </td>
			</tr>

			<tr>
				<td class="primeira">Material Reparo ($):</td>
				<td> - </td>
				<td> <?php echo site::formata_moeda_input($resultado->PredMatPreco,"R$",",") ;?> </td>
				<td> - </td>
				<td> <?php echo site::formata_moeda_input($resultado->ConvMatPreco,"R$",",") ;?> </td>
				<td colspan="2"> <?php echo site::formata_moeda_input($resultado->ConvMatPreco+$resultado->PredMatPreco,"R$",",") ;?> </td>
			</tr>

			<tr>
				<td class="primeira">Produção (h\ton):</td>
				<td> <?php echo $resultado->PreProdHora ;?> </td>
				<td> <?php echo site::formata_moeda_input($resultado->PreProdPreco,"R$",",") ;?> </td>
				<td> <?php echo $resultado->ConvProdHora ;?> </td>
				<td> <?php echo site::formata_moeda_input($resultado->ConvProdPreco,"R$",",") ;?> </td>
				<td colspan="2"> <?php echo site::formata_moeda_input( ( $resultado->ConvProdPreco*$resultado->ConvProdHora )+( $resultado->PreProdPreco*$resultado->PreProdHora )  ,"R$",",") ;?> </td>
			</tr>

			<tr>
				<td class="primeira">Outros ($):</td>
				<td> - </td>
				<td> <?php echo site::formata_moeda_input($resultado->PredOutrPreco,"R$",",") ;?> </td>
				<td> - </td>
				<td> <?php echo site::formata_moeda_input($resultado->ConvOutrPreco,"R$",",") ;?> </td>
				<td colspan="2"> <?php echo site::formata_moeda_input( ($resultado->ConvOutrPreco+$resultado->PredOutrPreco ) ,"R$",",") ;?> </td>
			</tr>
		</tbody>

	</table>

</div>