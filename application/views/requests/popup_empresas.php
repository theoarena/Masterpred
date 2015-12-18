<?php

		foreach ($empresas as $empresa) {
			
			echo '<div class="block_info_empresa">';
				echo '<span>'.$empresa->Empresa. ' - '.$empresa->Unidade.'</span>';
				echo '<span>Fábrica: '.$empresa->Fabrica.'</span>';
			echo '</div>';

		}

?>