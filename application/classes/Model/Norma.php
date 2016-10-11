<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Norma extends ORM {
	protected $_has_many = array(
		'tecnologias' => array ( 'model' => 'Tecnologia' , 'through' => 'tecnologia_norma','far_key' => 'tecnologia_CodTecnologia' , 'foreign_key' => 'norma_CodNorma')
	);
	
	protected $_table_name = 'norma';
	protected $_primary_key = 'CodNorma';

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodNorma';
		}
 
		return parent::unique_key($id);
	}
 
}