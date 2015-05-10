<h1>		
	<?php echo html::anchor(site::segment(1)."/empresas","< Voltar", array("class" => "label label-warning" )); ?>
</h1>
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

?>

<script>

var validator = new FormValidator('form_edit', [{
    name: 'Empresa',
    display: 'Empresa',    
    rules: 'required'
},{
    name: 'Unidade',
    display: 'Unidade',    
    rules: 'required'
},{
    name: 'Fabrica',
    display: 'Fábrica',    
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