<?php 

    if(Usuario::selected_empresaatual())
    {

?>
    <table class="footable table" data-page-navigation=".pagination"  data-filter=#campobusca>

        <thead>
            <tr>
                <th id='col_id' data-type='numeric' data-sort-initial='true'><h3><?php echo Site::getTituloCampos("codigo"); ?></h3></th>
                <th><h3><?php echo Site::getTituloCampos("sequencial"); ?></h3></th>                                     
                <th><h3><?php echo Site::getTituloCampos("tecnologia"); ?></h3></th>                                     
                <th><h3><?php echo Site::getTituloCampos("data"); ?></h3></th>                                     
                <th data-sort-ignore="true" id='col_actions'><h3><?php echo Site::getTituloCampos("acoes"); ?></h3></th>        
            </tr>
        </thead>
        <tbody>
        <?php 
            foreach ($arquivos as $o) {             
                echo "<tr>";
                    echo "<td>".$o->CodArquivoRelatorio."</td>";
                    echo "<td>".$o->Sequencial."</td>";  
                    echo "<td>".$o->tecnologia->Tecnologia."</td>";  
                    echo "<td>".Site::data_BR($o->Data)."</td>";                                      
                    echo "<td><div class='btn-group btn-group-lg'>";
                       
                        echo HTML::anchor("relatorios/edit_uploads/".$o->CodArquivoRelatorio,"EDITAR", array("class"=>"btn btn-info"));                  

                        
                        echo "<button type='button' class='btn btn-danger' id='ask_".$o->CodArquivoRelatorio."' onclick='askDelete(\"$o->CodArquivoRelatorio\")'>REMOVER</button>";
                        echo "<button type='button' class='btn btn-success confirm_hidden' id='confirm_".$o->CodArquivoRelatorio."' onclick='deleteRow(\"$o->CodArquivoRelatorio\")'>S</button>";                       
                        echo "<button type='button' class='btn btn-danger confirm_hidden' id='cancel_".$o->CodArquivoRelatorio."' onclick='askDelete(\"$o->CodArquivoRelatorio\")'>N</button>";                     
                        
                    echo "</div></td>";
                echo "</tr>";
            }   
        ?>  
        </tbody>
        <tfoot class="hide-if-no-paging">
            <tr>
                <td colspan="100">
                    <ul class="pagination pagination-centered"></ul>
                </td>
            </tr>
        </tfoot>

    </table>
	    
<?php
     
    } else echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'ative_empresa')."</div>"; 
?>

<script type="text/javascript">
    $(function () {
        $('.footable').footable();
    });

</script>

<?php echo Site::generateDelete('ArquivoRelatorio','relatorios/delete_uploads'); ?>