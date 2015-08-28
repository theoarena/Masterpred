
<h1 id='welcome'>
	<img src="<?php echo site::mediaUrl().'images/front_logo.jpg'?>" width=355>
</h1>
<p>Para entrar, preencha o formulário abaixo com seus dados</p>
<?php 	
	
	

	print form::open( "front/logar" ,array( "id" => "form_login" ) );			
	echo '<div class="alert alert-danger" id="box_error_login"></div>';			
	if($erro!="") echo "<div class='alert alert-danger alert-dismissable'>".$erro."</div>";		
	print "<div class='input-group input-group-lg'> <span class='input-group-addon'>Usuário</span>". form::input('username',null, array('class'=>'form-control') ) ."</div>";
	print "<div id='password_login' class='input-group input-group-lg'> <span class='input-group-addon'>Senha</span>". form::password('password',null, array('class'=>'form-control') ) ."</div>";

	print form::submit('submit', "Entrar", array('class'=>'btn btn-primary btn-pq'));
	echo html::anchor('front/esqueci_senha','Esqueci minha senha', array('class' => "btn btn-warning btn-pq pull-right" , "id" => "esqueci_senha"));			
	echo "</form>";
	echo html::anchor('front/cadastro','Não tenho cadastro',array('id' => 'sem_cadastro'));

	echo site::generateValidator(array('username'=>'Nome de usuário','password'=>'Senha'),'form_login','box_error_login'); 
?>


	
