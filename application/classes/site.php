<?php defined('SYSPATH') or die('No direct script access.');
 
class Site {
 
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
		return Site::build_array($arguments, $offset, $associative);
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
		return ( strpos(Site::segment($index,''), $search ) !== false);			
	}

	public static function segment_get($segment,$index)
	{	
		$s = explode('_',Site::segment($segment));
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

	public static function active($a,$i,$t,$class='drop') //active do menu
	{				
		$return = "";
		$v = Site::segment_array();			
		//print_r($v);
		if( (count($v) > 0) )
			if( isset($v[$i]) && ( $v[$i] == $a) )
				$return = ( ($t)?("class='active $class'"):("active $class") );
		return $return;
	}

	public static function getTituloTipo($i)
	{
		return ( ( Site::segment_has(2,'edit') )?'Cadastro':'Listagem' );	
	}

	public static function getTituloInterna($i)
	{
		$tit = "";
		switch (Site::segment($i)) {			

			case 'componentes':	
			case 'edit_componentes':	$tit = "Componentes"; break;
			case 'anomalias':	
			case 'edit_anomalias':	$tit = "Anomalias"; break;
			case 'tecnologias':	
			case 'edit_tecnologias':	$tit = "Tecnologias"; break;
			case 'instrumentacao':	
			case 'edit_instrumentacao':	$tit = "Instrumentação"; break;
			case 'normas':	
			case 'edit_normas':	$tit = "Normas"; break;
			case 'empresas':	
			case 'edit_empresas':	$tit = "Empresas"; break;
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
			case 'edit_grauderisco':$tit = "Graus de Risco"; break;
			case 'historico':
			case 'edit_historico':$tit = "Histórico de Ordens de serviço"; break;
			case 'resultado_historico':$tit = "Resultados da ordem de serviço"; break;
			case 'roles':
			case 'edit_roles':$tit = "Grupos de acesso de Usuário"; break;
			case 'privileges':
			case 'edit_privileges':$tit = "Privilégios do grupo de acesso"; break;
			case 'relatorios':$tit = "Relatórios"; break;
			case 'uploads':$tit = "Upload de Relatórios"; break;
			case 'edit_uploads':$tit = "Upload de arquivo"; break;
			case 'downloads':$tit = "Downloads de Relatórios"; break;
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
			case 'analista': $tit = "Analista"; break;
			case 'fabrica': $tit = "Site"; break;			
			case 'anomalia': $tit = "Anomalia"; break;			
			case 'inspecao': $tit = "Tipo de Inspeção"; break;			
			case 'acoes': $tit = "Ações"; break;			
			case 'ativada': $tit = "Ativada"; break;			
			case 'codigo': $tit = "Cod"; break;			
			case 'tecnologia': $tit = "Tecnologia"; break;			
			case 'id': $tit = "Id"; break;			
			case 'tag': $tit = "Tag"; break;			
			case 'rota': $tit = "Rota"; break;			
			case 'setor': $tit = "Setor"; break;			
			case 'area': $tit = "Área"; break;			
			case 'equipamento': $tit = "Equipamento"; break;			
			case 'tipo_equipamento': $tit = "Tipo"; break;			
			case 'estado': $tit = "Estado"; break;			
			case 'telefone': $tit = "Telefone"; break;			
			case 'email': $tit = "Email"; break;			
			case 'tipo_usuario': $tit = "Grupo de Acesso"; break;			
			case 'numero': $tit = "Número"; break;			
			case 'componente': $tit = "Componente"; break;			
			case 'funcao': $tit = "Função"; break;			
			case 'data': $tit = "Data"; break;			
			case 'condicao': $tit = "Condição"; break;			
			case 'cor': $tit = "Cor"; break;			
			case 'numerogr': $tit = "GR no Cliente"; break;			
			case 'desc': $tit = "Descrição"; break;			
			case 'apelido': $tit = "Apelido"; break;			
			case 'sequencial': $tit = "Sequencial"; break;			
			case 'obs': $tit = "Observação"; break;			
			default: $tit = "";	break;
		}

		return $tit;
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

	public static function data_BR($d,$return=false,$notime=true)
	{		
		if($d=="") return ( (!$return)?(date('d/m/Y')):($return) );

		if($notime)
		{
			$d = explode(" ",$d);
			$d = $d[0];
		}

		$d = explode("-",$d);
		return $d[2]."/".$d[1]."/".$d[0];
	}

	public static function data_EN_relatorio($d)
	{		
		$d = explode(" ",$d);
		$d = explode("-",$d[0]);
		return $d[0].".".$d[1];
	}

	public static function data_EN($d=false,$return=false)
	{
		if($d=="") 
			return (!$return)?(date('0000/00/00')):($return);

		$d = explode("/",$d);
		return $d[2]."-".$d[1]."-".$d[0];
	}

	public static function datahora_BR($d)
	{
		if($d == null) return null;
		$d = explode(" ", $d);
		return Site::data_BR($d[0]);
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


	public static function formata_numerodecimal($n,$q = 2) {
		return number_format((float)$n, $q, '.', '');
	}

	public static function formata_codRelatorio($cod) {

		return str_pad($cod, 4, '0', STR_PAD_LEFT);

	}


	public static function formata_moeda_input($v,$p=null,$s=".") {

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
	public static function formata_moeda( $v) {
		$money = (string)$v;
		$cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
	    $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

	    $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

	    $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
	    $removedThousendSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);

	    return (float) str_replace(',', '.', $removedThousendSeparator);
	}
	
	public static function random_password( $length = 8 ) {
	    $chars = "aNAZrsklIuefgv8hiDESQVwx3FGOTPBCR45UHqcdo6WXyzmnj012Y7btpJKLM9";
	    $password = substr( str_shuffle( $chars ), 0, $length );
	    return $password;
	}

	public static function generateValidator($fields,$form_name = 'form_edit',$error_box='box_error') //gera o script de validação dos campos
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
			    var SELECTOR_ERRORS = $('#".$error_box."'); 
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

	public static function generateDelete($class,$uri='welcome/delete')
	{
		$return = '<script type="text/javascript">';

		$return .= "
			function deleteRow(id)
			{
				$.ajax({
					url : '".Site::baseUrl()."".$uri."',
					type: 'POST',  
		  			data: { id: id,class:'".$class."',cache:'".Site::segment(2)."'},
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

	public static function toAscii($str, $replace=array(), $delimiter='_') {
	if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}

	//ORM add() extension
	public static function addORMRelation($obj,$itens,$post,$relation)
	{
		$array_db = array();

		foreach ($itens->find_all() as $o)
			$array_db[] = $o->pk();	
					
		$ids_remove = array_diff( $array_db, $post );
		$ids_add = array_diff( $post , $array_db );
	
		if(count($ids_remove) > 0)
			$obj->remove($relation,$ids_remove);
		if(count($ids_add) > 0)
			$obj->add($relation,$ids_add);
		
	}

	public static function handleErrors($errors) //junta os erros em uma query string
	{
		$return = array();
		foreach ($errors as $key => $value) {			
			$e = explode('/',$value);
			$return[] = ( isset($e[1]) )?($e[1]):('default');
		}
		return implode(',', $return);
	}

	public static function requireKey($needle, array $array)
    {
        foreach ($array as $key => $value) {
            if ($key === $needle) return $value;
            if (is_array($value)) {
                if ($x = Site::requireKey($key, $value)) return $x;
            }
        }
        return false;
    }

}
?>