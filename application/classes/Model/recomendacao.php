<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Recomendacao extends ORM {
	protected $_belongs_to = array('tecnologia' => array('model' => 'Tecnologia', 'foreign_key' => 'Tecnologia') );

	protected $_primary_key = "CodRecomendacao";
  	protected $_table_name = 'recomendacao';
	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'tecnologia' => 'Tecnologia' );
	

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodRecomendacao';
		}
 
		return parent::unique_key($id);
	}
 
}