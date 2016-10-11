<div id='empresa_lista_equipamentos'>

	<p id="ista_equipamentos_nome_empresa">Empresa: <?php echo $empresa;?></p>
	<p id='ista_equipamentos_total_equips'>Total de equipamentos: <?php echo $count;?></p>

</div>

<div id="lista_equipamentos">
	
<?php

	foreach ($areas as $area => $setores) {

		$a = ORM::factory('Area',$area);

		echo 'Área: '.$a->Area;
		echo '<br>';

		foreach ($setores as $setor => $equipamentos) {

			$s = ORM::factory('Setor',$setor);

			echo 'Setor: '.$s->Setor;
			echo '<br>';
			echo '<table cellspacing="0" cellpadding="0">';
				
				$data = $equipamentos[0]['Data'];

				echo '<tr>';
					echo '<td class="col_tag linha">Tag</td>';
					echo '<td class="col_equip linha">Equipamento</td>';
					echo '<td class="col_condicao linha">'.Site::data_BR($data,false,true).'</td>';
				echo '</tr>';			
				$row = 1;	
				foreach ($equipamentos as $equipamento) {

					if($row%2==0)						
						echo '<tr class="cor">';
					else
						echo '<tr>';
						echo '<td class="col_tag">'.$equipamento['Tag'].'</td>';
						echo '<td class="col_equip">'.$equipamento['Equipamento'].'</td>';
						echo '<td class="col_condicao">'.$equipamento['Condicao'].'</td>';
					echo '</tr>';
					$row++;
				}
			
			echo '</table>';
			echo '<br>';

		}

		
	}

?>

</div>