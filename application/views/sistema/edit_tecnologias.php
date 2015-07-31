<?php 
	
	echo form::open( "sistema/save_tecnologias",array("id" => "form_edit" ) );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo form::hidden("CodTecnologia",$obj->CodTecnologia);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Tecnologia',$obj->Tecnologia,array('class'=>'form-control', 'maxlength' => '100', 'placeholder' => 'Nome da Tecnologia')) ."</div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Id',$obj->Id,array('class'=>'form-control', 'maxlength' => '5', 'placeholder' => 'Id'))."</div>";		

	
	echo form::submit('submit', "Salvar",array('class' => 'btn btn-primary btn'));
	
	echo "</form>";
	echo site::generateValidator(array('Tecnologia'=>'Tecnologia','Id'=>'Id'));

?>

<br/>

<div class="panel panel-primary panel_tecnologia" id='componentes_relacionados'>
  <div class="panel-heading"><h3>Componentes Relacionados</h3></div>
  <div class="panel-body">
   <div class="list-group"> 
	<?php 

		if(count($obj->componentes->find_all()) > 0)
			foreach($obj->componentes->find_all() as $c)		
				echo '<a href="#" class="list-group-item">'.$c->Componente.'</a>';
		else
			echo "<h4>Nenhum componente.</h4>";

	?>
	</div>
  </div>
</div>

<div class="panel panel-danger panel_tecnologia" id='anomalias_relacionados'>
  <div class="panel-heading"><h3>Anomalias Relacionadas</h3></div>
  <div class="panel-body">
   <div class="list-group"> 
	<?php 

		if(count($obj->anomalias->find_all() ) > 0)
			foreach($obj->anomalias->find_all()  as $c)		
				echo '<a href="#" class="list-group-item">'.$c->Anomalia.'</a>';
		else
			echo "<h4>Nenhuma Anomalia.</h4>";

	?>
	</div>
  </div>
</div>

<div class="panel panel-success panel_tecnologia" id='recomendacoes_relacionados'>
  <div class="panel-heading"><h3>Recomendações desta Tecnologia</h3></div>
  <div class="panel-body">
   <div class="list-group"> 
	<?php 

		if(count($obj->recomendacoes->find_all()) > 0)
			foreach($obj->recomendacoes->find_all() as $c)		
				echo '<a href="#" class="list-group-item">'.$c->Recomendacao.'</a>';
		else
			echo "<h4>Nenhuma Recomendação.</h4>";

	?>
	</div>
  </div>
</div>