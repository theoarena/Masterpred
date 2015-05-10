<h1>		
	<?php echo html::anchor(site::segment(1)."/recomendacoes","< Voltar", array("class" => "label label-warning" )); ?>
</h1>
<h3>Cadastro <small>de recomendações</small></h3>
<?php 
	
	echo form::open( site::segment(1)."/save_recomendacoes",array("id" => "form_edit" ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo form::hidden("CodRecomendacao",$obj->CodRecomendacao);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Recomendacao',$obj->Recomendacao,array('class'=>'form-control', 'maxlength' => '100', 'placeholder' => 'Nome da Recomendação')) ."</div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tecnologia</span>". form::select('Tecnologia',$tecnologias , $obj->Tecnologia, array('class' => 'form-control')) ."</div>";		
	
	echo form::submit('submit', "Salvar",array('class' => 'btn btn-primary btn-lg'));
	
	echo "</form>";
	
?>

<script>

var validator = new FormValidator('form_edit', [{
    name: 'Recomendacao',
    display: 'Recomendação',    
    rules: 'required'
}], function(errors, event) {
   
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