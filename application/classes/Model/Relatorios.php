<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Relatorios extends ORM {
	protected $_primary_key = 'ID';
  	protected $_table_name = 'relatorios';
	protected $_belongs_to = array(		
		'rota' => array('model' => 'Rota', 'foreign_key' => 'Rota'), 		
		'tecnologia' => array('model' => 'Tecnologia', 'foreign_key' => 'Tecnologia'), 		
		'instrumentacao' => array('model' => 'Instrumentacao', 'foreign_key' => 'Instrumentacao'), 		
		'analista' => array('model' => 'Analista', 'foreign_key' => 'Analista')
	);

	protected $_has_many = array(
    	'arquivos' => array ( 'model' => 'ArquivoRelatorio' , 'foreign_key' => 'Relatorio' )    
    );

    protected $_has_one = array(
		'equipamentoinspecionado' => array('model' => 'EquipamentoInspecionado', 'foreign_key' => 'Relatorio')	
	);
	
	// protected $table_names_plural = false;
	// protected $foreign_key = array ( 'equipamentoinspecionado' => 'EquipamentoInspecionado', 'anomalia'=>'TipoAnomalia', 'componente'=>'TipoComponente', 'tipoinspecao' => 'TipoInspecao', 'resultados'=>'GR');

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'ID';
		}
 
		return parent::unique_key($id);
	} 
}