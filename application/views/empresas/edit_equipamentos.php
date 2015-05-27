<h3>Cadastro <small>de equipamentos</small></h3>

<?php 
	
	echo form::open( site::segment(1)."/save_equipamentos",array("id" => "form_edit") );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
    echo form::hidden("CodEquipamento",$obj->CodEquipamento);  
    echo form::hidden("Setor",$setor);  
	echo form::hidden("Area",$area);	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Equipamento',$obj->Equipamento, array('class' => 'form-control', 'maxlength' => '150', 'placeholder' => 'Nome do Equipamento' )) ."</div>";    
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Tag',$obj->Tag, array('class' => 'form-control', 'maxlength' => '20', 'placeholder' => 'Tag' )) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tipo do Equipamento</span>". form::select('TipoEquipamento',$tipo_equipamento,$obj->TipoEquipamento) ."</div>"; 
	//echo "<div class='input-group input-group-lg'> ".form::checkbox('estado',1, ($obj->Estado==1)?(true):(false) )." <label  class='checkbox-label'>Estado</label> </div>";	
	//echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Ordem',$obj->Ordem,"class='form-control' maxlength='20' placeholder='Ordem'") ."</div>"; 
	echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg' ));
	
	echo "</form>";
	echo site::generateValidator(array('Rota'=>'Rota'));
?>