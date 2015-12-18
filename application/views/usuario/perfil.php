<?php 
	
	echo Form::open( Site::segment(1)."/alterar_perfil",array("id" => "form_edit") );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo Form::hidden("id",$obj->id);	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('nome',$obj->nome,array('class' => 'form-control', 'maxlength' => '100' ,'placeholder' => 'Meu nome')) ."</div>";   
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('telefone',$obj->telefone,array('class' => 'form-control', 'maxlength' => '100' ,'placeholder' => 'Meu telefone')) ."</div>";	

    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Senha</span>". Form::password('password',"senhapadrao",array('class' => 'form-control', 'maxlength' => '16' ,'placeholder' => 'Senha')) ."</div>";   
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Confirmação de senha</span>". Form::password('password_confirm',"senhapadrao",array('class' => 'form-control', 'maxlength' => '16' ,'placeholder' => 'Confirmação de senha')) ."</div>";   
  
    echo Form::submit('submit', "Salvar",array('class' => 'btn btn-primary btn-lg'));       
	echo Form::close();
  
?>


<script>

var validator = new FormValidator('form_edit', [{
    name: 'nome',
    display: 'Nome',    
    rules: 'required'
}, {
    name: 'password',
     display: 'Senha',
     rules: 'required'
}, {
    name: 'password_confirm',
    display: 'Confirmação de senha',
    rules: 'required|matches[password]'
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