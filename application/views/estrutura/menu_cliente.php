<?php					
	echo "<li>".HTML::anchor('clientes/historico?sem_planejamento=1&pendentes=1', 'Histórico' , array("class" => Site::active("historico",3,false)) );			
	echo "<li>".HTML::anchor('clientes/downloads', 'Downloads' , array("class" => Site::active("downloads",3,false)) );			
?>
