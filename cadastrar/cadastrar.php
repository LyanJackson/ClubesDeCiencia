<?php 
	include '../../../web/seguranca.php';

	$titulo = htmlentities($_POST['titulo_projeto']);
	$clube = htmlentities($_POST['nome_clube']);


	$ano = $_POST['ano'];
	$cidade = htmlentities($_POST['cidade']);
	$escola = ($_POST['escola']);


	$nota_fase1 = (float) $_POST['nota_fase1'];
	$nota_fase2 = (float) $_POST['nota_fase2'];
	$link_video = $_POST['link_video'];
	$fotos = "";
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



	$query = "INSERT INTO clubes_de_ciencia (titulo_projeto, cidade, id_escola, nome_clube, integrantes, resumo, fotos, ano, nota_fase1, nota_fase2, link_video, integrante1, integrante2, integrante3, integrante4, integrante5, integrante6) VALUES ('$titulo', '$cidade' , '$escola','$clube', '$integrantes', '$doc', '$fotos', '$ano', $nota_fase1, $nota_fase2, '$link_video', '$integrante1', '$integrante2', '$integrante3', '$integrante4, '$integrante5', '$integrante6')";
	
	if(mysqli_query($_SG['link'], $query)){
		$id = mysqli_insert_id($_SG['link']);
		$id_usuario = $_SESSION['usuarioID'];
	    $time = date("Y-m-d H:i:s");

	    $res = mysqli_query($_SG['link'], "INSERT INTO log_sistema_clube_de_ciencia (id_usuario, id_clube, acao, date_time) VALUES ('$id_usuario','$id', 'cadastrar-clube', '$time')");

		echo '<div class="alert alert-success">Clube de Ciência cadastrado com sucesso!</div>';
	}
	else {
		echo '<div class="alert alert-danger">Clube não cadastrado.</div>';
	}
			

	echo '<script>window.location.href = "../cadastrar"</script>';

 ?>