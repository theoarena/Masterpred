<?php 	
	echo form::open( site::segment(1)."/save_empresas",array("id" => "form_edit" ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo form::hidden("CodEmpresa",$obj->CodEmpresa);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Empresa',$obj->Empresa, array('class' => 'form-control', 'maxlength' => '100', 'placeholder' => 'Nome da Empresa')) ."</div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Unidade',$obj->Unidade, array('class' => 'form-control', 'placeholder' => 'Unidade de negócio' )) ."</div>";		
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Fabrica',$obj->Fabrica, array('class' => 'form-control', 'placeholder' => 'Site (Cidade-UF)')) ."</div>";		
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('cep',$obj->cep, array('class' => 'form-control', 'placeholder' => 'CEP')) ."</div>";		
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('endereco',$obj->endereco, array('class' => 'form-control', 'placeholder' => 'Endereço (Rua, Bairro,etc)')) ."</div>";		
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('contato',$obj->contato, array('class' => 'form-control', 'placeholder' => 'Contato')) ."</div>";		
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('departamento',$obj->departamento, array('class' => 'form-control', 'placeholder' => 'Departamento')) ."</div>";		
	
    echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn'));
	
	echo form::close();
    echo site::generateValidator(array('Empresa'=>'Empresa', 'Unidade' => "Unidade",'Fabrica'=>'Fábrica'));
?>