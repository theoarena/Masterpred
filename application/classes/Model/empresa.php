<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Empresa extends ORM {
	protected $_has_many = array(
		'areas' => array ('model' => 'area', 'foreign_key' => 'CodArea' ) ,
		'rotas' => array ('model' => 'rota', 'foreign_key' => 'CodRota' ) ,
	    'users' => array ( 'model' => 'user' , 'through' => 'empresa_users','far_key' => 'user_id' , 'foreign_key' => 'empresa_CodEmpresa')
	);
	
  	protected $_table_name = 'empresa';  	
	protected $_primary_key = 'CodEmpresa';		
	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'area' => 'Empresa','rota'=>'Empresa');

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodEmpresa';
		}
 
		return parent::unique_key($id);
	}

	function delete()
	{
		foreach($this->area as $entry)
		  $entry->delete();	   
		parent::delete();
	}
 
}