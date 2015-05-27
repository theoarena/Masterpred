<h3>Cadastro <small>de analistas</small></h3>
<?php 
	
	echo form::open( site::segment(1)."/save_analistas",array("id" => "form_edit" ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo form::hidden("CodAnalista",$obj->CodAnalista);	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Analista',$obj->Analista, array('class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Nome da Analista')) ."</div>";  
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Funcao',$obj->Funcao,array('class'=>'form-control', 'maxlength' => '100', 'placeholder' => 'Função')) ."</div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon addon_textarea'>Observações</span>". form::textarea('Obs',$obj->Obs,array('class' => 'form-control')) ."</div>"; 	
	echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg'));
	
	echo "</form>";
	echo site::generateValidator(array('Analista' =>'Nome','Funcao' => 'Função'));
?>
