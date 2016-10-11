<?php 
	
	echo Form::open( Site::segment(1)."/save_condicoes",array("id" => "form_edit" , 'enctype' => 'multipart/form-data' ) );	
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo Form::hidden("CodCondicao",$obj->CodCondicao);	

    echo "<label class='control checkbox chk_equip'>";
    echo Form::checkbox('Emergencia', 1, ($obj->Emergencia)?true:false );
    echo '<span class="checkbox-label">Emergência</span></label>';

    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Condicao',$obj->Condicao,array('class'=>'form-control', 'maxlength' => '10', 'placeholder' => 'Nome da Condição')) ."</div>";  
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Descricao',$obj->Descricao,array('class'=>'form-control', 'maxlength' => '50', 'placeholder' => 'Descrição')) ."</div>";  
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::select('Cor',$cores,$obj->Cor, array('class' => 'form-control' , 'placeholder' => 'Cor')) ."</div>";    
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::select('Tecnologia',$tecnologias,$obj->Tecnologia,array('class' => 'form-control' , 'placeholder' => 'Tecnologia')) ."</div>";	

    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>";
  
    echo Form::file('imagem',array('class' => 'form-control upload'));

    $base = url::base().Kohana::$config->load('config')->get('upload_directory_condicoes');
    if($obj->Imagem!=null)
        echo '<img src="'.$base.$obj->Imagem.'" height="30%" />';

	echo "</div>";

	echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn'));
	
	echo "</form>";
	echo Site::generateValidator(array('Condicao'=>'Nome da Condição','Funcao'=>"Função"));
?>