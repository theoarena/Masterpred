<script src="<?php echo Site::mediaUrl(); ?>js/jquery-ui.custom.js"></script>
<link href="<?php echo Site::mediaUrl(); ?>css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Site::mediaUrl(); ?>js/datepicker.js"></script>
<script src="<?php echo Site::mediaUrl(); ?>js/money.js"></script>

<h1 id="btn_adicionar">     
    
     <?php //echo HTML::anchor(Site::segment(1)."/resultado_historico/".$obj->resultado->CodResultado."?gr=".$obj->CodGR,"Resultados", array("class" => "label label-primary" )); ?>
     <?php 
        if(Usuario::isGrant(array('access_print_osp')))
            echo HTML::anchor("relatorios/gera_relatorio/?tipo=ordem_servico&gr=".$codgr,"Imprimir", array("class" => "label label-info" , 'target'=>'blank' )); 
      ?>            
     
</h1>


<h1>Grau de risco</h1>

<?php 
    $equip = $obj->equipamentoinspecionado;	
    echo "<h2>Código: <span class='label label-primary'>".$obj->CodGR."</span></h2>";
    echo "<h2>GR:  <span class='label label-primary'>".$obj->NumeroGR."</span></h2>";
    echo "<br/>";
    
    echo Form::open( Site::segment(1)."/save_resultado",array("id" => "form_edit" ) );          
    echo Form::hidden("GR",$obj->CodGR); 
    echo Form::hidden("CodResultado",$resultado->CodResultado); 

?>

<div id="tabs" class="tabs_info">
  <ul class="nav nav-pills">
    <li><a href="#tabs-1">Informações</a></li>
    <li><a href="#tabs-2">Planejamento</a></li>
    <li><a href="#tabs-3">Correção</a></li>
    <li><a href="#tabs-4">Contabilização</a></li>
    <li><a href="#tabs-5">Finalização</a></li>
  </ul>
  <div id="tabs-1" class="tab_item">
    <div class="col_tab w40">
        <?php
            echo '<h3>Tecnologia: <span>'.$equip->tecnologia->Tecnologia.'</span></h3>';
            echo '<h3>Analista: <span>'.$equip->analista->Analista."</span></h3>";
            echo '<h3>Condição: <span>'.$equip->condicao->Condicao."</span></h3>";
            echo '<h3>Área: <span>'.$equip->equipamento->setor->area->Area."</span></h3>";
            echo '<h3>Setor: <span>'.$equip->equipamento->setor->Setor."</span></h3>";
            echo '<h3>Tag: <span>'.$equip->equipamento->Tag."</span></h3>";
            echo '<h3>Equipamento: <span>'.$equip->equipamento->Equipamento."</span></h3>";
            echo '<h3>Tipo do equipamento: <span>'.$equip->equipamento->tipoequipamento->TipoEquipamento."</span></h3>";
            echo '<h3>Data: <span>'.$equip->Data."</span></h3>";
            echo '<h3>Componente: <span>'.$obj->componente->Componente.': '.$obj->Componente.'</span></h3>';
            echo '<h3>Detalhes: <span>'.$obj->Detalhe.'</span></h3>';
            echo '<h3>Tipo de Inspeção: <span>'.$obj->tipoinspecao->TipoInspecao.'</span></h3>';
            echo '<h3>GR Referência: <span>'.$obj->GRReferencia.'</span></h3>';
            echo '<h3>Anomalia: <span>'.$obj->anomalia->Anomalia.': '.$obj->Anomalia.'</span></h3>';
            echo '<h3>Recomendação: <span>'.$obj->Recomendacao.'</span></h3>';
            echo '<h3>Observações: <span>'.$obj->Obs.'</span></h3>';
        ?>
    </div>
    <div class="col_tab w40">
        <?php
            echo '<h3>Ir: <span>'.$obj->Ir."</span></h3>";
            echo '<h3>Vr: <span>'.$obj->Vr."</span></h3>";
            echo '<h3>Is: <span>'.$obj->Is."</span></h3>";
            echo '<h3>Vs: <span>'.$obj->Vs."</span></h3>";
            echo '<h3>It: <span>'.$obj->It."</span></h3>";
            echo '<h3>Vt: <span>'.$obj->Vt."</span></h3>";
            echo '<h3>In: <span>'.$obj->In."</span></h3>";
            echo '<h3>Vn: <span>'.$obj->Vn."</span></h3>";
            echo '<br>';
            echo '<h3>Temp. Média: <span>'.$obj->TemperaturaMed."</span></h3>";
            echo '<h3>Temp. Referência.: <span>'.$obj->TemperaturaRef."</span></h3>";     
        ?>
    </div>
    <div class="cb"></div>
    <br>
    <br>
        <?php

            $base = URL::base().Kohana::$config->load('config')->get('upload_directory_gr');
            echo '<div class="imagens_tab">';
            echo "<h3><span class='label label-info'>Imagem Real</span></h3>";
            
                 if($obj->ImagemReal!=null)
                    echo '<a class="fancybox" href="'.$base.$obj->ImagemReal.'"><img src="'.$base.$obj->ImagemReal.'" width="80%"/></a>';
            echo '</div>';
            echo '<div class="imagens_tab">';
            echo "<h3><span class='label label-info'>Imagem Térmica</span></h3>";
            
                 if($obj->ImagemTermica!=null)
                    echo '<a class="fancybox" href="'.$base.$obj->ImagemTermica.'"><img src="'.$base.$obj->ImagemTermica.'" width="80%" /></a>';
            echo '</div>';

        ?>   
   
  </div>
  <div id="tabs-2" class="tab_item">

      <?php
        if(Usuario::isGrant(array('planejar_os')))
        {   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('CodCliente',$resultado->CodCliente, array('class' => 'form-control', 'placeholder' => 'Código da ordem gerada internamente')) ."</div>";         
            echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>Data de Planejamento</span>". Form::input('DataPlanejamento',Site::datahora_BR($resultado->DataPlanejamento), array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" ,'placeholder' => 'Data')) ."</div>";   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('RespPlanejamento',$resultado->RespPlanejamento, array('class' => 'form-control', 'placeholder' => 'Responsável')) ."</div>"; 
            echo "<br>";
             echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg'));  
  
        }
      ?>
   
  </div>
  <div id="tabs-3" class="tab_item">

    <?php
        if(Usuario::isGrant(array('executar_os')))
        {
            echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>Data da Corretiva</span>". Form::input('DataCorretiva',Site::datahora_BR($resultado->DataCorretiva), array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')", 'placeholder' => 'Data')) ."</div>";   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('RespCorretiva',$resultado->RespCorretiva, array('class' => 'form-control', 'placeholder' => 'Responsável')) ."</div>"; 
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::textarea('Obs',$resultado->Obs, array('class' => 'form-control', 'placeholder' => 'Ações')) ."</div>"; 
            echo "<br>";
             echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg'));  
  
        }
    ?>
  
  </div>
   <div id="tabs-4" class="tab_item">
  
   <?php
    if(Usuario::isGrant(array('contabilizar_os')))
    {

        echo "<div id='block_historico'>";     
            echo "<h3><span class='label label-info'>Manutenção Preditiva</span></h3>";
            echo '<div class="well well-sm" >';            
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Mão de Obra (h)</span>". Form::input('PreMOHora',$resultado->PreMOHora,  array('class' => 'form-control', 'placeholder' => 'Quantidade')). Form::input('PreMOPreco',$PreMOPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Serv. Terceirizado (h)</span>". Form::input('PredTercHora',$resultado->PredTercHora, array('class' => 'form-control', 'placeholder' => 'Quantidade')). Form::input('PredTercPreco',$PredTercPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Material Reparo($)</span>". Form::input('PredMatPreco',$PredMatPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Produção (h)</span>". Form::input('PreProdHora',$resultado->PreProdHora, array('class' => 'form-control', 'placeholder' => 'Quantidade')). Form::input('PreProdPreco',$PreProdPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                               
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Outros</span>". Form::input('PredOutrPreco',$PredOutrPreco, array('class' => 'form-control  valor', 'placeholder' => 'Valor($)'))."</div>";                                   
            echo "</div>";    
        echo "</div>";

        echo "<div id='block_historico'>";       
            echo "<h3><span class='label label-info'>Manutenção Convencional</span></h3>";
            echo '<div class="well well-sm" >';            
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Mão de Obra (h)</span>". Form::input('ConvMOHora',$resultado->ConvMOHora, array('class' => 'form-control', 'placeholder' => 'Quantidade')). Form::input('ConvMOPreco',$ConvMOPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Serv. Terceirizado (h)</span>". Form::input('ConvTercHora',$resultado->ConvTercHora, array('class' => 'form-control', 'placeholder' => 'Quantidade')). Form::input('ConvTercPreco',$ConvTercPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Material Reparo($)</span>". Form::input('ConvMatPreco',$ConvMatPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Produção (h)</span>". Form::input('ConvProdHora',$resultado->ConvProdHora, array('class' => 'form-control', 'placeholder' => 'Quantidade')). Form::input('ConvProdPreco',$ConvProdPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                               
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Outros</span>". Form::input('ConvOutrPreco',$ConvOutrPreco, array('class' => 'form-control valor', 'placeholder' => 'Valor($)'))."</div>";                                   
            echo "</div>";
        echo "</div>";

        echo "<div id='block_historico'>";     
            echo "<h3><span class='label label-info'>Retorno de Investimento</span></h3>";
            echo '<div class="well well-sm" >';   
                     
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Mão de Obra (h)</span>". Form::input('total_1',null, array('class' => 'form-control', 'placeholder' => 'Valor(R$)' ,'disabled' => 'disabled'))."</div>";                                   
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Serv. Terceirizado (h)</span>". Form::input('total_2',null, array('class' => 'form-control', 'placeholder' => 'Valor(R$)' ,'disabled' => 'disabled'))."</div>";                                   
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Material Reparo($)</span>". Form::input('total_3',null, array('class' => 'form-control', 'placeholder' => 'Valor(R$)' ,'disabled' => 'disabled'))."</div>";                                   
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Produção (h)</span>". Form::input('total_4',null, array('class' => 'form-control', 'placeholder' => 'Valor(R$)' ,'disabled' => 'disabled'))."</div>";                                               
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Outros</span>". Form::input('total_5',null, array('class' => 'form-control', 'placeholder' => 'Valor(R$)' ,'disabled' => 'disabled'))."</div>";                                   
                echo "<div class='input-group input-group-lg'> <span class='input-group-addon'><strong>Total(R$)</strong></span>". Form::input('Total',null, array('class' => 'form-control valorfinal', 'placeholder' => 'Valor(R$)' ,'disabled' => 'disabled'))."</div>";                                   
            echo "</div>";    
        echo "</div>";

        echo "<br>";

         echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg'));  
  

    }
   ?>

  </div>
  <div id="tabs-5" class="tab_item">
  
      <?php
        if(Usuario::isGrant(array('finalizar_os')))
        {
            echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>Data de Finalização</span>". Form::input('DataFinalizacao',Site::datahora_BR($resultado->DataFinalizacao), array('class' => 'form-control' , 'onkeypress' => "return mask(event,this,'##/##/####')"  ,'placeholder' => 'Data')) ."</div>";   
            echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('RespFinalizacao',$resultado->RespFinalizacao, array('class' => 'form-control', 'placeholder' => 'Responsável')) ."</div>"; 

             echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn-lg'));  
  
        }
      ?>



  </div>
</div>
<?php
      echo Form::close();
?>

<script>

$( function() {
    $( "#tabs" ).tabs();
    $(".fancybox").fancybox();  
} );

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