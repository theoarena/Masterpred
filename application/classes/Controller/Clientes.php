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
	    $this->template->content->conteudo->objs = $user->empresas->find_all();	//todas as empresas do usuario	
	    $this->template->content->conteudo->user = $user;	//todas as empresas do usuario	
 
	    $de = Arr::get($_GET, 'de',"01/".date('m')."/".date('Y')) ;
	    $ate = Arr::get($_GET, 'ate',date('d/m/Y')) ;
	    $sp =  Arr::get($_GET, 'sem_planejamento',0);
	    $pe = Arr::get($_GET, 'pendentes',0);
	    $fi = Arr::get($_GET, 'finalizadas',0);

	    $this->template->content->conteudo->de = $de;	
	    $this->template->content->conteudo->ate = $ate;		
	    $this->template->content->conteudo->sp = $sp;		
	    $this->template->content->conteudo->pe = $pe;
	    $this->template->content->conteudo->fi = $fi; 

	    $this->template->content->graficos = View::factory('clientes/list_historico_graficos');
		$this->template->content->graficos->valores_grafico = $this->action_getGraficosOSP_gauge($user,$de,$ate,$sp,$pe,$fi);
	}

	public function action_load_historico() //edit dos rotas
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
			case 'setor': //pegar os equipamentos do setor
				$ret = array();
				$obj = ORM::factory('Setor', $tipo[1]);						
				foreach ($obj->equipamentos->find_all() as $a)
					$ret[] =  array('key' => 'equipamento_'.$a->CodEquipamento , 'title' => 'Equipamento # '.$a->Equipamento , 'lazy' => true);
				print json_encode($ret);
			break;
			case 'equipamento': //pegar os equipamentos inspecionados do equipamento
				$ret = array();
//				$obj = ORM::factory('Equipamento', $tipo[1]);			

				$de = site::data_EN(Arr::get($_GET, 'de',null)); 
				$ate = site::data_EN(Arr::get($_GET, 'ate',null)); 
				$sp = Arr::get($_GET, 'sp',0); 
				$pe = Arr::get($_GET, 'pe',0); 
				$fi = Arr::get($_GET, 'fi',0); 

				$equipinsp = ORM::factory('EquipamentoInspecionado')
				->where('EquipamentoInspecionado.Equipamento','=',$tipo[1])
				->where('EquipamentoInspecionado.Data', 'BETWEEN', array($de, $ate))
				->join('gr','LEFT')->on('gr.EquipamentoInspecionado','=','EquipamentoInspecionado.CodEquipamentoInspecionado')
				->join('resultados','LEFT')->on('resultados.GR','=','gr.CodGR')
				->and_where_open();
				if( ($sp != 0) || ($pe != 0) || ($fi != 0) )
				{				
					if($sp!=0)
						$equipinsp->where("resultados.DataPlanejamento",'IS',NULL);					
					if($pe!=0)
						$equipinsp->or_where("resultados.DataPlanejamento",'IS NOT',NULL);
					if($fi!=0)
						$equipinsp->or_where("resultados.DataFinalizacao",'IS NOT',NULL);
				}
				$equipinsp->and_where_close();
				$equipinsp->where('gr.Confirmado','=',1)->order_by('Data','desc');

				$result = $equipinsp->find_all();
				//print_r($equipinsp);exit();
				foreach ($result as $a)
				{
					$estado = 'vermelho'; 	
					
					if( !in_array( site::datahora_BR($a->gr->resultado->DataCorretiva), array(null,'00/00/0000') ) )
					{	
						$estado = 'verde_pendente'; 

						if( ($a->gr->resultado->Total != null) && ($a->gr->resultado->Total != 0) &&
							!in_array( site::datahora_BR($a->gr->resultado->DataFinalizacao), array(null,'00/00/0000') ) )
							$estado = 'verde';

					}
					elseif( !in_array( site::datahora_BR($a->gr->resultado->DataPlanejamento), array(null,'00/00/0000')) )
						$estado = 'laranja'; 								

					
					$ret[] =  array('key' => 'equipamentoinspecionado_'.$a->CodEquipamentoInspecionado , 
									'title' => "<a class='".$estado."' target='parent' href='".site::baseUrl()."clientes/edit_historico/".$a->gr->CodGR."'>".site::datahora_BR($a->Data)." | TE | OSP #".$a->gr->NumeroGR."/".$a->gr->CodGR." | ".$a->condicao->Condicao." | ".$a->gr->componente->Componente.": ".$a->gr->Componente."</a>"									
									);
				}
				print json_encode($ret);
			break;
			
			
		}

		//$obj = ORM::factory('Rota', site::segment('edit_rotas',null) );
		//$equipamentos_selecionados = $obj->equipamento->find_all()->as_array('CodEquipamento','Equipamento');
		//print_r($equipamentos_selecionados);exit;				
					
	}

	public function action_edit_historico()
	{		
		$this->template->content->graficos = "";	
		$obj = ORM::factory('Gr', site::segment('edit_historico',null) );
		$this->template->content->conteudo = View::factory('clientes/edit_historico');						
		$this->template->content->conteudo->obj = $obj;								
	}

	public function action_resultado_historico()
	{		
		//$this->template->content = View::factory('clientes/home_clientes');	
		$this->template->content->graficos = "";	
		$id = (site::segment('resultado_historico',null) != 0)?(site::segment('resultado_historico',null) ):(null);		
		$obj = ORM::factory('Resultados', $id);
		$this->template->content->conteudo = View::factory('clientes/resultado_historico');						
		
		$this->template->content->conteudo->PreMOPreco = site::formata_moeda_input($obj->PreMOPreco);	
		$this->template->content->conteudo->PreProdPreco = site::formata_moeda_input($obj->PreProdPreco);					
		$this->template->content->conteudo->PredTercPreco = site::formata_moeda_input($obj->PredTercPreco);		
		$this->template->content->conteudo->PredMatPreco = site::formata_moeda_input($obj->PredMatPreco);					
		$this->template->content->conteudo->PredOutrPreco = site::formata_moeda_input($obj->PredOutrPreco);			
		$this->template->content->conteudo->ConvMOPreco = site::formata_moeda_input($obj->ConvMOPreco);						
		$this->template->content->conteudo->ConvProdPreco = site::formata_moeda_input($obj->ConvProdPreco);							
		$this->template->content->conteudo->ConvTercPreco = site::formata_moeda_input($obj->ConvTercPreco);					
		$this->template->content->conteudo->ConvMatPreco = site::formata_moeda_input($obj->ConvMatPreco);					
		$this->template->content->conteudo->ConvOutrPreco = site::formata_moeda_input($obj->ConvOutrPreco);	

		$this->template->content->conteudo->obj = $obj;	
	}
	
	public function action_save_historico() //salvar novo e editar
	{	
		$obj = ORM::factory('rota',$this->request->post('CodRota' ));		

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
		$obj->PreMOPreco = site::formata_moeda($this->request->post('PreMOPreco'));					
		$obj->PreProdHora = $this->request->post('PreProdHora');					
		$obj->PreProdPreco = site::formata_moeda($this->request->post('PreProdPreco'));					
		$obj->PredTercHora = $this->request->post('PredTercHora');					
		$obj->PredTercPreco = site::formata_moeda($this->request->post('PredTercPreco'));					
		$obj->PredMatPreco = site::formata_moeda($this->request->post('PredMatPreco'));					
		$obj->PredOutrPreco = site::formata_moeda($this->request->post('PredOutrPreco'));					
		$obj->ConvMOHora = $this->request->post('ConvMOHora');					
		$obj->ConvMOPreco = site::formata_moeda($this->request->post('ConvMOPreco'));					
		$obj->ConvProdHora = $this->request->post('ConvProdHora');					
		$obj->ConvProdPreco = site::formata_moeda($this->request->post('ConvProdPreco'));					
		$obj->ConvTercHora = $this->request->post('ConvTercHora');					
		$obj->ConvTercPreco = site::formata_moeda($this->request->post('ConvTercPreco'));					
		$obj->ConvMatPreco = site::formata_moeda($this->request->post('ConvMatPreco'));					
		$obj->ConvOutrPreco = site::formata_moeda($this->request->post('ConvOutrPreco'));	

		$obj->Total = ( site::formata_moeda($this->request->post('PreMOPreco'))+site::formata_moeda($this->request->post('PreProdPreco'))+
				  site::formata_moeda($this->request->post('PredTercPreco'))+site::formata_moeda($this->request->post('PredMatPreco'))+
				  site::formata_moeda($this->request->post('PredOutrPreco'))+site::formata_moeda($this->request->post('ConvMOPreco'))+
				  site::formata_moeda($this->request->post('ConvProdPreco'))+site::formata_moeda($this->request->post('ConvTercPreco'))+
				  site::formata_moeda($this->request->post('ConvMatPreco'))+site::formata_moeda($this->request->post('ConvOutrPreco'))
				   	);		
		$obj->DataPlanejamento = site::data_EN( $this->request->post('DataPlanejamento') ,null );					
		$obj->DataCorretiva = site::data_EN( $this->request->post('DataCorretiva'), null );					
		$obj->DataFinalizacao = site::data_EN( $this->request->post('DataFinalizacao'), null );		

		/*if( ( $this->request->post('DataFinalizacao') != null) && $obj->Total != 0) //significa que a OS foi finalizada
			enviaEmail::aviso_ospFinalizada($this->request->post('GR'));			*/

		$obj->RespPlanejamento = $this->request->post('RespPlanejamento');		
		$obj->RespCorretiva = $this->request->post('RespCorretiva');		
		$obj->RespFinalizacao = $this->request->post('RespFinalizacao');		
		$obj->Obs = $this->request->post('Obs');		

		if ($obj->save()) 
			HTTP::redirect('clientes/edit_historico/'.$obj->gr->CodGR);
		else
			HTTP::redirect('clientes/edit_historico/'.$obj->gr->CodGR.'?erro=1');

	}	
	
	public function action_getGraficosOSP_gauge($user=null,$de=null,$ate=null,$sp=null,$pe=null,$fi=null)
	{		
		if($user==null)
			$user = $this->input->post("user");

		if($this->request->is_ajax())
			$this->template = "";

		$de = site::data_EN($de);
		$ate = site::data_EN($ate);
		$total = 0;
		$finalizadas = 0;
		$pendentes = 0;
		$sem_planejamento = 0;

		foreach ($user->empresas->find_all() as $empresa) {	

			$equipamentos = ORM::factory('EquipamentoInspecionado')
			->where('EquipamentoInspecionado.Empresa','=',$empresa->CodEmpresa)
			->and_where('EquipamentoInspecionado.Data', 'BETWEEN', array($de, $ate))
			->join('gr','LEFT')->on('gr.EquipamentoInspecionado','=','EquipamentoInspecionado.CodEquipamentoInspecionado')
			->join('resultados','LEFT')->on('resultados.GR','=','gr.CodGR')
			->and_where_open();

			if( ($sp != 0) || ($pe != 0) || ($fi != 0) )
			{				
				if($sp!=0)
					$equipamentos->where("resultados.DataPlanejamento",'IS',NULL);					
				if($pe!=0)
					$equipamentos->or_where("resultados.DataPlanejamento",'IS NOT',NULL);
				if($fi!=0)
					$equipamentos->or_where("resultados.DataFinalizacao",'IS NOT',NULL);
			}

			$equipamentos->and_where_close();

			$equipamentos->where('gr.Confirmado','=',1)->order_by('EquipamentoInspecionado.Data','desc');

			$result = $equipamentos->find_all();
			
			foreach ($result as $e) {				
				$total++;
				if( ($e->gr->resultado->Total != null) && ($e->gr->resultado->Total != 0) )
				{
					$finalizadas++;
					continue;
				}

				if( !in_array( site::datahora_BR($e->gr->resultado->DataPlanejamento), array(null,'00/00/0000')) )
				{
					$pendentes++;
					continue;
				}	
			}
		}	
		//pegar as porcentagens
		if($total != 0){			
			$finalizadas = round(($finalizadas/$total)*100,2);
			$pendentes = round(($pendentes/$total)*100,2);		
			$sem_planejamento = round(100 - ($pendentes+$finalizadas),2);
		}	
		$array = array('finalizadas' => $finalizadas, 'pendentes' => $pendentes , 'sem_planejamento' => $sem_planejamento );
		return $array;
	}

} // End Welcome Controller
