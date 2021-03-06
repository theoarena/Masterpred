<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Analista extends ORM {
	protected $_belongs_to = array('analiseequipamentoinspecionados' => array('model' =>'AnaliseEquipamentoInspecionado', 'foreign_key' => 'CodEquipamentoInspAnalise') );	
	protected $_has_many = array( 
		'equipamentoinspecionados' => array('model' => 'EquipamentoInspecionado', 'foreign_key' => 'CodEquipamentoInspecionado') ,
		'relatorios' => array('model' => 'Relatorios', 'foreign_key' => 'Analista')
	);

  	protected $_table_name = 'analista';
	protected $_primary_key = 'CodAnalista';
	
	//protected $table_names_plural = false;
	//protected $foreign_key = array ( 'analiseequipamentoinspecionado' => 'Analista', 'equipamentoinspecionado' => 'Analista');

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodAnalista';
		}
 
		return parent::unique_key($id);
	}

	

}