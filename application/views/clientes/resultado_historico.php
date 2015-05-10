<link href="<?php echo site::mediaUrl(); ?>css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo site::mediaUrl(); ?>js/datepicker.js"></script>
<script src="<?php echo site::mediaUrl(); ?>js/money.js"></script>

<h1>		
	<?php echo html::anchor(site::segment(1)."/edit_historico/".Arr::get($_GET, "gr"),"< Voltar", array("class" => "label label-warning" )); ?>
</h1>
<h1>Avaliação de resultados</h1>

<?php     
    echo "<h2>Ordem de serviço: <span class='label label-primary'>".((!$obj->GR)?(Arr::get($_GET, "gr")):($obj->GR))."</span></h2>";    
    echo "<br>";
    echo form::open( site::segment(1)."/save_resultado",array("id" => "form_edit" ) );          
    echo form::hidden("GR",Arr::get($_GET, "gr")); 
    echo form::hidden("CodResultado",$obj->CodResultado); 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('CodCliente',$obj->CodCliente, array('class' => 'form-control', 'placeholder' => 'Código da ordem gerada internamente')) ."</div>"; 
    echo "<br>";
  
      
    echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>Data de Planejamento</span>". form::input('DataPlanejamento',site::datahora_BR($obj->DataPlanejamento), array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" ,'placeholder' => 'Data')) ."</div>";   
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('RespPlanejamento',$obj->RespPlanejamento, array('class' => 'form-control', 'placeholder' => 'Responsável')) ."</div>"; 
    echo "<br>";
    echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>Data da Corretiva</span>". form::input('DataCorretiva',site::datahora_BR($obj->DataCorretiva), array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')", 'placeholder' => 'Data')) ."</div>";   
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('RespCorretiva',$obj->RespCorretiva, array('class' => 'form-control', 'placeholder' => 'Responsável')) ."</div>"; 
    echo "<br>";
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::textarea('Obs',$obj->Obs, array('class' => 'form-control', 'placeholder' => 'Ações')) ."</div>"; 

    echo "<div id='block_historico'>";     
        echo "<h3><span class='label label-info'>Manutenção Preditiva</span></h3>";
        echo '<div class="well well-sm" >';            
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Mão de Obra (h)</span>". form::input('PreMOHora',$obj->PreMOHora,  array('class' => 'form-control', 'placeholder' => 'Quantidade')). form::input('PreMOPreco',$PreMOPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Serv. Terceirizado (h)</span>". form::input('PredTercHora',$obj->PredTercHora, array('class' => 'form-control', 'placeholder' => 'Quantidade')). form::input('PredTercPreco',$PredTercPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Material Reparo($)</span>". form::input('PredMatPreco',$PredMatPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Produção (h)</span>". form::input('PreProdHora',$obj->PreProdHora, array('class' => 'form-control', 'placeholder' => 'Quantidade')). form::input('PreProdPreco',$PreProdPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                               
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Outros</span>". form::input('PredOutrPreco',$PredOutrPreco, array('class' => 'form-control  valor', 'placeholder' => 'Valor($)'))."</div>";                                   
        echo "</div>";    
    echo "</div>";

    echo "<div id='block_historico'>";       
        echo "<h3><span class='label label-info'>Manutenção Convencional</span></h3>";
        echo '<div class="well well-sm" >';            
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Mão de Obra (h)</span>". form::input('ConvMOHora',$obj->ConvMOHora, array('class' => 'form-control', 'placeholder' => 'Quantidade')). form::input('ConvMOPreco',$ConvMOPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Serv. Terceirizado (h)</span>". form::input('ConvTercHora',$obj->ConvTercHora, array('class' => 'form-control', 'placeholder' => 'Quantidade')). form::input('ConvTercPreco',$ConvTercPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Material Reparo($)</span>". form::input('ConvMatPreco',$ConvMatPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Produção (h)</span>". form::input('ConvProdHora',$obj->ConvProdHora, array('class' => 'form-control', 'placeholder' => 'Quantidade')). form::input('ConvProdPreco',$ConvProdPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                               
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Outros</span>". form::input('ConvOutrPreco',$ConvOutrPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
        echo "</div>";
    echo "</div>";

    echo "<div id='block_historico'>";     
        echo "<h3><span class='label label-info'>Retorno de Investimento</span></h3>";
        echo '<div class="well well-sm" >';   
                 
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Mão de Obra (h)</span>". form::input('total_1',null, array('class' => 'form-control', 'placeholder' => 'Valor(R$)' ,'disabled' => 'disabled'))."</div>";                                   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Serv. Terceirizado (h)</span>". form::input('total_2',null, array('class' => 'form-control', 'placeholder' => 'Valor(R$)' ,'disabled' => 'disabled'))."</div>";                                   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Material Reparo($)</span>". form::input('total_3',null, array('class' => 'form-control', 'placeholder' => 'Valor(R$)' ,'disabled' => 'disabled'))."</div>";                                   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Produção (h)</span>". form::input('total_4',null, array('class' => 'form-control', 'placeholder' => 'Valor(R$)' ,'disabled' => 'disabled'))."</div>";                                               
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Outros</span>". form::input('total_5',null, array('class' => 'form-control', 'placeholder' => 'Valor(R$)' ,'disabled' => 'disabled'))."</div>";                                   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'><strong>Total(R$)</strong></span>". form::input('Total',null, array('class' => 'form-control valorfinal', 'placeholder' => 'Valor(R$)' ,'disabled' => 'disabled'))."</div>";                                   
        echo "</div>";    
    echo "</div>";

    echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>Data de Finalização</span>". form::input('DataFinalizacao',site::datahora_BR($obj->DataFinalizacao), array('class' => 'form-control' , 'onkeypress' => "return mask(event,this,'##/##/####')"  ,'placeholder' => 'Data')) ."</div>";   
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('RespFinalizacao',$obj->RespFinalizacao, array('class' => 'form-control', 'placeholder' => 'Responsável')) ."</div>"; 
  
    echo form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg'));  

	echo form::close();
  
?>


<script type="text/javascript">

    $(document).ready(function () {
        //$('.footable').footable();
        $('input[name="DataPlanejamento"]').datepicker({format:'dd/mm/yyyy'});
        $('input[name="DataCorretiva"]').datepicker({format:'dd/mm/yyyy'});
        $('input[name="DataFinalizacao"]').datepicker({format:'dd/mm/yyyy'});     

        $('.valor').priceFormat({prefix: 'R$ ', centsSeparator: ',', thousandsSeparator: '.', allowNegative: true});

        
    });

    $(window).load(function(){
        $("input[name='PreMOHora']" ).trigger("change");
        $("input[name='ConvTercHora']" ).trigger("change");
        $("input[name='PredMatPreco']" ).trigger("change");
        $("input[name='PreProdHora']" ).trigger("change");
        $("input[name='PredOutrPreco']" ).trigger("change");
    });

    $(document).ready(function(){

        $("input[name='PreMOHora'],input[name='PreMOPreco'],input[name='ConvMOPreco'],input[name='ConvMOHora']" ).change(function() {  

            v2 = $("input[name='ConvMOPreco']").unmask();
            q2 = $("input[name='ConvMOHora']").val();

            v1 = $("input[name='PreMOPreco']").unmask();
            q1 = $("input[name='PreMOHora']").val();
           
            $("input[name='total_1']").val( (q2*v2)-(q1*v1) );                     
            $("input[name='total_1']").priceFormat({prefix: 'R$ ', centsSeparator: ',', thousandsSeparator: '.', allowNegative: true});  
             atualizaTotal();
        });

        $("input[name='ConvTercHora'],input[name='ConvTercPreco'],input[name='PredTercHora'],input[name='PredTercPreco']" ).change(function() {  

            v2 = $("input[name='ConvTercHora']").val();
            q2 = $("input[name='ConvTercPreco']").unmask();

            v1 = $("input[name='PredTercHora']").val();
            q1 = $("input[name='PredTercPreco']").unmask();

            $("input[name='total_2']").val( (q2*v2)-(q1*v1) );  
            $("input[name='total_2']").priceFormat({prefix: 'R$ ', centsSeparator: ',', thousandsSeparator: '.', allowNegative: true});    
             atualizaTotal();
        });
       

         $("input[name='PredMatPreco'],input[name='ConvMatPreco']" ).change(function() {  

            v1 = $("input[name='PredMatPreco']").unmask();        

            v2 = $("input[name='ConvMatPreco']").unmask();
          

            $("input[name='total_3']").val( v2-v1 );   
            $("input[name='total_3']").priceFormat({prefix: 'R$ ', centsSeparator: ',', thousandsSeparator: '.', allowNegative: true});   
             atualizaTotal();
        });
         
          $("input[name='PreProdHora'],input[name='PreProdPreco'],input[name='ConvProdHora'],input[name='ConvProdPreco']" ).change(function() {  

            v2 = $("input[name='ConvProdPreco']").unmask();
            q2 = $("input[name='ConvProdHora']").val();

            v1 = $("input[name='PreProdPreco']").unmask();
            q1 = $("input[name='PreProdHora']").val();

            $("input[name='total_4']").val( (q2*v2)-(q1*v1) );   
            $("input[name='total_4']").priceFormat({prefix: 'R$ ', centsSeparator: ',', thousandsSeparator: '.', allowNegative: true});   
             atualizaTotal();
        });

         $("input[name='PredOutrPreco'],input[name='ConvOutrPreco']" ).change(function() {  

            v1 = $("input[name='PredOutrPreco']").unmask();
            v2 = $("input[name='ConvOutrPreco']").unmask();

            $("input[name='total_5']").val( v2-v1 );  
            $("input[name='total_5']").priceFormat({prefix: 'R$ ', centsSeparator: ',', thousandsSeparator: '.', allowNegative: true});  
            atualizaTotal();
        });

        function atualizaTotal(){
            
            v1 = $("input[name='total_1']").unmask();
            v2 = $("input[name='total_2']").unmask();
            v3 = $("input[name='total_3']").unmask();
            v4 = $("input[name='total_4']").unmask();
            v5 = $("input[name='total_5']").unmask();           

            $("input[name='Total']").val(  (parseInt(v1)+parseInt(v2)+parseInt(v3)+parseInt(v4)+parseInt(v5)) );

            $('.valorfinal').priceFormat({prefix: 'R$ ', centsSeparator: ',', thousandsSeparator: '.', allowNegative: true});
        }

    });
   

</script>