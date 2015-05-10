<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Privilege extends ORM {
	
    protected $_has_many = array(
    	'role' => array ( 'model' => 'role' , 'through' => 'roles_privileges','far_key' => 'role_id'  ),    	
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