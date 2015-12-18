<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Cron extends Controller {
		
	public $template = 'index';

	public function cobrancaosp()
	{		
		$this->auto_render = FALSE;
		$resultados = ORM::factory("Resultados")->where(array("DataFinalizacao"=>NULL) )->find_all();

		foreach ($resultados as $resultado) {
			$equip = $resultado->gr->equipamentoinspecionado;

			$condicao = $equip->condicao->Condicao;
			
			$tipos_condicao = Kohana::config('core.tipos_condicao');

			if(in_array($condicao,$tipos_condicao)) //se estiver em algum grau de risco
			{
				$data = strtotime(Site::datahora_EN($equip->Data)); //data da lançamento da os
				$hoje = strtotime(date("Y-m-d")); //data atual				
				$diferenca = date::timespan($data,$hoje);				
				//fazer o resto
				if( ( $diferenca["days"] == 30 ) && ($condicao == "GR-4") )
					email::aviso_limitegr(4,$equip);

				if( ( $diferenca["days"] == 20 ) && ($condicao == "GR-3") )
					email::aviso_limitegr(3,$equip);

				if( ( $diferenca["days"] == 10 ) && ($condicao == "GR-2") )
					email::aviso_limitegr(2,$equip);

				if( ( $diferenca["days"] == 3 ) && ($equip->condicao->Emergencia == 1) )
					email::aviso_limitegr(1,$equip);
			}			

		}
	}	
}