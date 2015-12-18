<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Area extends ORM {
	protected $_belongs_to = array('empresa' => array('model' => 'Empresa', 'foreign_key' => 'Empresa') );	
	protected $_has_many = array("setores" => array('model' => 'Setor', 'foreign_key' => 'Area') );

  	protected $_table_name = 'area';
	protected $_primary_key = "CodArea";
	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'empresa' => 'Empresa' , 'setor' => 'Area');

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodArea';
		}
 
		return parent::unique_key($id);
	}
 
 	function delete()
	{
		foreach($this->setores->find_all() as $entry)
		  $entry->delete();	   
		return parent::delete();
	}
}