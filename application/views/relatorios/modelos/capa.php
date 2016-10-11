<?php

	$base_tec = Kohana::$config->load('config')->get('endereco_sistema').'/'.Kohana::$config->load('config')->get('upload_directory_tecnologias');
	$base_emp = Kohana::$config->load('config')->get('endereco_sistema').'/'.Kohana::$config->load('config')->get('upload_directory_empresas');

?>
<div id='Capa'>

	<div id="col_left">
		<?php
			if($tecnologia->Imagem != null)
				echo "<img src='".$base_tec.$tecnologia->Imagem."' width='350px' height='990px' />"
		?>
	</div>

	<div id="col_right">
		<p id='sequencial'>Relatório Técnico Nº.<br> <?php echo Site::data_EN_relatorio($relatorio->Data).".".Site::formata_codRelatorio($relatorio->CodRelatorio) ?></p>	
		<div id='logo'>
		<?php
			if($empresa->Logo != null)
				echo "<img src='".$base_emp.$empresa->Logo."' width='250px' height='250px' />"
		?>
		</div>

		<table id="info_empresa" cellpadding="0" cellspacing="0">
			<tr>
				<td class="col_tit">Cliente:</td>
				<td><?php echo $empresa->Empresa; ?></td>
			</tr>
			<tr><td colspan="2" class="colspan"></td></tr>
			<tr>
				<td class="col_tit">Endereço:</td>
				<td><?php echo $empresa->endereco; ?></td>
			</tr>
			<tr>
				<td class="col_tit">Bairro:</td>
				<td><?php echo $empresa->departamento; ?></td>
			</tr>
			<tr>
				<td class="col_tit">Cidade:</td>
				<td><?php echo $empresa->Unidade; ?></td>
			</tr>
			<tr>
				<td class="col_tit">C.E.P:</td>
				<td><?php echo $empresa->cep; ?></td>
			</tr>
			<tr><td colspan="2" class="colspan"></td></tr>
			<tr>
				<td class="col_tit">A/C:</td>
				<td><?php echo $empresa->contato; ?></td>
			</tr>
		</table>

	</div>

</div>
