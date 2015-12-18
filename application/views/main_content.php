<h1 class="pull-left ">
	<?php echo Site::getTituloInterna(2); ?> <small><?php echo Site::getTituloTipo(1); ?></small>	
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
			
 			echo Kohana::message('admin', 'ocorreu_erro');
 			// mostra os erros de ORM_Validation_Exception
 			if(isset($_GET['error_info']))
 			{
 				echo '<br>';
 				$e = explode(',',$_GET['error_info']);
 				foreach ($e as $value) {
 					echo '<br>';
					echo Kohana::message('errors', $value); 	
					
 				}
 			}
			echo '</div>';
		}

		echo '<div class="alert alert-danger" id="box_error">';
		echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
		echo '</div>';

	if( !Site::segment_has(2,'edit') ) { 

		if($show_add_link)
		{
		?>
			<h1 id="btn_adicionar" class="inline">		
				<?php echo Html::anchor(Site::segment(1)."/edit_".Site::segment(2)."".$plus_add_link,"+", array('class' => 'label-success btn' )); ?>
			</h1>
		<?php
		}
		//campo de busca
		if($show_search)
		{
			echo "<div id='search_box' class='inline'>";
			echo "<div class='input-group input-group-lg'> <span class='input-group-addon'>Busca:</span>". Form::input('nome', null , array('class' => 'form-control', 'maxlength' => '30', 'id' => 'campobusca')) ."</div>";		
			echo '</div>';
		}
	}
	
	if(Site::segment_has(2,'edit') && $show_back_link)
		echo Html::anchor(Site::segment(1)."/".Site::segment_get(2,1)."".$plus_back_link,"Voltar", array('class' => 'label-warning btn' ,'id'=>'btn_voltar'));
	
	 echo $conteudo; //conteudo da página interna ?> 
</section>

<script type="text/javascript">

$( document ).ready(function() {
	$('.alert-dismissable').delay(15000).fadeOut('slow');  //tira quaisquer alertas depois de 4 segundos

	$('button.close').click(function(){
		$(this).parent().fadeOut('slow');
	});

	$('#campobusca').change(function(){
			var footableFilter = $('.footable').data('footable-filter');			  
		    footableFilter.filter($(this).val());
	});

	//nao sei pq fiz isso aqui hahaha
	//talvez seja meio lerdo, mas ok
	/*$('#col_actions').hide();
	$('table.footable tbody .btn-group-lg').each(function(){
		if( $(this).html() != '' )
			$('#col_actions').show();

	});*/
});

</script>
