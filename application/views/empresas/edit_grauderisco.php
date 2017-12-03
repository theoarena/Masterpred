<?php 

    $equip = $obj->equipamentoinspecionado;	
    echo "<h2>Código: <span class='label label-primary'>".$obj->CodGR."</span></h2>";
    echo "<h2>GR do Cliente:  <span class='label label-primary'>".$obj->NumeroGR."</span></h2>";
    echo "<br/>";
    echo "<div id='left_grauderisco'>";   

    echo Form::open( Site::segment(1)."/save_grauderisco",array("id" => "form_edit", 'enctype' => 'multipart/form-data' ) );          
    echo Form::hidden("CodGR",$obj->CodGR); 
    echo Form::hidden("query",$query); 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Analista</span>". Form::input('x',$equip->analista->Analista, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Área</span>". Form::input('x',$equip->equipamento->setor->area->Area, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Setor</span>". Form::input('x',$equip->equipamento->setor->Setor, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tag</span>". Form::input('x',$equip->equipamento->Tag, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Equipamento</span>". Form::input('x',$equip->equipamento->Equipamento, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tipo do equipamento</span>". Form::input('x',$equip->equipamento->tipoequipamento->TipoEquipamento, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Data</span>". Form::input('x',Site::datahora_BR($equip->Data), array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
	echo "<br/>";
	
    echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Tipo do Componente</span>". Form::select('TipoComponente',$componentes,$obj->TipoComponente, array('class' => 'form-control') ) ."</div>";        
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Componente',$obj->Componente, array('class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Componente')) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Detalhe',$obj->Detalhe, array('class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Detalhes' )) ."</div>"; 

    echo "<br/>";

    echo '<div class="well well-sm">';

    echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Inspeção</span>". Form::select('TipoInspecao',$inspecoes,$obj->TipoInspecao, array('class' => 'form-control') ) ."</div>";                
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('GRReferencia', $obj->GRReferencia , array('class' => 'form-control', 'maxlength' => '11', 'placeholder' => 'GR Referência' )) . "</div>";

    
    echo "<div class='input-group input-group-lg'> <button class='btn_picker label-warning btn' id='btn_gr_referencia'>Buscar</button> </div>";
    echo '</div>';
   

    echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Tipo de Anomalia</span>". Form::select('TipoAnomalia',$anomalias,$obj->TipoAnomalia, array('class' => 'form-control') ) ."</div>";        
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Anomalia</span>". Form::textarea('Anomalia',$obj->Anomalia, array('class' => 'form-control', 'placeholder' => 'Detalhes da Anomalia')) ."</div>"; 	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tecnologia</span>". Form::input('x',$equip->tecnologia->Tecnologia, array ('class' => 'form-control', 'maxlength' => '100', 'placeholder' =>'Nome da rota', 'disabled' => 'disabled')) ."</div>";    

    echo "<div id='qtd1' class='limite_caracteres'><b>".(250-( strlen($obj->Recomendacao) ) )." Caracteres Restantes</b></div>";
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Recomendação</span>". Form::textarea('Recomendacao',$obj->Recomendacao, array('class' => 'form-control', 'placeholder' => 'Recomendação','id' => 'recomendacao', 'onfocus' => 'limitarTamanho(250,this.id)' , 'onkeyup' => 'contar(this,250,\'qtd1\')') ) ."</div>";     
    echo "<div id='qtd2' class='limite_caracteres'><b>".(250-( strlen($obj->Obs) ) )." Caracteres Restantes</b></div>";
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Observação</span>". Form::textarea('Obs',$obj->Obs, array('class' => 'form-control', 'placeholder' =>'Observações', 'id' => 'obs','onfocus' => 'limitarTamanho(250,this.id)' , 'onkeyup' => 'contar(this,250,\'qtd2\')') ) ."</div>";  
    
    echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn'));       
    echo "</div>";

    echo "<div id='right_grauderisco'>";
    
    echo "<h3><span class='label label-info'>Grandezas Elétricas</span></h3>";
    echo '<div class="well well-sm" id="grandezas">';
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(R)</span>". Form::input('Ir',$obj->Ir, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(R)</span>". Form::input('Vr',$obj->Vr, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(S)</span>". Form::input('Is',$obj->Is, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(S)</span>". Form::input('Vs',$obj->Vs, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(T)</span>". Form::input('It',$obj->It, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(T)</span>". Form::input('Vt',$obj->Vt, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(N)</span>". Form::input('In',$obj->In, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(N)</span>". Form::input('Vn',$obj->Vn, array('class' => 'form-control grandezas', 'maxlength' => '10')) ."</div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Carga(%)</span>". Form::input('carga',null, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."</div>"; 
    echo "</div>";
     echo "<h3><span class='label label-info'>Temperaturas</span></h3>";
    echo '<div class="well well-sm" id="temperaturas">';
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Temp.Med</span>". Form::input('TemperaturaMed',$obj->TemperaturaMed, array('class' => 'form-control temperaturas', 'maxlength' => '10')) ."<span class='input-group-addon'>°C</span></div>";         
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Temp.Med Cor</span>". Form::input('TemperaturaMedCor',null, array('class' => 'form-control temperaturas', 'disabled' => 'disabled')) ."<span class='input-group-addon'>°C</span></div>";         
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Temp.Ref</span>". Form::input('TemperaturaRef',$obj->TemperaturaRef, array('class' => 'form-control temperaturas', 'maxlength' => '10')) ."<span class='input-group-addon'>°C</span></div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Temp.Ref Cor</span>". Form::input('TemperaturaRefCor',null, array('class' => 'form-control temperaturas', 'disabled' => 'disabled')) ."<span class='input-group-addon'>°C</span></div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Delta</span>". Form::input('delta',null, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."<span class='input-group-addon'>°C</span></div>"; 
        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Delta Temp. Cor</span>". Form::input('deltacor',null, array ('class' => 'form-control', 'disabled' => 'disabled') ) ."<span class='input-group-addon'>°C</span></div>"; 
    echo "</div>";
    echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Condição</span>". Form::select('Condicao', $condicoes ,$equip->Condicao, array('class' => 'form-control')) ."</div>";        

    echo "<br/>";

    $base = URL::base().Kohana::$config->load('config')->get('upload_directory_gr');

    echo "<h3><span class='label label-info'>Imagem Real</span></h3>";
    echo '<div class="well well-sm" id="temperaturas">';
        echo Form::file('ImagemReal',array('class' => 'form-control upload'));
         if($obj->ImagemReal!=null)
            echo '<img src="'.$base.$obj->ImagemReal.'" width="50%" />';
    echo "</div>";

    echo "<h3><span class='label label-info'>Imagem Térmica</span></h3>";
    echo '<div class="well well-sm" id="temperaturas">';       
        echo Form::file('ImagemTermica',array('class' => 'form-control upload'));
         if($obj->ImagemTermica!=null)
            echo '<img src="'.$base.$obj->ImagemTermica.'" width="50%" />';
    echo "</div>";

    echo "</div>";

	echo Form::close();
    echo Site::generateValidator(array('Rota'=>'Rota'));
?>

<script type="text/javascript">
    
    $(document).ready(function(){
        changeValores();
        $('div#grandezas input,div#temperaturas input').change(function(){ changeValores() });
        //  $('input[name=TemperaturaRef],input[name=TemperaturaMed]').change(function(){ changeValores() });

        $('#btn_gr_referencia').click(function(e){
            $.fancybox.open(
            {
                href: '<?php echo Site::baseUrl() ?>requests/grReferencia/?equipamento=<?php echo $equip->equipamento->CodEquipamento; ?>&componente=<?php echo $obj->TipoComponente; ?>&data=<?php echo Site::datahora_EN($equip->Data); ?>&empresa=<?php echo Usuario::get_empresaatual(); ?>',
                type: 'ajax',
                title: 'Selecione a GR',
                padding:20
            });           
            e.preventDefault();
        });

    });

    function changeValores()
    {
       
        var IR = moeda2float($('input[name=Ir]').val());
        var IS = moeda2float($('input[name=Is]').val());
        var IT = moeda2float($('input[name=It]').val());
        var IN = moeda2float($('input[name=In]').val());
        var TEMPMED =  moeda2float($('input[name=TemperaturaMed]').val());
        var TEMPREF =  moeda2float($('input[name=TemperaturaRef]').val());

        var carga  = ( ( ( ( (IR + IS) + IT ) / 3 ) * 100 ) / IN) ;
        var delta =  TEMPMED - TEMPREF;
        var deltacor = ( ( TEMPREF - TEMPMED ) * 100 ) / ( ( carga*(100) ) /carga ) ;
        var medcor = ( ( (TEMPMED * 100) / (carga*100) ) / carga );
        var refcor = ( ( (TEMPREF * 100) / (carga*100) ) / carga );
        
        $('input[name=carga]').val(carga.toPrecision(5));
        $('input[name=deltacor]').val(deltacor.toPrecision(5));
        $('input[name=delta]').val(delta.toPrecision(5));
        $('input[name=TemperaturaMedCor]').val(medcor.toPrecision(5));
        $('input[name=TemperaturaRefCor]').val(refcor.toPrecision(5));
    }

</script>
