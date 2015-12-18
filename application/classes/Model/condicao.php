<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Condicao extends ORM {
	protected $_belongs_to = array(
		"analiseequipamentoinspecionados" => array('model' => 'AnaliseEquipamentoInspecionado', 'foreign_key' => 'CodEquipamentoInspAnalise'), 
		"tecnologia" => array('model' => 'Tecnologia', 'foreign_key' => 'Tecnologia')
	);		
	protected $_has_many = array("equipamentoinspecionado" => array ( 'model' => 'EquipamentoInspecionado' , 'foreign_key' => 'Condicao'));

  	protected $_table_name = 'condicao';
	protected $_primary_key = "CodCondicao";

	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'analiseequipamentoinspecionado' => 'Condicao',  'equipamentoinspecionado' => 'Condicao' , "tecnologia" => "Tecnologia");

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodCondicao';
		}
 
		return parent::unique_key($id);
	}

}