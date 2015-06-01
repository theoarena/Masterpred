<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Equipamento extends ORM {
	protected $_belongs_to = array(
		'setor' => array('model' => 'setor', 'foreign_key' => 'Setor'),
		'tipoequipamento' => array('model' => 'tipoequipamento', 'foreign_key' => 'TipoEquipamento')
	);
	
	protected $_has_many = array(
		'rotas' => array ( 
			'model' => 'rota' ,
			'foreign_key' => 'equipamento_CodEquipamento', 
			'far_key' => 'rota_CodRota' , 
			'through' => 'equipamento_rota'
		),
		'analiseequipamentoinspecionados' => array('model' => 'analiseequipamentoinspecionado', 'foreign_key' => 'Equipamento'),
		'equipamentoinspecionados' => array('model' => 'equipamentoinspecionado', 'foreign_key' => 'Equipamento')
	);		

  	protected $_table_name = 'equipamento';
	protected $_primary_key = 'CodEquipamento';
	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'setor' => 'Setor' , 'tipoequipamento' => 'TipoEquipamento' , 'analiseequipamentoinspecionado' => 'Equipamento' , 'equipamentoinspecionado' => 'Equipamento');

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodEquipamento';
		}
 
		return parent::unique_key($id);
	}

	function delete()
	{		
		foreach($this->analiseequipamentoinspecionados->find_all() as $entry)
		  $entry->delete();	  

		foreach($this->equipamentoinspecionados->find_all() as $entry)
		  $entry->delete();	  
		
		return parent::delete();
	}

}