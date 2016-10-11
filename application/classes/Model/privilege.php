<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Privilege extends ORM {
	
    protected $_has_many = array(
    	'role' => array ( 'model' => 'Role' , 'through' => 'roles_privileges','far_key' => 'role_id'  ),    	
    );
 
    protected $_table_name = 'privileges';
	protected $_primary_key = 'id';

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'name';
		}
 
		return parent::unique_key($id);
	}
 
}