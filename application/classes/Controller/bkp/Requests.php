<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Requests extends Controller_Welcome {	

	// Selecione as GR´s anteriores com o mesmo equipamento e componente em reincidencia	
	public function action_grReferencia() 
	{	
		$this->template = ""; 
		$equipamento = $_GET['equipamento'];	
		$componente = $_GET['componente'];	
		$empresa = $_GET['empresa'];	
		$data = $_GET['data'];	

		$objs = ORM::factory('Gr');

		$objs->where('TipoComponente', '=', $componente);		
		$objs->join('equipamentoinspecionado','LEFT')->on('equipamentoinspecionado.CodEquipamentoInspecionado','=','gr.EquipamentoInspecionado');
		$objs->where("equipamentoinspecionado.Equipamento",'=',$equipamento);
		$objs->where("equipamentoinspecionado.Data",'<=',$data);
		$objs->where("equipamentoinspecionado.Empresa",'=',$empresa);
				
		$content = View::factory("requests/gr_referencia");	
		$content->objs = $objs->find_all();
		
		echo $content;
	}

	public function action_codRelatorio() 
	{	
		$this->template = ""; 		
		$empresa = $_GET['empresa'];			
		$tecnologia = $_GET['tecnologia'];			
		$data = $_GET['data'];			

		$objs = ORM::factory('Relatorios');
	
		$objs->where("Empresa",'=',$empresa);
		$objs->where("Tecnologia",'=',$tecnologia);
		//$objs->where("Data",'=',$data);
		$objs->order_by("Data","DESC");
				
		$content = View::factory("requests/cod_relatorio");	
		$content->objs = $objs->find_all();
		
		echo $content;
	}


	public function action_popup_empresas() 
	{	
		$this->template = ""; 
		$auth = Auth::instance(); //carrega o AUTH system
		$user = $auth->get_user();
		$empresas = $user->empresas->find_all();
		$content = View::factory('requests/popup_empresas');
		$content->empresas = $empresas;
		echo $content;

	}
	
} // End Welcome Controller
