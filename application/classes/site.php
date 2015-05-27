<?php defined('SYSPATH') or die('No direct script access.');
 
class site {
 
	public static function segment($index,$default=null) //URI FUNCTION
	{
		//remove os itens vazios do array e depois adiciona o [0] como nulo;
		$arguments = array_filter(explode("/",Kohana_Request::detect_uri()));
		$arguments[0] = null;
		
		if (is_string($index))
		{
			if (($key = array_search($index, $arguments)) === FALSE)
				return $default;
			$index = $key + 1;
		}
			
		$index = (int) $index; 
		return isset($arguments[$index]) ? $arguments[$index] : $default;
		
	}

	public static function segment_array($offset = 0, $associative = FALSE)
	{
		$arguments = explode("/",Kohana_Request::detect_uri());
		return site::build_array($arguments, $offset, $associative);
	}

	public static function build_array($array, $offset = 0, $associative = FALSE)
	{
		// Prevent the keys from being improperly indexed
		array_unshift($array, 0);

		// Slice the array, preserving the keys
		$array = array_slice($array, $offset + 1, count($array) - 1, TRUE);

		if ($associative === FALSE)
			return $array;

		$associative = array();
		$pairs       = array_chunk($array, 2);

		foreach ($pairs as $pair)
		{
			// Add the key/value pair to the associative array
			$associative[$pair[0]] = isset($pair[1]) ? $pair[1] : '';
		}

		return $associative;
	}

	public static function segment_has($index,$search)
	{	
		return ( strpos(site::segment($index), $search ) !== false);			
	}

	public static function segment_get($segment,$index)
	{	
		$s = explode('_',site::segment($segment));
		return $s[$index];			
	}

	public static function baseUrl($index=true) //return the base system URL
	{
		return URL::site("",null,$index);
	}

	public static function mediaUrl() //return the base system URL
	{
		return URL::base()."application/media/";
	}

	public static function logado()
	{
		return (Auth::instance()->logged_in());
	}		
	
	public static function getInfoUsuario($t=null)
	{		
		/*if($t!=null)
			return (Session::instance()->get("tipo_usuario") == $t);
		return Session::instance()->get("tipo_usuario","naologado"); */
		return Session::instance()->get($t,false);
	}	
	
	public static function checkPermissaoPagina($privileges_needed) //===========FAZER
	{
		if(site::getInfoUsuario('usuario_system') == 1)
			return true; //se for de sistema pode ver tudo;

		$qtd = count($privileges_needed);		
		$user = Auth::instance()->get_user();
		$privileges = $user->get_privileges();
		return ( count(array_intersect($privileges_needed,$privileges)) == $qtd );
	}

	public static function active($a,$i,$t) //active do menu
	{				
		$return = "";
		$v = site::segment_array();			
		//print_r($v);
		if( (count($v) > 0) )
			if( isset($v[$i]) && (strpos($v[$i],$a) !== false ) )
				$return = ( ($t)?("class='active'"):("active") );
		return $return;
	}

	public static function getTituloMae($i)
	{
		$tit = "";
		switch (site::segment($i)) {
			
			case 'sistema':	$tit = "Sistema"; break;
			case 'empresas':	$tit = "Empresa"; break;
			default: break;

		}
		return $tit;
	}

	public static function getTituloInterna($i)
	{
		$tit = "";
		switch (site::segment($i)) {			

			case 'componentes':	
			case 'edit_componentes':	$tit = "Componentes"; break;
			case 'anomalias':	
			case 'edit_anomalias':	$tit = "Anomalias"; break;
			case 'tecnologias':	
			case 'edit_tecnologias':	$tit = "Tecnologias"; break;
			case 'empresas':	
			case 'edit_empresas':	$tit = "Lista de Empresas"; break;
			case 'recomendacoes':	
			case 'edit_recomendacoes':	$tit = "Recomendações"; break;
			case 'condicoes':	
			case 'edit_condicoes':	$tit = "Condições"; break;
			case 'tipoinspecao':	
			case 'edit_tipoinspecao':	$tit = "Tipos de inspeção"; break;
			case 'tipoequipamento':	
			case 'edit_tipoequipamento':	$tit = "Tipos de equipamento"; break;
			case 'rotas':	
			case 'edit_rotas':	$tit = "Rotas"; break;			
			case 'areas_setores':	$tit = "Áreas e Setores"; break;
			case 'equipamentos':		
			case 'edit_equipamentos':$tit = "Equipamentos"; break;
			case 'usuarios':		
			case 'edit_usuarios':$tit = "Usuários"; break;
			case 'usuarios_sistema':		
			case 'edit_usuarios_sistema':$tit = "Usuários de Sistema"; break;
			case 'pedidos_usuario':		
			case 'edit_pedidos_usuario':$tit = "Pedidos de Usuário"; break;
			case 'analiseinspecao':		
			case 'edit_analiseinspecao':
			case 'edit_analiseinspecao_novo':$tit = "Análise de Inspeção"; break;
			case 'analistas':		
			case 'edit_analistas':$tit = "Analistas"; break;
			case 'grauderisco':		
			case 'edit_grauderisco':$tit = "Relação de Grau de Risco"; break;
			case 'historico':
			case 'edit_historico':$tit = "Histórico de Ordens de serviço"; break;
			case 'roles':
			case 'edit_roles':$tit = "Grupos de acesso de Usuário"; break;
			case 'privileges':
			case 'edit_privileges':$tit = "Privilégios do grupo de acesso"; break;
			default: break;
		}

		return $tit;
	}
	
	public static function getTituloCampos($i)	
	{
		$tit = "";
		switch ($i) {
			case 'unidade': $tit = "Unidade de negócio"; break;
			case 'nome': $tit = "Nome"; break;
			case 'fabrica': $tit = "Site"; break;			
			case 'anomalia': $tit = "Anomalia"; break;			
			case 'inspecao': $tit = "Tipo de Inspeção"; break;			
			case 'acoes': $tit = "Ações"; break;			
			case 'ativada': $tit = "Ativada"; break;			
			case 'codigo': $tit = "Código"; break;			
			case 'tecnologia': $tit = "Tecnologia"; break;			
			case 'id': $tit = "Id"; break;			
			case 'tag': $tit = "Tag"; break;			
			case 'setor': $tit = "Setor"; break;			
			case 'area': $tit = "Área"; break;			
			case 'equipamento': $tit = "Equipamento"; break;			
			case 'tipo_equipamento': $tit = "Tipo"; break;			
			case 'estado': $tit = "Estado"; break;			
			case 'telefone': $tit = "Telefone"; break;			
			case 'email': $tit = "Email"; break;			
			case 'tipo_usuario': $tit = "Tipo do usuário"; break;			
			case 'numero': $tit = "Número"; break;			
			case 'componente': $tit = "Componente"; break;			
			case 'funcao': $tit = "Função"; break;			
			case 'data': $tit = "Data"; break;			
			case 'condicao': $tit = "Condição"; break;			
			case 'cor': $tit = "Cor"; break;			
			case 'numerogr': $tit = "GR no Cliente"; break;			
			case 'desc': $tit = "Descrição"; break;			
			case 'apelido': $tit = "Apelido"; break;			
			default: $tit = "";	break;
		}

		return $tit;
	}

	public static function check_empresaatual()
	{
		if(!isset($_SESSION["empresa_atual"])) //se a empresa atual nao foi seleciona, inicializa			
			Session::instance()->set('empresa_atual',0);	
	}

	public static function set_empresaatual($v,$nome)
	{
		Session::instance()->set('empresa_atual', $v);// atribui a empresa selecionada		
		Session::instance()->set('nome_empresa_atual', $nome);// atribui a empresa selecionada		
	}

	public static function get_empresaatual($i=1)
	{
		if($i==0)
			return ORM::factory('Empresa', Session::instance()->get('empresa_atual',null) );
		elseif($i==1)
			return Session::instance()->get('empresa_atual',null);// pega a empresa selecionada	
		else	
			return Session::instance()->get('nome_empresa_atual',null);// pega a empresa selecionada	
	}

	public static function selected_empresaatual()//retorna se alguma empresa foi selecionada
	{
		return ( Session::instance()->get('empresa_atual') != 0);
	}

	public static function avatar_empresaatual() //pega o nome e o codigo da empresa pra deixar lá em cima
	{
		$str = "";
		if(site::selected_empresaatual())
		{
			$empresa = 
			$str = '<h2 class="pull-right">'.site::get_empresaatual(2).' <span class="label label-primary">'.site::get_empresaatual().'</span></h2>';
		}
		return $str;

	}

	public static function qtd_pedidosusuario() //quantidade de usuarios que fizeram pedidos
	{
		//ARRUMAR ?
		//if ( !isset($_SESSION['qtd_usuarios']) )
		//{
			$qtd = ORM::factory("User")->where("ativo","=",0);
			Session::instance()->set('qtd_usuarios', $qtd->count_all() );
		//}	

		return Session::instance()->get('qtd_usuarios');
	}

	public static function data_BR($d,$return="00/00/0000")
	{		
		if($d=="") return $return;

		$d = explode("-",$d);
		return $d[2]."/".$d[1]."/".$d[0];
	}

	public static function data_EN($d="00/00/0000",$return="0000-00-00")
	{
		if($d=="") return $return;
		$d = explode("/",$d);
		return $d[2]."-".$d[1]."-".$d[0];
	}

	public static function datahora_BR($d)
	{
		if($d == null) return null;
		$d = explode(" ", $d);
		return site::data_BR($d[0]);
	}

	public static function datahora_EN($d)
	{
		if($d == null) return null;
		$d = explode(" ", $d);
		return $d[0];
	}	

	public static function inspecaoGraudeRisco($c,$a,$gerar=false) //verifica se a condicao está dentro de algum grau de risco
	{
		$tipos = Kohana::$config->load('config')->get('tipos_condicao'); //nomes das GRS			
		
		if(!$gerar)
		{
			if($c<=0) return false;	
				return	in_array($a[$c],$tipos);
		}
		else
			return implode(",",$tipos);
		
	}


	function formata_moeda_input($v,$p=null,$s=".") {

		if(($v==null) || ($v==0)) return 0;
		$v = explode(".", (string)$v);
		if(!isset($v[1]))
			return $p.$v[0].$s."00";
		else
		{
			if(strlen($v[1]) == 1)
				$v[1].="0";
			
			return $p.$v[0].$s.$v[1];
		}
	}
	public function formata_moeda( $v) {
		$money = (string)$v;
		$cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
	    $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

	    $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

	    $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
	    $removedThousendSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);

	    return (float) str_replace(',', '.', $removedThousendSeparator);
	}
	
	public function random_password( $length = 8 ) {
	    $chars = "aNAZrsklIuefgv8hiDESQVwx3FGOTPBCR45UHqcdo6WXyzmnj012Y7btpJKLM9";
	    $password = substr( str_shuffle( $chars ), 0, $length );
	    return $password;
	}

	public function generateValidator($fields,$form_name = 'form_edit') //gera o script de validação dos campos
	{		
		$return = '<script>';

		$return .= "var validator = new FormValidator('".$form_name."', [{";
		$msg = 'O campo "%s" é obrigatório.';

		foreach ($fields as $key => $value) {
			$return .=  "name: '".$key."',";
			if(is_array($value))
			{
				$return .= "display: '".$value[0]."',";
				$return .= "rules: '".$value[1]."'";
			}
			else
			{
				$return .= "display: '".$value."',";
				$return .= "rules: 'required'";
			}				
			
				$return .= '},{';
		}	
			   
		$return .= "}], function(errors, event) {
			    var SELECTOR_ERRORS = $('#box_error'); 
			    if (errors.length > 0) {
			        SELECTOR_ERRORS.empty();
			           for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
			            SELECTOR_ERRORS.append(errors[i].message + '<br />');
			        }        
			        SELECTOR_ERRORS.fadeIn(200);
			        SELECTOR_ERRORS.delay(7000).fadeOut('slow');			        
			        return false;
			    }
			    return true;			      
			    event.preventDefault()
			});		
			validator.setMessage('required','".$msg."');		
			</script>
		";
		return $return;
	}

	public function generateDelete($class)
	{
		$return = '<script type="text/javascript">';

		$return .= "
			function deleteRow(id)
			{
				$.ajax({
					url : '".site::baseUrl()."welcome/delete',
					type: 'POST',  
		  			data: { id: id,class:'".$class."',cache:'".site::segment(2)."'},
					success : function(data) {
						if(data == 1)	
						{						    
						    var footable = $('table').data('footable');			    
						    var row = $('#confirm_'+id).parents('tr:first');
						    footable.removeRow(row);
						}
					}
				});
			}";

		$return .= '</script>';
		return $return;
	}

}
?>