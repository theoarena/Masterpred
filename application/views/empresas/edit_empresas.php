<?php 	
	echo Form::open( Site::segment(1)."/save_empresas",array("id" => "form_edit" , 'enctype' => 'multipart/form-data') );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo Form::hidden("CodEmpresa",$obj->CodEmpresa);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Empresa',$obj->Empresa, array('class' => 'form-control', 'maxlength' => '100', 'placeholder' => 'Nome da Empresa')) ."</div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Unidade',$obj->Unidade, array('class' => 'form-control', 'placeholder' => 'Unidade de negócio' )) ."</div>";		
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Fabrica',$obj->Fabrica, array('class' => 'form-control', 'placeholder' => 'Site (Cidade-UF)')) ."</div>";		
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('cep',$obj->cep, array('class' => 'form-control', 'placeholder' => 'CEP')) ."</div>";		
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('endereco',$obj->endereco, array('class' => 'form-control', 'placeholder' => 'Endereço (Rua, Bairro,etc)')) ."</div>";		
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('contato',$obj->contato, array('class' => 'form-control', 'placeholder' => 'Contato')) ."</div>";		
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('departamento',$obj->departamento, array('class' => 'form-control', 'placeholder' => 'Departamento')) ."</div>";		

	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Logo <br> (250x250)</span>";
  
    echo Form::file('imagem',array('class' => 'form-control upload'));

    $base = url::base().Kohana::$config->load('config')->get('upload_directory_empresas');
    if($obj->Logo!=null)
        echo '<img src="'.$base.$obj->Logo.'" width="30%" />';

	echo "</div>";

    echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn'));
	
	echo Form::close();
    echo Site::generateValidator(array('Empresa'=>'Empresa', 'Unidade' => "Unidade",'Fabrica'=>'Fábrica'));
?>