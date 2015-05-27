<h3>Cadastro <small>de anomalias</small></h3>
<?php 
	
	echo form::open( site::segment(1)."/save_anomalias",array("id" => "form_edit" ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo form::hidden("CodAnomalia",$obj->CodAnomalia);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Anomalia',$obj->Anomalia,array('class'=>'form-control', 'maxlength' => '100', 'placeholder' => 'Nome da Anomalia'))."</div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tecnologia</span>". form::select('Tecnologia',$tecnologias ,  $obj->Tecnologia, array('class' => 'form-control')) ."</div>";		
	echo form::submit('submit', "Salvar",array('class' => 'btn btn-primary btn-lg'));
	
	echo "</form>";
	echo site::generateValidator(array('Anomalia'=>'Anomalia'));
?>