<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Rota extends ORM {
	protected $_belongs_to = array('empresas' => array('model' => 'empresa', 'foreign_key' => 'CodEmpresa') );
	protected $_has_many = array( 
		'equipamentos' => array (
			 'model' => 'equipamento' ,
			 'foreign_key' => 'rota_CodRota',
			 'far_key' => 'equipamento_CodEquipamento',
			 'through' => 'equipamento_rota')
			 );	

  	protected $_table_name = 'rota';
	protected $_primary_key = 'CodRota';
	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'empresa' => 'Empresa');

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodRota';
		}
 
		return parent::unique_key($id);
	}
 
 	public function delete($rota)
	{
		foreach($this->equipamento as $entry)
		{
			$entry->remove(ORM::factory('rota',$rota));	   
			$entry->save();
		}
	
		if(parent::delete())
			return true;
		else
			return false;
	}
}