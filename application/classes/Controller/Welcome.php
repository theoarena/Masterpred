<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Welcome extends Controller {
	
	function before(){
			
		$auth = Auth::instance();
		

		$this->template = View::factory('index');
			
		if(site::logado())
		{		
			$user = $auth->get_user();
			$this->template->menu_lateral = View::factory('estrutura/menu_lateral');
			$this->template->menu_lateral->nome_usuario = $user->username;
			
			//melhorar isso aqui talvez, para nao ficar sempre buscando do BD
			$roles = $auth->get_user()->roles->find_all();
			$this->template->menu_lateral->tipo_usuario = $roles[1]->nickname;

			$this->template->menu_lateral->empresas = $user->empresas->find_all();		

			//==========verificação de usuários
			switch (site::getTipoUsuario())
			{
				case 'admin': //dono do sistema
					site::check_empresaatual();
					$this->template->menu_lateral->tipo_menu = View::factory('estrutura/menu_admin');
					$this->template->menu_lateral->tipo_menu->qtd_usuarios = site::qtd_pedidosusuario();
					$this->template->content = View::factory('home_admin');					
					break;
				case 'cliente': //dono da empresa					
					$this->template->menu_lateral->tipo_menu = View::factory('estrutura/menu_cliente');
					$this->template->content = View::factory('home_clientes');	
					break;
				case 'funcionario': //funcionario da empresa
					$this->template->content = View::factory('home_clientes');	
					break;
			}		

						
		}	
		else //se nao está logado
			site::verifica_login();//verifica se esta logado ou nao, manda pra pagina de login;
				
		$this->template->footer = View::factory('estrutura/footer');	
										
	}	

	function after()
	{
		$this->response->body($this->template);	
	}
	
	public function action_index()
	{				
		$this->template->content->nome_usuario = Auth::instance()->get_user()->nome;	
		
	}	
	
	public function action_denied()
	{				
		$this->template = View::factory('denied');
		
	}	
	

} // End Welcome Controller
