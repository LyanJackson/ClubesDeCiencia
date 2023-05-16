<?php 
	
	include '../../../web/seguranca.php';

	$id = $_POST['id'];
	$docs = $_FILES['doc'];
	$doc = $docs['name'];

	// Pasta onde as imagens serao salvas
	$_UP['pasta_doc'] = '../documentos/';

	$extensoes = explode(".", $doc);
	$extensao = $extensoes[count($extensoes)-1];

    $nome_final = $id.'.'.$extensao;

	if (move_uploaded_file($_FILES['doc']['tmp_name'], $_UP['pasta_doc'] . $nome_final)) {
		$query = "UPDATE clubes_de_ciencia SET resumo = '".$nome_final."' WHERE id = ".$id;
		if(mysqli_query($_SG['link'], $query)){
			$id_usuario = $_SESSION['usuarioID'];
		    $time = date("Y-m-d H:i:s");

		    $res = mysqli_query($_SG['link'], "INSERT INTO log_sistema_clube_de_ciencia (id_usuario, id_clube, acao, date_time) VALUES ('$id_usuario','$id', 'alterar-documento', '$time')");


			echo 'Documento adicionado com sucesso!';
		}
		else{
			echo 'Erro no banco de dados, entre em contato com o administrador!';
			echo mysqli_error($_SG['link']);
		}
	}
	else{
		echo 'Erro no upload';
	}
 ?>