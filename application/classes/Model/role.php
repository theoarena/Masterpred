<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Role extends ORM {
    protected $_has_many = array(
    	'users' => array ( 'model' => 'user' , 'through' => 'roles_users' ),
    	'privileges' => array ( 'model' => 'privilege' , 'through' => 'roles_privileges', 'far_key' => 'privilege_id' )
    );
 
	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'name';
		}
 
		return parent::unique_key($id);
	}
 
}