<?php 
	
	echo form::open( site::segment(1)."/save_recomendacoes",array("id" => "form_edit" ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo form::hidden("CodRecomendacao",$obj->CodRecomendacao);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Recomendacao',$obj->Recomendacao,array('class'=>'form-control', 'maxlength' => '100', 'placeholder' => 'Nome da Recomendação')) ."</div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tecnologia</span>". form::select('Tecnologia',$tecnologias , $obj->Tecnologia, array('class' => 'form-control')) ."</div>";		
	
	echo form::submit('submit', "Salvar",array('class' => 'btn btn-primary btn'));
	
	echo "</form>";
	echo site::generateValidator(array('Recomendacao'=>'Recomendação'));
?>