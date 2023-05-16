<?php 
	include '../../../web/seguranca.php';

	$id = $_POST['id'];
	
	  

	$titulo = htmlentities($_POST['titulo_projeto']);
	$clube = htmlentities($_POST['nome_clube']);
	
	$escola = ($_POST['escolae']);

	
	$queryy = "SELECT nome_escola FROM escola WHERE id_escola = $escola";

	$resultado = mysqli_query($conexao, $queryy);

	$linha = mysqli_fetch_assoc($resultado);
	
	$nome_escola = $linha['nome_escola'];
	
	
	$nomesup = htmlentities($_POST['nomesup']);
	
	$cidade = htmlentities($_POST['cidadee']);
	$ano = $_POST['ano'];
	$nota_fase1 = (float) $_POST['nota_fase1'];
	$nota_fase2 = (float) $_POST['nota_fase2'];
	$link_video = $_POST['link_video'];


	$integrante1 = ($_POST['integrante1']);
	$integrante2 = ($_POST['integrante2']);
	$integrante3 = ($_POST['integrante3']);
	$integrante4 = ($_POST['integrante4']);
	$integrante5 = ($_POST['integrante5']);
	$integrante6 = ($_POST['integrante6']);


	$integrantes = implode(',', array(
		$_POST['integrante1'],
		$_POST['integrante2'],
		$_POST['integrante3'],
		$_POST['integrante4'],
		$_POST['integrante5'],
		$_POST['integrante6'],
	  ));

	$query = "UPDATE clubes_de_ciencia SET titulo_projeto = '$titulo', cidade = '$cidade', id_escola = '$escola', nome_clube = '$clube', integrantes = '$integrantes', supervisor = '$nomesup', ano = '$ano', nota_fase1 = $nota_fase1 , nota_fase2 = $nota_fase2, link_video = '$link_video', integrante1 = '$integrante1', integrante2 = '$integrante2', integrante3 = '$integrante3' , integrante4 = '$integrante4', integrante5 = '$integrante5', integrante6 = '$integrante6' WHERE id = '$id'";



	if(mysqli_query($_SG['link'], $query)){
		$id_usuario = $_SESSION['usuarioID'];
	    $time = date("Y-m-d H:i:s");

	    $res = mysqli_query($_SG['link'], "INSERT INTO log_sistema_clube_de_ciencia (id_usuario, id_clube, acao, date_time) VALUES ('$id_usuario','$id', 'editar', '$time')");

		echo '<i class="fa fa-check"></i> Clube atualizado com sucesso';
	}
	else{
		echo 'Erro ao atualizar, tente novamente mais tarde.';
	}
 ?>