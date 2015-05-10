<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Gr extends ORM {
	protected $_primary_key = 'CodGR';
  	protected $_table_name = 'gr';
	protected $_belongs_to = array(
		'equipamentoinspecionado' => array('model' => 'equipamentoinspecionado', 'foreign_key' => 'EquipamentoInspecionado'), 
		'anomalia' => array('model' => 'anomalia', 'foreign_key' => 'Anomalia'), 
		'componente' => array('model' => 'componente', 'foreign_key' => 'Componente'), 
		'tipoinspecao' => array('model' => 'tipoinspecao', 'foreign_key' => 'TipoInspecao'), 
	);
	
	protected $_has_one = array(

		'resultado' => array('model' => 'resultados', 'foreign_key' => 'GR')
		
	);

	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'equipamentoinspecionado' => 'EquipamentoInspecionado', 'anomalia'=>'TipoAnomalia', 'componente'=>'TipoComponente', 'tipoinspecao' => 'TipoInspecao', 'resultados'=>'GR');

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodGR';
		}
 
		return parent::unique_key($id);
	} 
}