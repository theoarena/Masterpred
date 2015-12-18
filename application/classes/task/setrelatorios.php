<?php defined('SYSPATH') or die('No direct script access.');
 
class Task_setrelatorios extends Minion_Task
{
      protected $_options = array(
        'empresa' => 1,        
        'start' => 1      
      );
    /**
     * This is a demo task
     *
     * @return null
     */
    protected function _execute(array $params)
    {
    	Minion_CLI :: write ('começou');	
    	//var_dump($params);
        $this->template = "";
		//$empresas = ORM::factory("Empresa")->find_all();
		$empresa = ORM::factory("Empresa",$params['empresa']);
		
		$relatorios = array();
		$equipamento_array = array();
		
		$start = $params['start'];

		foreach ($empresa->rotas->find_all() as $rota) {	
		// para cada dessa só pode haver um relatório, logo só precisamos identificar caso haja a mesma rota em datas diferentes				
		// pegamos os equipamentos inspecionados e agrupamos por data, cada data será uma entrada de relatório diferntes, depois é só 
		//colocar cada coisa em seu lugar
				
			foreach ($rota->equipamentos->find_all() as $equipamento) {
				foreach ($equipamento->equipamentoinspecionados->find_all() as $equipinsp) { //todos os equipamentos inspecionados dessa empresa, na rota acima
					
					$md5 = md5( Site::data_BR($equipinsp->Data)."".$equipinsp->Tecnologia."".$rota->CodRota );
					$md5 = substr($md5, 0, 10);
					//$md5_array[] = $md5

					if(!array_key_exists($md5, $equipamento_array))
					{
						$equipamento_array[$md5] = array(		
							'CodRelatorio' => $start,			
							'Tecnologia' => $equipinsp->Tecnologia,
							'Data' => Site::data_BR($equipinsp->Data),
							'Rota' => $rota->CodRota,
							'Empresa' => $params['empresa'],
							'Analista' => $equipinsp->Analista
						);

						$start++;
					}
				}		
			}						
		}
	
		foreach ($equipamento_array as $equip) {
		
			$relatorio = ORM::factory("Relatorios");
			$relatorio->CodRelatorio = $equip['CodRelatorio'];
			$relatorio->Empresa = $equip['Empresa'];
			$relatorio->Analista = $equip['Analista'];
			$relatorio->Rota = $equip['Rota'];
			$relatorio->Tecnologia = $equip['Tecnologia'];
			$relatorio->Data = Site::data_EN($equip['Data']);
			$relatorio->save();
			
		}		


		Minion_CLI :: write ('terminou');	
		die();
	}
}

