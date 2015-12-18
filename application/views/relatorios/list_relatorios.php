<link href="<?php echo Site::mediaUrl(); ?>css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Site::mediaUrl(); ?>js/datepicker.js"></script>

<?php 

    if(Site::selected_empresaatual())
    {

        $amanha = date('d/m/Y', strtotime("+1 days"));  

        echo Form::open( Site::segment(1)."/gera_relatorio",array("id" => "form_edit",'target' => 'parent' ) ); 

        echo "<div id='select_data'>";
        echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>De</span>". Form::input('de', Arr::get($_GET, 'de',null) , array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" , 'placeholder' => 'Data Inicial' )) ."</div>";   

        echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Até</span>". Form::input('ate', Arr::get($_GET, 'ate', $amanha) , array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" , 'placeholder' => 'Data Final' )) ."</div>";   
                echo "<div class='input-group input-group-lg div_filtrar'>". HTML::anchor('#','Buscar relatórios', array('class' => 'btn btn-primary' ,'id' => 'btn_filtrar')) ."</div>";  
        echo '</div>';      

        echo "<div id='select_data'>";
        echo "<div class='input-group input-group-lg drop'> <span class='input-group-addon'>Tecnologia</span>". Form::select('tecnologia',$tecnologias, Arr::get($_GET, 'tec', 'padrao') , array('class' => 'form-control')) ."</div>";   

        echo "<div class='input-group input-group-lg drop2'> <span class='input-group-addon'>Tipo do relatório</span>". Form::select('tipo', $tipos ,Arr::get($_GET, 'tipo', 'padrao'), array('class' => 'form-control')) ."</div>";      

        echo '</div>';  
        echo Form::close();
   

?>
    <table class="footable table" data-page-navigation=".pagination"  data-filter=#campobusca>

        <thead>
            <tr>
                <th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo Site::getTituloCampos("sequencial"); ?></h3></th>
                <th><h3><?php echo Site::getTituloCampos("data"); ?></h3></th>
                <th><h3><?php echo Site::getTituloCampos("tecnologia"); ?></h3></th>
                <th><h3><?php echo Site::getTituloCampos("analista"); ?></h3></th>           
                <th><h3><?php echo Site::getTituloCampos("rota"); ?></h3></th>        
                <th data-sort-ignore="true" id='col_actions'><h3><?php echo Site::getTituloCampos("acoes"); ?></h3></th>        
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot class="hide-if-no-paging">
            <tr>
                <td colspan="100">
                    <ul class="pagination pagination-centered"></ul>
                </td>
            </tr>
        </tfoot>

    </table>
	    
<?php
     
    } else echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'ative_empresa')."</div>"; 
?>


<script type="text/javascript">

    $(function () {
        //$('.footable').footable();
        $('input[name="de"]').datepicker({format:'dd/mm/yyyy'});
        $('input[name="ate"]').datepicker({format:'dd/mm/yyyy'});
      
    });


    $( "#btn_filtrar" ).click(function () {
        $(".footable tbody").html("<span id='loading'><img src='<?php echo Site::mediaUrl() ?>images/loading.gif'></span>");

        var de = $( "input[name='de']" ).val(); 
        var ate = $( "input[name='ate']" ).val();
        var tec = $( "select[name='tecnologia'] option:selected" ).val();
       
        //var empresa = '<?php echo Site::get_empresaatual(); ?>'; 


        $.ajax({
            url : "<?php echo Site::baseUrl() ?>relatorios/carrega_relatorios",
            type: "POST",  
            dataType: "json",
            data: { de:de, ate:ate, tecnologia:tec},
            success : function(dados) { 
                
                $(".footable tbody").html("");
                $(".footable thead").show();

                if(dados.length > 0) //se tem relatorios
                {
                    for(var i=0;i < dados.length ;i++)
                    {
                        var gr = dados[i];                  
                        var colunas = "<tr>";
                        var cod = gr["ID"];
                        var param = "cod="+cod+"&de="+de+"&ate="+ate+"&tec="+tec;
                        colunas += "<td>"+gr["Sequencial"]+"</td>";                                                                      
                        colunas += "<td>"+gr["Data"]+"</td>";                       
                        colunas += "<td>"+gr["Tecnologia"]+"</td>";                                            
                        colunas += "<td>"+gr["Analista"]+"</td>";                                     
                        colunas += "<td>"+gr["Rota"]+"</td>";                                     
                        colunas += "<td><div class='btn-group btn-group-lg'>";
                        colunas += "<a onclick='geraRelatorio(\""+param+"\")' href='javascript:void(0)' class='btn btn-info'>GERAR</a>";                      
                      
                        colunas += "</div></td></tr>";
                        $(".footable tbody").append(colunas);                       
                    }                   
                    
                }
                else
                {                   
                    $(".footable tbody").append("<tr><td colspan='5'><div class='alert alert-warning tabela_vazia'><?php echo Kohana::message('admin', 'nenhum_item'); ?></div></td></tr>");    
                    $(".footable thead").hide();
                }

                $('.footable').footable();          
                
            }
        });
        
    });

    function geraRelatorio(param)
    {       
        var tipo = $( "select[name='tipo'] option:selected" ).val(); 
        var link = "<?php echo Site::baseUrl() ?>relatorios/gera_relatorio/?&tipo="+tipo+"&"+param;
        window.open(link, '_blank');
    }


</script>