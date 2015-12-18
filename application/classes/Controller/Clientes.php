	<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Clientes extends Controller_Welcome {
	
	public function before(){
		parent::before();
		$this->template->content = View::factory("main_content_clientes");		
		//$this->template = View::factory("index_relatorios");								
	}

	//======================================================//
	//==================HISTORICO================================//
	//======================================================//	

	public function action_historico() //página principal do historico
	{
		$user = Auth::instance()->get_user();	
						
		$this->template->content->conteudo = View::factory('clientes/list_historico');					
	    //$this->template->content->conteudo->objs = $user->empresas->find_all();	//todas as empresas do usuario	
	    //$this->template->content->conteudo->user = $user;	//todas as empresas do usuario	

	    $de = Arr::get($_GET, 'de',"01/".date('m')."/".date('Y')) ;
	    $ate = Arr::get($_GET, 'ate',date('d/m/Y', strtotime("+1 days")) ) ;
	    $sp =  Arr::get($_GET, 'sem_planejamento',0);
	    $pe = Arr::get($_GET, 'pendentes',0);
	    $ex = Arr::get($_GET, 'executadas',0);
	    $fi = Arr::get($_GET, 'finalizadas',0);

	    if( ($sp+$pe+$ex+$fi) == 0 ) //se desseleciona todos, seleciona todos
	    {
	    	$sp = 1;
		    $pe = 1;
		    $ex = 1;
		    $fi = 1;
	    }

	    $this->template->content->conteudo->de = $de;	
	    $this->template->content->conteudo->ate = $ate;		
	    $this->template->content->conteudo->sp = $sp;		
	    $this->template->content->conteudo->pe = $pe;
	    $this->template->content->conteudo->ex = $ex;
	    $this->template->content->conteudo->fi = $fi; 

	    //================================================================novo search das OSPs

	   $empresas = array_keys($user->empresas->find_all()->as_array('CodEmpresa','Empresa'));	  

	   $objs = ORM::factory('Gr');
	   $objs->join('equipamentoinspecionado','LEFT')->on('gr.equipamentoinspecionado','=','equipamentoinspecionado.CodEquipamentoInspecionado');
	   $objs->join('resultados','LEFT')->on('gr.CodGR','=','resultados.GR');
	   $objs->where('equipamentoinspecionado.Empresa', 'IN', $empresas );
	   $objs->where('equipamentoinspecionado.Data', 'BETWEEN', array( Site::data_EN($de) , Site::data_EN($ate) ) );

	   $objs->where_open();
			if($sp!=0)
				$objs->where("resultados.DataPlanejamento",'IS',NULL);
			if($pe!=0)
			{
				$objs->or_where_open();
					$objs->and_where("resultados.DataPlanejamento",'IS NOT',NULL);
					$objs->and_where("resultados.DataCorretiva",'IS',NULL);	
					$objs->and_where("resultados.DataFinalizacao",'IS',NULL);				
				$objs->or_where_close();
			}
			
			if($ex!=0)				
			{
				$objs->or_where_open();
					$objs->and_where("resultados.DataCorretiva",'IS NOT',NULL);						
					$objs->and_where("resultados.DataFinalizacao",'IS',NULL);				
				$objs->or_where_close();
			}						
			
			if($fi!=0)
				$objs->or_where("resultados.DataFinalizacao",'IS NOT',NULL);		
		$objs->where_close();		

		$objs->where('gr.Confirmado','=',1)->order_by('equipamentoinspecionado.Data','desc');

		$objs = $objs->find_all();
		
		$list = array();
		
		foreach ($objs as $r)
		{
			$estado = 'vermelho'; 	
			
			$gr = $r->equipamentoinspecionado->condicao->Cor;

			if( !in_array( Site::datahora_BR($r->resultado->DataCorretiva), array(null,'00/00/0000') ) )
			{	
				$estado = 'verde_pendente'; 
				if( ($r->resultado->Total != null) && ($r->resultado->Total != 0) &&
					!in_array( Site::datahora_BR($r->resultado->DataFinalizacao), array(null,'00/00/0000') ) )
					$estado = 'verde';
			}
			elseif( !in_array( Site::datahora_BR($r->resultado->DataPlanejamento), array(null,'00/00/0000')) )
				$estado = 'laranja'; 								
			
			$list[] = "<span class='caminho'>".$r->equipamentoinspecionado->equipamento->setor->area->Area." - ".$r->equipamentoinspecionado->equipamento->setor->Setor."</span><span class='estado estado_".$estado."'></span>".
				"<a class='gr cor_".$gr."' target='parent' href='".Site::baseUrl()."clientes/edit_historico/".$r->CodGR."'>".				
				Site::datahora_BR($r->equipamentoinspecionado->Data)." | ".$r->equipamentoinspecionado->tecnologia->Tecnologia." | OSP #".$r->NumeroGR."/".$r->CodGR." | ".$r->equipamentoinspecionado->condicao->Condicao." | ".$r->equipamentoinspecionado->equipamento->Equipamento." | ".$r->componente->Componente.": ".$r->Componente.
			"</a>";
					
		}	

		//=====================================================================================

	    $this->template->content->graficos = View::factory('clientes/list_historico_graficos');
	    $this->template->content->conteudo->objs = $list;
		$this->template->content->graficos->valores_grafico = $this->action_getGraficosOSP_gauge($user,$de,$ate,$sp,$pe,$ex,$fi);
	}

	public function action_load_historico() 
	{			
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda
		$tipo = explode('_',Arr::get($_GET, 'id',null)); //separa o id do tipo
	
		switch ($tipo[0]) {
			case 'empresa': //pegar as áreas da empresa
				$ret = array();
				$obj = ORM::factory('Empresa', $tipo[1]);						
				foreach ($obj->areas->find_all() as $a)
					$ret[] =  array('key' => 'area_'.$a->CodArea , 'title' => 'Área # '.$a->Area , 'lazy' => true);
				print json_encode($ret);
			break;
			case 'area': //pegar os setores da area
				$ret = array();
				$obj = ORM::factory('Area', $tipo[1]);						
				foreach ($obj->setores->find_all() as $a)
					$ret[] =  array('key' => 'setor_'.$a->CodSetor , 'title' => 'Setor # '.$a->Setor , 'lazy' => true);
				print json_encode($ret);
			break;

			/* //quando o load era feito somente a cada item e todos os equips eram mostrados, tendo equiinsp ou nao
			case 'setors': //pegar os equipamentos do setor
				$ret = array();
				$obj = ORM::factory('Setor', $tipo[1]);	
				//$equips = ORM::factory('Setor', $tipo[1])		
				foreach ($obj->equipamentos->find_all() as $a)
				{

					$ret[] =  array('key' => 'equipamento_'.$a->CodEquipamento , 'title' => 'Equipamento # '.$a->Equipamento , 'lazy' => true);
				}
				print json_encode($ret);
			break;
			*/

			//case 'equipamento': //pegar os equipamentos inspecionados do equipamento
			case 'setor': 
				$ret = array();
				$setor = ORM::factory('Setor', $tipo[1]);	

				$de = Site::data_EN(Arr::get($_GET, 'de',null)); 
				$ate = Site::data_EN(Arr::get($_GET, 'ate',null)); 
				$sp = Arr::get($_GET, 'sp',0); 
				$ex = Arr::get($_GET, 'ex',0); 
				$pe = Arr::get($_GET, 'pe',0); 
				$fi = Arr::get($_GET, 'fi',0); 

				foreach ($setor->equipamentos->find_all() as $a)
				{
					$children = array();					

					$equipinsp = ORM::factory('EquipamentoInspecionado')
					->where('equipamentoinspecionado.Equipamento','=', $a->CodEquipamento)//$tipo[1])
					->where('equipamentoinspecionado.Data', 'BETWEEN', array($de, $ate))
					->join('gr','LEFT')->on('gr.equipamentoinspecionado','=','equipamentoinspecionado.CodEquipamentoInspecionado')
					->join('resultados','LEFT')->on('resultados.GR','=','gr.CodGR');
					
					//weheres para cada estado das osp
					if( ($sp != 0) || ($pe != 0) || ($fi != 0) || ($ex != 0) )
					{			
						$equipinsp->where_open();

						if($sp!=0)
							$equipinsp->where("resultados.DataPlanejamento",'IS',NULL);
						if($pe!=0)
						{
							$equipinsp->or_where_open();
								$equipinsp->and_where("resultados.DataPlanejamento",'IS NOT',NULL);
								$equipinsp->and_where("resultados.DataCorretiva",'IS',NULL);	
								$equipinsp->and_where("resultados.DataFinalizacao",'IS',NULL);				
							$equipinsp->or_where_close();
						}
						
						if($ex!=0)				
						{
							$equipinsp->or_where_open();
								$equipinsp->and_where("resultados.DataCorretiva",'IS NOT',NULL);						
								$equipinsp->and_where("resultados.DataFinalizacao",'IS',NULL);				
							$equipinsp->or_where_close();
						}						
						
						if($fi!=0)
							$equipinsp->or_where("resultados.DataFinalizacao",'IS NOT',NULL);
						
						$equipinsp->where_close();
					}

					$equipinsp->where('gr.Confirmado','=',1)->order_by('Data','desc');

					$result = $equipinsp->find_all();
					//print_r($equipinsp);exit();
					foreach ($result as $r)
					{
						$estado = 'vermelho'; 	
						
						if( !in_array( Site::datahora_BR($r->gr->resultado->DataCorretiva), array(null,'00/00/0000') ) )
						{	
							$estado = 'verde_pendente'; 

							if( ($r->gr->resultado->Total != null) && ($r->gr->resultado->Total != 0) &&
								!in_array( Site::datahora_BR($r->gr->resultado->DataFinalizacao), array(null,'00/00/0000') ) )
								$estado = 'verde';

						}
						elseif( !in_array( Site::datahora_BR($r->gr->resultado->DataPlanejamento), array(null,'00/00/0000')) )
							$estado = 'laranja'; 								

						
						$children[] =  array('key' => 'equipamentoinspecionado_'.$r->CodEquipamentoInspecionado , 
										'title' => "<a class='".$estado."' target='parent' href='".Site::baseUrl()."clientes/edit_historico/".$r->gr->CodGR."'>".Site::datahora_BR($r->Data)." | TE | OSP #".$r->gr->NumeroGR."/".$r->gr->CodGR." | ".$r->condicao->Condicao." | ".$r->gr->componente->Componente.": ".$r->gr->Componente."</a>"									
										);
					}

					if(count($children) > 0)
						$ret[] =  array('key' => 'equipamento_'.$a->CodEquipamento , 'title' => 'Equipamento # '.$a->Equipamento , 'lazy' => false, 'children'=> $children );
				}
				print json_encode($ret);
			break;
			
			
		}

		//$obj = ORM::factory('Rota', Site::segment('edit_rotas',null) );
		//$equipamentos_selecionados = $obj->equipamento->find_all()->as_array('CodEquipamento','Equipamento');
		//print_r($equipamentos_selecionados);exit;				
					
	}

	public function action_edit_historico()
	{		
		$this->template->content->graficos = "";	
		$obj = ORM::factory('Gr', Site::segment('edit_historico',null) );

		$auth = Auth::instance();
		$user = $auth->get_user();

		if(!in_array($obj->equipamentoinspecionado->Empresa, $user->getListEmpresas(false) ) ) //caso não seja o historico da sua empresa
			HTTP::redirect('avisos/denied');

		$encrypt = Encrypt::instance('relatorios');
		$codgr = $encrypt->encode($obj->CodGR);

		$this->template->content->conteudo = View::factory('clientes/edit_historico');						
		$this->template->content->conteudo->obj = $obj;								
		$this->template->content->conteudo->codgr = $codgr;								
	}

	public function action_resultado_historico()
	{	
		$auth = Auth::instance();
		$user = $auth->get_user();
		
		$this->template->content->graficos = "";	
		$id = (Site::segment('resultado_historico',null) != 0)?(Site::segment('resultado_historico',null) ):(null);		
		$obj = ORM::factory('Resultados', $id);
		$gr = ORM::factory('Gr', $_GET['gr']);
		$this->template->content->conteudo = View::factory('clientes/resultado_historico');						
		
		if(!in_array($gr->equipamentoinspecionado->Empresa, $user->getListEmpresas(false) ) ) //caso não seja o historico da sua empresa
			HTTP::redirect('avisos/denied');

		$this->template->content->conteudo->PreMOPreco = Site::formata_moeda_input($obj->PreMOPreco);	
		$this->template->content->conteudo->PreProdPreco = Site::formata_moeda_input($obj->PreProdPreco);					
		$this->template->content->conteudo->PredTercPreco = Site::formata_moeda_input($obj->PredTercPreco);		
		$this->template->content->conteudo->PredMatPreco = Site::formata_moeda_input($obj->PredMatPreco);					
		$this->template->content->conteudo->PredOutrPreco = Site::formata_moeda_input($obj->PredOutrPreco);			
		$this->template->content->conteudo->ConvMOPreco = Site::formata_moeda_input($obj->ConvMOPreco);						
		$this->template->content->conteudo->ConvProdPreco = Site::formata_moeda_input($obj->ConvProdPreco);							
		$this->template->content->conteudo->ConvTercPreco = Site::formata_moeda_input($obj->ConvTercPreco);					
		$this->template->content->conteudo->ConvMatPreco = Site::formata_moeda_input($obj->ConvMatPreco);					
		$this->template->content->conteudo->ConvOutrPreco = Site::formata_moeda_input($obj->ConvOutrPreco);	

		$this->template->content->conteudo->obj = $obj;	
	}
	
	public function action_save_historico() //salvar novo e editar
	{	
		$obj = ORM::factory('Rota',$this->request->post('CodRota' ));		

		$obj->Rota = $this->request->post('Rota');					
		$obj->equipamento = $this->request->post('equipamento');					
		
		if ($obj->save()) 
			HTTP::redirect('clientes/rotas?sucesso=1');
		else
			HTTP::redirect('clientes/edit_rotas?erro=1&Rota='.$this->request->post('Rota'));		
	}

	public function action_save_resultado()
	{

		$obj = ORM::factory('Resultados',$this->request->post('CodResultado') );				
		$obj->GR = $this->request->post('GR');					
		$obj->CodCliente = $this->request->post('CodCliente');					
		$obj->PreMOHora = $this->request->post('PreMOHora');					
		$obj->PreMOPreco = Site::formata_moeda($this->request->post('PreMOPreco'));					
		$obj->PreProdHora = $this->request->post('PreProdHora');					
		$obj->PreProdPreco = Site::formata_moeda($this->request->post('PreProdPreco'));					
		$obj->PredTercHora = $this->request->post('PredTercHora');					
		$obj->PredTercPreco = Site::formata_moeda($this->request->post('PredTercPreco'));					
		$obj->PredMatPreco = Site::formata_moeda($this->request->post('PredMatPreco'));					
		$obj->PredOutrPreco = Site::formata_moeda($this->request->post('PredOutrPreco'));					
		$obj->ConvMOHora = $this->request->post('ConvMOHora');					
		$obj->ConvMOPreco = Site::formata_moeda($this->request->post('ConvMOPreco'));					
		$obj->ConvProdHora = $this->request->post('ConvProdHora');					
		$obj->ConvProdPreco = Site::formata_moeda($this->request->post('ConvProdPreco'));					
		$obj->ConvTercHora = $this->request->post('ConvTercHora');					
		$obj->ConvTercPreco = Site::formata_moeda($this->request->post('ConvTercPreco'));					
		$obj->ConvMatPreco = Site::formata_moeda($this->request->post('ConvMatPreco'));					
		$obj->ConvOutrPreco = Site::formata_moeda($this->request->post('ConvOutrPreco'));	

		$obj->Total = ( Site::formata_moeda($this->request->post('PreMOPreco'))+Site::formata_moeda($this->request->post('PreProdPreco'))+
				  Site::formata_moeda($this->request->post('PredTercPreco'))+Site::formata_moeda($this->request->post('PredMatPreco'))+
				  Site::formata_moeda($this->request->post('PredOutrPreco'))+Site::formata_moeda($this->request->post('ConvMOPreco'))+
				  Site::formata_moeda($this->request->post('ConvProdPreco'))+Site::formata_moeda($this->request->post('ConvTercPreco'))+
				  Site::formata_moeda($this->request->post('ConvMatPreco'))+Site::formata_moeda($this->request->post('ConvOutrPreco'))
				   	);		
		$obj->DataPlanejamento = Site::data_EN( $this->request->post('DataPlanejamento') ,null );					
		$obj->DataCorretiva = Site::data_EN( $this->request->post('DataCorretiva'), null );					
		$obj->DataFinalizacao = Site::data_EN( $this->request->post('DataFinalizacao'), null );		

		if( ( $this->request->post('DataFinalizacao') != null) && $obj->Total != 0) //significa que a OS foi finalizada
			enviaEmail::aviso_ospFinalizada($this->request->post('GR'));			

		$obj->RespPlanejamento = $this->request->post('RespPlanejamento');		
		$obj->RespCorretiva = $this->request->post('RespCorretiva');		
		$obj->RespFinalizacao = $this->request->post('RespFinalizacao');		
		$obj->Obs = $this->request->post('Obs');		

		if ($obj->save()) 
			HTTP::redirect('clientes/edit_historico/'.$obj->gr->CodGR);
		else
			HTTP::redirect('clientes/edit_historico/'.$obj->gr->CodGR.'?erro=1');

	}	
	
	public function action_getGraficosOSP_gauge($user=null,$de=null,$ate=null,$sp=null,$pe=null,$ex=null,$fi=null)
	{		
		if($user==null)
			$user = $this->input->post("user");

		if($this->request->is_ajax())
			$this->template = "";

		$de = Site::data_EN($de);
		$ate = Site::data_EN($ate);
		$total = 0;
		$finalizadas = 0;
		$executadas = 0;
		$pendentes = 0;
		$sem_planejamento = 0;

		foreach ($user->empresas->find_all() as $empresa) {	

			$equipamentos = ORM::factory('EquipamentoInspecionado')
			->where('equipamentoinspecionado.Empresa','=',$empresa->CodEmpresa)
			->and_where('equipamentoinspecionado.Data', 'BETWEEN', array($de, $ate))
			->join('gr','LEFT')->on('gr.equipamentoinspecionado','=','equipamentoinspecionado.CodEquipamentoInspecionado')
			->join('resultados','LEFT')->on('resultados.GR','=','gr.CodGR');
			

			//weheres para cada estado das osp
			if( ($sp != 0) || ($pe != 0) || ($fi != 0) || ($ex != 0) )
			{			
				$equipamentos->where_open();

				if($sp!=0)
					$equipamentos->where("resultados.DataPlanejamento",'IS',NULL);
				if($pe!=0)
				{
					$equipamentos->or_where_open();
						$equipamentos->and_where("resultados.DataPlanejamento",'IS NOT',NULL);
						$equipamentos->and_where("resultados.DataCorretiva",'IS',NULL);	
						$equipamentos->and_where("resultados.DataFinalizacao",'IS',NULL);				
					$equipamentos->or_where_close();
				}
				
				if($ex!=0)				
				{
					$equipamentos->or_where_open();
						$equipamentos->and_where("resultados.DataCorretiva",'IS NOT',NULL);						
						$equipamentos->and_where("resultados.DataFinalizacao",'IS',NULL);				
					$equipamentos->or_where_close();
				}						
				
				if($fi!=0)
					$equipamentos->or_where("resultados.DataFinalizacao",'IS NOT',NULL);
				
				$equipamentos->where_close();
			}
		

			$equipamentos->where('gr.Confirmado','=',1)->order_by('equipamentoinspecionado.Data','desc');
		//	print_r($equipamentos->find_all());exit;
			$result = $equipamentos->find_all();
			
			foreach ($result as $e) {				
				$total++;
				if( ($e->gr->resultado->Total != null) && ($e->gr->resultado->Total != 0) )
				{
					$finalizadas++;
					continue;
				}

				if( !in_array( Site::datahora_BR($e->gr->resultado->DataCorretiva), array(null,'00/00/0000')) )
				{
					$executadas++;
					continue;
				}	

				if( !in_array( Site::datahora_BR($e->gr->resultado->DataPlanejamento), array(null,'00/00/0000')) )
				{
					$pendentes++;
					continue;
				}	
			}
		}	
		//pegar as porcentagens
		if($total != 0){			
			$finalizadas = round(($finalizadas/$total)*100,2);
			$executadas = round(($executadas/$total)*100,2);
			$pendentes = round(($pendentes/$total)*100,2);		
			$sem_planejamento = round(100 - ($pendentes+$finalizadas+$executadas),2);
		}	
		$array = array('finalizadas' => $finalizadas, 'executadas' => $executadas, 'pendentes' => $pendentes , 'sem_planejamento' => $sem_planejamento );
		return $array;
	}


} // End Welcome Controller
