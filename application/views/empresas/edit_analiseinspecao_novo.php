<link href="<?php echo Site::mediaUrl(); ?>css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Site::mediaUrl(); ?>js/datepicker.js"></script>

<?php 
	echo Form::open( Site::segment(1)."/save_analiseinspecao_novo",array("id" => "form_edit") );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	//echo Form::hidden("CodRota",$obj->CodRota);	

	echo '<div class="well well-sm">';
	echo '<h4>Por favor, escolha qual será o sequencial do relatório:</h4>';
	echo "<div class='input-group input-group-lg'>";
	echo "<label class='control radio'> ".Form::radio('relatorio_novo',1, true )." <span class='radio-label'>Gerar novo número</span></label>";   
	echo "<label class='control radio'> ".Form::radio('relatorio_novo',2, false )." <span class='radio-label'>Utilizar outro número (preencha abaixo)</span></label>";   
	echo "</div>";

    echo "<div class='input-group input-group-lg' id='busca_cod_relatorio'> <span class='input-group-addon'>Sequencial do relatório</span>". Form::input('codigo_relatorio',null,array('class' => 'form-control') ) ."</div>"; 
    echo "<div class='input-group input-group-lg drop'> <button class='btn_picker label-warning btn' id='btn_cod_relatorio'>Buscar</button> </div>";

	echo "</div>";
   
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Rota</span>". Form::select('Rota',$rotas,null,array('class' => 'form-control') ) ."</div>"; 
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Analista</span>". Form::select('Analista',$analistas,$obj->Analista,array('class' => 'form-control') ) ."</div>"; 
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Data</span>". Form::input('Data', ($obj->Data != null)?( Site::data_BR($obj->Data) ):( date("d/m/Y") ) ,array('class' => 'form-control', 'id' => 'datepicker',  'maxlength' => '10', 'placeholder' => 'Data', 'onkeypress' => 'return mask(event,this,"##/##/####")' )) ."</div>";	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Tecnologia</span>". Form::select('Tecnologia',$tecnologias,$obj->Tecnologia,array('class' => 'form-control') ) ."</div>"; 
	echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn'));       
	echo Form::close();

    echo Site::generateValidator(array('Data'=>'Data'));
?>

<script type="text/javascript">
	
$(function () {	    
	    $('input[name="Data"]').datepicker({format:'dd/mm/yyyy'});	   


	      $('#btn_cod_relatorio').click(function(e){

	      	var tec = $("select[name='Tecnologia'] option:selected").val();
	      	var data = $('input[name=Data]').val();
	      
            $.fancybox.open(
            {
                href: '<?php echo Site::baseUrl() ?>requests/codRelatorio/?empresa=<?php echo Site::get_empresaatual(); ?>&data='+data+'&tecnologia='+tec,
                type: 'ajax',
                title: 'Selecione o Relatório desejado',
                padding:20
            });           
            e.preventDefault();
        });

	});

</script>