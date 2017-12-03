<?php echo $graficos; ?>
<h1 class="pull-left">
	Empresas <span class="label label-default"><?php echo site::getTituloInterna(2); ?></span>	
</h1>

<section id='ContentClientes' class='Content'>			
	<?php 

		if(isset($_GET['sucesso']))
		{
			echo '<div class="alert alert-success alert-dismissable">';
 			echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			echo Kohana::message('admin', 'item_salvo').'</div>';
		}

		if(isset($_GET['erro']))
		{
			echo '<div class="alert alert-danger alert-dismissable">';
 			echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			echo Kohana::message('admin', 'ocorreu_erro').'</div>';
		}

		echo '<div class="alert alert-danger" id="box_error"></div>';
		echo $conteudo; //conteudo da página interna  
	?> 
</section>

<script type="text/javascript">

var $rows = $('#historico_list li');

$( document ).ready(function() {
	$('.alert-dismissable').delay(4000).fadeOut('slow');  //tira quaisquer alertas depois de 4 segundos
});

$('#campobusca').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});


</script>
