<div class="jumbotron">
	<h1 id='welcome'>Masterpred</h1>
<?php 
	
	echo form::open( 'usuario/recuperar_senha' );			
	if($this->input->get("erro")) echo "<div class='alert alert-danger alert-dismissable'><p>Nenhum usuário com este email foi encontrado.</p></div>";		
	if($this->input->get("enviado")) echo "<div class='alert alert-success alert-dismissable'><p>Você receberá um email com sua nova senha em breve.</p></div>";		
	echo '<h3>Insira seu email no campo abaixo.</h3>';	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Email</span>". form::input('email',null, "class='form-control' placeholder='Seu email'" ) ."</div>";
	
	echo form::submit('submit', "Enviar","class='btn btn-primary btn-lg'");
	echo html::anchor('','Voltar', array('class' => "btn btn-warning btn-lg" , "id" => "voltar_esqueci_senha"));			
	
	echo '</form>';
	
?>
  
</div>