<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_ArquivoRelatorio extends ORM {
	protected $_primary_key = 'CodArquivoRelatorio';
  	protected $_table_name = 'arquivorelatorio';	

  	protected $_belongs_to = array(					
		'tecnologia' => array('model' => 'Tecnologia', 'foreign_key' => 'Tecnologia')		
	);
	
	protected $_has_one = array(

		'relatorio' => array('model' => 'Relatorio', 'foreign_key' => 'Relatorio')
		
	);

	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'equipamentoinspecionado' => 'EquipamentoInspecionado', 'anomalia'=>'TipoAnomalia', 'componente'=>'TipoComponente', 'tipoinspecao' => 'TipoInspecao', 'resultados'=>'GR');

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'CodArquivoRelatorio';
		}
 
		return parent::unique_key($id);
	} 
}