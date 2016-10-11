<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Tecnologia extends ORM {
	protected $_has_many = array(
		 'componentes' => array('model' => 'Componente', 'foreign_key' => 'Tecnologia'),
		 'anomalias' => array('model' => 'Anomalia', 'foreign_key' => 'Tecnologia') ,
		 'relatorios' => array('model' => 'Relatorio', 'foreign_key' => 'Tecnologia') ,
		 'arquivos' => array('model' => 'Relatorio', 'foreign_key' => 'Tecnologia') ,
		 'recomendacoes' => array('model' =>'Recomendacao', 'foreign_key' => 'Tecnologia'),
		 'arquivos' => array('model' =>'ArquivoRelatorio', 'foreign_key' => 'Tecnologia'),
		 'equipamentoinspecionados' => array('model' =>'EquipamentoInspecionado', 'foreign_key' => 'CodEquipamentoInspecionado'),
		 'analiseequipamentoinspecionados' => array('model' =>'AnaliseEquipamentoInspecionado', 'foreign_key' => 'CodEquipamentoInspAnalise'),
		 'condicoes' => array('model' =>'Condicao', 'foreign_key' => 'Tecnologia' , 'far_key' => 'Tecnologia'),
		 'normas' => array ( 'model' => 'Norma' , 'through' => 'tecnologia_norma','far_key' => 'norma_CodNorma' , 'foreign_key' => 'tecnologia_CodTecnologia')
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