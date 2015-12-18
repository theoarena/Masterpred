
<h1 id='welcome'>
	<img src="<?php echo site::mediaUrl().'images/front_logo.jpg'?>" width=355>
</h1>
<p>Para entrar, preencha o formulário abaixo com seus dados</p>
<?php 	
	
	echo Form::open( "front/logar" ,array( "id" => "form_login" ) );			
	echo '<div class="alert alert-danger" id="box_error_login"></div>';			
	if($erro!="") echo "<div class='alert alert-danger alert-dismissable'>".$erro."</div>";		
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Usuário</span>". Form::input('username',null, array('class'=>'form-control') ) ."</div>";
	echo "<div id='password_login' class='input-group input-group-lg'> <span class='input-group-addon'>Senha</span>". Form::password('password',null, array('class'=>'form-control') ) ."</div>";

	echo Form::submit('submit', "Entrar", array('class'=>'btn btn-primary btn-pq'));
	echo HTML::anchor('front/esqueci_senha','Esqueci minha senha', array('class' => "btn btn-warning btn-pq pull-right" , "id" => "esqueci_senha"));			
	echo "</form>";
	echo HTML::anchor('front/cadastro','Não tenho cadastro',array('id' => 'sem_cadastro'));

	echo site::generateValidator(array('username'=>'Nome de usuário','password'=>'Senha'),'form_login','box_error_login'); 
?>


	
