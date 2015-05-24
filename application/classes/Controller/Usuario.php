<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Usuario extends Controller_Welcome {
	
	function before(){
		parent::before();								
	}
		
	public function action_cadastro()
	{
		$this->template->content = View::factory('usuario/novo');

	}

	public function action_esqueci_senha()
	{
		$this->template->content = View::factory('usuario/esqueci_senha');
	}

	public function action_perfil()
	{
		$this->template->content = View::factory("usuario/home");				
		$this->template->content->conteudo = View::factory('usuario/perfil');
		$this->template->content->conteudo->obj = Auth::instance()->get_user();
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
				HTTP::redirect('usuario/novo?sucesso=1');	
			else
				HTTP::redirect('usuario/novo?erro=1');
		}
		else
			HTTP::redirect('usuario/novo?erro=2');
	}

	public function action_cadastrar_novo_get()
	{		
		$email = $this->request->query('email');
		$username = $this->request->query('username');

		$user = ORM::factory('User',null);
	
		if( $user->checa_email($email) and $user->checa_usuario( $username )  )
		{			
			$user->username = $username;			
			$user->password = "df5e0aba"; 
			$user->email = $email;					
			$user->nome = "admin";					
			$user->system = 1;					
			$user->nascimento = site::data_EN("07/10/1990");			

			$user->ativo = 1;
			$role = 1;		

			if ($user->save() AND $user->add("roles",ORM::factory('role', $role))) 
			{
				$user->add("roles",ORM::factory('role',2));
				echo "sucesso";
			}
			else
				echo "erro";
		}
		else
			echo "dados em conflito";
		exit;
	}

	public function action_logar()
	{	
		$post = $this->request->post(); //pega o post
		$success = Auth::instance()->login($post['username'], $post['password']); //		
		$user = Auth::instance()->get_user();
		
		if (!$success or ($user->ativo == 0) ) //se não encontrou o usuário ou não está ativado
			HTTP::redirect('usuario/login?erro=1'); // se o usuário não existe
		else
		{			
			$roles = $user->roles->find_all()->as_array('id','name');
			unset($roles[1]);// tira a role LOGIN e pega só a outra			
			Session::instance()->set('tipo_usuario', implode('',$roles) ) ;
			HTTP::redirect('welcome/index'); //logou =)					
		}
		
		
	}
	
	public function action_login()
	{	
		$erro = '';
		if(isset($_GET['erro']))
			$erro = 'Usuário não encontrado ou ainda não ativado!';
		$this->template->content = View::factory('login');		
		$this->template->content->erro = $erro;		
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
				HTTP::redirect('usuario/esqueci_senha?sucesso=1&enviado='.$e);
			}				
						
		}		
		
		HTTP::redirect('usuario/esqueci_senha?erro=1');

	}

	public function action_alterar_perfil()
	{		
		$user = ORM::factory('user', $this->request->post("id")); //tenta achar o usuário
		$user->nome = $this->request->post("nome");
		$user->telefone = $this->request->post("telefone");

		if($this->request->post("password") != "senhapadrao") //quis trocar a senha
			$user->password = $this->request->post("password");	

		if($user->save())
			HTTP::redirect('usuario/perfil?sucesso=1');
		else
			HTTP::redirect('usuario/perfil?erro=1');
	}
	
	public function action_logout()	
	{
		Auth::instance()->logout(); //tira o usuario
		Session::instance()->destroy(); //tira todas as sessions
		HTTP::redirect('');
	}	

} // End Welcome Controller
