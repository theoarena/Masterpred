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

		if(!Site::isGrant($this->privileges_needed)) //se pode acessar a url
			HTTP::redirect('avisos/denied');
	}

	public function action_carrega_relatorios() //===========ajax
	{
		$this->template = ""; //tira o AUTO RENDER, devolve só o request pedido ao inves da pagina toda	

		$de = Site::data_EN($this->request->post('de'));
		$ate = Site::data_EN($this->request->post('ate'));
		$tecnologia = $this->request->post('tecnologia');
		$empresa = Site::get_empresaatual();
	
		$array = array();
		$objs = ORM::factory('Relatorios');
		
		$objs->where('Data', 'BETWEEN', array($de, $ate));
		$objs->where("Tecnologia",'=',$tecnologia);			
		$objs->where("Empresa",'=',$empresa);
	
		$objs->order_by("Data","DESC");
			
		$relatorios = $objs->find_all();
		foreach ($relatorios as $item)			
			$array[] = array(
					'ID' => $item->ID,					
					'CodRelatorio' => $item->CodRelatorio,					
					'Sequencial' => Site::data_EN_relatorio($item->Data).".".Site::formata_codRelatorio($item->CodRelatorio),					
					'Data' => Site::data_BR($item->Data),
					'Tecnologia' => $item->tecnologia->Tecnologia,
					'Analista' => $item->analista->Analista,
					'Rota' => $item->rota->Rota,
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
			'ordem_servico' => 'Ordem de serviço'
			);

		$this->template->content->conteudo->tecnologias = $list;	
		$this->template->content->conteudo->tipos = $tipos;	
	}

	public function action_gera_relatorio()
	{	
		$mpdf = new mPDF('c','', 0, '', 10, 10, 28, 25, 5, 2, 'A4-P');
		$mpdf->ignore_invalid_utf8 = true;
		$tipo = $_GET['tipo'];

		if($tipo == 'ordem_servico')
		{
			$encrypt = Encrypt::instance('relatorios');			

			$gr = ORM::factory("Gr", $encrypt->decode($_GET['gr']) );			

			$mpdf = $this->relatorio_ordem_servico($mpdf,$gr);	

		}
		if($tipo == 'x')
		{

			/*
			$objs = ORM::factory("GR")
			->join('EquipamentoInspecionado','LEFT')->on('equipamentoinspecionado.CodEquipamentoInspecionado','=','GR.EquipamentoInspecionado')
			->where('Data', 'BETWEEN', array($de, $ate))
			->where("equipamentoinspecionado.Empresa",'=',Site::get_empresaatual())
			->where("equipamentoinspecionado.Tecnologia",'=',$tecnologia);
			*/

			$objs = ORM::factory("EquipamentoInspecionado")
			->where('Empresa','=',Site::get_empresaatual())
			->where('Tecnologia','=',$tecnologia)
			->where('Data', 'BETWEEN', array($de, $ate))
			->order_by("Equipamento")
			->find_all();

			$mpdf = $this->relatorio_ordem_servico($mpdf,$objs);

		}
		elseif($tipo == 'lista_equipamentos')
		{

		}

		$mpdf->Output();
		exit;

	}

	public function relatorio_ordem_servico($mpdf,$gr)
	{	
		$cabecalho = View::factory("relatorios/estrutura/cabecalho_internas");	
		$cabecalho->secao = "Seção A - Carta ao Cliente";	
		$mpdf->DefHTMLHeaderByName("cabecalho",utf8_encode($cabecalho));	

		$footer = View::factory("relatorios/estrutura/footer_internas");			
		$mpdf->DefHTMLFooterByName("rodape",utf8_encode($footer));	

		$mpdf->SetHTMLHeaderByName('cabecalho');
		$mpdf->SetHTMLFooterByName('cabecalho');

		$osp = View::factory("relatorios/modelos/osp");		
		$osp->gr = $gr;		

		$mpdf->WriteHTML($this->stylesheet,1);
		$mpdf->WriteHTML($osp);

		return $mpdf;
	}

	public function relatorio_asd($mpdf,$objs)
	{	

		$cabecalho_capa = View::factory("relatorios/estrutura/cabecalho_capa");		
		$footer_capa = View::factory("relatorios/estrutura/footer_capa");	

		$cabecalho_internas = View::factory("relatorios/estrutura/cabecalho_internas");	
		$cabecalho_internas->secao = "Seção A - Carta ao Cliente";		
		$mpdf->DefHTMLHeaderByName("cabecalho_internas",utf8_encode($cabecalho_internas));

		$mpdf->DefHTMLHeaderByName("cabecalho_capa",$cabecalho_capa);
 		$mpdf->SetHTMLHeaderByName('cabecalho_capa');

 		$mpdf->DefHTMLFooterByName("footer_capa",$footer_capa);
 		$mpdf->SetHTMLFooterByName('footer_capa');
	//	$footer_internas = View::factory("relatorios/estrutura/footer_internas");		

		$capa = View::factory("relatorios/estrutura/capa");		
		$capa->numero_relatorio = 'x';	
		$capa->nome_empresa = $empresa->Empresa;			
		$capa->endereço = $empresa->endereco;		
		$capa->bairro = $empresa->departamento;		
		$capa->cidade = $empresa->Unidade;		
		$capa->cep = $empresa->cep;		
		$capa->ac = $empresa->contato;		
		
		$mpdf->WriteHTML($this->stylesheet,1);
		$mpdf->WriteHTML($capa);
 		
 		$mpdf->SetHTMLHeaderByName('cabecalho_internas');	
		
		$mpdf->AddPage();
		
		$html = "<ul>";

		foreach ($objs as $equip) {
			$html .= "<li>";
				$html .= $equip->equipamento->Tag." - ".$equip->equipamento->Equipamento;	

				$html .= "/ <strong>Numero da Gr:".$equip->gr->CodGR."</strong>";

			$html .= "</li>";
		}

		$html .= "</ul>";
		$mpdf->WriteHTML($html);
			
		return $mpdf;
	}		

} // End Welcome Controller
