<h1 class="pull-left">
	<?php echo site::getTituloMae(1); ?> <span class="label label-default"><?php echo site::getTituloInterna(2); ?></span>	
</h1>

<section id='list' class='Content'>			
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

		echo '<div class="alert alert-danger" id="box_error">';
		echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
		echo '</div>';

	if( !site::segment_has(2,'edit') && $show_add_link) { 
	?>
		<h1 id="btn_adicionar" class="inline">		
			<?php echo html::anchor(site::segment(1)."/edit_".site::segment(2)."".$plus_add_link,"Adicionar +", array("class" => "label label-success" )); ?>
		</h1>
	<?php
	}
	
	if(site::segment_has(2,'edit') && $show_back_link)
		echo '<h1>'.html::anchor(site::segment(1)."/".site::segment_get(2,1)."".$plus_back_link,"Voltar", array("class" => "label label-warning" )).'</h1>';
	
	 echo $conteudo; //conteudo da página interna ?> 
</section>

<script type="text/javascript">

$( document ).ready(function() {
	$('.alert-dismissable').delay(4000).fadeOut('slow');  //tira quaisquer alertas depois de 4 segundos
});

</script>
