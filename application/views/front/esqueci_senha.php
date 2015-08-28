
<h1 id='welcome'><img src="<?php echo site::mediaUrl().'images/front_logo.jpg'?>" width=355></h1>        
<?php 
	
	echo form::open( 'front/recuperar_senha' ,array("id" => "form_edit") );		

	if(Arr::get($_GET, 'erro',false)) echo "<div class='alert alert-danger alert-dismissable'><p>Nenhum usuário com este email foi encontrado.</p></div>";		
	if(Arr::get($_GET, 'enviado',false)) echo "<div class='alert alert-success alert-dismissable'><p>Você receberá um email com sua nova senha em breve.</p></div>";		
	echo '<p>Insira seu email no campo abaixo.</p>';	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Email</span>". form::input('email',null, array('class' => 'form-control', 'placeholder' => 'Seu email')) ."</div>";
	
	echo form::submit('submit', "Enviar", array ('class' => 'btn label-primary btn-pq' ));
    echo html::anchor('','Voltar', array('class' => "btn btn-warning btn-pq" , "id" => "voltar_esqueci_senha"));    		
	
	echo '</form>';
	
?>
