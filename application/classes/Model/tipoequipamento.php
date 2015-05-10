<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_TipoEquipamento extends ORM {
	protected $_has_many = array("equipamentos" => array ('model' => 'equipamento', 'foreign_key' => 'CodEquipamento') );	

	protected $_primary_key = "CodTipoEquipamento";
  	protected $_table_name = 'tipoequipamento';
	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'equipamento' => 'TipoEquipamento');
	

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodTipoEquipamento';
		}
 
		return parent::unique_key($id);
	}
 
}