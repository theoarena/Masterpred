<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Tecnologia extends ORM {
	protected $_has_many = array(
		 'componentes' => array('model' => 'componente', 'foreign_key' => 'CodComponente'),
		 'anomalias' => array('model' => 'anomalia', 'foreign_key' => 'CodAnomalia') ,
		 'recomendacoes' => array('model' =>'recomendacao', 'foreign_key' => 'CodRecomendacao'),
		 'equipamentoinspecionados' => array('model' =>'equipamentoinspecionado', 'foreign_key' => 'CodEquipamentoInspecionado'),
		 'analiseequipamentoinspecionados' => array('model' =>'analiseequipamentoinspecionado', 'foreign_key' => 'CodEquipamentoInspAnalise'),
		 'condicoes' => array('model' =>'condicao', 'foreign_key' => 'Tecnologia' , 'far_key' => 'Tecnologia')
	);
	
	protected $_table_name = 'tecnologia';
	protected $_primary_key = 'CodTecnologia';

//	protected $_table_names_plural = false;
//	protected $_foreign_key = array ('condicao'=>'Tecnologia', 'componente' => 'Tecnologia' , 'anomalia' => 'Tecnologia' , 'recomendacao' => 'Tecnologia' , 'equipamentoinspecionado' =>'Tecnologia' , 'analiseequipamentoinspecionado' => 'Tecnologia');

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodTecnologia';
		}
 
		return parent::unique_key($id);
	}
 
}