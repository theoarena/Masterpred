<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Welcome extends Controller {

	public $cached = false; //para carregamento do cache

	function before(){
			
		//vê se o site está em manutençao
		if(!Kohana::$config->load('config')->get('system_active'))
			HTTP::redirect('avisos/manutencao');

		$this->template = View::factory('index'); //padrao
		$auth = Auth::instance(); //carrega o AUTH system

		if(!Site::logado()) //verifica se está logado		
			HTTP::redirect('front/login'); //redireciona pra pagina de login

		//echo "<pre>";
		//print_r($_SESSION);exit;

		$user = $auth->get_user();

		if($user->termos == 0)
			HTTP::redirect('avisos/termos');
			
		//===============menu lateral				

		$this->template->menu_lateral = View::factory('estrutura/menu_lateral');
		$this->template->menu_lateral->nome_usuario = $user->username;
		//$this->template->content = View::factory('home_clientes');	

		//melhorar isso aqui talvez, para nao ficar sempre buscando do BD
		$roles = $auth->get_user()->roles->find_all();
		$this->template->menu_lateral->tipo_usuario = $roles[1]->nickname;
		
		//================================

		//==========verificação de usuários
		if( Site::getInfoUsuario('usuario_system') == 1) //verifica se é usuario de sistema
		{			
			Site::check_empresaatual();
			$this->template->menu_lateral->tipo_menu = View::factory('estrutura/menu_admin');
			$this->template->menu_lateral->tipo_menu->qtd_usuarios = Site::qtd_pedidosusuario();			
		}
		else
		{
			$this->template->menu_lateral->tipo_menu = View::factory('estrutura/menu_cliente');
			$this->template->menu_lateral->empresas = true;						
		}
		
		$this->template->content = View::factory('main_content');
		$this->template->content->plus_add_link = '';				
		$this->template->content->show_add_link = true;								
		$this->template->content->plus_back_link = '';								
		$this->template->content->show_back_link = true;			
		$this->template->content->show_search = true;			

		/*
		if($view = Cache::instance()->get(Site::segment(2), FALSE) )		
		{
			$this->template->content->conteudo = $view;	
			//die();
		}*/							

	}	

	function after()
	{			
		$this->response->body($this->template);	

		//if(!Cache::instance()->get(Site::segment(2), FALSE) )		
		//	Cache::instance()->set(Site::segment(2),$this->template->content->conteudo->render());				
	}	

	public function action_index()
	{	
		if( Site::getInfoUsuario('usuario_system') == 1) //verifica se é usuario de sistema
			$this->template->content = View::factory('home_admin');		
		else
			$this->template->content = View::factory('home_clientes');					
			
		$this->template->content->nome_usuario = Auth::instance()->get_user()->nome;	
		
	}	
	
	//metodo padrao de delete
	public function action_delete()
	{		
		$this->template = "";
		$obj = ORM::factory($this->request->post('class'),$this->request->post('id'));	
		if($obj->delete())
		{
			//Cache::instance()->delete($this->request->post('cache')); //remove o cache
			print 1;
		}
		else
			print 0;
	}
	

} // End Welcome Controller
