<?php 
	
	echo Form::open( Site::segment(1)."/save_equipamentos",array("id" => "form_edit") );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
    echo Form::hidden("CodEquipamento",$obj->CodEquipamento);  
    echo Form::hidden("Setor",$setor);  
	echo Form::hidden("Area",$area);	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Tag',$obj->Tag, array('class' => 'form-control', 'maxlength' => '20', 'placeholder' => 'Tag' )) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Equipamento',$obj->Equipamento, array('class' => 'form-control', 'maxlength' => '150', 'placeholder' => 'Nome do Equipamento' )) ."</div>";    
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tipo do Equipamento</span>". Form::select('TipoEquipamento',$tipo_equipamento,$obj->TipoEquipamento) ."</div>"; 
	//echo "<div class='input-group input-group-lg'> ".Form::checkbox('estado',1, ($obj->Estado==1)?(true):(false) )." <label  class='checkbox-label'>Estado</label> </div>";	
	//echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Ordem',$obj->Ordem,"class='form-control' maxlength='20' placeholder='Ordem'") ."</div>"; 
	echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn' ));
	
	echo "</form>";
	echo Site::generateValidator(array('Rota'=>'Rota'));
?>