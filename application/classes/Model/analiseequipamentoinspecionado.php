<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_AnaliseEquipamentoInspecionado extends ORM {
	protected $_has_one = array(
		'condicao' => array('model' => 'condicao', 'foreign_key' => 'Condicao'),
		'analista'=> array('model' => 'analista', 'foreign_key' => 'Analista'),
		'componente'=> array('model' => 'componente', 'foreign_key' => 'Componente'),
		'anomalia' => array('model' => 'anomalia', 'foreign_key' => 'Anomalia')
	);
	protected $_belongs_to = array(
		'equipamento' => array('model' => 'equipamento', 'foreign_key' => 'Equipamento'),
		'tecnologia' => array('model' => 'tecnologia', 'foreign_key' => 'Tecnologia')
		);
	//protected $has_and_belongs_to_many = array('rota');		

  	protected $_table_name = 'analiseequipamentoinspecionado';
	protected $_primary_key = 'CodEquipamentoInspAnalise';

	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'equipamento' => 'Equipamento', 'analista' => 'Analista', 'componente' => 'TipoComponente', 'anomalia' => 'TipoAnomalia','tecnologia'=>'Tecnologia');

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodEquipamentoInspAnalise';
		}
 
		return parent::unique_key($id);
	}

}