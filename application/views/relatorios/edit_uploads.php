<link href="<?php echo Site::mediaUrl(); ?>css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Site::mediaUrl(); ?>js/datepicker.js"></script>
<?php 
	
	echo Form::open( Site::segment(1)."/save_uploads",array("id" => "form_edit" , 'enctype' => 'multipart/form-data' ) );	
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
	echo Form::hidden("CodArquivoRelatorio",$obj->CodArquivoRelatorio);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Data</span>". Form::input('Data', ($obj->Data != null)?( Site::data_BR($obj->Data) ):( date("d/m/Y") ) ,array('class' => 'form-control', 'id' => 'datepicker',  'maxlength' => '10', 'placeholder' => 'Data', 'onkeypress' => 'return mask(event,this,"##/##/####")' )) ."</div>";	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Sequencial',$obj->Sequencial,array('class'=>'form-control', 'maxlength' => '8', 'placeholder' => 'Sequencial do Relatório'))."</div>";	
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::textarea('Obs',$obj->Obs,array('class'=>'form-control', 'maxlength' => '255', 'placeholder' => 'Observações')) ."</div>";  
    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::select('Tecnologia',$tecnologias,$obj->Tecnologia,array('class' => 'form-control' , 'placeholder' => 'Tecnologia')) ."</div>";	

    echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>";
  
    echo Form::file('arquivo',array('class' => 'form-control upload'));

    $base = url::base().Kohana::$config->load('config')->get('upload_directory_relatorios');
    if($obj->Arquivo!=null)
        echo '<img src="'.Site::mediaUrl().'images/pdf.png" />';

	echo "</div>";

	echo Form::submit('submit', "Salvar", array('class' => 'btn btn-primary btn'));
	
	echo "</form>";	
?>

<script type="text/javascript">
	
$(function () {	    
	    $('input[name="Data"]').datepicker({format:'dd/mm/yyyy'});	   
	});

</script>