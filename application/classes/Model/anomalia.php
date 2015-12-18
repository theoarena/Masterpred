<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Anomalia extends ORM {
	protected $_belongs_to = array(
		'tecnologia' => array('model' => 'Tecnologia', 'foreign_key' => 'Tecnologia'),
		'analiseequipamentoinspecionados' => array('model' =>'AnaliseEquipamentoInspecionado', 'foreign_key' => 'CodEquipamentoInspAnalise')
	);	
	protected $_has_many = array('grs' => array('model' => 'Gr', 'foreign_key' => 'TipoAnomalia') );
	protected $_primary_key = 'CodAnomalia';
  	protected $_table_name = 'anomalia';
	
	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'tecnologia' => 'Tecnologia' , 'analiseequipamentoinspecionado' => 'TipoAnomalia', 'gr' => 'TipoAnomalia');
	
	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodAnomalia';
		}
 
		return parent::unique_key($id);
	}
 
}