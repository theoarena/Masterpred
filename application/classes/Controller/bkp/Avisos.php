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

	public function action_termos()
	{
		$this->template->content = View::factory('avisos/termos');		
	}

	public function action_aceitar()
	{
		$user = Auth::instance()->get_user();
		$user->termos = 1;
		$user->save();
		HTTP::redirect('welcome/index');	
	}
	
	public function action_denied()
	{				
		$this->template->content = View::factory('avisos/denied');
		
	}	

	public function action_manutencao()
	{		
		$this->template->content = View::factory('avisos/manutencao');
		
	}	
		
	public function action_logout()	
	{
		Auth::instance()->logout(); //tira o usuario
		Session::instance()->destroy(); //tira todas as sessions
		HTTP::redirect('');
	}	
	
	

} // End Welcome Controller
