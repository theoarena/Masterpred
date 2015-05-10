<h1>		
	<?php echo html::anchor(site::segment(1)."/condicoes","< Voltar", array("class" => "label label-warning" )); ?>
</h1>
<h3>Cadastro <small>de condições</small></h3>
<?php 
	
	echo form::open( site::segment(1)."/save_condicoes",array("id" => "form_edit" , 'enctype' => 'multipart/form-data' ) );	
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo form::hidden("CodCondicao",$obj->CodCondicao);	

    echo "<label class='control checkbox chk_equip'>";
    echo form::checkbox('Emergencia', 1, false);
    echo '<span class="checkbox-label">Emergência</span></label>';

    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Condicao',$obj->Condicao,array('class'=>'form-control', 'maxlength' => '10', 'placeholder' => 'Nome da Condição')) ."</div>";  
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Descricao',$obj->Descricao,array('class'=>'form-control', 'maxlength' => '50', 'placeholder' => 'Descrição')) ."</div>";  
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::select('Cor',site::getListaCores(),$obj->Cor, array('class' => 'form-control' , 'placeholder' => 'Cor')) ."</div>";    
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::select('Tecnologia',$tecnologias,$obj->Tecnologia,array('class' => 'form-control' , 'placeholder' => 'Tecnologia')) ."</div>";	

    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>";
  
    echo form::file('imagem',array('class' => 'form-control upload'));

    $base = url::base().Kohana::$config->load('config')->get('upload_directory');
    if($obj->Imagem!=null)
        echo '<img src="'.$base.$obj->Imagem.'" width="50%" />';

	echo "</div>";

	echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg'));
	
	echo "</form>";
	
?>

<script>

var validator = new FormValidator('form_edit', [{
    name: 'Condicao',
    display: 'Nome',    
    rules: 'required'
},
{
    name: 'Funcao',
    display: 'Função',    
    rules: 'required'
}
], function(errors, event) {
   
    var SELECTOR_ERRORS = $('#box_error');        
       
    if (errors.length > 0) {
        SELECTOR_ERRORS.empty();
        
        for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
            SELECTOR_ERRORS.append(errors[i].message + '<br />');
        }        
     
        SELECTOR_ERRORS.fadeIn(200);
        return false;
    }

    return true;
      
    event.preventDefault()
});

validator.setMessage('required', 'O campo "%s" é obrigatório.');

</script>