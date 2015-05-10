<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Setor extends ORM {
	protected $_belongs_to = array('area' => array ('model' => 'area', 'foreign_key' => 'Area') );	
	protected $_has_many = array('equipamentos' => array ('model' => 'equipamento', 'foreign_key' => 'CodEquipamento' ) );

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
 
}