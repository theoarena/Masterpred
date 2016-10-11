<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Instrumentacao extends ORM {
	protected $_has_many = array(		
		 'relatorios' => array('model' => 'Relatorio', 'foreign_key' => 'Instrumentacao') ,		
	);
	
	protected $_table_name = 'instrumentacao';
	protected $_primary_key = 'CodInstrumentacao';

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodInstrumentacao';
		}
 
		return parent::unique_key($id);
	}
 
}