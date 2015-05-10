<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_TipoInspecao extends ORM {
	protected $_has_many = array('grs' => array ('model' => 'gr' , 'foreign_key' => 'CodGr') );
	protected $_primary_key = 'CodTipoInspecao';
  	protected $_table_name = 'tipoinspecao';
//	protected $table_names_plural = false;
//	protected $foreign_key = array ( 'gr' => 'TipoInspecao' );	

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodTipoInspecao';
		}
 
		return parent::unique_key($id);
	}
 
}