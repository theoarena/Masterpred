<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Componente extends ORM {
	protected $_belongs_to = array('tecnologia' => array('model' => 'Tecnologia', 'foreign_key' => 'Tecnologia') );	
	protected $_has_many = array("grs" => array('model' => 'Gr', 'foreign_key' => 'TipoComponente') );
	protected $_primary_key = "CodComponente";
  	protected $_table_name = 'componente';
  	
	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'tecnologia' => 'Tecnologia', "analiseequipamentoinspecionado" => "TipoComponente" , "gr" => "TipoComponente" );

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodComponente';
		}
 
		return parent::unique_key($id);
	}
 
}