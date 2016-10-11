<?php defined('SYSPATH') or die('No direct script access.');
 
class Usuario {
 
	public static function logado()
	{
		return (Auth::instance()->logged_in());
	}		
	

	public static function isGrant($privileges_needed) 
	{
		if(Session::instance()->get('usuario_roles',false) == 'admin')
			return true; //se for de sistema pode ver tudo;
		
		/*
		$pass = 0;
		$user = Auth::instance()->get_user();
		$privileges = explode(',', $user->get_privileges() );
		
		foreach ($privileges as $key => $value) 
			if(array_search($value,$privileges_needed) !== false )			
				$pass++;				
				
		return ($pass == count($privileges_needed));
		*/

		$qtd = count($privileges_needed);		
		$user = Auth::instance()->get_user();
		$privileges = explode(',', $user->get_privileges() );
		return ( count(array_intersect($privileges_needed,$privileges)) == $qtd );
	}

	

	//===============empresa que está ativada no ADMIN
	//================================================
		public static function check_empresaatual()
		{
			if(!isset($_SESSION["empresa_atual"])) //se a empresa atual nao foi seleciona, inicializa			
				Session::instance()->set('empresa_atual',0);	
		}

		public static function set_empresaatual($v,$nome)
		{
			Session::instance()->set('empresa_atual', $v);// atribui a empresa selecionada		
			Session::instance()->set('nome_empresa_atual', $nome);// atribui a empresa selecionada		
		}

		public static function remove_empresaatual()
		{
			Session::instance()->delete('empresa_atual');
			Session::instance()->delete('nome_empresa_atual');
		}

		public static function get_empresaatual($i=1)
		{
			if($i==0)
				return ORM::factory('Empresa', Session::instance()->get('empresa_atual',null) );
			elseif($i==1)
				return Session::instance()->get('empresa_atual',null);// pega a empresa selecionada	
			else	
				return Session::instance()->get('nome_empresa_atual',null);// pega a empresa selecionada	
		}

		public static function selected_empresaatual()//retorna se alguma empresa foi selecionada
		{
			return ( Session::instance()->get('empresa_atual') != 0);
		}

		public static function avatar_empresaatual() //pega o nome e o codigo da empresa pra deixar lá em cima
		{
			$str = "";
			if(Usuario::selected_empresaatual())
			{
				$empresa = 
				$str = '<h2 class="pull-right">'.Usuario::get_empresaatual(2).' <span class="label label-primary">'.Usuario::get_empresaatual().'</span></h2>';
			}
			return $str;

		}
	//================================================
	//=============================================

	

}
?>