<script src="<?php echo site::mediaUrl(); ?>js/slide.js"></script>

<?php 
	    
	echo form::open( site::segment(1)."/save_analiseinspecao",array("id" => "form_edit") );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo form::hidden("CodEquipamentoInspAnalise",$obj->CodEquipamentoInspAnalise);	

    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tipo do Componente</span>". form::select('TipoComponente',$componentes,($obj->TipoComponente!=null)?($obj->TipoComponente):0, array('class' => 'form-control') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Componente',$obj->Componente, array('class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Componente')) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Detalhe',$obj->Detalhe, array('class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Detalhes')) ."</div>"; 
    echo "<div class='margin_5'></div>";    
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tipo da Anomalia</span>". form::select('TipoAnomalia',$anomalias,($obj->TipoAnomalia!=null)?$obj->TipoAnomalia:0, array('class' => 'form-control')) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon addon_textarea'>Anomalia</span>". form::textarea('Anomalia',$obj->Anomalia, array('class' => 'form-control', 'placeholder' => 'Detalhes da anomalia' )) ."</div>"; 
    echo "<div class='margin_5'></div>";    
    echo '<div class="btn-group btn-group-lg"><button type="button" class="btn btn-primary btn_switch" id="buscar_recomendacoes">Buscar recomendações</button></div>';
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon addon_textarea'>Recomendação</span>". form::textarea('Recomendacao',$obj->Recomendacao, array('id' => 'Recomendacao','class' => 'form-control', 'placeholder' => 'Digite para buscar uma recomendação')) ."</div>";     
    echo "<div class='margin_5'></div>";    
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon addon_textarea'>Observações</span>". form::textarea('Obs',$obj->Obs, array('class' => 'form-control', 'placeholder' => 'Observações desta análise')) ."</div>"; 
	echo "<div class='margin_5'></div>";    

    echo "<section>";
    echo '<div class="panel panel-primary" id="list_areas">';
        echo '<div class="panel-heading"><h4>Grandezas Elétricas</h4></div>';
        echo '<div class="panel-body" id="grandezas">';
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(R)</span>". form::input('Ir',$obj->Ir, array('class' => 'form-control grandezas', 'maxlength' => '10') ) ."</div>"; 
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(S)</span>". form::input('Is',$obj->Is, array('class' => 'form-control grandezas', 'maxlength' => '10') ) ."</div>"; 
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(T)</span>". form::input('It',$obj->It, array('class' => 'form-control grandezas', 'maxlength' => '10') ) ."</div>"; 
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>I(N)</span>". form::input('In',$obj->In, array('class' => 'form-control grandezas', 'maxlength' => '10') ) ."</div>"; 
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(R)</span>". form::input('Vr',$obj->Vr, array('class' => 'form-control grandezas', 'maxlength' => '10') ) ."</div>"; 
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(S)</span>". form::input('Vs',$obj->Vs, array('class' => 'form-control grandezas', 'maxlength' => '10') ) ."</div>"; 
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(T)</span>". form::input('Vt',$obj->Vt, array('class' => 'form-control grandezas', 'maxlength' => '10') ) ."</div>"; 
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>V(N)</span>". form::input('Vn',$obj->Vn, array('class' => 'form-control grandezas', 'maxlength' => '10') ) ."</div>"; 
        echo '</div>';
    echo '</div>';

    echo '<div class="panel panel-primary" id="list_setores">';
        echo '<div class="panel-heading"><h4>Temperaturas</h4></div>';
        echo '<div class="panel-body">';
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Temp.Ref</span>". form::input('TemperaturaRef',$obj->TemperaturaRef, array('class' => 'form-control temperaturas', 'maxlength' => '10' )) ."<span class='input-group-addon'>°C</span></div>"; 
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Temp.Med</span>". form::input('TemperaturaMed',$obj->TemperaturaMed, array('class' => 'form-control temperaturas', 'maxlength' => '10' )) ."<span class='input-group-addon'>°C</span></div>";         
        echo '</div>';
    echo '</div>';
    echo "<div class='cb'></div>";
    echo "</section>";
	echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn'));       
	echo form::close();
    echo site::generateValidator(array('Data'=>'Data'));
?>


    <aside id='lista_recomendacoes'>
        <div class="btn-group btn-group-lg"><button type="button" class="btn btn-primary btn_switch" id="btn_voltar_rec">Voltar para o formulário</button></div>
        <h3>Selecione uma recomendação abaixo</h3>
        <?php 
            if(count($recomendacoes) > 0)
            {                
                echo  '<ul class="list-group">';
                foreach ($recomendacoes as $k => $v)                   
                    echo  '<a href="javascript:void(0)" id="rec_'.$k.'" onclick="setrecomendacao('.$k.')" class="list-group-item" >'.$v.'</a>';                                         
                echo '</ul>';
            }
        ?>
    </aside>

<script>

$(".btn_switch").click(function(){
   muda();
});

function setrecomendacao(id)
{
   $("#Recomendacao").val($("#rec_"+id).text());  
   muda();
}

function muda()
{
  $( "#form_edit" ).toggle( "slide" );
  $( "#btn_voltar" ).fadeToggle();
  $( "#list > h1" ).fadeToggle();
  $( "#list > h3" ).fadeToggle();     
  $( "#lista_recomendacoes" ).fadeToggle();    
}

</script>