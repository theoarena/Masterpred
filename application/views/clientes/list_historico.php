<?php

	echo form::open( site::segment(1)."/".site::segment(2),array("id" => "form_edit" , 'method' => 'get') );	
	echo "<div id='select_data'>";
		echo "<div class='input-group input-group-lg first'> <span class='input-group-addon'>De</span>". form::input('de', $de , array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" , 'placeholder' => 'Data Inicial' )) ."</div>";	
		echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Até</span>". form::input('ate', $ate , array('class' => 'form-control', 'maxlength' => '10', 'onkeypress' => "return mask(event,this,'##/##/####')" , 'placeholder' => 'Data Inicial' )) ."</div>";		
		echo "<div class='input-group input-group-lg'> ". form::submit('submit', "Buscar", array('class' => 'btn btn-primary btn-lg','id'=>'btn_buscar') ) ."</div>";		
		

	echo '</div>';	 

	echo "<div id='historico_check'>";
		echo "<label class='control checkbox chk_equip'> ".form::checkbox('sem_planejamento',1,($sp==1)?true:false)." <span class='checkbox-label'>Sem Planejamento</span></label>";   
		echo "<label class='control checkbox chk_equip'> ".form::checkbox('pendentes',1,($pe==1)?true:false)." <span class='checkbox-label'>Pendentes</span></label>";   
		echo "<label class='control checkbox chk_equip'> ".form::checkbox('executadas',1,($ex==1)?true:false)." <span class='checkbox-label'>Executadas</span></label>";   
		echo "<label class='control checkbox chk_equip'> ".form::checkbox('finalizadas',1,($fi==1)?true:false)." <span class='checkbox-label'>Finalizadas</span></label>";   
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