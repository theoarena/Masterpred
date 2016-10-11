<?php 
	
	echo Form::open( "sistema/save_normas",array("id" => "form_edit", 'enctype' => 'multipart/form-data' ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo Form::hidden("CodNorma",$obj->CodNorma);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Nome',$obj->Nome,array('class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Nome da Norma')) ."</div>";		

	
	echo Form::submit('submit', "Salvar",array('class' => 'btn btn-primary btn'));
	
	echo "</form>";
	echo Site::generateValidator(array('Nome'=>'Nome'));

?>