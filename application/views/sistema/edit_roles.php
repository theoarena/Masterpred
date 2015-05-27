<h3>Cadastro <small>de Grupos de Acesso</small></h3>
<?php 
	
	echo form::open( site::segment(1)."/save_roles",array("id" => "form_edit" ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo form::hidden("id",$obj->id);	  
    echo '<div class="alert alert-danger"><p>'.Kohana::message('admin', 'roles_aviso_1').'</p></div>';
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('name',$obj->name, array('class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Nome')) ."</div>";    
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('nickname',$obj->nickname, array('class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Apelido')) ."</div>";  	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon addon_textarea'>Descrição</span>". form::textarea('description',$obj->description,array('class' => 'form-control')) ."</div>"; 	
	
    if($obj->id != null)   
    {
       echo '<hr>';
       echo '<h2>Privilégios deste grupo de usuário</h2>';
       echo '<div class="alert alert-danger"><p>'.Kohana::message('admin', 'roles_aviso_2').'</p></div>';
     
       echo '<ul class="list-group">';
       if( count($privileges) > 0) 
       {
           foreach ($privileges as $p) {          
                  
                  echo '<li class="list-group-item check_privileges">';
                    echo form::checkbox('privileges[]', $p->id, array_key_exists($p->id,$privileges_selecionados));
                    echo '<h4>'.$p->apelido.'</h4><p>'.$p->description.'</p>';                     
                  echo '</li>';
           }
           echo '</ul>';
        }
        else
            echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'nenhum_item')."</div>";
    }	
    echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg'));
    echo "</form>";
    echo site::generateValidator(array('name'=>'Nome'));
?>