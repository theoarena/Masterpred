<link href="<?php echo Site::mediaUrl(); ?>css/chosen.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Site::mediaUrl(); ?>js/chosen.js"></script>

<?php 
	
    
	echo Form::open( Site::segment(1)."/save_pedidos_usuario",array("id" => "form_edit") );			
	echo Form::hidden("role[]",1);
    echo Form::hidden("id",$obj->id); 
    echo "<label class='control checkbox chk_equip'>".Form::checkbox('ativar',1, false )." <span class='checkbox-label'>Perfil ativado</span></label>";   
    
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tipo de Usuário</span>". Form::select('role[]',$roles,$roles_selecionadas, array('class' => 'form-control', 'id' => 'roles' )) ."</div>";      
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('nome',$obj->nome, array('class' => 'form-control', 'maxlength' => '200', 'placeholder' => 'Nome completo')) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('email',$obj->email, array('class' => 'form-control', 'maxlength' => '127', 'placeholder' => 'Email' )) ."</div>";   
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('telefone',$obj->telefone, array('class' => 'form-control', 'maxlength' => '127', 'placeholder' => 'Telefone' )) ."</div>";  
    
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('nascimento',Site::data_BR($obj->nascimento), array( 'class' => 'form-control', 'maxlength' => '10', 'placeholder' => 'Data de nascimento', 'onkeypress' => "return mask(event,this,'##/##/####')" ) ) ."</div>";	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Empresas</span>". Form::select( 'lista_empresas[]',$empresas,$empresas_selecionadas, array('multiple' => 'multiple', 'class' => 'form-control', 'data-placeholder' => 'Selecione as empresas', 'id' => 'empresas' )) ."</div>";      
    echo "<br/>";
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>@</span>". Form::input('username',$obj->username, array('class' => 'form-control', 'maxlength' => '32', 'placeholder' => 'Nome de usuário')) ."</div>";  

    echo "<label class='control checkbox chk_equip'> ".Form::checkbox('gerar_senha',1, false )." <span class='checkbox-label'>Atribuir nova senha (selecionando esta opção a senha atual deste usuário será substituida)</span></label>";   
    echo "<label class='control checkbox chk_equip'> ".Form::checkbox('senha_aleatoria',1, false )." <span  class='checkbox-label'>Gerar senha aleatóriamente (ignorará o campo abaixo).</span></label> ";   
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>#</span>". Form::input('password',null, array('class' => 'form-control', 'maxlength' => '8', 'placeholder' => 'Senha customizada')) ."</div>";      
   

	echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn'));       
	
	echo "</form>";
    echo Site::generateValidator(array(
        'nome'=>'Nome completo',
        'email' => array('Email','required|valid_email'),
        'nascimento' => 'Data de nascimento',
        'username' => array('Nome de usuário','required|alpha_numeric'),
        'lista_empresas[]'=>'Empresas'
    ));
	
?>


<script>

$(document).ready(function(){
    $("select#empresas").chosen({width: "100%"});
});

</script>