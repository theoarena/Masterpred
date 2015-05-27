<h3>Cadastro <small>de Privilégios</small></h3>
<?php 
	
	echo form::open( site::segment(1)."/save_privileges",array("id" => "form_edit" ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
    echo form::hidden("id",$obj->id);   	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('name',$obj->name, array('class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Nome')) ."</div>";  	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('apelido',$obj->apelido, array('class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Apelido')) ."</div>";  	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon addon_textarea'>Descrição</span>". form::textarea('description',$obj->description,array('class' => 'form-control')) ."</div>"; 	
	echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg'));
	
	echo "</form>";  
    echo site::generateValidator(array('name'=>'Nome'));
?>