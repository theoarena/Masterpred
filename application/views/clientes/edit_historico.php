<h1>        
<h1 id="btn_adicionar">     
    <?php echo html::anchor(site::segment(1)."/historico","< Voltar", array("class" => "label label-warning" )); ?>
     <?php echo html::anchor(site::segment(1)."/resultado_historico/".$obj->resultado->CodResultado."?gr=".$obj->CodGR,"Resultados", array("class" => "label label-primary" )); ?>
     <?php echo html::anchor("relatorios/empresa_resultado/".$obj->resultado->CodResultado,"Imprimir", array("class" => "label label-info" )); ?>            
     
</h1>


<h1>Grau de risco</h1>

<?php 
    $equip = $obj->equipamentoinspecionado;	
    echo "<h2>Código: <span class='label label-primary'>".$obj->CodGR."</span></h2>";
    echo "<h2>GR:  <span class='label label-primary'>".$obj->NumeroGR."</span></h2>";
    echo "<br/>";
    echo "<div id='left_grauderisco'>";   
 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Analista</span>". form::input('x',$equip->analista->Analista, array('class' => 'form-control', 'disabled' => 'disabled')) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Área</span>". form::input('x',$equip->equipamento->setor->area->Area,array('class' => 'form-control', 'disabled' => 'disabled')) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Setor</span>". form::input('x',$equip->equipamento->setor->Setor,array('class' => 'form-control', 'disabled' => 'disabled')) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tag</span>". form::input('x',$equip->equipamento->Tag,array('class' => 'form-control', 'disabled' => 'disabled')) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Equipamento</span>". form::input('x',$equip->equipamento->Equipamento,array('class' => 'form-control', 'disabled' => 'disabled')) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tipo do equipamento</span>". form::input('x',$equip->equipamento->tipoequipamento->TipoEquipamento,array('class' => 'form-control', 'disabled' => 'disabled')) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Data</span>". form::input('x',site::datahora_BR($equip->Data),array('class' => 'form-control', 'disabled' => 'disabled')) ."</div>"; 
	echo "<br/>";
	
    echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Tipo do Componente</span>". form::input('TipoComponente', $obj->componente->Componente,array('class' => 'form-control', 'disabled' => 'disabled')) ."</div>";        
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Componente',$obj->Componente, array('class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Componente', 'disabled' =>'disabled')) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Detalhe',$obj->Detalhe,array('class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Detalhes', 'disabled' =>'disabled')) ."</div>"; 

    echo "<br/>";

    echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Inspeção</span>". form::input('TipoInspecao',$obj->tipoinspecao->TipoInspecao,array('class' => 'form-control', 'disabled' => 'disabled')) ."</div>";                
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('GRReferencia',$obj->GRReferencia,array('class' => 'form-control', 'maxlength' => '11', 'placeholder' => 'GR Referência', 'disabled' =>'disabled')) ."</div>"; 
    echo "<br/>";
    echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Tipo de Anomalia</span>". form::input('TipoAnomalia',$obj->anomalia->Anomalia,array('class' => 'form-control', 'disabled' => 'disabled')) ."</div>";        
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tecnologia</span>". form::input('x',$equip->tecnologia->Tecnologia,array('class' => 'form-control', 'maxlength' => '100', 'placeholder' => 'Nome da Rota', 'disabled' =>'disabled')) ."</div>";    
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Anomalia</span>". form::textarea('Anomalia',$obj->Anomalia, array('class' => 'form-control', 'placeholder' => 'Detalhes da Anomalia', 'disabled' => 'disabled' )) ."</div>"; 	

    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Recomendação</span>". form::textarea('Recomendacao',$obj->Recomendacao,array('class' => 'form-control', 'placeholder' => 'Recomendação', 'disabled' => 'disabled' )) ."</div>";     
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Observação</span>". form::textarea('Obs',$obj->Obs,array('class' => 'form-control', 'placeholder' => 'Observações', 'disabled' => 'disabled' )) ."</div>";  
        
    echo "</div>";

    echo "<div id='right_grauderisco'>";
    
    echo "<h3><span class='label label-info'>Grandezas Elétricas</span></h3>";
    echo '<div id="grandezas">';
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(R)</span>". form::input('Ir',$obj->Ir,array('class' => 'form-control grandezas', 'maxlength' => '10', 'disabled' => 'disabled')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(S)</span>". form::input('Is',$obj->Is,array('class' => 'form-control grandezas', 'maxlength' => '10', 'disabled' => 'disabled')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(T)</span>". form::input('It',$obj->It,array('class' => 'form-control grandezas', 'maxlength' => '10', 'disabled' => 'disabled')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(N)</span>". form::input('In',$obj->In,array('class' => 'form-control grandezas', 'maxlength' => '10', 'disabled' => 'disabled')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(R)</span>". form::input('Vr',$obj->Vr,array('class' => 'form-control grandezas', 'maxlength' => '10', 'disabled' => 'disabled')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(S)</span>". form::input('Vs',$obj->Vs,array('class' => 'form-control grandezas', 'maxlength' => '10', 'disabled' => 'disabled')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(T)</span>". form::input('Vt',$obj->Vt,array('class' => 'form-control grandezas', 'maxlength' => '10', 'disabled' => 'disabled')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(N)</span>". form::input('Vn',$obj->Vn,array('class' => 'form-control grandezas', 'maxlength' => '10', 'disabled' => 'disabled')) ."</div>"; 
    echo "</div>";
     echo "<h3><span class='label label-info'>Temperaturas</span></h3>";
    echo '<div id="temperaturas">';
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Temp.Ref</span>". form::input('TemperaturaRef',$obj->TemperaturaRef, array('class' => 'form-control temperaturas', 'maxlength' => '10', 'disabled' => 'disabled')) ."<span class='input-group-addon'>°C</span></div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Temp.Med</span>". form::input('TemperaturaMed',$obj->TemperaturaMed, array('class' => 'form-control temperaturas', 'maxlength' => '10', 'disabled' => 'disabled')) ."<span class='input-group-addon'>°C</span></div>";         
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Delta</span>". form::input('x',"x",array('class' => 'form-control', 'disabled' => 'disabled')) ."<span class='input-group-addon'>°C</span></div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Carga(%)</span>". form::input('x',"x",array('class' => 'form-control', 'disabled' => 'disabled')) ."</div>"; 
    echo "</div>";
    echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Condição</span>". form::input('Condicao',$equip->condicao->Condicao,array('class' => 'form-control', 'disabled' => 'disabled')) ."</div>";        

     $base = URL::base().Kohana::$config->load('config')->get('upload_directory_gr');

    echo "<br/>";
    echo "<h3><span class='label label-info'>Imagem Real</span></h3>";
    echo '<div class="well well-sm" id="temperaturas">';       
         if($obj->ImagemReal!=null)
            echo '<img src="'.$base.$obj->ImagemReal.'" width="50%"/>';
    echo "</div>";

    echo "<h3><span class='label label-info'>Imagem Térmica</span></h3>";
    echo '<div class="well well-sm" id="temperaturas">';
         if($obj->ImagemTermica!=null)
            echo '<img src="'.$base.$obj->ImagemTermica.'" width="50%" />';
    echo "</div>";

    echo "</div>";  
?>