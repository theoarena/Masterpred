<?php defined('SYSPATH') or die('No direct script access.');
 
class Task_setempresa extends Minion_Task
{
      protected $_options = array(
        'empresa' => 1,        
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
		
		foreach ($empresa->areas->find_all() as $area) {
			foreach ($area->setores->find_all() as $setor) {
				foreach ($setor->equipamentos->find_all() as $equipamento) {
					foreach ($equipamento->equipamentoinspecionados->find_all() as $equipinsp) {

						Minion_CLI :: write ('empresa: '.$empresa->CodEmpresa.' - area: '.$area->CodArea.' - setor: '.$setor->CodSetor.' - '.$equipamento->CodEquipamento.' - '.$equipinsp->CodEquipamentoInspecionado);	
						
						$obj = ORM::factory("EquipamentoInspecionado",$equipinsp->CodEquipamentoInspecionado);
						$obj->Empresa = $empresa->CodEmpresa;
						$obj->save();
					}						
				}
			}				
		}
		

		/*

		foreach ($empresas as $empresa) {
			foreach ($empresa->areas->find_all() as $area) {
				foreach ($area->setores->find_all() as $setor) {
					foreach ($setor->equipamentos->find_all() as $equipamento) {
						foreach ($equipamento->equipamentoinspecionados->find_all() as $equipinsp) {

							Minion_CLI :: write ('empresa: '.$empresa->CodEmpresa.' - area: '.$area->CodArea.' - setor: '.$setor->CodSetor.' - '.$equipamento->CodEquipamento.' - '.$equipinsp->CodEquipamentoInspecionado);	
							
							$obj = ORM::factory("EquipamentoInspecionado",$equipinsp->CodEquipamentoInspecionado);
							$obj->Empresa = $empresa->CodEmpresa;
							$obj->save();
						}						
					}
				}				
			}
		}

		*/
		
		Minion_CLI :: write ('terminou');	
		die();
	}
}

