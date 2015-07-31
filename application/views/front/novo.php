<?php
    if(isset($_GET["erro"]))
        if($_GET["erro"] == 1)
        echo "<div class='alert alert-danger'><h4>Ocorreu algum erro, tente novamente.</h4></div>";		
            else
        echo "<div class='alert alert-danger'><h4>Usuário e/ou Email já existem, insira outro(s).</h4></div>";

    if(isset($_GET["sucesso"])) echo "<div class='alert alert-success'><h4>Seu pedido de cadastro foi enviado, em breve entraremos em contato!</h4></div>";     
	
?>

<h1 id='welcome'><img src="<?php echo site::mediaUrl().'images/front_logo.jpg' ?> ?>" width=355></h1>        
  <h3>Para se cadastrar, preencha os campos abaixo</h3>
  <p>Nós analisaremos seu pedido e logo entraremos em contato.</p>

<?php 
	
	echo '<div class="alert alert-danger" id="box_error"></div>';

	echo form::open( "front/cadastrar_novo" ,array("id" => "form_edit")  );			
	echo form::hidden("senha_aleatoria",1); 
	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('nome',null, array('class' => 'form-control', 'maxlength' => '200', 'placeholder' => 'Nome completo' )) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('email',null, array('class' => 'form-control', 'maxlength' => '127', 'placeholder' => 'Email' )) ."</div>";   
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('telefone',null, array('class' => 'form-control', 'maxlength' => '127', 'placeholder' => 'Telefone' )) ."</div>";  
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('nascimento',null, array('class' => 'form-control', 'maxlength' => '10' ,'placeholder' => 'Data de nascimento' , 'onkeypress' => "return mask(event,this,'##/##/####')" )) ."</div>";	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>@</span>". form::input('username',null, array('class' => 'form-control', 'maxlength' => '32' ,'placeholder' => 'Nome de usuário' )) ."</div>";  
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon addon_textarea'>Observações</span>". form::textarea('obs',null, array('class' => 'form-control' )) ."</div>"; 
	echo form::submit('submit', "Enviar pedido", array ('class' => 'btn label-primary btn-pq' ));
    echo html::anchor('','Voltar', array('class' => "btn btn-warning btn-pq" , "id" => "voltar_esqueci_senha"));            
	
	
	echo "</form>";
	
?>




<script>

var validator = new FormValidator('form_edit', [{
    name: 'nome',
    display: 'Nome completo',    
    rules: 'required'
},
{
    name: 'email',
    display: 'Email',    
    rules: 'required|valid_email'
},
{
    name: 'nascimento',
    display: 'Data de nascimento',    
    rules: 'required'
},
{
    name: 'username',
    display: 'Nome de usuário',    
    rules: 'required|alpha_dash'
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