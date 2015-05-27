<h3>Cadastro <small>de rotas</small></h3>

<?php 
	
	echo form::open( site::segment(1)."/save_rotas",array("id" => "form_edit") );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
    echo form::hidden("CodRota",$obj->CodRota); 
	echo form::hidden("Empresa",$empresa->CodEmpresa);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". form::input('Rota',$obj->Rota, array('class' => 'form-control', 'maxlength' => '100', 'placeholder' => 'Nome da rota' )) ."</div>";	
	
        echo "<br/>";
        echo '<div class="panel panel-primary">';
        echo '<div class="panel-heading"><h4>Equipamentos desta rota</h4></div>';
        echo '<div class="panel-body">';
            echo '<div class="list-group">';
                if(count($empresa->areas)>0)
                {
                    foreach($empresa->areas->find_all() as $a) //para cada área da empresa
                    {
                        echo '<a href="javascript:abrirfechar(\'area\',\''.$a->CodArea.'\')" class="list-group-item">'.$a->Area.'</a>';

                        echo '<div class="list-group item_area" id="area_'.$a->CodArea.'">';
                            if(count($a->setores)>0)
                            {
                                foreach ($a->setores->find_all() as $s)  //para setor da area
                                {
                                    echo '<a href="javascript:abrirfechar(\'setor\',\''.$s->CodSetor.'\')" class="list-group-item">'.$s->Setor.'</a>';
                                        echo '<div class="panel item_setor" id="setor_'.$s->CodSetor.'">';
                                            if(count($s->equipamentos)>0)
                                            {
                                                foreach ($s->equipamentos->find_all() as $e) //para cada equipamento do setor   
                                                {
                                                    $id = $e->CodEquipamento;
                                                    echo '<label class="control checkbox chk_equip">';
                                                    echo form::checkbox('equipamento[]', $id, array_key_exists($id,$equipamentos_selecionados));
                                                    echo '<span class="checkbox-label">'.$e->Equipamento.'</span>';
                                                    echo "</label>";
                                                }
                                            }
                                            else
                                                echo "<h4>".Kohana::message('admin', 'nenhum_equipamento_setor')."</h4>";  
                                        echo '</div>';                            
                                }
                            }
                            else
                                echo "<h4>".Kohana::message('admin', 'nenhum_equipamento_setor')."</h4>";  
                        echo '</div>';                   
                    }
                }
                else
                    echo "<h4>".Kohana::message('admin', 'insira_setor_area')."</h4>";
            echo "</div>";
        echo '</div></div>';
   
    echo form::submit('submit', "Salvar",array('class' => 'btn btn-primary btn-lg'));       
	echo form::close();

    echo site::generateValidator(array('Rota'=>'Rota'));
?>


<script>

function abrirfechar(tipo,id,obj)
{   
    var alvo = tipo+"_"+id;    
    $(".item_"+tipo).slideUp("fast");
    $("#"+alvo).slideToggle("fast");
}

$(document).ready(function(){

    $(".list-group-item").click(function(){        
        $(".list-group-item").removeClass("active");
        $(this).addClass("active");       
    });

});

</script>