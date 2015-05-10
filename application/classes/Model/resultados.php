<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Resultados extends ORM {
	protected $_belongs_to = array('gr' => array('model' => 'gr', 'foreign_key' => 'GR') );	
	protected $_table_name = 'resultados';
	protected $_primary_key = "CodResultado";		
	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'gr' => 'GR');

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodResultado';
		}
 
		return parent::unique_key($id);
	} 
}