<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Empresas extends Controller_Welcome {
	
	public $privileges_needed = array();//"access_empresa"

	public function after(){
		parent::after();

		if(!Site::isGrant($this->privileges_needed)) //se pode acessar a url
			HTTP::redirect('avisos/denied');
	}

		//carregamento geral do cache
	/*	if($view = Cache::instance()->get(Site::segment(2), FALSE) )		
		{
			$this->template->content->conteudo = $view;	
			$this->cached = true;
		}					*/
	
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
		$this->template->content->show_add_link = false;	
		$this->template->content->show_search = false;	
						
		//$this->template->content->conteudo->objs = $rotas;
	}
	
	public function action_edit_grauderisco()
	{		
		$obj = ORM::factory('Gr', Site::segment('edit_grauderisco',null) );

		$this->template->content->conteudo = View::factory("empresas/edit_grauderisco");						
		$this->template->content->conteudo->obj = $obj;						
		$this->template->content->conteudo->componentes = ORM::factory('Componente')->where("Tecnologia",'=',$obj->equipamentoinspecionado->Tecnologia)->find_all()->as_array("CodComponente","Componente");						
		$this->template->content->conteudo->anomalias = ORM::factory('Anomalia')->where("Tecnologia",'=',$obj->equipamentoinspecionado->Tecnologia)->find_all()->as_array("CodAnomalia","Anomalia");						
		$this->template->content->conteudo->condicoes = ORM::factory('Condicao')->where("Tecnologia",'=',$obj->equipamentoinspecionado->Tecnologia)->and_where('Emergencia','=',1)->find_all()->as_array('CodCondicao','Condicao');
		$this->template->content->conteudo->inspecoes = ORM::factory('TipoInspecao')->find_all()->as_array("CodTipoInspecao","TipoInspecao");						
		
		//$this->template->content->conteudo->condicoes = ORM::factory('Condicao',$obj->equipamentoinspecionado->Condicao);	//->where("Tecnologia",'=',$obj->equipamentoinspecionado->Tecnologia)->find_all()
		//$this->template->content->conteudo->inspecoes = ORM::factory('TipoInspecao', Site::segment('edit_grauderisco',null) )->as_array("CodTipoInspecao","TipoInspecao");						

		$query = parse_url(URL::query());
		$this->template->content->conteudo->query = ( isset($query["query"]) )?($query["query"]):("1=1");
		$this->template->content->plus_back_link = ( isset($query["query"]) )?("?".$query["query"]):("");	
	}

	public function action_carrega_grausderisco() 
	{
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda	

		$de = Site::data_EN($this->request->post('de'));
		$ate = Site::data_EN($this->request->post('ate'));

		/*
		$de = false;
		$ate = false;

		if($this->request->post('de')!=0)
			$de = Site::data_EN($this->request->post('de'));
		if($this->request->post('ate')!=0)
			$ate = Site::data_EN($this->request->post('ate'));

		if($de!=false)
			$objs->where('Data','>=',$de);
		if($ate!=false)
			$objs->where('Data','<=',$ate);
		*/
		$grs = array();
		$objs = ORM::factory('EquipamentoInspecionado');
		
		$objs->where('Data', 'BETWEEN', array($de, $ate));
		// fazer select pra escolher só as que estao em emergencia
		$objs->where("equipamentoinspecionado.Tecnologia",'=',$this->request->post('tecnologia'));	
		$objs->where("equipamentoinspecionado.Empresa",'=',Site::get_empresaatual());	
		$objs->join('condicao','LEFT')->on('condicao.CodCondicao','=','equipamentoinspecionado.Condicao');
		$objs->where("condicao.Emergencia",'=',1);
		//$objs->order_by("equipamentoinspecionado.Equipamento","ASC");
			
		$equip = $objs->find_all();
		foreach ($equip as $equipamento) { //peguei os equip inspecionado

			$gr = ORM::factory('Gr');
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
						'Componente' => ($gr->componente->Componente!=NULL)?($gr->componente->Componente):"-",
						'Inspecao' => ($gr->TipoInspecao!=NULL)?($gr->tipoinspecao->TipoInspecao):"-",
						'Data' => Site::datahora_BR($equipamento->Data)
					);
			}
		}
		print json_encode($grs);	

	}

	public function action_save_grauderisco() //salva a análise
	{		
		$obj = ORM::factory("Gr",$this->request->post('CodGR'));		

		$obj->TipoComponente = $this->request->post('TipoComponente');
		$obj->Componente = $this->request->post('Componente');
		$obj->Detalhe = $this->request->post('Detalhe');
		$obj->TipoAnomalia = $this->request->post('TipoAnomalia');
		$obj->Anomalia = $this->request->post('Anomalia');
		$obj->Recomendacao = $this->request->post('Recomendacao');
		$obj->Obs = $this->request->post('Obs');
		$obj->GRReferencia = $this->request->post('GRReferencia');
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
			$ext = pathinfo($_FILES['ImagemReal']["name"], PATHINFO_EXTENSION);
			$rdn = Site::random_password(3);
			$file = $_FILES['ImagemReal'];
			$filename = Upload::save($file,null,$dir);	
			$foto = $dir."/real_".$this->request->post('CodGR')."_".$rdn.".".$ext;
			Image::factory($filename)->save($foto);	
		    unlink($filename);
		    $obj->ImagemReal = "real_".$this->request->post('CodGR')."_".$rdn.".".$ext;
		}	

		if(isset($_FILES['ImagemTermica']) and $_FILES['ImagemTermica']["name"] != "")
		{
			$rdn = Site::random_password(3);
			$ext = pathinfo($_FILES['ImagemTermica']["name"], PATHINFO_EXTENSION);
			
			$file = $_FILES['ImagemTermica'];
			$filename = Upload::save($file,null,$dir);					
			$foto = $dir."/termica_".$this->request->post('CodGR')."_".$rdn.".".$ext;
			Image::factory($filename)->save($foto);	
		    unlink($filename);
		    $obj->ImagemTermica = "termica_".$this->request->post('CodGR')."_".$rdn.".".$ext;
		}	

		
		$equip = $obj->equipamentoinspecionado;
		$equip->Condicao = $this->request->post('Condicao');
		
		if($obj->save() && $equip->save())	
			HTTP::redirect("empresas/grauderisco?".$this->request->post('query')."&sucesso=1");	
		else
			HTTP::redirect("empresas/grauderisco?".$this->request->post('query')."&erro=1");

	}

	//======================================================//
	//==================ANALISE DE INSPECAO================================//
	//======================================================//	

	public function action_analiseinspecao() //página principal das Inspeçoes
	{	
		//$rotas = ORM::factory('Rota')->where( 'Empresa','=',Site::get_empresaatual() )->find_all(); //vamos pegar todas as rotas dessa empresa	
		$areas = ORM::factory('Area')->where( 'Empresa','=',Site::get_empresaatual() )->find_all(); //vamos pegar todas as areas dessa empresa	

		$this->template->content->conteudo = View::factory('empresas/list_analiseinspecao');						
		$this->template->content->conteudo->objs = $areas;
		$this->template->content->show_add_link = false;	
	}

	public function action_edit_analiseinspecao_novo() //adicionar um nova AnaliseEquipamentoInspecionado, essa tabela é só temporária
	{			
		$obj = ORM::factory('AnaliseEquipamentoInspecionado', Site::segment('edit_analiseinspecao',null));
		$this->template->content->conteudo = View::factory('empresas/edit_analiseinspecao_novo');	
		
		if(Site::get_empresaatual() != null)
		{
			$rotas = ORM::factory('Rota')->where( 'Empresa','=',Site::get_empresaatual() )->find_all()->as_array('CodRota','Rota'); //vamos pegar todas as rotas dessa empresa	
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
		$obj = ORM::factory('AnaliseEquipamentoInspecionado', Site::segment('edit_analiseinspecao',null));

		$tecnologia = $obj->tecnologia; //pega a tecnologia que esta vinculada a esta analise
		$componentes = $tecnologia->componentes->find_all()->as_array('CodComponente','Componente');		
		$anomalias = $tecnologia->anomalias->find_all()->as_array('CodAnomalia','Anomalia');
		$recomendacoes = $tecnologia->recomendacoes->find_all()->as_array('CodRecomendacao','Recomendacao');
		
		$this->template->content->conteudo = View::factory('empresas/edit_analiseinspecao');							
		$componentes[0] = Kohana::$config->load('config')->get('select_default'); 
		$anomalias[0] = Kohana::$config->load('config')->get('select_default');
		
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
			$obj->Data = Site::data_EN($this->request->post('Data')).' '.date('H:i:s');
			$obj->Empresa = Site::get_empresaatual();
			$obj->save();
		}	
	
		//pega o sequencial mais alto tendo a empresa e a tecnologia
		$db = DB::query(Database::SELECT,"SELECT max(codRelatorio) as 'cod' from relatorios where Empresa = :empresa and Tecnologia = :tecnologia")
		->bind(':empresa', Site::get_empresaatual())
		->bind(':tecnologia',$this->request->post('Tecnologia'));
		
		$result = $db->execute();		
		$cod = $result[0]['cod']; 

		//gera uma nova entrada de relatório, referente à essa analise de inspeçao
		$relatorio = ORM::factory('Relatorios');

		if($this->request->post('relatorio_novo') == 1)
			$relatorio->CodRelatorio = ($cod+1);
		else
			$relatorio->CodRelatorio = $this->request->post('codigo_relatorio');

		$relatorio->Tecnologia = $this->request->post('Tecnologia');
		$relatorio->Analista = $this->request->post('Analista');
		$relatorio->Rota = $this->request->post('Rota');
		$relatorio->Empresa = Site::get_empresaatual();		
		$relatorio->Data = Site::data_EN($this->request->post('Data'));	
		$relatorio->save();

		HTTP::redirect('empresas/analiseinspecao?sucesso=1');	
	}

	//teste
	public function action_teste() //transfere tudo pra cada tabela
	{
		$equip = ORM::factory('EquipamentoInspecionado')->where('Empresa','=','5')->where('Tecnologia','=','16')->find_all(); 
		$s = 1;

		foreach ($equip as $eq)
		{
			$gr = $eq->gr;
			$gr->NumeroGR = $s;
			$gr->save();
			$s++;
		}
							
			//$gr->NumeroGR = $s;
			//$gr->save();
			//$s++;
		
		exit;
		$empresa = 5;
		$tec = 16;
		$this->template = "";
		$db = DB::query(Database::SELECT,"SELECT max(gr.NumeroGR) as 'numerogr' from gr, equipamentoinspecionado where equipamentoinspecionado.Empresa = :empresa and equipamentoinspecionado.CodEquipamentoInspecionado = gr.EquipamentoInspecionado and equipamentoinspecionado.Tecnologia = :tecnologia")
			->bind(':empresa', $empresa)
			->bind(':tecnologia',$tec);
			
					
		$result = $db->execute();
		print_r( intval($result[0]) -1	);
	}
	//=====

	public function action_transferir_analiseinspecao() //transfere tudo pra cada tabela
	{		
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		$empresa = ORM::factory('Empresa',Site::get_empresaatual()); //pega a empresa
		$analises = ORM::factory('AnaliseEquipamentoInspecionado')->where('Empresa','=',Site::get_empresaatual())->find_all(); //pega todas as análises

		foreach ($analises as $item) { // para cada item, vamos passar pra tabela correspondente

			$equipamento = ORM::factory('EquipamentoInspecionado'); //vamos criar um novo item do equipamento inspecionado			
			//$empresa = $equipamento->setor->area->empresa
			$tec = $item->Tecnologia;
			$equipamento->Equipamento = $item->Equipamento; 
			$equipamento->Condicao = $item->Condicao;
			$equipamento->Analista = $item->Analista;
			$equipamento->Tecnologia = $tec;
			$equipamento->Data = $item->Data;
			$equipamento->Empresa = Site::get_empresaatual(); // FICA MUITO MAIS FACIL E RAPIDO TENDO ESSE CAMPO...
			$equipamento->save();

			$cond = ORM::factory('condicao',$item->Condicao);		
			
			if($cond->Emergencia == 1) //só manda pra GR caso seja emergencia
			{
				//pega a gr mais alta daquela tecnologia, daquela empresa
				$db = DB::query(Database::SELECT,"SELECT max(gr.NumeroGR) as 'numerogr' from gr, equipamentoinspecionado where equipamentoinspecionado.Empresa = :empresa and equipamentoinspecionado.CodEquipamentoInspecionado = gr.EquipamentoInspecionado and equipamentoinspecionado.Tecnologia = :tecnologia")
				->bind(':empresa', Site::get_empresaatual())
				->bind(':tecnologia',$tec);
				
				$result = $db->execute();		
				$valor = $result[0]['numerogr']; 
				
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

				$gr->Ir = $item->Ir;
				$gr->Is = $item->Is;
				$gr->It = $item->It;
				$gr->In = $item->In;
				$gr->Vr = $item->Vr;
				$gr->Vs = $item->Vs;
				$gr->Vt = $item->Vt;
				$gr->Vn = $item->Vn;		
				//$gr->TipoInspecao = 1;			
				$gr->save();
			}

			$item->delete(); //remove o item da tabela AnaliseEquipamentoInspecionado;
		}
		
		//======= vamos avisar os usuários
/*
			$empresa = ORM::factory('Empresa',Site::get_empresaatual());
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
			$db = DB::query(Database::DELETE,"DELETE from analiseequipamentoinspecionado where Empresa = '".Site::get_empresaatual()."'");
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
		$novo->Empresa = Site::get_empresaatual();

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
		$this->privileges_needed[] = 'access_list_empresas';
		if(!$this->cached)// se não há cache
		{
			$objs =ORM::factory('Empresa')->find_all();
			$this->template->content->conteudo = View::factory('empresas/list_empresas');					
			$this->template->content->conteudo->objs = $objs;	

			Cache::instance()->set(Site::segment(2),$this->template->content->conteudo->render());
		}			

		if(!Site::isGrant(array('add_empresas')))
			$this->template->content->show_add_link = false;	
	}

	public function action_edit_empresas() //edit dos empresas
	{			
		$this->privileges_needed[] = 'access_list_empresas';
		$this->privileges_needed[] = 'edit_empresas';

		$obj = ORM::factory('Empresa', Site::segment('edit_empresas',null) );

		$this->template->content->conteudo = View::factory('empresas/edit_empresas');					
		$this->template->content->conteudo->obj = $obj;	
	}
	
	public function action_save_empresas() //salvar novo e editar
	{			
		$obj = ORM::factory('Empresa',$this->request->post('CodEmpresa'));		

		$obj->Empresa = $this->request->post('Empresa'); //nome da empresa
		$obj->Unidade = $this->request->post('Unidade');				
		$obj->Fabrica = $this->request->post('Fabrica');				
		$obj->contato = $this->request->post('contato');				
		$obj->cep = $this->request->post('cep');				
		$obj->endereco = $this->request->post('endereco');				
		$obj->departamento = $this->request->post('departamento');	
					
		Cache::instance()->delete('empresas');
		
		if ($obj->save()) 
			HTTP::redirect('empresas/empresas?sucesso=1');
		else
			HTTP::redirect('empresas/edit_empresas?erro=1&Empresa='.$this->request->post('Empresa'));
		
	}

	public function action_toggle_empresas() //ativar/desativar a empresa que está se trabalhando
	{
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		Site::set_empresaatual($this->request->post('id'),$this->request->post('nome'));
		
		print 1;
	}
	
	//======================================================
	//======================================================

	//======================================================//
	//==================ROTAS=========================//
	//======================================================//	

	public function action_rotas() //página principal dos rotas
	{			
		$this->privileges_needed[] = 'access_rotas';
		$objs = ORM::factory('Rota')->where('Empresa','=',Site::get_empresaatual())->find_all();
		
		$this->template->content->conteudo = View::factory('empresas/list_rotas');					
		$this->template->content->conteudo->objs = $objs;			

		if(!Site::isGrant(array('add_rotas')))
			$this->template->content->show_add_link = false;	
	}

	public function action_edit_rotas() //edit dos rotas
	{			
		$this->privileges_needed[] = 'edit_rotas';
		$obj = ORM::factory('Rota', Site::segment('edit_rotas',null) );
		$equipamentos_selecionados = $obj->equipamentos->find_all()->as_array('CodEquipamento','Equipamento');
		//print_r($equipamentos_selecionados);exit;
		$this->template->content->conteudo = View::factory('empresas/edit_rotas');					
		$this->template->content->conteudo->obj = $obj;				
		$this->template->content->conteudo->empresa = Site::get_empresaatual(0);				
		$this->template->content->conteudo->equipamentos_selecionados = $equipamentos_selecionados;				
	}
	
	public function action_save_rotas() //salvar novo e editar
	{	
		$obj = ORM::factory('Rota',$this->request->post('CodRota'));		

		$obj->Rota = $this->request->post('Rota');					
		$obj->Empresa = $this->request->post('Empresa');					
		
		if ($obj->save()) 
		{			

			Site::addORMRelation($obj, $obj->equipamentos,$this->request->post('equipamento'),'equipamentos');

			HTTP::redirect('empresas/rotas?sucesso=1');		
		}
		else
			HTTP::redirect('empresas/edit_rotas?erro=1&Rota='.$this->request->post('Rota'));		
	}	
	
	//======================================================
	//======================================================


	//======================================================//
	//==================EQUIPAMENTOS=========================//
	//======================================================//	

	public function action_equipamentos() //página principal dos equipamentos
	{					
		$this->privileges_needed[] = 'access_equipamentos';
		$this->template->content->conteudo = View::factory('empresas/list_equipamentos');					
		$this->template->content->conteudo->objs = ORM::factory('Area')->where('Empresa','=',Site::get_empresaatual())->find_all()->as_array('CodArea', 'Area');	//pega as areas		
		$this->template->content->conteudo->area =  Site::segment(3,null);	
		$this->template->content->conteudo->setor =  Site::segment(4,null);	
		if(!Site::isGrant(array('add_equipamentos')))
			$this->template->content->show_add_link = false;	

	}

	public function action_edit_equipamentos() //edit dos equipamentos
	{			
		$this->privileges_needed[] = 'edit_equipamentos';
		$obj = ORM::factory('Equipamento', Site::segment('edit_equipamentos',null) );
		$tipo_equipamento = ORM::factory('TipoEquipamento')->find_all()->as_array('CodTipoEquipamento','TipoEquipamento');
		
		$this->template->content->conteudo = View::factory('empresas/edit_equipamentos');					
		$this->template->content->conteudo->obj = $obj;				
		$this->template->content->conteudo->tipo_equipamento = $tipo_equipamento;				
		$this->template->content->conteudo->setor =  Site::segment(4);				
		$this->template->content->conteudo->area =  Site::segment(5);
		$this->template->content->plus_back_link = '/'.Site::segment(5).'/'.Site::segment(4) ;					
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
	
	//======================================================
	//======================================================


	//======================================================//
	//==================ÁREAS E SETORES===============================//
	//======================================================//	
	
	public function action_areas_setores() //página principal dos rotas
	{			
		$this->privileges_needed[] = 'access_areassetores';
		$objs = ORM::factory('Area')->where('Empresa','=',Site::get_empresaatual())->find_all();
		
		$this->template->content->conteudo = View::factory('empresas/list_areas_setores');					
		$this->template->content->conteudo->objs = $objs;		
		$this->template->content->conteudo->empresa = Site::get_empresaatual(); //id da empresa atual	
		$this->template->content->show_add_link = false;
		$this->template->content->show_search = false;
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
		$this->privileges_needed[] = 'access_usuarios_empresa';
		$empresa = ORM::factory('Empresa',Site::get_empresaatual());		
		$this->template->content->conteudo = View::factory('usuario/list_usuarios');					
		$this->template->content->conteudo->tipo = 'empresa';					
		$this->template->content->conteudo->link_edit = 'empresas/edit_usuarios';									
		$this->template->content->conteudo->objs = $empresa->users->where('ativo','=',1)->find_all();	//mostra só os usuários que estão ativos		
	}

	public function action_edit_usuarios() //edit dos usuarios
	{			
		$this->privileges_needed[] = 'access_usuarios_empresa';
		$obj = ORM::factory('User', Site::segment('edit_usuarios',null) );
		
		$array = array();
		foreach ($obj->empresas->find_all() as $emp)  //pegar as empresas do usuario
			$array[] = $emp->CodEmpresa;

		if(sizeof($array) == 0) //se nao tiver nenhuma, deixa a empresa atual como já selecionada
			$array[] = Site::get_empresaatual();

		$roles = ORM::factory('Role')->find_all()->as_array('id','nickname');		
		unset($roles[1]);//tira a role LOGIN, já que ela é padrão

		$roles_selecionadas = 1;
		foreach ($obj->roles->find_all() as $r) 
			$roles_selecionadas = $r->id;

		$this->template->content->conteudo = View::factory('usuario/edit_usuarios');	
		$this->template->content->conteudo->redir = 'usuarios';	
		$this->template->content->conteudo->tipo = 'empresa';					
		$this->template->content->conteudo->obj = $obj;	
		$this->template->content->conteudo->roles = $roles;				
		$this->template->content->conteudo->roles_selecionadas = $roles_selecionadas;				
		$this->template->content->conteudo->empresas_selecionadas = $array;	
		$list = array();
		foreach( (ORM::factory('Empresa')->find_all()) as $i )
			$list[$i->CodEmpresa] = $i->Empresa.' - '.$i->Unidade; 

		$this->template->content->conteudo->empresas = $list;				
	}
	
	//======================================================
	//======================================================


	//======================================================//
	//==================PEDIDOS DE USUARIOS=========================//
	//======================================================//	

	public function action_pedidos_usuario() //página principal dos usuarios
	{			
		$this->privileges_needed[] = 'access_usuarios_empresa';
		$objs = ORM::factory('User')->where('ativo','=',0)->find_all();		
		$this->template->content->conteudo = View::factory('usuario/list_usuarios');	
		$this->template->content->conteudo->tipo = 'pendente';					
		$this->template->content->conteudo->link_edit = 'empresas/edit_pedidos_usuario';					
		$this->template->content->conteudo->objs = $objs;	
		$this->template->content->show_add_link = false;				
	}

	public function action_edit_pedidos_usuario() //edit dos usuarios
	{			
		$this->privileges_needed[] = 'access_usuarios_empresa';
		$this->template->content->plus_back_link = '_usuario';		

		$obj = ORM::factory('User', Site::segment('edit_pedidos_usuario',null) );
		$array = array();
		foreach ($obj->empresas->find_all() as $emp) 
			$array[] = $emp->CodEmpresa;

		$roles = ORM::factory('Role')->find_all()->as_array('id','name');		
			unset($roles[1]);//tira a role LOGIN, já que ela é padrão

		$roles_selecionadas = 1;
		foreach ($obj->roles->find_all() as $r) 
			$roles_selecionadas = $r->id;

		$this->template->content->conteudo = View::factory('usuario/edit_usuarios');	
		$this->template->content->conteudo->redir = 'pedidos_usuario';		
		$this->template->content->conteudo->tipo = 'pendente';					
		$this->template->content->conteudo->obj = $obj;				
		$this->template->content->conteudo->roles = $roles;				
		$this->template->content->conteudo->roles_selecionadas = $roles_selecionadas;				
		$this->template->content->conteudo->empresas_selecionadas = $array;	
		
		$list = array();
		foreach( (ORM::factory('Empresa')->find_all()) as $i )
			$list[$i->CodEmpresa] = $i->Empresa.' - '.$i->Unidade; 

		$this->template->content->conteudo->empresas = $list;				
	}
	

	//session::instance()->delete('qtd_usuarios');	
		

} // End Welcome Controller
