<?php 
	
	echo Form::open( Site::segment(1)."/save_tipoequipamento",array("id" => "form_edit") );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo Form::hidden("CodTipoEquipamento",$obj->CodTipoEquipamento);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('TipoEquipamento',$obj->TipoEquipamento, array('class' => 'form-control', 'maxlength' => '100',  'placeholder' => 'Tipo do equipamento')) ."</div>";	
		
	echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn'));
	
	echo "</form>";
	echo Site::generateValidator(array('TipoEquipamento'=>'Tipo de Equipamento'));
?>