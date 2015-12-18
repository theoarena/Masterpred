<?php 
	
	echo Form::open( Site::segment(1)."/save_analistas",array("id" => "form_edit" ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo Form::hidden("CodAnalista",$obj->CodAnalista);	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Analista',$obj->Analista, array('class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Nome da Analista')) ."</div>";  
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Funcao',$obj->Funcao,array('class'=>'form-control', 'maxlength' => '100', 'placeholder' => 'Função')) ."</div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon addon_textarea'>Observações</span>". Form::textarea('Obs',$obj->Obs,array('class' => 'form-control')) ."</div>"; 	
	echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn'));
	
	echo "</form>";
	echo Site::generateValidator(array('Analista' =>'Nome','Funcao' => 'Função'));
?>
