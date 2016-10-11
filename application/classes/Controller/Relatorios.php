<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Relatorios extends Controller_Welcome {
	
	public $privileges_needed = array('access_print_osp');

	public function before(){
		parent::before();		

	//	$this->template = View::factory("index_relatorios");								

		include_once(Kohana::$config->load('config')->get('mpdf'));
		$this->stylesheet = file_get_contents(Kohana::$config->load('config')->get('css').'print.css');

		$this->template->content->show_add_link = false;													
		$this->template->content->show_back_link = false;			
		$this->template->content->show_search = false;	
		
	}

	public function after(){
		parent::after();

		if(!Usuario::isGrant($this->privileges_needed)) //se pode acessar a url
			HTTP::redirect('avisos/denied');
	}

	public function action_carrega_relatorios() //===========ajax
	{
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda	

		$de = Site::data_EN($this->request->post('de'));
		$ate = Site::data_EN($this->request->post('ate'));
		$tecnologia = $this->request->post('tecnologia');
		$empresa = Usuario::get_empresaatual();
	
		$array = array();
		$objs = ORM::factory('Relatorios');
		
		$objs->where('Data', 'BETWEEN', array($de, $ate));
		$objs->where("Tecnologia",'=',$tecnologia);			
		$objs->where("Empresa",'=',$empresa);
	
		$objs->order_by("CodRelatorio","DESC");
			
		$relatorios = $objs->find_all();
		foreach ($relatorios as $item)			
			$array[] = array(
					'ID' => $item->ID,					
					'CodRelatorio' => $item->CodRelatorio,					
					'Sequencial' => Site::data_EN_relatorio($item->Data).".".Site::formata_codRelatorio($item->CodRelatorio),					
					'Data' => Site::data_BR($item->Data),
					'Tecnologia' => $item->tecnologia->Tecnologia,
					'Analista' => $item->analista->Analista,
					'CodAnalista' => $item->analista->CodAnalista,
					'Rota' => $item->rota->Rota,
					'CodRota' => $item->rota->CodRota,
					'DataCod' => $item->Data,
				);
					
		print json_encode($array);	

	}

	public function action_relatorios()
	{
		$this->template->content->conteudo = View::factory("relatorios/list_relatorios");					
		
		$list = ORM::factory('Tecnologia')->find_all()->as_array("CodTecnologia","Tecnologia");
		$list["padrao"] = "Selecione uma tecnologia";

		$tipos = array(			
			'capa_relatorio' => 'Capa',		
			'carta_relatorio' => 'Carta do relatório',		
			'lista_equipamentos' => 'Lista de equipamentos monitorados',		
			'graficos_gerenciais' => 'Gráficos Gerenciais',		
			'ordem_servico_batch' => 'Ordem de serviço'
			);

		$this->template->content->conteudo->tecnologias = $list;	
		$this->template->content->conteudo->tipos = $tipos;	
	}

	public function action_gera_relatorio()
	{	

		//ini_set("memory_limit","-1");

		$mpdf = new mPDF('c','', 0, '', 10, 10, 24, 9, 5, 2, 'A4-P');
		$mpdf->ignore_invalid_utf8 = true;
		$mpdf->simpleTables = true;
		$this->packTableData = true;

		$tipo = $_GET['tipo'];
		$direct = ( isset($_GET['direct']) )?( $_GET['direct'] ):("I");
		$filename = "";
		
		if($tipo == 'capa_relatorio')
		{				
			$cod = $_GET['cod'];
			$relatorio = ORM::factory("Relatorios", $cod);					
			$empresa = ORM::factory('Empresa',$relatorio->Empresa);	
			$tecnologia = $relatorio->tecnologia;
			$filename = 'relatorio_'.$cod.' - capa.pdf';
			$mpdf = $this->relatorio_capa($mpdf,$empresa,$tecnologia,$relatorio);	

		}

		elseif($tipo == 'ordem_servico')
		{
			$mpdf->simpleTables = false;
			$encrypt = Encrypt::instance('relatorios');			
			$cod = $_GET['gr']; //$encrypt->decode($_GET['gr']);
			$gr = ORM::factory("Gr", $cod);			
			$filename = 'relatorio_'.$cod.' - osp.pdf';
			$mpdf = $this->relatorio_ordem_servico($mpdf,$gr);	

		}

		elseif($tipo == 'ordem_servico_batch')
		{
			$mpdf->simpleTables = false;
			$cod = $_GET['cod'];
			$direct = "D";			
				
			$filename = 'relatorio_'.$cod.' - osps.pdf';

			$list_equips = array();
			$rota = ORM::factory("Rota", $_GET['rota']);		

			$equips = DB::query(Database::SELECT,
				"SELECT
					equipamentoinspecionado.CodEquipamentoInspecionado AS CodEquipamento, 					
					equipamentoinspecionado.Condicao AS Condicao,  						
					condicao.Emergencia as Emergencia
 
					FROM equipamentoinspecionado
					LEFT JOIN condicao ON equipamentoinspecionado.Condicao = condicao.CodCondicao

					WHERE Emergencia = 1 AND Empresa = :empresa AND equipamentoinspecionado.Tecnologia = :tecnologia AND Analista = :analista AND DATE_FORMAT(Data, '%Y-%m-%d') = :data ORDER BY CodEquipamentoInspecionado ASC"
			);
			//WHERE Empresa = :empresa AND Tecnologia = :tecnologia AND Analista = :analista AND Data BETWEEN :start AND :end ORDER BY Data Desc"
			 
			$equips->parameters(array(
			    ':empresa' => Usuario::get_empresaatual(),
			    ':tecnologia' => $_GET['tec'],
			    ':analista' => $_GET['analista'],
			    //':data' => Site::datahora_EN($_GET['data']),		    
			    ':data' => Site::datahora_EN($_GET['data']),		    
			));

			//echo $equips;exit;

			$equips = $equips->execute();	
			
			$array_equips = array();
			$qtd = 0;			
			foreach ($equips as $e) {	
				
				$equipamentoinp = ORM::factory('EquipamentoInspecionado',$e['CodEquipamento']);	
				$equipamento = $equipamentoinp->equipamento;

				if($equipamento->has('rotas', $rota))//se o equipamento pertence à rota em questao									
				{
					$array_equips[] = $equipamentoinp->gr;				
					$qtd++;
				} 
			}	

			
			foreach ($array_equips as $a) {
				$qtd--;
				$mpdf = $this->relatorio_ordem_servico($mpdf,$a);		
				if($qtd!=0)									
					$mpdf->AddPage();
			}
			
		}

		elseif($tipo == 'lista_equipamentos')
		{	
			$cod = $_GET['cod'];
			//$id_relatorio = $_GET['relatorio'];
			$relatorio = ORM::factory("Rota", $cod);			
			$filename = 'relatorio_'.$cod.' - equipamentos.pdf';

			$list_equips = array();
			$rota = ORM::factory("Rota", $_GET['rota']);	

			//	$timer = new Timer(1);
			//echo  "start  : " . $timer->get() . "<br \> " ;
			//echo memory_get_usage() . "<br \> " 
;	
			$equips = DB::query(Database::SELECT,
				"SELECT 
					equipamentoinspecionado.Equipamento AS Equipamento,
					equipamentoinspecionado.Condicao AS Condicao,
					equipamentoinspecionado.Data AS Data,														
					equipamentoinspecionado.Empresa AS Empresa				
					FROM equipamentoinspecionado AS equipamentoinspecionado
					INNER JOIN equipamento as e ON e.CodEquipamento = equipamentoinspecionado.equipamento
					WHERE Empresa = :empresa AND Tecnologia = :tecnologia AND Analista = :analista AND DATE_FORMAT(Data, '%Y-%m-%d') = :data ORDER BY e.Equipamento ASC"
			);
			//WHERE Empresa = :empresa AND Tecnologia = :tecnologia AND Analista = :analista AND Data BETWEEN :start AND :end ORDER BY Data Desc"
			 
			$equips->parameters(array(
			    ':empresa' => Usuario::get_empresaatual(),
			    ':tecnologia' => $_GET['tec'],
			    ':analista' => $_GET['analista'],
			    //':data' => Site::datahora_EN($_GET['data']),		    
			    ':data' => Site::datahora_EN($_GET['data']),		    
			));

			//echo $equips;exit;

			$equips = $equips->execute();	
			
			$count = 0;

			foreach ($equips as $e) {	

				//$equipamento = $e->equipamento;
				$equipamento = ORM::factory('Equipamento',$e['Equipamento']);

				if($equipamento->has('rotas', $rota)) //se o equipamento pertence à rota em questao
				{
					$condicao = DB::query(Database::SELECT,	"SELECT Condicao as Condicao from condicao WHERE CodCondicao = :condicao" );
					$condicao->parameters(array(':condicao' => $e['Condicao'] ));
					$condicao = $condicao->execute();	

					$setor = $equipamento->setor->CodSetor;
					$area = $equipamento->setor->area->CodArea;			
				
					if( !isset($list_equips[$area]) )					
						$list_equips[$area] = array();						
										
					if( !isset($list_equips[$area][$setor]) )
						$list_equips[$area][$setor] = array();

					$list_equips[$area][$setor][] = array(
						'Equipamento' => $equipamento->Equipamento,
						'Tag' => $equipamento->Tag,
						//'Condicao' => $e->condicao->Condicao,
						'Condicao' => $condicao->get('Condicao'),
						//'Data' => $e->Data,
						'Data' => $e['Data'],
					);		
					$count++;			
				}					
			}	

			$mpdf = $this->relatorio_lista_equipamentos($mpdf,$list_equips,$count);	

		}
		
		$mpdf->Output($filename,$direct);	
		exit;

	}

	public function relatorio_capa($mpdf,$empresa,$tecnologia,$relatorio)
	{
		$cabecalho = View::factory("relatorios/estrutura/cabecalho_capa");			
		$mpdf->DefHTMLHeaderByName("cabecalho",$cabecalho);	

		$rodape = View::factory("relatorios/estrutura/footer_capa");			
		$mpdf->DefHTMLFooterByName("rodape",$rodape);	

		$mpdf->SetHTMLHeaderByName('cabecalho');
		$mpdf->SetHTMLFooterByName('rodape');

		$capa = View::factory("relatorios/modelos/capa");	
		$capa->empresa = $empresa; 
		$capa->tecnologia = $tecnologia; 		
		$capa->relatorio = $relatorio; 		

		$mpdf->WriteHTML($this->stylesheet,1);
		$mpdf->WriteHTML($capa);		

		return $mpdf;
	}

	public function relatorio_lista_equipamentos($mpdf,$list_equips,$count)
	{

		$cabecalho = View::factory("relatorios/estrutura/cabecalho_internas");	
		$cabecalho->secao = "Seção C - Equipamentos Inspecionados "; 
		$mpdf->DefHTMLHeaderByName("cabecalho",$cabecalho);	

		$rodape = View::factory("relatorios/estrutura/footer_capa");			
		$mpdf->DefHTMLFooterByName("rodape",$rodape);	

		$mpdf->SetHTMLHeaderByName('cabecalho');
		$mpdf->SetHTMLFooterByName('rodape');

		$lista = View::factory("relatorios/modelos/lista_equipamentos");	
		$lista->areas = $list_equips; 
		$lista->count = $count; 
		$lista->empresa = Usuario::get_empresaatual(2); 

		$mpdf->WriteHTML($this->stylesheet,1);
		$mpdf->WriteHTML($lista);		

		return $mpdf;
	}

	public function relatorio_ordem_servico($mpdf,$gr)
	{		
		$cabecalho = View::factory("relatorios/estrutura/cabecalho_internas");	
		$cabecalho->secao = "Seção D - Ordem de Serviço"; 
		$mpdf->DefHTMLHeaderByName("cabecalho",$cabecalho);	

		$rodape = View::factory("relatorios/estrutura/footer_capa");			
		$mpdf->DefHTMLFooterByName("rodape",$rodape);	

		$mpdf->SetHTMLHeaderByName('cabecalho');
		$mpdf->SetHTMLFooterByName('rodape');

		$osp1 = View::factory("relatorios/modelos/osp_1");		
		$osp2 = View::factory("relatorios/modelos/osp_2");		
		$osp3 = View::factory("relatorios/modelos/osp_3");		

		$medcor = 0;
		$deltacor = 0;
		$carga = 0;

		if($gr->In != 0)
			$carga = ( ( ( ( ($gr->Ir + $gr->Is) + $gr->It ) / 3 ) * 100 ) / $gr->In);
		
		if($carga != 0)
		{
			$medcor = ( ( ($gr->TemperaturaMed * 100) / ($carga*100) ) / $carga );
			$deltacor = ( ( $gr->TemperaturaRef - $gr->TemperaturaMed ) * 100 ) / ( ( $carga*(100) ) /$carga ) ;
		}
	

		$osp1->gr = $gr;

		$osp1->carga = $carga;		
		$osp1->medcor = $medcor;		
		$osp1->deltacor = $deltacor;			
				
		$osp2->resultado = $gr->resultado;		
		$osp3->resultado = $gr->resultado;		

		$mpdf->WriteHTML($this->stylesheet,1);
		$mpdf->WriteHTML($osp1->render());		
		$mpdf->WriteHTML($osp2->render());
		$mpdf->WriteHTML($osp3->render());

		return $mpdf;
	}

	public function action_uploads() //página principal de upload
	{	
		$this->template->content->show_add_link = true;																	
		$this->template->content->show_search = true;	

		$this->template->content->conteudo = View::factory("relatorios/list_uploads");						
		$list = ORM::factory('ArquivoRelatorio')->where( 'Empresa','=',Usuario::get_empresaatual() )->find_all();		

		$this->template->content->conteudo->arquivos = $list;		
						
		//$this->template->content->conteudo->objs = $rotas;
	}

	public function action_edit_uploads() //edit dos condicoes
	{		
		$this->template->content->show_back_link = true;	
		$obj = ORM::factory("ArquivoRelatorio", Site::segment("edit_uploads",null) );
		$tecnologias = ORM::factory("Tecnologia")->find_all()->as_array("CodTecnologia","Tecnologia");
		$this->template->content->conteudo = View::factory("relatorios/edit_uploads");	
		$this->template->content->conteudo->obj = $obj;									
		$this->template->content->conteudo->tecnologias = $tecnologias;				
	}

	public function action_save_uploads() //salvar novo e editar
	{			
		$obj = ORM::factory('ArquivoRelatorio',$this->request->post('CodArquivoRelatorio' ));		
		$tecnologia = ORM::factory('Tecnologia',$this->request->post('Tecnologia' ));		
		
		$dir = Kohana::$config->load('config')->get('upload_directory_relatorios');

		$obj->Obs = $this->request->post('Obs');
		$obj->Sequencial = $this->request->post('Sequencial');
		$obj->Empresa = Usuario::get_empresaatual();				
		$obj->Tecnologia = $this->request->post('Tecnologia');					
		$obj->Data = Site::data_EN($this->request->post('Data'));					
		
		if ($obj->save()) 
		{
			$filename = true;

			if(isset($_FILES['arquivo']) and $_FILES['arquivo']["name"] != "")
			{
				$ext = pathinfo($_FILES['arquivo']["name"], PATHINFO_EXTENSION);
				
				$rdn = Site::random_password(5);
				$file = $_FILES['arquivo'];
				$name = "relatorio_".Site::toAscii(Usuario::get_empresaatual(2)).'_'.Site::toAscii($tecnologia->CodTecnologia)."_".$obj->CodArquivoRelatorio."".$rdn.".".$ext;	
				//echo $dir."".$name;exit;						
				$filename = Upload::save($file,$name,$dir);	
			    //unlink($filename);
			    $obj->Arquivo = $name;
			    $obj->save();
			}	

			if($filename !== false)
				HTTP::redirect("relatorios/uploads?sucesso=1");
		}				
		
		HTTP::redirect("relatorios/uploads?erro=1");
		
	}	

		//metodo padrao de delete
	public function action_delete_uploads()
	{		
		$this->template = "";
		$obj = ORM::factory($this->request->post('class'),$this->request->post('id'));	
		$dir = Kohana::$config->load('config')->get('upload_directory_relatorios');
		$path = $dir."".$obj->Arquivo;
		if($obj->delete())
		{
			unlink($path);
			Cache::instance()->delete($this->request->post('cache')); //remove o cache
			print 1;
		}
		else
			print 0;
	}

} // End Welcome Controller
