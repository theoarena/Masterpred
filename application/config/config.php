<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(

	//general
	'system_active' => TRUE,
	'aviso_manutencao' => FALSE,
	'system_version' => 'Beta 1.0',
	'site_domain' => '/masterpred',
	'site_name' => 'Masterpred',
	
	'endereco_sistema' => '',
	//'endereco_sistema' => 'http://www.masterpred.com.br/sistema',
	'endereco_site' => 'www.masterpred.com.br',
	'telefone' => '(19) 9844-5510',
	'select_default' => '-- Selecione --',
	'index_page' => 'index.php/',
	
	//Dirs
	'mpdf' => 'application/media/classes/mpdf/mpdf.php',
	'css' => 'application/media/css/',
	'composer' => 'vendor/autoload.php',

	//uploads
	'upload_directory' => 'application/media/uploads/analises/',
	'upload_directory_gr' => 'application/media/uploads/gr/',
	'upload_directory_condicoes' => 'application/media/uploads/condicoes/',
	'upload_directory_relatorios' => 'application/media/uploads/relatorios/',
	'upload_directory_assinaturas' => 'application/media/uploads/assinaturas/',
	'upload_directory_empresas' => 'application/media/uploads/empresas/',
	'upload_directory_tecnologias' => 'application/media/uploads/tecnologias/',

	//condicoes
	'tipos_condicao' => array("GR-0","GR-1","GR-2","GR-3","GR-4","GR-5"), //condiçoes de emergência
	'cores_condicao' => array(
		"green"=>"Verde",
		"bordeaux"=>"Vinho",
		"red"=>"Vermelho",
		"orange"=>"Laranja",
		"yellow"=>"Amarelo",
		"dark_orange"=>"Laranja Escuro",
		"grey"=>"Cinza",
		"black"=>"Preto",
		"light_green"=>"Verde Claro",
		"light_blue"=>"Azul Claro",
		""=>"-"	
	),

	//mail
	'email_site' => 'sistema@masterpred.com.br',
	'nome_email_site' => 'Masterpred',
	'mail' => array(		
		'hostname'=>'smtp.masterpred.com.br', 
		'port'=>'587', 
		'username'=>'sistema@masterpred.com.br',
		'password'=>'masterpred123'
	)
);

