<link href="<?php echo site::mediaUrl(); ?>css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo site::mediaUrl(); ?>js/datepicker.js"></script>
<link href="<?php echo site::mediaUrl(); ?>css/chosen.css" rel="stylesheet" type="text/css" />
<script src="<?php echo site::mediaUrl(); ?>js/chosen.js"></script>

<h3>Cadastro <small>de usuários</small></h3>

<?php 
	
	echo form::open( site::segment(1)."/save_usuarios_sistema",array("id" => "form_edit") );			
		
    echo form::hidden("id",$obj->id);  	
        echo "<label class='control checkbox chk_equip'>".form::checkbox('ativar',1, ($obj->ativo == 1)?(true):(false) )." <span class='checkbox-label'>Perfil ativado</span></label>";   
    
     echo form::hidden("role[]",1);  
   
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tipo de Usuário</span>". form::select('role[]',$roles,$roles_selecionadas, array('class' => 'form-control' , 'id' => 'roles' )) ."</div>";      
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('nome',$obj->nome, array( 'class' => 'form-control', 'maxlength' => '200', 'placeholder' => 'Nome completo' )) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('email',$obj->email, array('class' => 'form-control', 'maxlength' => '127', 'placeholder' => 'Email')) ."</div>";   
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('telefone',$obj->telefone, array('class' => 'form-control', 'maxlength' => '127', 'placeholder' => 'Telefone' )) ."</div>";  
    
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('nascimento',site::data_BR($obj->nascimento), array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')"  )) ."</div>";	
    
    echo "<br/>";
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>@</span>". form::input('username',$obj->username, array('class' => 'form-control', 'maxlength' => '32', 'placeholder' => 'Nome de usuário' )) ."</div>";  

    echo "<label class='control checkbox chk_equip'> ".form::checkbox('gerar_senha',1, false )." <span class='checkbox-label'>Atribuir nova senha (selecionando esta opção a senha atual deste usuário será substituida)</span></label> </div>";   
    echo "<label class='control checkbox chk_equip'> ".form::checkbox('senha_aleatoria',1, false )." <span  class='checkbox-label'>Gerar senha aleatóriamente (ignorará o campo abaixo).</span></label>";       
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>#</span>". form::input('password',null, array('class' => 'form-control', 'maxlength' => '8', 'placeholder' => 'Senha Cutomizada' )) ."</div>";      
	echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg' ));
	
	echo "</form>";
	   echo site::generateValidator(array(
        'nome'=>'Nome completo',
        'email' => array('Email','required|valid_email'),
        'nascimento' => 'Data de nascimento',
        'username' => array('Nome de usuário','required|alpha_numeric')
    ));
?>


<script>

 $(document).ready(function () {
        //$('.footable').footable();
        $('input[name="nascimento"]').datepicker({format:'dd/mm/yyyy'});  
        $("select#empresas").chosen({width: "100%"});     
});

</script>