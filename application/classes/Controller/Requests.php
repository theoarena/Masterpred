<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Requests extends Controller_Welcome {	

	// Selecione as GR´s anteriores com o mesmo equipamento e componente em reincidencia	
	public function action_grReferencia() 
	{	
		$this->template = ""; 
		$equipamento = $_GET['equipamento'];	
		$componente = $_GET['componente'];	
		$data = $_GET['data'];	

		$objs = ORM::factory('gr');

		$objs->where('TipoComponente', '=', $componente);		
		$objs->join('equipamentoinspecionado','LEFT')->on('equipamentoinspecionado.CodEquipamentoInspecionado','=','gr.EquipamentoInspecionado');
		$objs->where("equipamentoinspecionado.Equipamento",'=',$equipamento);
		$objs->where("equipamentoinspecionado.Data",'<=',$data);
				
		$content = View::factory("requests/gr_referencia");	
		$content->objs = $objs->find_all();
		
		echo $content;
	}
	
} // End Welcome Controller
