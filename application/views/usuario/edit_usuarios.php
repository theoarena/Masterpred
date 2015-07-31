<link href="<?php echo site::mediaUrl(); ?>css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo site::mediaUrl(); ?>js/datepicker.js"></script>
<link href="<?php echo site::mediaUrl(); ?>css/chosen.css" rel="stylesheet" type="text/css" />
<script src="<?php echo site::mediaUrl(); ?>js/chosen.js"></script>

<?php 
	
	echo form::open( "usuario/save_usuarios",array("id" => "form_edit") );			
		
    echo form::hidden("id",$obj->id);  
    echo form::hidden("redir",$redir);  
    echo form::hidden("menu",site::segment(1));  

    if($tipo!='sistema')
	   echo form::hidden("empresa",site::get_empresaatual());	

    echo "<label class='control checkbox' id='usuario_ativado'>".form::checkbox('ativar',1, ($obj->ativo == 1)?(true):(false) )." <span class='checkbox-label'>Perfil ativado</span></label>";   
    
     echo form::hidden("role[]",1);  

    if( ($obj->obs != null) && ($tipo=='pendente'))
    {        
        echo "<div class='well' id='pedido_usuario'>";
         echo "<h4>Comentários inseridos pelo usuário:</h4>";
         echo $obj->obs;
        echo "</p></div>";
    }
   
    echo "<div class='input-group input-group-lg pull-left w75' id='tipo_usuario'> <span class='input-group-addon'>Tipo de Usuário</span>". form::select('role[]',$roles,$roles_selecionadas, array('class' => 'form-control' , 'id' => 'roles' )) ."</div>";      
	echo "<div class='input-group input-group-lg w20 no_margin'> <span class='input-group-addon'>></span>". form::input('nascimento',site::data_BR($obj->nascimento), array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')"  )) ."</div>";	

    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('nome',$obj->nome, array( 'class' => 'form-control', 'maxlength' => '200', 'placeholder' => 'Nome completo' )) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('email',$obj->email, array('class' => 'form-control', 'maxlength' => '127', 'placeholder' => 'Email')) ."</div>";   
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('telefone',$obj->telefone, array('class' => 'form-control', 'maxlength' => '127', 'placeholder' => 'Telefone' )) ."</div>";  
    
    if($tipo!='sistema')
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Empresas</span>". form::select( 'lista_empresas[]', $empresas,$empresas_selecionadas, array('class' => 'form-control', 'data-placeholder' => 'Selecione as empresas', 'id' =>'empresas','multiple' => 'multiple')) ."</div>"; 
    echo "<br/>";
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>@</span>". form::input('username',$obj->username, array('class' => 'form-control', 'maxlength' => '32', 'placeholder' => 'Nome de usuário' )) ."</div>";  

    echo "<div class='input-group input-group-lg check_list'>";
    if($tipo=='pendente')
        echo "<label class='control checkbox'> ".form::checkbox('notificar_ativado',1, false )." <span class='checkbox-label'>Notificar automaticamente o usuário que seu perfil foi ativado.</span></label>";   
    echo "<label class='control checkbox'> ".form::checkbox('gerar_senha',1, ($obj->id!=NULL)?false:true )." <span class='checkbox-label'>Atribuir nova senha (selecionando esta opção a senha atual deste usuário será substituida)</span></label>";   
    echo "<label class='control checkbox'> ".form::checkbox('senha_aleatoria',1, ($obj->id!=NULL)?false:true )." <span  class='checkbox-label'>Gerar senha aleatóriamente (ignorará o campo abaixo).</span></label>";   
    echo "<label class='control checkbox'> ".form::checkbox('notificar_senha',1, false )." <span class='checkbox-label'>Notificar automaticamente o usuário que sua senha foi alterada.</span></label>";   
    echo "</div>";

    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>#</span>". form::input('password',null, array('class' => 'form-control', 'maxlength' => '8', 'placeholder' => 'Senha Cutomizada' )) ."</div>";      
	echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg' ));
	
	echo form::close();

    $validate = array(
        'nome'=>'Nome completo',
        'email' => array('Email','required|valid_email'),
        'nascimento' => 'Data de nascimento',     
        'username' => array('Nome de usuário','required|alpha_numeric')
    );

    if($tipo!='sistema')
        $validate['lista_empresas[]'] = 'Empresas';

    echo site::generateValidator($validate);

?>


<script>

 $(document).ready(function () {
        //$('.footable').footable();
        $('input[name="nascimento"]').datepicker({format:'dd/mm/yyyy'});  
        $("select#empresas").chosen({width: "100%"});     
});

</script>