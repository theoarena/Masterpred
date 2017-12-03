<link href="<?php echo Site::mediaUrl(); ?>css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Site::mediaUrl(); ?>js/datepicker.js"></script>
<?php

	echo Form::open( Site::segment(1)."/".Site::segment(2),array("id" => "form_edit" , 'method' => 'get') );	
	echo "<div id='select_data'>";
		echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>De</span>". Form::input('de', $de , array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" , 'placeholder' => 'Data Inicial' )) ."</div>";	
		echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Até</span>". Form::input('ate', $ate , array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" , 'placeholder' => 'Data Inicial' )) ."</div>";		
		echo "<div class='input-group input-group-lg'> ". Form::submit('submit', "Buscar", array('class' => 'btn btn-primary btn-lg','id'=>'btn_buscar') ) ."</div>";		
		

	echo '</div>';	 

	echo "<div id='search_box' class='inline'>";
			echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Filtrar:</span>". Form::input('nome', null , array('class' => 'form-control', 'maxlength' => '30', 'id' => 'campobusca')) ."</div>";		
	echo '</div>';

	echo "<div id='historico_check'>";
		echo "<label class='control checkbox chk_equip'> ".Form::checkbox('sem_planejamento',1,($sp==1)?true:false)." <span class='checkbox-label'>Sem Planejamento</span></label>";   
		echo "<label class='control checkbox chk_equip'> ".Form::checkbox('pendentes',1,($pe==1)?true:false)." <span class='checkbox-label'>Pendentes</span></label>";   
		echo "<label class='control checkbox chk_equip'> ".Form::checkbox('executadas',1,($ex==1)?true:false)." <span class='checkbox-label'>Executadas</span></label>";   
		echo "<label class='control checkbox chk_equip'> ".Form::checkbox('finalizadas',1,($fi==1)?true:false)." <span class='checkbox-label'>Finalizadas</span></label>";   
	echo '</div>';	 	

	echo "</form>";

	

	if(count($objs) > 0) //se há pelo menos um resultado
	{
		echo "<div id='historico_list'>";
			echo "<ul>";
				foreach ($objs as $item)
					echo "<li>".$item."</li>";
				//	echo "<><li class='lazy' id='empresa_".$empresa->CodEmpresa."'>Empresa # ".$empresa->Empresa.' | '.$empresa->Unidade.' | '.$empresa->Fabrica;
					
				
			echo '</ul>';
		echo '</div>';	
	} 
	else echo "<div class='alert alert-warning tabela_vazia'>Nenhum item foi encontrado.</div>"; 
	
?>

<script type="text/javascript">
	$(function () {
	    //$('.footable').footable();
	    $('input[name="de"]').datepicker({format:'dd/mm/yyyy'});
	    $('input[name="ate"]').datepicker({format:'dd/mm/yyyy'});
	});
</script>