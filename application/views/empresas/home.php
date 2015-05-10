<h1 class="pull-left">
	Empresas <span class="label label-default"><?php echo site::getTituloInterna(2); ?></span>	
</h1>

<section id='list' class='Content'>			
	<?php 

		if(isset($_GET['sucesso']))
		{
			echo '<div class="alert alert-success alert-dismissable">';
 			echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			echo 'Item salvo <strong>com sucesso!</strong>  </div>';
		}

		if(isset($_GET['erro']))
		{
			echo '<div class="alert alert-danger alert-dismissable">';
 			echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			echo 'Ocorreu algum erro! <strong>verifique os dados e tente novamente!</strong>  </div>';
		}

		echo '<div class="alert alert-danger" id="box_error"></div>';
		echo $conteudo; //conteudo da página interna  
	?> 
</section>

<script type="text/javascript">

$( document ).ready(function() {
	$('.alert-dismissable').delay(4000).fadeOut('slow');  //tira quaisquer alertas depois de 4 segundos
});

</script>
