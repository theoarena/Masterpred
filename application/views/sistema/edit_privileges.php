<?php 
	
	echo Form::open( Site::segment(1)."/save_privileges",array("id" => "form_edit" ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
    echo Form::hidden("id",$obj->id);   	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('name',$obj->name, array('class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Nome')) ."</div>";  	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('apelido',$obj->apelido, array('class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Apelido')) ."</div>";  	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon addon_textarea'>Descrição</span>". Form::textarea('description',$obj->description,array('class' => 'form-control')) ."</div>"; 	
	echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn'));
	
	echo "</form>";  
    echo Site::generateValidator(array('name'=>'Nome'));
?>