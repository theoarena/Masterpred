<?php 
	
	echo Form::open( "sistema/save_instrumentacao",array("id" => "form_edit", 'enctype' => 'multipart/form-data' ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo Form::hidden("CodInstrumentacao",$obj->CodInstrumentacao);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Nome',$obj->Nome,array('class'=>'form-control', 'maxlength' => '50', 'placeholder' => 'Nome da Instrumentação (controle interno)')) ."</div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::textarea('Descricao',$obj->Descricao,array('class'=>'form-control big_txt', 'rows'=>'5','placeholder' => 'Descrição dos itens utilizados nessa instrumentação'))."</div>";		

	
	echo Form::submit('submit', "Salvar",array('class' => 'btn btn-primary btn'));
	
	echo "</form>";
	echo Site::generateValidator(array('Nome'=>'Nome','Descricao'=>'Descricao'));

?>