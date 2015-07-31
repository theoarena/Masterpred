<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Sistema extends Controller_Welcome {
	
	public $privileges_needed = array();// 'access_sistema' 
	
	public function after(){
		parent::after();

		if(!site::isGrant($this->privileges_needed)) //se pode acessar a url
			HTTP::redirect('avisos/denied');
	}
	//======================================================//
	//==================CONDICOES=========================//
	//======================================================//	

	public function action_condicoes() 
	{	
		$this->privileges_needed[] = 'access_condicoes';
		$objs = ORM::factory("Condicao")->find_all();
		$this->template->content->conteudo = View::factory("sistema/list_condicoes");					
		$this->template->content->conteudo->objs = $objs;	

		if(!site::isGrant(array('add_condicoes')))
			$this->template->content->show_add_link = false;					
	}

	public function action_edit_condicoes() //edit dos condicoes
	{				
		$this->privileges_needed[] = 'access_condicoes';
		$this->privileges_needed[] = 'edit_condicoes';
		$obj = ORM::factory("Condicao", site::segment("edit_condicoes",null) );
		$tecnologias = ORM::factory("Tecnologia")->find_all()->as_array("CodTecnologia","Tecnologia");
		$this->template->content->conteudo = View::factory("sistema/edit_condicoes");					
		$this->template->content->conteudo->obj = $obj;				
		$this->template->content->conteudo->cores = Kohana::$config->load('config')->get('cores_condicao');				
		$this->template->content->conteudo->tecnologias = $tecnologias;				
	}
	
	public function action_save_condicoes() //salvar novo e editar
	{	
		$this->privileges_needed[] = 'access_condicoes';
		$obj = ORM::factory('Condicao',$this->request->post('CodCondicao' ));		
		
		$dir = Kohana::$config->load('config')->get('upload_directory_condicoes');
		if(isset($_FILES['imagem']) and $_FILES['imagem']["name"] != "")
		{
			
			$file = $_FILES['imagem'];
			$filename = Upload::save($file,null,$dir);	
			$foto = $dir."/condicao_".$this->request->post('Tecnologia')."_".basename($filename);
			Image::factory($filename)->save($foto);	
		    unlink($filename);
		    $obj->Imagem ="condicao_".$this->request->post('Tecnologia')."_".basename($filename);	
		}	

		$obj->Condicao = $this->request->post('Condicao');		
		$obj->Descricao = $this->request->post('Descricao');
		$obj->Emergencia = $this->request->post('Emergencia');				
		$obj->Tecnologia = $this->request->post('Tecnologia');				
		$obj->Cor = $this->request->post('Cor');	
		
		Cache::instance()->delete('condicoes'); //remove o cache

		if ($obj->save()) 
			HTTP::redirect("sistema/condicoes?sucesso=1");
		else
			HTTP::redirect("sistema/edit_condicoes?erro=1&Condicao=".$this->request->post('Condicao'));
		
	}
	
	//======================================================//
	//==================USUARIOS=========================//
	//=====================================================

	public function action_usuarios_sistema() //página principal dos usuarios
	{		
		$this->privileges_needed[] = 'access_usuarios_sistema';	
		$user = Auth::instance()->get_user();
		$objs = ORM::factory('User')->where('system','=',1)->and_where('ativo','=',1)->and_where('id','!=',$user->id)->find_all();		
		$this->template->content->conteudo = View::factory('usuario/list_usuarios');					
		$this->template->content->conteudo->tipo = 'sistema';	
		$this->template->content->conteudo->link_edit = 'sistema/edit_usuarios_sistema';	
		$this->template->content->conteudo->objs = $objs;	

	}

	public function action_edit_usuarios_sistema() //edit dos usuarios
	{			
		$obj = ORM::factory('User', site::segment('edit_usuarios_sistema',null) );
		
		$roles = ORM::factory('Role')->find_all()->as_array('id','nickname');		
		unset($roles[1]);//tira a role LOGIN, já que ela é padrão

		$roles_selecionadas = 1;
		foreach ($obj->roles->find_all() as $r) 
			$roles_selecionadas = $r->id;

		$this->template->content->conteudo = View::factory('usuario/edit_usuarios');
		$this->template->content->conteudo->tipo = 'sistema';						
		$this->template->content->conteudo->redir = 'usuarios_sistema';	
		$this->template->content->conteudo->obj = $obj;	
		$this->template->content->conteudo->roles = $roles;				
		$this->template->content->conteudo->roles_selecionadas = $roles_selecionadas;				
		$this->template->content->plus_back_link = '_sistema';	
		$list = array();
				
	}	
	
	//======================================================//
	//==================ROLES=========================//
	//======================================================//	

	public function action_roles() 
	{		
		$this->privileges_needed[] = 'access_roles';
		$objs = ORM::factory('Role')->where('name','!=','login')->find_all();
		$this->template->content->conteudo = View::factory('sistema/list_roles');					
		$this->template->content->conteudo->objs = $objs;

	}

	public function action_edit_roles() //edit dos grupos de acesso
	{		
		$this->privileges_needed[] = 'access_roles';		
		$obj = ORM::factory('Role', site::segment('edit_roles',null) );		
		$privileges = ORM::factory('Privilege')->order_by('ord','ASC')->find_all();
		$privileges_selecionados = $obj->privileges->find_all()->as_array('id','name');
		$this->template->content->conteudo = View::factory('sistema/edit_roles');												
		$this->template->content->conteudo->privileges = $privileges;							
		$this->template->content->conteudo->privileges_selecionados = $privileges_selecionados;							
		$this->template->content->conteudo->obj = $obj;									
	}
	
	public function action_save_roles() //salvar as roles do usuario, atualizando os privilégios de cada uma
	{		
		$obj = ORM::factory('Role',$this->request->post('id'));		
	   
		$obj->name = $this->request->post('name');				
		$obj->description = $this->request->post('description');				
		$obj->nickname = $this->request->post('nickname');				
		$post = $this->request->post('privileges');

		if($post == null)
			$post = array();	
		
		site::addORMRelation($obj, $obj->privileges,$post,'privileges');

		if ($obj->save()) 
			HTTP::redirect('sistema/roles?sucesso=1');
		else
			HTTP::redirect('sistema/edit_roles?erro=1');		
	}

	//======================================================//
	//==================PRIVILEGES=========================//
	//======================================================//	

	public function action_privileges() 
	{		

		$obj = ORM::factory('Privilege')->find_all();
		$this->template->content->conteudo = View::factory("sistema/list_privileges");					
		$this->template->content->conteudo->obj = $obj;			
	}

	public function action_edit_privileges() //edit dos grupos de acesso
	{				
		$obj = ORM::factory("Privilege", site::segment('edit_privileges',null) );		
		$this->template->content->conteudo = View::factory("sistema/edit_privileges");												
		$this->template->content->conteudo->obj = $obj;									
	}
	
	public function action_save_privileges() //salvar novo e editar
	{	
		$obj = ORM::factory('Privilege',$this->request->post('id'));		
	  
		$obj->name = URL::title($this->request->post('name'),'_');				
		$obj->description = $this->request->post('description');				
		$obj->apelido = $this->request->post('apelido');				
		//$obj->add("role",$this->request->post('role'));

		if ($obj->save()) 
			HTTP::redirect("sistema/privileges/?sucesso=1");
		else
			HTTP::redirect("sistema/privileges/?erro=1");
		
	}

	//======================================================//
	//==================ANALISTA=========================//
	//======================================================//	

	public function action_analistas() //página principal dos componentes
	{		
		$this->privileges_needed[] = 'access_analistas';	
		$objs = ORM::factory("Analista")->find_all();
		$this->template->content->conteudo = View::factory("sistema/list_analistas");					
		$this->template->content->conteudo->objs = $objs;	

		if(!site::isGrant(array('add_analistas')))
			$this->template->content->show_add_link = false;			
	}

	public function action_edit_analistas() //edit dos analistas
	{			
		$this->privileges_needed[] = 'access_analistas';	
		$this->privileges_needed[] = 'edit_analistas';	
		$obj = ORM::factory("Analista", site::segment("edit_analistas",null) );
		
		$this->template->content->conteudo = View::factory("sistema/edit_analistas");					
		$this->template->content->conteudo->obj = $obj;				
	}
	
	public function action_save_analistas() //salvar novo e editar
	{			
		$obj = ORM::factory('Analista',$this->request->post('CodAnalista' ));		

		$obj->Analista = $this->request->post('Analista');
		$obj->Funcao = $this->request->post('Funcao');				
		$obj->Obs = $this->request->post('Obs');				
		
		if ($obj->save()) 
			HTTP::redirect("sistema/analistas?sucesso=1");
		else
			HTTP::redirect("sistema/edit_analistas?erro=1&Analista=".$this->request->post('Analista'));
		
	}

	//======================================================//
	//==================COMPONENTES=========================//
	//======================================================//	

	public function action_componentes() //página principal dos componentes
	{			
		$this->privileges_needed[] = 'access_componentes';	
		if(!$this->cached)
		{
			$objs = ORM::factory("Componente")->find_all();
			$this->template->content->conteudo = View::factory("sistema/list_componentes");					
			$this->template->content->conteudo->objs = $objs;			
			Cache::instance()->set(site::segment(2),$this->template->content->conteudo->render());
		}
		if(!site::isGrant(array('add_componentes')))
			$this->template->content->show_add_link = false;
	}

	public function action_edit_componentes() //edit dos componentes
	{			
		$this->privileges_needed[] = 'access_componentes';	
		$this->privileges_needed[] = 'edit_componentes';	
		$obj = ORM::factory("Componente", site::segment("edit_componentes",null) );

		$tecnologias = ORM::factory("Tecnologia")->find_all()->as_array('CodTecnologia', 'Tecnologia');
		$this->template->content->conteudo = View::factory("sistema/edit_componentes");					
		$this->template->content->conteudo->obj = $obj;			
		$this->template->content->conteudo->tecnologias = $tecnologias;			
	}
	
	public function action_save_componentes() //salvar novo e editar
	{			
		$obj = ORM::factory('componente',$this->request->post('CodComponente'));		

		$obj->Componente = $this->request->post('Componente');
		$obj->Tecnologia = $this->request->post('Tecnologia');				

		Cache::instance()->delete('componentes');

		if ($obj->save()) 
			HTTP::redirect("sistema/componentes?sucesso=1");
		else
			HTTP::redirect("sistema/edit_componentes?erro=1&Componente=".$this->request->post('Componente'));
		
	}
	
	//======================================================
	//======================================================


	//======================================================//
	//==================ANOMALIAS=========================//
	//======================================================//	

	public function action_anomalias() //página principal dos componentes
	{			
		$this->privileges_needed[] = 'access_anomalias';	
		if(!$this->cached)
		{
			$objs = ORM::factory("anomalia")->find_all();
			$this->template->content->conteudo = View::factory("sistema/list_anomalias");					
			$this->template->content->conteudo->objs = $objs;			
			Cache::instance()->set(site::segment(2),$this->template->content->conteudo->render());
		}
		if(!site::isGrant(array('add_anomalias')))
			$this->template->content->show_add_link = false;
	}

	public function action_edit_anomalias() //edit dos componentes
	{			
		$this->privileges_needed[] = 'access_anomalias';	
		$this->privileges_needed[] = 'edit_anomalias';	
		$obj = ORM::factory("anomalia", site::segment("edit_anomalias",null) );
		$tecnologias = ORM::factory("Tecnologia")->find_all()->as_array('CodTecnologia', 'Tecnologia');;
		$this->template->content->conteudo = View::factory("sistema/edit_anomalias");					
		$this->template->content->conteudo->obj = $obj;		
		$this->template->content->conteudo->tecnologias = $tecnologias;				
	}
	
	public function action_save_anomalias() //salvar novo e editar
	{			
		$obj = ORM::factory('anomalia',$this->request->post('CodAnomalia'));		

		$obj->Anomalia = $this->request->post('Anomalia');
		$obj->Tecnologia = $this->request->post('Tecnologia');				
		Cache::instance()->delete('anomalias');
		if ($obj->save()) 
			HTTP::redirect("sistema/anomalias?sucesso=1");
		else
			HTTP::redirect("sistema/edit_anomalias?erro=1&Anomalia=".$this->request->post('Anomalia'));
		
	}


	//======================================================
	//======================================================


	//======================================================//
	//==================RECOMENDACOES=========================//
	//======================================================//	

	public function action_recomendacoes() //página principal dos componentes
	{						
		$this->privileges_needed[] = 'access_recomendacoes';	

		if(!$this->cached)
		{
			$objs = ORM::factory("recomendacao")->find_all();
			$this->template->content->conteudo = View::factory("sistema/list_recomendacoes");					
			$this->template->content->conteudo->objs = $objs;			
			Cache::instance()->set(site::segment(2),$this->template->content->conteudo->render());
		}
		if(!site::isGrant(array('add_recomendacoes')))
			$this->template->content->show_add_link = false;
	}

	public function action_edit_recomendacoes() //edit dos componentes
	{			
		$this->privileges_needed[] = 'access_recomendacoes';	
		$this->privileges_needed[] = 'edit_recomendacoes';	

		$obj = ORM::factory("recomendacao", site::segment("edit_recomendacoes",null) );
		$tecnologias = ORM::factory("Tecnologia")->find_all()->as_array('CodTecnologia', 'Tecnologia');;
		$this->template->content->conteudo = View::factory("sistema/edit_recomendacoes");					
		$this->template->content->conteudo->obj = $obj;		
		$this->template->content->conteudo->tecnologias = $tecnologias;				
	}
	
	public function action_save_recomendacoes() //salvar novo e editar
	{			
		$obj = ORM::factory('recomendacao',$this->request->post('CodRecomendacao'));		

		$obj->Recomendacao = $this->request->post('Recomendacao');
		$obj->Tecnologia = $this->request->post('Tecnologia');				
		Cache::instance()->delete('recomendacoes');

		if ($obj->save()) 
			HTTP::redirect("sistema/recomendacoes?sucesso=1");
		else
			HTTP::redirect("sistema/edit_recomendacoes?erro=1&Recomendacao=".$this->request->post('Recomendacao'));
		
	}
	
	//======================================================
	//======================================================


	//======================================================//
	//==================INSPECOES=========================//
	//======================================================//	

	public function action_tipoinspecao() //página principal dos componentes
	{			
		$this->privileges_needed[] = 'access_tipos_inspecao';	

		$objs = ORM::factory("tipoinspecao")->find_all();
		$this->template->content->conteudo = View::factory("sistema/list_tipoinspecao");					
		$this->template->content->conteudo->objs = $objs;

		if(!site::isGrant(array('add_tipo_inspecao')))
			$this->template->content->show_add_link = false;			
	}

	public function action_edit_tipoinspecao() //edit dos componentes
	{			
		$this->privileges_needed[] = 'access_tipos_inspecao';	
		$this->privileges_needed[] = 'edit_tipos_inspecao';	

		$obj = ORM::factory("tipoinspecao", site::segment("edit_tipoinspecao",null) );		
		$this->template->content->conteudo = View::factory("sistema/edit_tipoinspecao");					
		$this->template->content->conteudo->obj = $obj;				
	}
	
	public function action_save_tipoinspecao() //salvar novo e editar
	{			
		$obj = ORM::factory('tipoinspecao',$this->request->post('CodTipoInspecao'));		

		$obj->TipoInspecao = $this->request->post('TipoInspecao');
								
		if ($obj->save()) 
			HTTP::redirect("sistema/tipoinspecao?sucesso=1");
		else
			HTTP::redirect("sistema/edit_tipoinspecao?erro=1&TipoInspecao=".$this->request->post('TipoInspecao'));
		
	}
	
	//======================================================
	//======================================================

	//======================================================//
	//==================TIPOS DE EQUIPAMENTO=========================//
	//======================================================//	

	public function action_tipoequipamento() //página principal dos componentes
	{			
		$this->privileges_needed[] = 'access_tipos_equipamento';	

		if(!$this->cached)
		{
			$objs = ORM::factory("TipoEquipamento")->find_all();
			$this->template->content->conteudo = View::factory("sistema/list_tipoequipamento");					
			$this->template->content->conteudo->objs = $objs;			
			Cache::instance()->set(site::segment(2),$this->template->content->conteudo->render());
		}			

		if(!site::isGrant(array('add_tipos_equipamento')))
			$this->template->content->show_add_link = false;
	}

	public function action_edit_tipoequipamento() //edit dos tipoequipamento
	{			
		$this->privileges_needed[] = 'access_tipos_equipamento';	
		$this->privileges_needed[] = 'edit_tipos_equipamento';	

		$obj = ORM::factory("TipoEquipamento", site::segment("edit_tipoequipamento",null) );
		
		$this->template->content->conteudo = View::factory("sistema/edit_tipoequipamento");					
		$this->template->content->conteudo->obj = $obj;			
			
	}
	
	public function action_save_tipoequipamento() //salvar novo e editar
	{			
		$obj = ORM::factory('tipoequipamento',$this->request->post('CodTipoEquipamento' ));		
		$obj->TipoEquipamento = $this->request->post('TipoEquipamento');				
		Cache::instance()->delete('tipoequipamento');

		if ($obj->save()) 
			HTTP::redirect("sistema/tipoequipamento?sucesso=1");
		else
			HTTP::redirect("sistema/edit_tipoequipamento?erro=1&TipoEquipamento=".$this->request->post('TipoEquipamento'));
		
	}
	
	//======================================================
	//======================================================

	//======================================================//
	//==================TECNOLOGIAS=========================//
	//======================================================//	

	public function action_tecnologias() //página principal dos componentes
	{					
		$this->privileges_needed[] = 'access_tecnologias';	
		if(!$this->cached)
		{
			$objs = ORM::factory("tecnologia")->find_all();	
			$this->template->content->conteudo = View::factory("sistema/list_tecnologias");					
			$this->template->content->conteudo->objs = $objs;			
			Cache::instance()->set(site::segment(2),$this->template->content->conteudo->render());
		}		
		if(!site::isGrant(array('add_tecnologias')))
			$this->template->content->show_add_link = false;	
	}

	public function action_edit_tecnologias() //edit dos componentes
	{			
		$this->privileges_needed[] = 'access_tecnologias';	
		$this->privileges_needed[] = 'edit_tecnologias';	

		$obj = ORM::factory("tecnologia", site::segment("edit_tecnologias",null) );

		$this->template->content->conteudo = View::factory("sistema/edit_tecnologias");					
		$this->template->content->conteudo->obj = $obj;			
	}
	
	public function action_save_tecnologias() //salvar novo e editar
	{	
		$obj = ORM::factory('tecnologia',$this->request->post('CodTecnologia'));		

		$obj->Id = $this->request->post('Id');
		$obj->Tecnologia = $this->request->post('Tecnologia');				
		Cache::instance()->delete('tecnologias');
		if ($obj->save()) 
			HTTP::redirect("sistema/tecnologias?sucesso=1");
		else
			HTTP::redirect("sistema/edit_tecnologias?erro=1&Tecnologia=".$this->request->post('Tecnologia'));
		
	}
	
	//======================================================
	//======================================================

	public function equipinsp_set_empresa()
	{
		$this->template = "";
		$empresas = ORM::factory("Empresa")->find_all();

		foreach ($empresas as $empresa) {
			foreach ($empresa->area as $area) {
				foreach ($area->setor as $setor) {
					foreach ($setor->equipamento as $equipamento) {
						foreach ($equipamento->equipamentoinspecionado as $equipinsp) {
							$obj = ORM::factory("EquipamentoInspecionado",$equipinsp->CodEquipamentoInspecionado);
							$obj->Empresa = $empresa->CodEmpresa;
							$obj->save();
						}						
					}
				}				
			}
		}
		echo "fim";
		exit;
	}

	public function action___call($method, $arguments)
	{
		// Disable auto-rendering
		$this->auto_render = TRUE;

		// By defining a __call method, all pages routed to this controller
		// that result in 404 errors will be handled by this method, instead of
		// being displayed as "Page Not Found" errors.
		echo 'This text is generated by __call. If you expected the index page, you need to use: welcome/index/'.substr(Router::$current_uri, 8);
	}

} // End Welcome Controller
