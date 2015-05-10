<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Empresas extends Controller_Welcome {
	
	public $privileges_needed = array("access_empresa");

	public function before(){
		parent::before();

		if(!site::checkPermissaoPagina($this->privileges_needed)) //se pode acessar a url
			HTTP::redirect('welcome/denied');

		$this->template->content = View::factory("main_content");							
	}
	
	//======================================================//
	//==================GRAU DE RISCO================================//
	//======================================================//	

	public function action_grauderisco() //página principal dos graus de risco
	{	

		$this->template->content->conteudo = View::factory("empresas/list_grauderisco");						
		$list = ORM::factory('Tecnologia')->find_all()->as_array("CodTecnologia","Tecnologia");
		$list["padrao"] = "Selecione uma tecnologia";

		$this->template->content->conteudo->tecnologias = $list;
		$this->template->content->conteudo->query = ( isset($_GET["tec"]) )?(true):(false);
						
		//$this->template->content->conteudo->objs = $rotas;
	}
	
	public function action_edit_grauderisco()
	{
		
		$obj = ORM::factory('Gr', site::segment('edit_grauderisco',null) );
		$this->template->content->conteudo = View::factory("empresas/edit_grauderisco");						
		$this->template->content->conteudo->obj = $obj;						
		$this->template->content->conteudo->componentes = ORM::factory('Componente')->where("Tecnologia",'=',$obj->equipamentoinspecionado->Tecnologia)->find_all()->as_array("CodComponente","Componente");						
		$this->template->content->conteudo->anomalias = ORM::factory('Anomalia')->where("Tecnologia",'=',$obj->equipamentoinspecionado->Tecnologia)->find_all()->as_array("CodAnomalia","Anomalia");						
		$this->template->content->conteudo->condicoes = ORM::factory('Condicao')->where("Tecnologia",'=',$obj->equipamentoinspecionado->Tecnologia)->find_all()->as_array("CodCondicao","Condicao");						
		$this->template->content->conteudo->inspecoes = ORM::factory('TipoInspecao', site::segment('edit_grauderisco',null) )->find_all()->as_array("CodTipoInspecao","TipoInspecao");						

		$query = parse_url(URL::query());
		$this->template->content->conteudo->query = ( isset($query["query"]) )?($query["query"]):("1=1");
	}

	public function action_carrega_grausderisco() 
	{
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda	

		$de = false;
		$ate = false;

		if($this->request->post('de')!=0)
			$de = site::data_EN($this->request->post('de'));
		if($this->request->post('ate')!=0)
			$ate = site::data_EN($this->request->post('ate'));

		$grs = array();
		$objs = ORM::factory('EquipamentoInspecionado');

		if($de!=false)
			$objs->where('Data','>=',$de);
		if($ate!=false)
			$objs->where('Data','<=',$ate);

		// fazer select pra escolher só as que estao em emergencia
		$objs->where("EquipamentoInspecionado.Tecnologia",'=',$this->request->post('tecnologia'));	
		$objs->where("EquipamentoInspecionado.Empresa",'=',site::get_empresaatual());	
		$objs->join('Condicao','LEFT')->on('Condicao.CodCondicao','=','EquipamentoInspecionado.Condicao');
		$objs->where("Condicao.Emergencia",'=',1);
			



		$equip = $objs->find_all();
		foreach ($equip as $equipamento) { //peguei os equip inspecionado

			$gr = ORM::factory('gr');
			$gr->where( 'EquipamentoInspecionado','=',$equipamento->CodEquipamentoInspecionado );		

			if($this->request->post('tipo') == "nao")
				$gr->where("confirmado",'=',0);
			else
				$gr->where("confirmado",'=',1);

			$gr = $gr->find();		
			if($gr->CodGR) //só deu certo assim essa porra
			{
				$grs[] = array(
						'CodGr' => $gr->CodGR,					
						'NumeroGr' => $gr->NumeroGR,
						'Equipamento' => $equipamento->equipamento->Equipamento,
						//'Anomalia' => ($gr->TipoAnomalia != null)?($gr->anomalias->Anomalia):"",
						//'Anomalia' => ($gr->Anomalia != null)?($gr->Anomalia):"",
						//'Componente' => ($gr->TipoComponente!=NULL)?($gr->componente->Componente):"",
						'Componente' => ($gr->Componente!=NULL)?($gr->Componente):"",
						'Inspecao' => ($gr->TipoInspecao!=NULL)?($gr->tipoinspecao->TipoInspecao):"",
						'Data' => site::datahora_BR($equipamento->Data)
					);
			}
		}
		print json_encode($grs);	

	}

	public function action_save_grauderisco() //salva a análise
	{		
		$obj = ORM::factory("gr",$this->request->post('CodGR'));		

		$obj->TipoComponente = $this->request->post('TipoComponente');
		$obj->Componente = $this->request->post('Componente');
		$obj->Detalhe = $this->request->post('Detalhe');
		$obj->TipoAnomalia = $this->request->post('TipoAnomalia');
		$obj->Anomalia = $this->request->post('Anomalia');
		$obj->Recomendacao = $this->request->post('Recomendacao');
		$obj->Obs = $this->request->post('Obs');
		$obj->GRReferencia = $this->request->post('GRReferencia');
		$obj->TipoInspecao = $this->request->post('TipoInspecao');
		$obj->TipoInspecao = $this->request->post('TipoInspecao');

		$obj->Ir = $this->request->post('Ir');
		$obj->Is = $this->request->post('Is');
		$obj->It = $this->request->post('It');
		$obj->In = $this->request->post('In');
		$obj->Vr = $this->request->post('Vr');
		$obj->Vs = $this->request->post('Vs');
		$obj->Vt = $this->request->post('Vt');
		$obj->Vn = $this->request->post('Vn');
		$obj->TemperaturaRef = $this->request->post('TemperaturaRef');
		$obj->confirmado = 1;

		$dir = Kohana::$config->load('config')->get('upload_directory_gr');
		if(isset($_FILES['ImagemReal']) and $_FILES['ImagemReal']["name"] != "")
		{
			$file = $_FILES['ImagemReal'];
			$filename = Upload::save($file,null,$dir);	
			$foto = $dir."/real_".$this->request->post('CodGR')."_".basename($filename);
			Image::factory($filename)->save($foto);	
		    unlink($filename);
		    $obj->ImagemReal = "real_".$this->request->post('CodGR')."_".basename($filename);
		}	

		if(isset($_FILES['ImagemTermica']) and $_FILES['ImagemTermica']["name"] != "")
		{
			$file = $_FILES['ImagemTermica'];
			$filename = Upload::save($file,null,$dir);					
			$foto = $dir."/termica_".$this->request->post('CodGR')."_".basename($filename);
			Image::factory($filename)->save($foto);	
		    unlink($filename);
		    $obj->ImagemTermica = "termica_".$this->request->post('CodGR')."_".basename($filename);
		}	


		$equip = $obj->equipamentoinspecionado;

		$equip->Condicao = $this->request->post('Condicao',null);
		$equip->save();

		if($obj->save())	
			HTTP::redirect("empresas/grauderisco?".$this->request->post('query')."&sucesso=1");	
		else
			HTTP::redirect("empresas/grauderisco?".$this->request->post('query')."&erro=1");

	}

	//======================================================//
	//==================ANALISE DE INSPECAO================================//
	//======================================================//	

	public function action_analiseinspecao() //página principal das Inspeçoes
	{	
		$rotas = ORM::factory('Rota')->where( 'Empresa','=',site::get_empresaatual() )->find_all(); //vamos pegar todas as rotas dessa empresa	

		$this->template->content->conteudo = View::factory('empresas/list_analiseinspecao');						
		$this->template->content->conteudo->objs = $rotas;
	}

	public function action_edit_analiseinspecao_novo() //adicionar um nova AnaliseEquipamentoInspecionado, essa tabela é só temporária
	{			
		$obj = ORM::factory('AnaliseEquipamentoInspecionado', site::segment('edit_analiseinspecao',null));
		$this->template->content->conteudo = View::factory('empresas/edit_analiseinspecao_novo');	
		
		if(site::get_empresaatual() != null)
		{
			$rotas = ORM::factory('Rota')->where( 'Empresa','=',site::get_empresaatual() )->find_all()->as_array('CodRota','Rota'); //vamos pegar todas as rotas dessa empresa	
			$analistas = ORM::factory('Analista')->find_all()->as_array('CodAnalista','Analista');
			$tecnologias = ORM::factory('Tecnologia')->find_all()->as_array('CodTecnologia','Tecnologia');								
			
			$this->template->content->conteudo->obj = $obj;					
			$this->template->content->conteudo->rotas = $rotas;			
			$this->template->content->conteudo->analistas = $analistas;			
			$this->template->content->conteudo->tecnologias = $tecnologias;			
		}			

	}

	public function action_edit_analiseinspecao() //fazer a análise
	{			
		$obj = ORM::factory('AnaliseEquipamentoInspecionado', site::segment('edit_analiseinspecao',null));

		$tecnologia = $obj->tecnologia; //pega a tecnologia que esta vinculada a esta analise
		$componentes = $tecnologia->componentes->find_all()->as_array('CodComponente','Componente');
		$anomalias = $tecnologia->anomalias->find_all()->as_array('CodAnomalia','Anomalia');
		$recomendacoes = $tecnologia->recomendacoes->find_all()->as_array('CodRecomendacao','Recomendacao');
		
		$this->template->content->conteudo = View::factory('empresas/edit_analiseinspecao');							
		
		$this->template->content->conteudo->obj = $obj;					
		$this->template->content->conteudo->recomendacoes = $recomendacoes;			
		$this->template->content->conteudo->anomalias = $anomalias;			
		$this->template->content->conteudo->componentes = $componentes;			
		$this->template->content->conteudo->tecnologia = $tecnologia;			
	}

	public function action_save_analiseinspecao() //salva a análise
	{
		
		$obj = ORM::factory('AnaliseEquipamentoInspecionado',$this->request->post('CodEquipamentoInspAnalise'));
			
		$obj->TipoComponente = $this->request->post('TipoComponente');
		$obj->Componente = $this->request->post('Componente');
		$obj->Detalhe = $this->request->post('Detalhe');
		$obj->TipoAnomalia = $this->request->post('TipoAnomalia');
		$obj->Anomalia = $this->request->post('Anomalia');
		$obj->Recomendacao = $this->request->post('Recomendacao');
		$obj->Obs = $this->request->post('Obs');

		$obj->Ir = $this->request->post('Ir');
		$obj->Is = $this->request->post('Is');
		$obj->It = $this->request->post('It');
		$obj->In = $this->request->post('In');
		$obj->Vr = $this->request->post('Vr');
		$obj->Vs = $this->request->post('Vs');
		$obj->Vt = $this->request->post('Vt');
		$obj->Vn = $this->request->post('Vn');
		$obj->TemperaturaRef = $this->request->post('TemperaturaRef');
		$obj->TemperaturaMed = $this->request->post('TemperaturaMed');

		if($obj->save())	
			HTTP::redirect('empresas/analiseinspecao?sucesso=1');	
		else
			HTTP::redirect('empresas/analiseinspecao?erro=1');

	}

	public function action_save_analiseinspecao_novo() //cria novos registros
	{		
		$rota = ORM::factory('Rota',$this->request->post('Rota'));

		foreach ($rota->equipamentos->find_all() as $equipamento) {			
			$obj = ORM::factory('AnaliseEquipamentoInspecionado');	
			$obj->Equipamento = $equipamento->CodEquipamento;
			$obj->Analista = $this->request->post('Analista');
			$obj->Tecnologia = $this->request->post('Tecnologia');
			$obj->Data = site::data_EN($this->request->post('Data')).' '.date('H:i:s');
			$obj->save();
		}	
	
		HTTP::redirect('empresas/analiseinspecao?sucesso=1');	
	}

	public function action_teste() //transfere tudo pra cada tabela
	{
		$empresa = 39;
		$tec = 3;
		$this->template = "";
		$db = DB::query(Database::SELECT,"SELECT max(gr.NumeroGR) as 'numerogr' from gr, equipamentoinspecionado where Empresa = :empresa and CodEquipamentoInspecionado = EquipamentoInspecionado and Tecnologia = :tecnologia")
			->bind(':empresa', $empresa)
			->bind(':tecnologia',$tec);
					
		$result = $db->execute();
		print_r( intval($result[0]) -1	);
	}


	public function action_transferir_analiseinspecao() //transfere tudo pra cada tabela
	{		
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		$analises = ORM::factory('AnaliseEquipamentoInspecionado')->find_all(); //pega todas as análises
		$empresa = ORM::factory('Empresa',site::get_empresaatual()); //pega a empresa

		foreach ($analises as $item) { // para cada item, vamos passar pra tabela correspondente

			$equipamento = ORM::factory('EquipamentoInspecionado'); //vamos criar um novo item do equipamento inspecionado			
			//$empresa = $equipamento->setor->area->empresa
			$tec = $item->Tecnologia;
			$equipamento->Equipamento = $item->Equipamento; //ta pegando o campo da coluna, é pra ser assim ao inves do objeto?
			$equipamento->Condicao = $item->Condicao;
			$equipamento->Analista = $item->Analista;
			$equipamento->Tecnologia = $tec;
			$equipamento->Data = $item->Data;
			$equipamento->Empresa = site::get_empresaatual(); // FICA MUITO MAIS FACIL E RAPIDO TENDO ESSE CAMPO...
			$equipamento->save();

			//pega a gr mais alta daquela tecnologia, daquela empresa
			
			$db = DB::query(Database::SELECT,"SELECT max(gr.NumeroGR) as 'numerogr' from gr, equipamentoinspecionado where Empresa = :empresa and CodEquipamentoInspecionado = EquipamentoInspecionado and Tecnologia = :tecnologia")
			->bind(':empresa', site::get_empresaatual())
			->bind(':tecnologia',$tec);
				
			$result = $db->execute();

			$valor = (intval($result[0])-1); //por algum motivo vem como 1 quando transforma em INT

			$gr = ORM::factory('Gr'); //vamos criar um novo item de GR
			$gr->EquipamentoInspecionado = $equipamento->CodEquipamentoInspecionado;
			$gr->NumeroGR = ($valor+1); //maior numero de GR da empresa, +1
			$gr->Estado = 1; //ativado
			$gr->Anomalia = $item->Anomalia;
			$gr->TipoAnomalia = $item->TipoAnomalia;
			$gr->Componente = $item->Componente;
			$gr->TipoComponente = $item->TipoComponente;
			$gr->Recomendacao = $item->Recomendacao;
			$gr->Detalhe = $item->Detalhe;
			$gr->TemperaturaRef = $item->TemperaturaRef;
			$gr->TemperaturaMed = $item->TemperaturaMed;
			$gr->Obs = $item->Obs;			
			//$gr->TipoInspecao = 1;			
			$gr->save();

			$item->delete(); //remove o item da tabela AnaliseEquipamentoInspecionado;
		}

		//======= vamos avisar os usuários
/*
			$empresa = ORM::factory('Empresa',site::get_empresaatual());
			foreach ($empresa->users->find_all() as $usuario)
				enviaEmail::aviso_inspecao($usuario);			
*/
		//================================

		print 1;
		//HTTP::redirect('empresas/analiseinspecao?transferido=1');	
		
	}

	public function action_delete_analiseinspecao()
	{		
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda

		if( Arr::get($_GET, 'todos') )
		{
			$db = DB::query(Database::DELETE,"TRUNCATE analiseequipamentoinspecionado");
			$db->execute();
			//ORM::factory('AnaliseEquipamentoInspecionado')->delete_all();	
			print 1;
		}
		else
		{
			$obj = ORM::factory('AnaliseEquipamentoInspecionado',$this->request->post('id'));
			if($obj->delete())
				print 1;
			else
				print 0;	
		}
		
	}

	public function action_duplicate_analiseinspecao()
	{		
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		
		$obj = ORM::factory('AnaliseEquipamentoInspecionado',$this->request->post('id'));

		$novo = ORM::factory('AnaliseEquipamentoInspecionado');
		$novo->Equipamento = $obj->Equipamento;		
		$novo->Data = $obj->Data;
		$novo->Analista = $obj->Analista;			
		$novo->Tecnologia = $obj->Tecnologia;		

		if($novo->save())
			print 1;
		else
			print 0;	
		
		
	}
	
	public function action_mudacondicao()
	{
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		$id = $this->request->post('id');
		$condicao = $this->request->post('condicao');
		$inspecao = ORM::factory('AnaliseEquipamentoInspecionado',$id);
		$inspecao->Condicao = $condicao;
		if($inspecao->save())
			print 1;
		else
			print 0;
	}

	public function action_linkinspecao() //verifica se a inspecao possui alguma condicao de urgencia, caso contrario não permite que o usuário 
	{
		$id = $this->request->post('id');
	}
	
	//======================================================//
	//==================EMPRESAS=========================//
	//======================================================//	

	public function action_empresas() //página principal dos empresas
	{	
		$objs =ORM::factory('Empresa')->find_all();
		$this->template->content->conteudo = View::factory('empresas/list_empresas');					
		$this->template->content->conteudo->objs = $objs;			
	}

	public function action_edit_empresas() //edit dos empresas
	{			
		$obj = ORM::factory('Empresa', site::segment('edit_empresas',null) );

		$this->template->content->conteudo = View::factory('empresas/edit_empresas');					
		$this->template->content->conteudo->obj = $obj;			
	}
	
	public function action_save_empresas() //salvar novo e editar
	{			
		$obj = ORM::factory('Empresa',$this->request->post('CodEmpresa'));		

		$obj->Empresa = $this->request->post('Empresa'); //nome da empresa
		$obj->Unidade = $this->request->post('Unidade');				
		$obj->Fabrica = $this->request->post('Fabrica');				
		
		if ($obj->save()) 
			HTTP::redirect('empresas/empresas?sucesso=1');
		else
			HTTP::redirect('empresas/edit_empresas?erro=1&Empresa='.$this->request->post('Empresa'));
		
	}

	public function action_toggle_empresas() //ativar/desativar a empresa que está se trabalhando
	{
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		site::set_empresaatual($this->request->post('id'),$this->request->post('nome'));
		
		print 1;
	}

	public function action_delete_empresas()
	{		
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		$obj = ORM::factory('Empresa',$this->request->post('id'));	

		if($obj->delete())
			print 1;
		else
			print 0;
	}
	
	//======================================================
	//======================================================

	//======================================================//
	//==================ROTAS=========================//
	//======================================================//	

	public function action_rotas() //página principal dos rotas
	{			
		$objs = ORM::factory('Rota')->where('Empresa','=',site::get_empresaatual())->find_all();
		
		$this->template->content->conteudo = View::factory('empresas/list_rotas');					
		$this->template->content->conteudo->objs = $objs;			
	}

	public function action_edit_rotas() //edit dos rotas
	{			
		$obj = ORM::factory('Rota', site::segment('edit_rotas',null) );
		$equipamentos_selecionados = $obj->equipamentos->find_all()->as_array('CodEquipamento','Equipamento');
		//print_r($equipamentos_selecionados);exit;
		$this->template->content->conteudo = View::factory('empresas/edit_rotas');					
		$this->template->content->conteudo->obj = $obj;				
		$this->template->content->conteudo->empresa = site::get_empresaatual(0);				
		$this->template->content->conteudo->equipamentos_selecionados = $equipamentos_selecionados;				
	}
	
	public function action_save_rotas() //salvar novo e editar
	{	
		$obj = ORM::factory('rota',$this->request->post('CodRota' ));		

		$obj->Rota = $this->request->post('Rota');					
		$obj->equipamento = $this->request->post('equipamento');					
		$obj->Empresa = $this->request->post('Empresa');					
		
		if ($obj->save()) 
			HTTP::redirect('empresas/rotas?sucesso=1');
		else
			HTTP::redirect('empresas/edit_rotas?erro=1&Rota='.$this->request->post('Rota'));		
	}

	public function action_delete_rotas()
	{		
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		$obj = ORM::factory('rota',$this->request->post('id'));	
		if($obj->delete($obj->CodRota))
			print 1;
		else
			print 0;
	}
	
	//======================================================
	//======================================================


	//======================================================//
	//==================EQUIPAMENTOS=========================//
	//======================================================//	

	public function action_equipamentos() //página principal dos equipamentos
	{			
		$this->template->content->conteudo = View::factory('empresas/list_equipamentos');					
		$this->template->content->conteudo->objs = ORM::factory('Area')->where('Empresa','=',site::get_empresaatual())->find_all()->as_array('CodArea', 'Area');	//pega as areas		
		$this->template->content->conteudo->area =  site::segment(3,null);	
		$this->template->content->conteudo->setor =  site::segment(4,null);		
	}

	public function action_edit_equipamentos() //edit dos equipamentos
	{			
		$obj = ORM::factory('Equipamento', site::segment('edit_equipamentos',null) );
		$tipo_equipamento = ORM::factory('TipoEquipamento')->find_all()->as_array('CodTipoEquipamento','TipoEquipamento');
		
		$this->template->content->conteudo = View::factory('empresas/edit_equipamentos');					
		$this->template->content->conteudo->obj = $obj;				
		$this->template->content->conteudo->tipo_equipamento = $tipo_equipamento;				
		$this->template->content->conteudo->setor =  site::segment(4);				
		$this->template->content->conteudo->area =  site::segment(5);				
	}

	public function action_carrega_equipamentos() //carrega por ajax
	{			
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		$equips = array();
		$objs = ORM::factory('Equipamento')->where('Setor','=',$this->request->post('setor'))->find_all();
		foreach ($objs as $e) {
			$equips[] = array(
					'CodEquipamento' => $e->CodEquipamento,					
					'Tag' => $e->Tag,
					'Equipamento' => $e->Equipamento,
					'codSetor' => $this->request->post('setor'),
					'TipoEquipamento' => $e->tipoequipamento->TipoEquipamento
				);
		}
		print json_encode($equips);	
				
	}

	
	public function action_save_equipamentos() //salvar novo e editar
	{			
		$obj = ORM::factory('Equipamento',$this->request->post('CodEquipamento'));		
		
		$obj->Equipamento = $this->request->post('Equipamento');					
		$obj->Setor = $this->request->post('Setor');					
		$obj->Tag = $this->request->post('Tag');					
		$obj->TipoEquipamento = $this->request->post('TipoEquipamento');					
		$obj->Estado = ($this->request->post('Estado')==1)?(1):(0);					
		$obj->Ordem = $this->request->post('Ordem');						
		
		if ($obj->save()) 
			HTTP::redirect('empresas/equipamentos/'.$this->request->post('Area').'/'. $this->request->post('Setor').'?sucesso=1');
		else
			HTTP::redirect('empresas/edit_equipamentos?erro=1&Equipamento='.$this->request->post('Equipamento'));
		
	}

	public function action_delete_equipamentos()
	{		
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		$obj = ORM::factory('Equipamento',$this->request->post('id'));	
		if($obj->delete())
			print 1;
		else
			print 0;
	}
	
	//======================================================
	//======================================================


	//======================================================//
	//==================ÁREAS E SETORES===============================//
	//======================================================//	
	
	public function action_areas_setores() //página principal dos rotas
	{			
		$objs = ORM::factory('Area')->where('Empresa','=',site::get_empresaatual())->find_all();
		
		$this->template->content->conteudo = View::factory('empresas/list_areas_setores');					
		$this->template->content->conteudo->objs = $objs;		
		$this->template->content->conteudo->empresa = site::get_empresaatual(); //id da empresa atual	
	}


	public function action_save_areas() //save/edit areas
	{		
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		$obj = ORM::factory('Area',$this->request->post('id'));	//se for nulo é um novo registro
		$obj->Area = $this->request->post('area');
		$obj->Empresa = $this->request->post('empresa');		

		if($obj->save())
		{
			$html = '';
			foreach ( ( $this->action_carrega_areas($this->request->post('empresa')) ) as $i)
				$html .= '<a href="javascript:void(0)" class="list-group-item" id="area_'.$i->CodArea.'" onclick="load_setores('.$i->CodArea.')" name="'.$i->Area.'">'.$i->Area.'  <button type="button" class="delete btn btn-danger">X</button> </a>';

			print $html;			
		}
		else
			print '<h4>Ocorreu algum erro, tente novamente</h4>';
	}

	public function action_carrega_areas($e = null) //carrega as áreas por ajax
	{		
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		if($e!=null)
			return ORM::factory('Area')->where('Empresa','=',$e)->find_all();
		else
			print ORM::factory('Area')->where('Empresa','=',$this->request->post('empresa'))->find_all();	
				
	}

	public function action_save_setores() //save/edit setores
	{		
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		$obj = ORM::factory('Setor',$this->request->post('id'));	//se for nulo é um novo registro
		$obj->Area = $this->request->post('area');
		$obj->Setor = $this->request->post('setor');		

		if($obj->save())		
			print $this->action_carrega_setores();			
		else
			print '<h4>Ocorreu algum erro, tente novamente</h4>';
	}

	public function action_carrega_setores() //carrega os setores por ajax
	{			
		$this->template = "";
		if(isset($_GET["a"])) 
		{			
			$setores =  ORM::factory('Setor')->where('Area','=',$this->request->post('id'))->find_all()->as_array('CodSetor', 'Setor');
			print json_encode($setores);			
		}
		else
		{	
			$objs = ORM::factory('Setor')->where('Area','=',$this->request->post('area'))->find_all();			
			
			$html = "";

			if(count($objs) > 0)
				foreach ( $objs as $i)
					$html .= "<a href='javascript:void(0)' class='list-group-item' name='".$i->Setor."' id='setor_".$i->CodSetor."' onclick=\"edita_setor('$i->CodSetor')\" >".$i->Setor."</a>";
			else
				$html = '<h4>Nenhum setor nesta área.</h4>';

			print $html;	
		}				
	}


	//======================================================//
	//==================USUARIOS=========================//
	//=====================================================
	public function action_usuarios() //página principal dos usuarios
	{			
		$empresa = ORM::factory('Empresa',site::get_empresaatual());		
		$this->template->content->conteudo = View::factory('empresas/list_usuarios');					
		$this->template->content->conteudo->objs = $empresa->where('ativo','=',1)->users->find_all();	//mostra só os usuários que estão ativos		
	}

	public function action_edit_usuarios() //edit dos usuarios
	{			
		$obj = ORM::factory('User', site::segment('edit_usuarios',null) );
		
		$array = array();
		foreach ($obj->empresas->find_all() as $emp)  //pegar as empresas do usuario
			$array[] = $emp->CodEmpresa;

		if(sizeof($array) == 0) //se nao tiver nenhuma, deixa a empresa atual como já selecionada
			$array[] = site::get_empresaatual();

		$roles = ORM::factory('Role')->find_all()->as_array('id','name');		
		unset($roles[1]);//tira a role LOGIN, já que ela é padrão

		$roles_selecionadas = 1;
		foreach ($obj->roles->find_all() as $r) 
			$roles_selecionadas = $r->id;

		$this->template->content->conteudo = View::factory('empresas/edit_usuarios');					
		$this->template->content->conteudo->obj = $obj;	
		$this->template->content->conteudo->roles = $roles;				
		$this->template->content->conteudo->roles_selecionadas = $roles_selecionadas;				
		$this->template->content->conteudo->empresas_selecionadas = $array;	
		$list = array();
		foreach( (ORM::factory('Empresa')->find_all()) as $i )
			$list[$i->CodEmpresa] = $i->Empresa.' - '.$i->Unidade; 

		$this->template->content->conteudo->empresas = $list;				
	}
	
	public function action_save_usuarios() //salvar novo e editar
	{			

		$obj = ORM::factory('User',$this->request->post('id'));
				
		$obj->username = $this->request->post('username');					
		$obj->ativo = $this->request->post('ativar');					
		$obj->email = $this->request->post('email');					
		$obj->nome = $this->request->post('nome');					
		$obj->telefone = $this->request->post('telefone');
		
		$obj->nascimento = site::data_EN( $this->request->post('nascimento') );	

		$password = null;
		$password_email = '';

		if($this->request->post('gerar_senha')==1) //se é pra alterar a senha	
		{	
			if($this->request->post('senha_aleatoria')==0)	
				$password_email = $this->request->post('password');								
			else			
				$password_email = site::random_password( 8,$this->request->post('email') ); //gera uma senha aleatória 				
				
			$obj->password = $password_email; 
		}		
			
			
		if ($obj->save()) 
		{	
			//roles 			
			$user_roles = array();

			foreach ($obj->roles->find_all() as $o)
				$user_roles[] = $o->id;	
			
			if( is_array( $this->request->post('role') ) ) 
			{	

				$ids_remove = array_diff( $user_roles, $this->request->post('role') );
				$ids_add = array_diff( $this->request->post('role') , $user_roles );
			
				if(count($ids_remove) > 0)
					$obj->remove('roles',$ids_remove) ;
				if(count($ids_add) > 0)
					$obj->add('roles',$ids_add);
			}
			//empresas
			$user_empresas = array();

			foreach ($obj->empresas->find_all() as $o)
				$user_empresas[] = $o->CodEmpresa;	
			
			if( is_array( $this->request->post('lista_empresas') ) ) 
			{
				$ids_remove = array_diff( $user_empresas, $this->request->post('lista_empresas') );
				$ids_add = array_diff( $this->request->post('lista_empresas') , $user_empresas );
			
				if(count($ids_remove) > 0)
					$obj->remove('empresas',$ids_remove) ;
				if(count($ids_add) > 0)
					$obj->add('empresas',$ids_add);		
			}
			$e=2; //2 é sem ação
			if($this->request->post('notificar')==1)			
				$e = enviaEmail::aviso_usuarioAtivado($obj,$password_email); //enviar o email de aviso 
			
			HTTP::redirect('empresas/usuarios?sucesso=1&enviado='.$e);
		}
		else
			HTTP::redirect('empresas/edit_usuarios?erro=1&Usuario='.$this->request->post('Usuario'));
		
	}

	public function action_delete_usuarios()
	{		
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		$obj = ORM::factory('User',$this->request->post('id'));	
		if($obj->delete())
			print 1;
		else
			print 0;
	}
	
	//======================================================
	//======================================================


	//======================================================//
	//==================PEDIDOS DE USUARIOS=========================//
	//======================================================//	

	public function action_pedidos_usuario() //página principal dos usuarios
	{			
		$objs = ORM::factory('User')->where('ativo','=',0)->find_all();		
		$this->template->content->conteudo = View::factory('empresas/list_pedidosusuario');					
		$this->template->content->conteudo->objs = $objs;			
	}

	public function action_edit_pedidos_usuario() //edit dos usuarios
	{			
		$obj = ORM::factory('User', site::segment('edit_pedidos_usuario',null) );
		$array = array();
		foreach ($obj->empresas->find_all() as $emp) 
			$array[] = $emp->CodEmpresa;

		$roles = ORM::factory('Role')->find_all()->as_array('id','name');		
			unset($roles[1]);//tira a role LOGIN, já que ela é padrão

		$roles_selecionadas = 1;
		foreach ($obj->roles->find_all() as $r) 
			$roles_selecionadas = $r->id;

		$this->template->content->conteudo = View::factory('empresas/edit_pedidosusuario');					
		$this->template->content->conteudo->obj = $obj;				
		$this->template->content->conteudo->roles = $roles;				
		$this->template->content->conteudo->roles_selecionadas = $roles_selecionadas;				
		$this->template->content->conteudo->empresas_selecionadas = $array;	
		
		$list = array();
		foreach( (ORM::factory('Empresa')->find_all()) as $i )
			$list[$i->CodEmpresa] = $i->Empresa.' - '.$i->Unidade; 

		$this->template->content->conteudo->empresas = $list;				
	}
	
	public function action_save_pedidos_usuario() //salvar novo e editar
	{	
		$obj = ORM::factory('User',$this->request->post('id'));		
		//print_r($this->request->post('role') );exit;
		$obj->username = $this->request->post('username');					
		$obj->email = $this->request->post('email');					
		$obj->nome = $this->request->post('nome');					
		$obj->telefone = $this->request->post('telefone');											
		$obj->nascimento = site::data_EN($this->request->post('nascimento'));	
		$obj->ativo = $this->request->post('ativar');
		
		$password = null;
		$password_email = '';
		if($this->request->post('gerar_senha')==1) //se é pra alterar a senha	
		{	
			if($this->request->post('senha_aleatoria')==0)	
				$password_email = $this->request->post('password');								
			else			
				$password_email = site::random_password( 8,$this->request->post('email') ); //gera uma senha aleatória 				
				
			$obj->password = $password_email; 
		}		

		if ($obj->save()) 
		{

			$obj->add('roles', $this->request->post('role') );
			$obj->add('empresas', $this->request->post('lista_empresas') );			

			$e=2; //2 é sem ação
			if($this->request->post('notificar')==1)			
				$e = enviaEmail::aviso_usuarioAtivado($obj,$password_email); //enviar o email de aviso 

			Session::instance()->delete('qtd_usuarios'); //reinicia o contador de usuários pendentes
			HTTP::redirect('empresas/pedidos_usuario?sucesso=1&enviado='.$e);
		}
		else
			HTTP::redirect('empresas/edit_pedidos_usuario?erro=1&Usuario='.$this->request->post('Usuario'));
		
	}

	public function action_delete_pedidos_usuario()
	{		

		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		//Session::instance()->delete('qtd_usuarios');
		$obj = ORM::factory('User',$this->request->post('id',null));	
		if($obj->delete())
			print 1;
		else
			print 0;
	}
		

} // End Welcome Controller
