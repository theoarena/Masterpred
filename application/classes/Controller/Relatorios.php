<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Relatorios extends Controller {
	
	public $privileges_needed = array();

	public function before(){
		//parent::before();		
		$this->template = View::factory("index_relatorios");								
	}

	public function action_empresa_resultado()
	{		
		$this->privileges_needed[] = 'access_print_osp';
			
		$this->template->content = View::factory('relatorios/empresa_resultado');	
		$this->template->content->resultado = ORM::factory('Resultados', site::segment('empresa_resultado',null) );
		
	}	

	public function after(){
		$this->response->body($this->template);	

		if(!site::isGrant($this->privileges_needed)) //se pode acessar a url
			HTTP::redirect('avisos/denied');
	}

} // End Welcome Controller
