<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_EquipamentoInspecionado extends ORM {
	protected $_belongs_to = array(
		'equipamento' => array('model' => 'Equipamento', 'foreign_key' => 'Equipamento'),
		'condicao' => array('model' => 'Condicao', 'foreign_key' => 'Condicao'),
		'analista' => array('model' => 'Analista', 'foreign_key' => 'Analista'),
		'tecnologia' => array('model' => 'Tecnologia', 'foreign_key' => 'Tecnologia'),
		'relatorio' => array('model' => 'Relatorios', 'foreign_key' => 'Relatorio'),
	);
	
	protected $_has_one = array(
		'gr' => array('model' => 'Gr', 'foreign_key' => 'EquipamentoInspecionado')	
	);

  	protected $_table_name = 'equipamentoinspecionado';
	protected $_primary_key = 'CodEquipamentoInspecionado';
	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'equipamento' => 'Equipamento' , 'condicao' => 'Condicao' , 'analista' => 'Analista', 'tecnologia'=>'Tecnologia', 'gr' => 'EquipamentoInspecionado');

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodEquipamento';
		}
 
		return parent::unique_key($id);
	}

}