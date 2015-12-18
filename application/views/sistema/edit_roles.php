<script src="<?php echo Site::mediaUrl(); ?>js/fast_search.js"></script>
<script type="text/javascript">
  
  $(function() {
        $('#txt_search').fastLiveFilter('#lista_roles',300);
    });
  
</script>
<?php 
	
	echo Form::open( Site::segment(1)."/save_roles",array("id" => "form_edit" ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo Form::hidden("id",$obj->id);	  
    echo '<div class="alert alert-danger"><p>'.Kohana::message('admin', 'roles_aviso_1').'</p></div>';
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('name',$obj->name, array('class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Nome') ) ."</div>";    
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('nickname',$obj->nickname, array('class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Apelido')) ."</div>";  	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon addon_textarea'>Descrição</span>". Form::textarea('description',$obj->description,array('class' => 'form-control')) ."</div>"; 	
	
  if($obj->name != 'admin')
  {
      if($obj->id != null)   
      {
         echo '<hr>';
         echo '<h2>Privilégios deste grupo de usuário</h2>';
         echo '<div class="alert alert-danger"><p>'.Kohana::message('admin', 'roles_aviso_2').'</p></div>';
         echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('search',null, array('id' => 'txt_search', 'class'=>'form-control', 'maxlength' => '150', 'placeholder' => 'Pesquise')) ."</div>";         
         echo '<ul class="list-group" id="lista_roles">';
         if( count($privileges) > 0) 
         {
             foreach ($privileges as $p) {          
                    
                    echo '<li class="list-group-item check_privileges">';
                      echo Form::checkbox('privileges[]', $p->id, array_key_exists($p->id,$privileges_selecionados));
                      echo '<h4>'.$p->apelido.'</h4><p>'.$p->description.'</p>';                     
                    echo '</li>';
             }
             echo '</ul>';
          }
          else
              echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'nenhum_item')."</div>";
       }	
    }
    echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn'));
    echo "</form>";
    echo Site::generateValidator(array('name'=>'Nome'));
?>