<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_User extends Model_Auth_User {
	protected $_has_many = array(
		'roles' => array ('model' => 'role' , 'through' => 'roles_users'),
		'empresas' => array ( 'model' => 'empresa' , 'through' => 'empresa_users','far_key' => 'empresa_CodEmpresa')
	);		
 
	protected $_table_name = 'users';
	protected $_primary_key = "id";

	 protected function _login($username, $password, $remember)
    {
        // Do username/password check here
    }
 
    public function password($username)
    {
        // Return the password for the username
    }
 
    public function check_password($password)
    {
        // Check to see if the logged in user has the given password
    }
 
    public function logged_in($role = NULL)
    {
        // Check to see if the user is logged in, and if $role is set, has all roles
    }
 
    public function get_user($default = NULL)
    {
        // Get the logged in user, or return the $default if a user is not found
    }

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'username';
		}
 
		return parent::unique_key($id);
	}

	public function checa_email($email)
	{

		$u = ORM::factory('user')->where('email','=',$email);
		if($u->count_all()>0)
			return false;
		return true;
	}

	public function checa_usuario($usuario)
	{

		$u = ORM::factory('user')->where('username','=',$usuario);
		if($u->count_all()>0)
			return false;
		return true;
	}

	public function get_privileges($return=true)
	{
		if(Session::instance()->get('usuario_privileges',false))
			return Session::instance()->get('usuario_privileges');
		else
		{		
			$role = $this->roles->find_all();
			$role = $role[1]; //pega só a role que nao é LOGIN
			$privileges =  $role->privileges->find_all()->as_array('id','name');
			$privileges_str = implode(',',$privileges);	
			Session::instance()->set('usuario_privileges',$privileges_str);
			if($return)
				return $privileges_str;
		}
	}

	function delete()
	{
		foreach($this->roles->find_all() as $entry)		
		 $this->remove('roles',$entry);

		return parent::delete();
	}
 
}