<?php 
	
	echo form::open( site::segment(1)."/save_tipoinspecao",array( "id" => "form_edit") );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo form::hidden("CodTipoInspecao",$obj->CodTipoInspecao);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('TipoInspecao',$obj->TipoInspecao,array('class' => 'form-control', 'maxlength' => '100', 'placeholder' => 'Nome da Inspeção')) ."</div>";	
	echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn'));
	
	echo "</form>";
	
    echo site::generateValidator(array('TipoInspecao'=>'Nome da Inspeção'));
?>
