<h3>Cadastro <small>de empresas</small></h3>
<?php 
	
	echo form::open( site::segment(1)."/save_empresas",array("id" => "form_edit" ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo form::hidden("CodEmpresa",$obj->CodEmpresa);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Empresa',$obj->Empresa, array('class' => 'form-control', 'maxlength' => '100', 'placeholder' => 'Nome da Empresa')) ."</div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Unidade',$obj->Unidade, array('class' => 'form-control', 'placeholder' => 'Unidade' )) ."</div>";		
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Fabrica',$obj->Fabrica, array('class' => 'form-control', 'placeholder' => 'Fabrica')) ."</div>";		
	
    echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg'));
	
	echo form::close();
    echo site::generateValidator(array('Empresa'=>'Empresa', 'Unidade' => "Unidade",'Fabrica'=>'Fábrica'));
?>