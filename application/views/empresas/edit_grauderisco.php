<h1>		
	<?php echo html::anchor(site::segment(1)."/grauderisco?".$query,"< Voltar", array("class" => "label label-warning" )); ?>
</h1>
<h1>Grau de risco</h1>

<?php 

    $equip = $obj->equipamentoinspecionado;	
    echo "<h2>Código: <span class='label label-primary'>".$obj->CodGR."</span></h2>";
    echo "<h2>GR do Cliente:  <span class='label label-primary'>".$obj->NumeroGR."</span></h2>";
    echo "<br/>";
    echo "<div id='left_grauderisco'>";   

    echo form::open( site::segment(1)."/save_grauderisco",array("id" => "form_edit", 'enctype' => 'multipart/form-data' ) );          
    echo form::hidden("CodGR",$obj->CodGR); 
    echo form::hidden("query",$query); 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Analista</span>". form::input('x',$equip->analista->Analista, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Área</span>". form::input('x',$equip->equipamento->setor->area->Area, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Setor</span>". form::input('x',$equip->equipamento->setor->Setor, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tag</span>". form::input('x',$equip->equipamento->Tag, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Equipamento</span>". form::input('x',$equip->equipamento->Equipamento, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tipo do equipamento</span>". form::input('x',$equip->equipamento->tipoequipamento->TipoEquipamento, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Data</span>". form::input('x',site::datahora_BR($equip->Data), array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
	echo "<br/>";
	
    echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Tipo do Componente</span>". form::select('TipoComponente',$componentes,$obj->TipoComponente, array('class' => 'form-control') ) ."</div>";        
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Componente',$obj->Componente, array('class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Componente')) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Detalhe',$obj->Detalhe, array('class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Detalhes' )) ."</div>"; 

    echo "<br/>";

    echo '<div class="well well-sm">';

    echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Inspeção</span>". form::select('TipoInspecao',$inspecoes,$obj->TipoInspecao, array('class' => 'form-control') ) ."</div>";                
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('GRReferencia',$obj->GRReferencia, array('class' => 'form-control', 'maxlength' => '11', 'placeholder' => 'GR Referência' )) ."</div>"; 

    echo '</div>';
   

    echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Tipo de Anomalia</span>". form::select('TipoAnomalia',$anomalias,$obj->TipoAnomalia, array('class' => 'form-control') ) ."</div>";        
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tecnologia</span>". form::input('x',$equip->tecnologia->Tecnologia, array ('class' => 'form-control', 'maxlength' => '100', 'placeholder' =>'Nome da rota', 'disabled' => 'disabled')) ."</div>";    
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Anomalia</span>". form::textarea('Anomalia',$obj->Anomalia, array('class' => 'form-control', 'placeholder' => 'Detalhes da Anomalia')) ."</div>"; 	

    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Recomendação</span>". form::textarea('Recomendacao',$obj->Recomendacao, array('class' => 'form-control', 'placeholder' => 'Recomendação')) ."</div>";     
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Observação</span>". form::textarea('Obs',$obj->Obs, array('class' => 'form-control', 'placeholder' =>'Observações')) ."</div>";  
    
    echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg'));       
    echo "</div>";

    echo "<div id='right_grauderisco'>";
    
    echo "<h3><span class='label label-info'>Grandezas Elétricas</span></h3>";
    echo '<div class="well well-sm" id="grandezas">';
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(R)</span>". form::input('Ir',$obj->Ir, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(S)</span>". form::input('Is',$obj->Is, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(T)</span>". form::input('It',$obj->It, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(N)</span>". form::input('In',$obj->In, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(R)</span>". form::input('Vr',$obj->Vr, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(S)</span>". form::input('Vs',$obj->Vs, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(T)</span>". form::input('Vt',$obj->Vt, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(N)</span>". form::input('Vn',$obj->Vn, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
    echo "</div>";
     echo "<h3><span class='label label-info'>Temperaturas</span></h3>";
    echo '<div class="well well-sm" id="temperaturas">';
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Temp.Ref</span>". form::input('TemperaturaRef',$obj->TemperaturaRef, array('class' => 'form-control temperaturas', 'maxlength' => '10')) ."<span class='input-group-addon'>°C</span></div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Temp.Med</span>". form::input('TemperaturaMed',$obj->TemperaturaMed, array('class' => 'form-control temperaturas', 'maxlength' => '10')) ."<span class='input-group-addon'>°C</span></div>";         
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Delta</span>". form::input('x',"x", array ('class' => 'form-control', 'disabled' => 'disabled') ) ."<span class='input-group-addon'>°C</span></div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Carga(%)</span>". form::input('x',"x", array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "</div>";
    echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Condição</span>". form::select('Condicao', array($condicao->CodCondicao => $condicao->Condicao ) ,$equip->Condicao, array('class' => 'form-control', 'disabled' => 'disabled')) ."</div>";        

    echo "<br/>";

    $base = URL::base().Kohana::$config->load('config')->get('upload_directory_gr');

    echo "<h3><span class='label label-info'>Imagem Real</span></h3>";
    echo '<div class="well well-sm" id="temperaturas">';
        echo form::file('ImagemReal',array('class' => 'form-control upload'));
         if($obj->ImagemReal!=null)
            echo '<img src="'.$base.$obj->ImagemReal.'" width="50%" />';
    echo "</div>";

    echo "<h3><span class='label label-info'>Imagem Térmica</span></h3>";
    echo '<div class="well well-sm" id="temperaturas">';       
        echo form::file('ImagemTermica',array('class' => 'form-control upload'));
         if($obj->ImagemTermica!=null)
            echo '<img src="'.$base.$obj->ImagemTermica.'" width="50%" />';
    echo "</div>";

    echo "</div>";



	echo form::close();
  
?>


<script>

var validator = new FormValidator('form_edit', [{
    name: 'Rota',
    display: 'Rota',    
    rules: 'required'
}], function(errors, event) {
   
    var SELECTOR_ERRORS = $('#box_error');        
       
    if (errors.length > 0) {
        SELECTOR_ERRORS.empty();
        
        for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
            SELECTOR_ERRORS.append(errors[i].message + '<br />');
        }        
     
        SELECTOR_ERRORS.fadeIn(200);
        return false;
    }

    return true;
      
    event.preventDefault()
});

validator.setMessage('required', 'O campo "%s" é obrigatório.');

</script>