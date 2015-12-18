    <?php 
	
	echo Form::open( Site::segment(1)."/save_rotas",array("id" => "form_edit") );			
	
	//if($erro!="") echo "<span id='erro-home'>".$erro."</span>";	
    echo Form::hidden("CodRota",$obj->CodRota); 
	echo Form::hidden("Empresa",$empresa->CodEmpresa);	
	echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>></span>". Form::input('Rota',$obj->Rota, array('class' => 'form-control', 'maxlength' => '100', 'placeholder' => 'Nome da rota' )) ."</div>";	
	
        echo "<br/>";
        echo '<div class="panel-primary">';
        echo '<div class="panel-heading"><h4>Equipamentos desta rota</h4></div>';
        echo '<div class="panel-body">';
            echo '<div class="list-group">';
                if(count($empresa->areas)>0)
                {
                    foreach($empresa->areas->find_all() as $a) //para cada área da empresa
                    {
                        echo '<a href="javascript:abrirfechar(\'area\',\''.$a->CodArea.'\')" class="list-group-item">';                       
                            echo '<label class="checkbox check_all">';
                                echo Form::checkbox('checkall_area_'.$a->CodArea);
                                echo '<span class="checkbox-label"></span>';
                            echo '</label>';
                        echo '<span class="label_chkall">'.$a->Area.'</span>';
                        echo '</a>';

                        echo '<div class="list-group item_area" id="area_'.$a->CodArea.'">';
                            if(count($a->setores)>0)
                            {
                                foreach ($a->setores->find_all() as $s)  //para setor da area
                                {
                                    echo '<a href="javascript:abrirfechar(\'setor\',\''.$s->CodSetor.'\')" class="list-group-item">';
                                        echo '<label class="checkbox check_all">';
                                            echo Form::checkbox('checkall_setor_'.$s->CodSetor);
                                            echo '<span class="checkbox-label"></span>';
                                        echo '</label>';                                        
                                        echo '<span class="label_chkall">'.$s->Setor.'</span>';
                                    echo '</a>';
                                        echo '<div class="panel item_setor" id="setor_'.$s->CodSetor.'">';
                                            if(count($s->equipamentos)>0)
                                            {
                                                echo '<ul class="list-group list_equip">';
                                                foreach ($s->equipamentos->find_all() as $e) //para cada equipamento do setor   
                                                {
                                                    $id = $e->CodEquipamento;
                                                    echo ' <li class="list-group-item chk_equip">';
                                                    echo '<label class="checkbox">';
                                                    echo Form::checkbox('equipamento[]', $id, array_key_exists($id,$equipamentos_selecionados));
                                                    echo '<span class="checkbox-label">'.$e->tipoequipamento->TipoEquipamento." / ".$e->Equipamento.'</span>';
                                                    echo '</label>';
                                                  
                                                    echo '</li>';
                                                    
                                                }
                                                 echo '</ul>';  
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
   
    echo Form::submit('submit', "Salvar",array('class' => 'btn btn-primary btn'));       
	echo Form::close();

    echo Site::generateValidator(array('Rota'=>'Rota'));
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

    $(".check_all > input[type='checkbox']").click(function(){
        var checked = $(this).is(":checked");
        if(checked)
            checked = 'checked';
        else
            checked = false;
        var name = $(this).attr('name');
        name = name.split('_');                
        $('#'+name[1]+'_'+name[2]).find("input[type='checkbox']").prop("checked",checked);
        
    })

});

</script>