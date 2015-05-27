<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Avisos extends Controller {
	
	function before(){
		$this->template = View::factory('index_aviso');									
	}	

	function after()
	{			
		$this->response->body($this->template);			
	}
	
	public function action_index()
	{				
		//$this->template->content->nome_usuario = Auth::instance()->get_user()->nome;	
		
	}	
	
	public function action_denied()
	{				
		$this->template->content = View::factory('avisos/denied');
		
	}	

	public function action_manutencao()
	{		
		$this->template->content = View::factory('avisos/manutencao');
		
	}	
	
	

} // End Welcome Controller
