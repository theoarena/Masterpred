<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Relatorios extends Controller {
	
	public function before(){
		//parent::before();		
		$this->template = View::factory("index_relatorios");								
	}

	public function action_empresa_resultado()
	{				
		$this->template->content = View::factory('relatorios/empresa_resultado');	
		$this->template->content->resultado = ORM::factory('Resultados', site::segment('empresa_resultado',null) );
		
	}	

	public function after(){
		$this->response->body($this->template);								
	}

} // End Welcome Controller
