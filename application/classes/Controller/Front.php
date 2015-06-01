<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Front extends Controller {

	function before(){
			
		//site em manutençao
		if(!Kohana::$config->load('config')->get('system_active'))
			HTTP::redirect('avisos/manutencao');

		$this->template = View::factory('index'); //padrao
		$auth = Auth::instance(); //carrega o AUTH system
			
		if(site::logado()) 	
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
	
		if( $user->checa_email($this->request->post('email')) and $user->checa_usuario( $this->request->post('username') )  )
		{			
			$user->username = $this->request->post('username');					
			$user->password =  "12345678";//essa senha nao vale, já que o usuario será inativo 
			$user->email = $this->request->post('email');					
			$user->nome = $this->request->post('nome');					
			$user->telefone = $this->request->post('telefone');					
			$user->nascimento = site::data_EN($this->request->post('nascimento'));	
			$user->obs = $this->request->post('obs');	

			$user->ativo = 0;
			$role = 1;		

			if ($user->save() AND $user->add('roles', $role) ) 
				HTTP::redirect('front/novo?sucesso=1');	
			else
				HTTP::redirect('front/novo?erro=1');
		}
		else
			HTTP::redirect('front/novo?erro=2');
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
		$success = Auth::instance()->login($post['username'], $post['password']); //		
		$user = Auth::instance()->get_user();
		
		if (!$success or ($user->ativo == 0) ) //se não encontrou o usuário ou não está ativado
			HTTP::redirect('front/login?erro=1'); // se o usuário não existe
		else
		{			
			$roles = $user->roles->find_all()->as_array('id','name');
			unset($roles[1]);// tira a role LOGIN e pega só a outra		
			$privileges =  $user->roles->privileges->find_all()->as_array('id','name');
			$privileges_str = implode('_',$privileges);
			
			//mudar pra cache???	
			Session::instance()->set('usuario_roles', implode('',$roles) );
			Session::instance()->set('usuario_system', $user->system ) ;
			Session::instance()->set('usuario_privileges', $privileges_str);
		
			if( $user->termos != 0)
				HTTP::redirect('welcome/index'); //logou =)					
			else			
				HTTP::redirect('avisos/termos');// termos de uso			
		}
		
		
	}

	public function action_recuperar_senha()
	{		
		$user = ORM::factory('User')->where('email',$this->request->post('email'))->find();
		if($user->loaded) //se achou
		{			
			$password_email = site::random_password(8); //gera uma senha aleatória 			 						
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
