<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(

	'system_version' => '1.0',
	'site_domain' => '/masterpred',
	
	'endereco_site' => 'httpp://www.masterpred.com.br/sistema',
	'endereco' => 'www.masterpred.com.br',
	'telefone' => '(19) 9844-5510',
	'select_default' => '-- Selecione --',
	'index_page' => 'index.php/',
	
	//uploads
	'upload_directory' => 'application/media/uploads/',
	'upload_directory_gr' => 'application/media/uploads/gr/',
	'upload_directory_condicoes' => 'application/media/uploads/condicoes/',

	//condicoes
	'tipos_condicao' => array("GR-0","GR-1","GR-2","GR-3","GR-4"),
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

