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

	public function action_save_usuarios() //salvar novo e editar
	{			
		$obj = ORM::factory('User',$this->request->post('id'));
		$redir = $this->request->post('redir');
		$menu = $this->request->post('menu');
		$obj->username = $this->request->post('username');					
		$obj->ativo = $this->request->post('ativar');					
		$obj->email = $this->request->post('email');					
		$obj->nome = $this->request->post('nome');					
		$obj->telefone = $this->request->post('telefone');

		if($redir == 'usuarios_sistema')
		$obj->system = 1;
		
		$obj->nascimento = site::data_EN( $this->request->post('nascimento') );	

		$password = null;
		$password_email = '';

		if($this->request->post('gerar_senha')==1) //se é pra alterar a senha	
		{	
			if($this->request->post('senha_aleatoria')==0)	
				$password_email = $this->request->post('password');								
			else			
				$password_email = site::random_password( 8,$this->request->post('email') ); //gera uma senha aleatória 				
				
			$obj->password = $password_email; 
		}		
				
		/*
			Atualmente, se o usuario desmarcar a caixa de seleção de senha aleatória
			ou se nao marcar pra atribuir nova senha (desmarcar), vai dar problema
			uma vez que espera-se que sempre venha a senha para ser salva no BD.
		*/

		try{

			$obj->save();
			site::addORMRelation($obj, $obj->roles,$this->request->post('role'),'roles');

			if($this->request->post('lista_empresas'))
				site::addORMRelation($obj, $obj->empresas,$this->request->post('lista_empresas'),'empresas');

			$e=2; //2 é sem ação

			if($this->request->post('notificar_ativado')==1)			
				$e = enviaEmail::aviso_usuarioAtivado($obj,$password_email); //enviar o email de aviso 

			if($this->request->post('notificar_senha')==1)			
				$e = enviaEmail::aviso_novaSenha($obj,$password_email); //enviar o email de aviso 

			if($redir == 'pedidos_usuario')
				Session::instance()->delete('qtd_usuarios'); //reinicia o contador de usuários pendentes
			
			HTTP::redirect($menu.'/'.$redir.'?sucesso=1&enviado='.$e);
		}
	    catch (ORM_Validation_Exception $e)
	    {		    	
	        $errors = site::handleErrors($e->errors('models'));				           
	        HTTP::redirect($menu.'/edit_'.$redir.'/'.$obj->id.'?erro=1&error_info='.$errors);
	    }
	
	}
	
	public function action_logout()	
	{
		Auth::instance()->logout(); //tira o usuario
		Session::instance()->destroy(); //tira todas as sessions
		HTTP::redirect('');
	}	

} // End Welcome Controller
