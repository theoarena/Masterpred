<script src="<?php echo site::mediaUrl(); ?>js/datepicker.js"></script>
<h3>Inserir <small>novos registros de inpeção</small></h3>

<?php 
	echo form::open( site::segment(1)."/save_analiseinspecao_novo",array("id" => "form_edit") );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	//echo form::hidden("CodRota",$obj->CodRota);	

    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Rota</span>". form::select('Rota',$rotas,null,array('class' => 'form-control') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Analista</span>". form::select('Analista',$analistas,$obj->Analista,array('class' => 'form-control') ) ."</div>"; 
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Data</span>". form::input('Data', ($obj->Data != null)?( site::data_BR($obj->Data) ):( date("d/m/Y") ) ,array('class' => 'form-control', 'id' => 'datepicker',  'maxlength' => '10', 'placeholder' => 'Data', 'onkeypress' => 'return mask(event,this,"##/##/####")' )) ."</div>";	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tecnologia</span>". form::select('Tecnologia',$tecnologias,$obj->Tecnologia,array('class' => 'form-control') ) ."</div>"; 
	echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg'));       
	echo form::close();

    echo site::generateValidator(array('Data'=>'Data'));
?>