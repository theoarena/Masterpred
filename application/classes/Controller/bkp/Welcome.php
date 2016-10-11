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
		$error = rand(1,2);
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
			/*
			if($error == 1)
			{
				/*
				
					escription Language: 
				                 File: /var/lib/apt/lists/ppa.launchpad.c_ppa_ubuntu_dists_trusty_main_binary-amd64_Packages
				                  MD5: 20eb9cc7cf4c215c79adaa7566554312
				 Description Language: en
				                 File: /var/lib/apt/lists/ppa.launchpad.c_ppa_ubuntu_dists_trusty_main_i18n_Translation-en
				                  MD5: 20eb9cc7cf4c215c79adaa7566554312

				4:4.0.10-1 (/var/lib/apt/lists/us.archive.ubuntu.com_ubuntu_dists_trusty_universe_binary-amd64_Packages)
				 Description Language: 
				                 File: /var/lib/apt/lists/us.archive.ubuntu.com_ubuntu_dists_trusty_universe_binary-amd64_Packages
				                  MD5: 741cc5619fcb316ac8049f5906394984
				 Description Language: en
				                 File: /var/lib/apt/lists/us.archive.ubuntu.com_ubuntu_dists_trusty_universe_i18n_Translation-en
				                  MD5: 741cc5619fcb316ac8049f5906394984
				*/
			//	trigger_error('Warning: require_once(/nfs/c03/h01/mnt/81833/domains/masterpred.com.br/absolute_loading.php');	
				/*
	* warning: Illegal offset type in isset or empty in sites/all/modules/domain/domain.module on line 1157.
					* warning: Illegal offset type in sites/all/modules/domain/domain.module on line 1172.
					* warning: Illegal offset type in sites/all/modules/domain/domain.module on line 1173.
					* warning: in_array() [function.in-array]: Wrong datatype for second argument in sites/all/modules/domain/domain_source/domain_source.module on line 208.
					* warning: current() [function.current]: Passed variable is not an array or object in sites/all/modules/domain/domain_source/domain_source.module on line 209.

				*/
		//	}
			

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
