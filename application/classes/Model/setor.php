<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Setor extends ORM {
	protected $_belongs_to = array('area' => array ('model' => 'Area', 'foreign_key' => 'Area') );	
	protected $_has_many = array('equipamentos' => array ('model' => 'Equipamento', 'foreign_key' => 'Setor' ) );

  	protected $_table_name = 'setor';
	protected $_primary_key = 'CodSetor';
	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'equipamento' => 'Setor' , 'area' => 'Area');	

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodSetor';
		}
 
		return parent::unique_key($id);
	}

	
 	/*function delete()
	{
		//foreach($this->equipamentos->find_all() as $entry)
		//  $entry->delete();	   
		parent::delete();
	}*/
 
}