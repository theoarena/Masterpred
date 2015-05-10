<div style='background-color:#f1f1f1;padding:10px;color:#444444;font-family:Verdana'>
	<h2>Masterpred</h2>
	<p style="margin:0">Uma ordem de serviço foi finalizada pelo cliente.</p>
	<p style="margin:0">Código: </p><strong><?php echo $gr->CodGr; ?></strong>		
	<p style="margin:0">Empresa: </p><strong><?php echo $gr->equipamentoinspecionado->empresa->Empresa." | ".$gr->equipamentoinspecionado->empresa->Unidade; ?></strong>		
	<p style="margin:0">Equipamento Inspecionado: </p><strong><?php echo $gr->equipamentoinspecionado->EquipamentoInspecionado; ?></strong>			
	<p style="margin:0">&nbsp;</p>
	<p style="margin:0">Atenciosamente,</p>
	<p style="margin:0">Equipe MASTERPRED ©</p>
</div>