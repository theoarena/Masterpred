<?php 
	
	echo Form::open( Site::segment(1)."/save_componentes",array("id" => "form_edit") );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo Form::hidden("CodComponente",$obj->CodComponente);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Componente',$obj->Componente,array('class'=>'form-control', 'maxlength' => '100', 'placeholder' => 'Nome do Componente')) ."</div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tecnologia</span>". Form::select('Tecnologia',$tecnologias , $obj->Tecnologia, array ('class' => 'form-control') ) ."</div>";		

	
	echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn') );
	
	echo "</form>";
	echo Site::generateValidator(array('Componente'=>'Componente'));
?>