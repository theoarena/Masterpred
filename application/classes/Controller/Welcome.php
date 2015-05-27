<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Welcome extends Controller {

	public $cached = false; //para carregamento do cache

	function before(){
			
		//vê se o site está em manutençao
		if(!Kohana::$config->load('config')->get('system_active'))
			HTTP::redirect('avisos/manutencao');

		$this->template = View::factory('index'); //padrao
		$auth = Auth::instance(); //carrega o AUTH system

		if(!site::logado()) //verifica se está logado		
			HTTP::redirect('front/login'); //redireciona pra pagina de login

		//echo "<pre>";
		//print_r($_SESSION);exit;
			
		//===============menu lateral				
		$user = $auth->get_user();
		$this->template->menu_lateral = View::factory('estrutura/menu_lateral');
		$this->template->menu_lateral->nome_usuario = $user->username;
		//$this->template->content = View::factory('home_clientes');	

		//melhorar isso aqui talvez, para nao ficar sempre buscando do BD
		$roles = $auth->get_user()->roles->find_all();
		$this->template->menu_lateral->tipo_usuario = $roles[1]->nickname;
		$this->template->menu_lateral->empresas = $user->empresas->find_all();		
		//================================

		//==========verificação de usuários
		if( site::getInfoUsuario('usuario_system') == 1) //verifica se é usuario de sistema
		{			
			site::check_empresaatual();
			$this->template->menu_lateral->tipo_menu = View::factory('estrutura/menu_admin');
			$this->template->menu_lateral->tipo_menu->qtd_usuarios = site::qtd_pedidosusuario();			
		}
		else
			$this->template->menu_lateral->tipo_menu = View::factory('estrutura/menu_cliente');
		
		$this->template->content = View::factory('main_content');
		$this->template->content->plus_add_link = '';				
		$this->template->content->show_add_link = true;								
		$this->template->content->plus_back_link = '';								
		$this->template->content->show_back_link = true;								
	}	

	function after()
	{			
		$this->response->body($this->template);			
	}
	
	public function action_index()
	{	
		if( site::getInfoUsuario('usuario_system') == 1) //verifica se é usuario de sistema
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
			Cache::instance()->delete($this->request->post('cache')); //remove o cache
			print 1;
		}
		else
			print 0;
	}
	

} // End Welcome Controller
