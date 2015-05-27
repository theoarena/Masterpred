<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Usuario extends Controller_Welcome {
	
	function before(){
		parent::before();								
	}
		
	public function action_perfil()
	{
		$this->template->content = View::factory("usuario/home");				
		$this->template->content->conteudo = View::factory('usuario/perfil');
		$this->template->content->conteudo->obj = Auth::instance()->get_user();
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
		
	//para teste de email
	public function action_email()
	{
		enviaEmail::teste();
		//exit;
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
