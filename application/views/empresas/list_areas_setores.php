<?php

 if(Site::selected_empresaatual()) {

?>

<div class="panel panel-primary" id='list_areas'>
  <div class="panel-heading"><h3>Áreas</h3></div>
  <div class="panel-body">
   <?php 
        if(Site::isGrant(array('add_areas') ) )  
        {
            echo Form::open("empresas/save_areas",array('id' => "form_save_area"));
                echo Form::hidden("Empresa",$empresa);  
                echo Form::hidden("id",null);              
                echo '<div class="row">';
                    echo '<div class="col-lg-6">';
                        echo '<div class="input-group">';
                            echo Form::input("Area",null,array('class' => 'form-control input-lg', 'placeholder' => 'Nome' ));
                            echo '<span class="input-group-btn">';   
                                                
                                echo Form::submit('submit', "+",array('class' => 'btn btn-success input-lg') );                     
                            echo '</span>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';          
            echo Form::close();
        }
   ?>
   <?php
        if(Site::isGrant(array('edit_areas') ) )  
        {
            echo Form::open("empresas/save_areas",array('id' => "form_altera_area"));    
                echo Form::hidden("Empresa",$empresa);       
                echo Form::hidden("id",null);          
                echo '<div class="row">';
                    echo '<div class="col-lg-6">';
                        echo '<div class="input-group btn-group row_edit_areassetores">';
                            echo Form::input("Area",null, array('class' => 'form-control input-lg', 'placeholder' => 'Nome'));
                            echo '<span class="input-group-btn">';
                            echo Form::submit('submit', "Alterar", array('class' => 'btn btn-info input-lg btn_alterar_areassetores' ));
                            if(Site::isGrant(array('remove_areas'))){
                                echo "<button type='button' class='btn btn-danger input-lg ask_btn_area' id='ask_area' onclick='askDelete()'>REMOVER</button>";                                        
                                echo "<button type='button' class='btn btn-success input-lg confirm_hidden confirm_area' id='confirm_area'>S</button>";                     
                                echo "<button type='button' class='btn btn-danger input-lg confirm_hidden cancel_area' id='cancel_area'>N</button>";                       
                            }
                            echo '</span>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';          
            echo Form::close();
        }

   ?>
   <div class="list-group" id='lista_areas'> 
    <?php   



        if(count($objs) > 0)
            foreach($objs as $c)       
                echo '<a href="javascript:void(0)" class="list-group-item" id="area_'.$c->CodArea.'" onclick="load_setores('.$c->CodArea.')" name="'.$c->Area.'" >'.$c->Area.'  <button type="button" class="delete btn btn-danger">X</button> </a>';
        else
            echo "<h4>".Kohana::message('admin', 'nenhum_item')."</h4>";

    ?>
    </div>
  </div>
</div>

<div class="panel panel-primary" id='list_setores'>
  <div class="panel-heading"><h3>Setores</h3></div>
  <div class="panel-body">
    <?php
        if(Site::isGrant(array('add_setores') ) )  
        {
            echo Form::open("empresas/save_setores",array('id' => "form_save_setor"));
                echo Form::hidden("Area",null); 
                echo Form::hidden("id",null);   
                echo '<div class="row">';
                    echo '<div class="col-lg-6">';
                        echo '<div class="input-group">';
                            echo Form::input("Setor",null, array('class' => 'form-control input-lg', 'placeholder' => 'Nome', 'disabled' => 'disabled' ));
                            echo '<span class="input-group-btn">';
                            echo Form::submit('submit', "+", array('class' => 'btn btn-success input-lg' ,'disabled' => 'disabled'));
                            echo '</span>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';          
            echo Form::close();
        }
   ?>
   <?php
        if(Site::isGrant(array('edit_setores') ) )  
        {
            echo Form::open("empresas/save_setores",array('id' => "form_altera_setor"));
                echo Form::hidden("Area",null); 
                echo Form::hidden("id",null);   
                echo '<div class="row">';
                    echo '<div class="col-lg-6">';
                        echo '<div class="input-group row_edit_areassetores">';
                            echo Form::input("Setor",null,array('class' => 'form-control input-lg', 'placeholder' => 'Nome'));
                            echo '<span class="input-group-btn">';
                            echo Form::submit('submit', "Alterar",array('class' => 'btn btn-info input-lg btn_alterar_areassetores') );
                             if(Site::isGrant(array('remove_setores'))){
                                echo "<button type='button' class='btn btn-danger input-lg ask_btn_setor' id='ask_setor' onclick='askDelete()'>REMOVER</button>";                                        
                                echo "<button type='button' class='btn btn-success input-lg confirm_hidden confirm_setor' id='confirm_setor'>S</button>";                     
                                echo "<button type='button' class='btn btn-danger input-lg confirm_hidden cancel_setor' id='cancel_setor'>N</button>";                       
                            }
                            echo '</span>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';          
            echo Form::close();
        }

   ?>
   <div class="list-group" id='lista_setores'> 
        <h4><?php echo Kohana::message('admin', 'nenhuma_area_selecionada'); ?></h4>
    </div>
  </div>
</div>

<?php
} else echo "<div class='alert alert-warning tabela_vazia'>".Kohana::message('admin', 'ative_empresa')."</div>";
?>


<script type="text/javascript">
    $( "#form_altera_area" ).submit(function( event ) {       
        
        var emp = $("#form_altera_area input[name='Empresa']").val();
        var ar = $("#form_altera_area input[name='Area']").val();
        var id = $("#form_altera_area input[name='id']").val();   
        
        if(!$.trim(ar).length)
            return false;   
        else    
        {
            $("#lista_areas").html("<span id='loading'><img src='<?php echo Site::mediaUrl() ?>images/loading.gif'></span>");

            $.ajax({
                type: "POST",
                url: "<?php echo Site::baseUrl() ?>/empresas/save_areas",
                data: {empresa: emp, area: ar, id: id }
            }).done(function( text ) {   
                $("#form_altera_area").slideUp();            
                $( "#lista_areas" ).html( text );
                $("#form_save_area input[name='Area']").val("");
                $("#form_altera_area input[name='Area']").val("");

                //reinicia o quadro de setores
                $("#form_save_setor input[name='Setor']").prop("disabled",true);
                $("#form_save_setor input[type='submit']").prop("disabled",true);
                 $( "#lista_setores" ).html( "<h4><?php echo Kohana::message('admin', 'nenhuma_area_selecionada'); ?></h4>" );

              });
        }
        
      event.preventDefault();
    });
       
    $( "#form_save_area" ).submit(function( event ) {       

        var emp = $("#form_save_area input[name='Empresa']").val();
        var ar = $("#form_save_area input[name='Area']").val();
        var id = $("#form_save_area input[name='id']").val();   

        
        if(!$.trim(ar).length)
            return false;   
        else    
        {
            $("#lista_areas").html("<span id='loading'><img src='<?php echo Site::mediaUrl() ?>images/loading.gif'></span>");

            $.ajax({
                type: "POST",
                url: "<?php echo Site::baseUrl() ?>/empresas/save_areas",
                data: {empresa: emp, area: ar, id: id }
            }).done(function( text ) {   
                 $("#form_altera_area").slideUp();            
                $( "#lista_areas" ).html( text );
                $("#form_save_area input[name='Area']").val("");
                $("#form_altera_area input[name='Area']").val("");

                //reinicia o quadro de setores
                $("#form_save_setor input[name='Setor']").prop("disabled",true);
                $("#form_save_setor input[type='submit']").prop("disabled",true);
                $( "#lista_setores" ).html( "<h4><?php echo Kohana::message('admin', 'nenhuma_area_selecionada'); ?></h4>" );

              });
        }
        
      event.preventDefault();
    });


    //===============================

    function load_setores(a)
    {
        $(".list-group-item").removeClass("selected");
        $("#area_"+a).addClass("selected");

        $("#form_altera_area").slideDown(); 
         $("#form_altera_setor").slideUp(); 
        $("#form_altera_area input[name='Area']").val( $("#area_"+a).attr("name") ); // coloca o nome da area no form para a ediçao
        $("#form_altera_area input[name='id']").val(a); // coloca o id da area no campo hidden
        $("#form_altera_setor input[name='Area']").val(a);
        $('.ask_btn_area').attr('onclick','askDelete("'+a+'")');
        $('.ask_btn_area').attr('id','ask_'+a);
        $('.confirm_area').attr('id','confirm_'+a);
        $('.confirm_area').attr('onclick','deleteRowArea("'+a+'")');
        $('.cancel_area').attr('id','cancel_'+a);
        $('.cancel_area').attr('onclick','askDelete("'+a+'")');

        $("#form_save_setor input[name='Setor']").prop("disabled",false); //habilita os botoes do form
        $("#form_save_setor input[type='submit']").prop("disabled",false);
        $("#form_save_setor input[name='Area']").val(a); // coloca o id da area no form

        $("#lista_setores").html("<span id='loading'><img src='<?php echo Site::mediaUrl() ?>images/loading.gif'></span>");
        $.ajax({
            type: "POST",
            url: "<?php echo Site::baseUrl() ?>/empresas/carrega_setores",
            data: {area: a }
        }).done(function( text ) {          
            $( "#lista_setores" ).html( text );
          });
    }

    function edita_setor(s)
    {

        $("#form_altera_setor").slideDown(); 
        $("#form_altera_setor input[name='Setor']").val($("#setor_"+s).attr("name") ); 
        $("#form_altera_setor input[name='id']").val(s); // coloca o id da area no campo hidden
        $('.ask_btn_setor').attr('onclick','askDelete("'+s+'")');
        $('.ask_btn_setor').attr('id','ask_'+s);
        $('.confirm_setor').attr('id','confirm_'+s);
        $('.confirm_setor').attr('onclick','deleteRowSetor("'+s+'")');
        $('.cancel_setor').attr('id','cancel_'+s);
        $('.cancel_setor').attr('onclick','askDelete("'+s+'")');

    }

    $( "#form_altera_setor" ).submit(function( event ) {
            var set = $("#form_altera_setor input[name='Setor']").val();
            var ar = $("#form_altera_setor input[name='Area']").val();
            var id = $("#form_altera_setor input[name='id']").val();  


            if(!$.trim(set).length)
                return false;   
            else    
            {
                $("#lista_setores").html("<span id='loading'><img src='<?php echo Site::mediaUrl() ?>images/loading.gif'></span>");

                $.ajax({
                    type: "POST",
                    url: "<?php echo Site::baseUrl() ?>/empresas/save_setores",
                    data: {setor: set, area: ar, id: id }
                }).done(function( text ) {          
                     $("#form_altera_setor").slideUp(); 
                    $( "#lista_setores" ).html( text );
                    $("#form_altera_setor input[name='Setor']").val("");
                  });
            }
          event.preventDefault();
    });

    $( "#form_save_setor" ).submit(function( event ) {

        var set = $("#form_save_setor input[name='Setor']").val();
        var ar = $("#form_save_setor input[name='Area']").val();
        var id = $("#form_save_setor input[name='id']").val();  


        if(!$.trim(set).length)
            return false;   
        else    
        {
            $("#lista_setores").html("<span id='loading'><img src='<?php echo Site::mediaUrl() ?>images/loading.gif'></span>");

            $.ajax({
                type: "POST",
                url: "<?php echo Site::baseUrl() ?>/empresas/save_setores",
                data: {setor: set, area: ar, id: id }
            }).done(function( text ) {          
                $( "#lista_setores" ).html( text );
                $("#form_save_setor input[name='Setor']").val("");
              });
        }
      event.preventDefault();
    });

    

</script>

<script type="text/javascript">
            function deleteRowArea(id)
            {
                $.ajax({
                    url : '/masterpred/index.php/welcome/delete',
                    type: 'POST',  
                    data: { id: id,class:'Area',cache:'areas_setores'},
                    success : function(data) {
                        if(data == 1)   
                        {      
                            $('#area_'+id).slideUp(); 
                            $("#form_altera_area").slideUp(); 
                            askDelete(id);
                        }
                    }
                });
            }
            function deleteRowSetor(id)
            {
                $.ajax({
                    url : '/masterpred/index.php/welcome/delete',
                    type: 'POST',  
                    data: { id: id,class:'Setor',cache:'areas_setores'},
                    success : function(data) {
                        if(data == 1)   
                        {      
                            $('#setor_'+id).slideUp(); 
                             $("#form_altera_setor").slideUp(); 
                             askDelete(id);
                        }
                    }
                });
            }</script> 