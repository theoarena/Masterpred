<h1>		
	<?php echo html::anchor(site::segment(1)."/roles","< Voltar", array("class" => "label label-warning" )); ?>
</h1>
<h3>Cadastro <small>de Grupos de Acesso</small></h3>
<?php 
	
	echo form::open( site::segment(1)."/save_roles",array("id" => "form_edit" ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo form::hidden("id",$obj->id);	
    echo '<div class="alert alert-danger"><p>O NOME do grupo de acesso faz parte do funcionamento do sistema, não mude-o. O APELIDO é o campo mostrado no sistema, você pode alterá-lo como preferir.</p></div>';
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('name',$obj->name, array('class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Nome')) ."</div>";    
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('nickname',$obj->nickname, array('class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Apelido')) ."</div>";  	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon addon_textarea'>Descrição</span>". form::textarea('description',$obj->description,array('class' => 'form-control')) ."</div>"; 	
	
    if($obj->id != null)   
    {
       echo '<hr>';
       echo '<h2>Privilégios deste grupo de usuário</h2>';
       echo '<div class="alert alert-danger"><p>Os itens abaixo dizem respeito ao funcionamento interno do sistema. Não modifique seus dados a menos que você saiba o que está fazendo.</p></div>';
     
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
            echo "<div class='alert alert-warning tabela_vazia'>Nenhum privilégio encontrado</div>";
    }	
    echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg'));
    echo "</form>";
    echo site::generateValidator(array('name'=>'Nome'));
?>